<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // 1. Lấy các hóa đơn đã thanh toán trong tháng kèm chi tiết để tách Doanh thu Dịch vụ & Thuốc
        $paidInvoices = Invoice::with('details')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalRevenue = $paidInvoices->sum('final_amount');
        $totalVat = $paidInvoices->sum('vat_amount');

        $serviceRevenue = 0;
        $medicineRevenue = 0;
        $medicinePrefixes = ['thuốc:', 'đơn thuốc:', 'gói thuốc'];

        foreach ($paidInvoices as $inv) {
            foreach ($inv->details as $detail) {
                $lowerName = mb_strtolower(trim($detail->item_name));
                $isMedicine = false;
                foreach ($medicinePrefixes as $prefix) {
                    if (str_starts_with($lowerName, $prefix)) {
                        $isMedicine = true;
                        break;
                    }
                }
                if ($isMedicine) {
                    $medicineRevenue += floatval($detail->total_price);
                } else {
                    $serviceRevenue += floatval($detail->total_price);
                }
            }
        }

        // 2. Bệnh nhân mới trong tháng
        $newPatients = Patient::whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. Số lượt khám hoàn thành
        $completedAppointments = Appointment::where('status', 'completed')
            ->whereBetween('appointment_time', [$startDate, $endDate])
            ->count();

        // 4. Doanh thu theo từng ngày trong tháng
        $dailyRevenue = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as invoice_count, SUM(vat_amount) as vat_total, SUM(final_amount) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Cảnh báo thuốc sắp hết tồn kho
        $lowStockMedicines = Medicine::where('stock_quantity', '<=', 20)
            ->orderBy('stock_quantity')
            ->get();

        return view('admin.reports.index', compact(
            'month',
            'year',
            'totalRevenue',
            'serviceRevenue',
            'medicineRevenue',
            'totalVat',
            'newPatients',
            'completedAppointments',
            'dailyRevenue',
            'lowStockMedicines'
        ));
    }

    public function export(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $dailyRevenue = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as invoice_count, SUM(vat_amount) as vat_total, SUM(final_amount) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $csvFileName = "baocao_doanhthu_{$month}_{$year}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');

        // Add BOM for UTF-8 Excel compatibility
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, ['Ngày', 'Số hóa đơn', 'Thuế VAT 10% (VNĐ)', 'Tổng doanh thu thực thu (VNĐ)']);

        foreach ($dailyRevenue as $day) {
            fputcsv($handle, [
                Carbon::parse($day->date)->format('d/m/Y'),
                $day->invoice_count,
                $day->vat_total,
                $day->total
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}
