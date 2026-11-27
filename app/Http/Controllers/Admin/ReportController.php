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
    protected function resolvePeriod(Request $request): array
    {
        $rawMonth = $request->input('month');
        $rawYear = $request->input('year');

        $month = (is_numeric($rawMonth) && (int) $rawMonth >= 1 && (int) $rawMonth <= 12)
            ? (int) $rawMonth
            : Carbon::now()->month;

        $year = (is_numeric($rawYear) && (int) $rawYear >= 2020 && (int) $rawYear <= 2100)
            ? (int) $rawYear
            : Carbon::now()->year;

        return [$month, $year];
    }

    public function index(Request $request)
    {
        [$month, $year] = $this->resolvePeriod($request);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // 1. Lấy các hóa đơn đã thanh toán trong tháng kèm chi tiết để tách Doanh thu Dịch vụ & Thuốc
        $paidInvoices = Invoice::with(['details', 'payments', 'appointment.doctor.user'])
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalRevenue = $paidInvoices->sum('final_amount');
        $totalVat = $paidInvoices->sum('vat_amount');
        $totalDiscount = $paidInvoices->sum('discount');
        $paidInvoiceCount = $paidInvoices->count();

        $unpaidAmount = Invoice::where('status', 'unpaid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('final_amount');
        $unpaidInvoiceCount = Invoice::where('status', 'unpaid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $serviceRevenue = 0;
        $medicineRevenue = 0;
        $medicinePrefixes = ['thuốc:', 'đơn thuốc:', 'gói thuốc'];

        $serviceBreakdown = [];
        $doctorBreakdown = [];
        $paymentMethods = [
            'VietQR / Chuyển khoản' => 0,
            'Tiền mặt' => 0,
            'Khác' => 0,
        ];

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
                $lineTotal = floatval($detail->total_price);
                if ($isMedicine) {
                    $medicineRevenue += $lineTotal;
                } else {
                    $serviceRevenue += $lineTotal;
                    $cleanServiceName = preg_replace('/^(Dịch vụ\/Thủ thuật:|Dịch vụ:)\s*/iu', '', trim($detail->item_name));
                    if (!isset($serviceBreakdown[$cleanServiceName])) {
                        $serviceBreakdown[$cleanServiceName] = ['name' => $cleanServiceName, 'qty' => 0, 'revenue' => 0];
                    }
                    $serviceBreakdown[$cleanServiceName]['qty'] += max(1, intval($detail->quantity));
                    $serviceBreakdown[$cleanServiceName]['revenue'] += $lineTotal;
                }
            }

            // Phân bổ phương thức thanh toán
            foreach ($inv->payments->where('status', 'completed') as $pay) {
                $m = mb_strtolower(trim((string) $pay->payment_method));
                $amt = floatval($pay->amount);
                if (str_contains($m, 'qr') || str_contains($m, 'chuyển khoản') || str_contains($m, 'bank') || str_contains($m, 'vietqr')) {
                    $paymentMethods['VietQR / Chuyển khoản'] += $amt;
                } elseif (str_contains($m, 'cash') || str_contains($m, 'tiền mặt')) {
                    $paymentMethods['Tiền mặt'] += $amt;
                } else {
                    $paymentMethods['Khác'] += $amt;
                }
            }

            // Hiệu suất doanh thu theo Bác sĩ
            if ($inv->appointment && $inv->appointment->doctor) {
                $doc = $inv->appointment->doctor;
                $docId = $doc->id;
                if (!isset($doctorBreakdown[$docId])) {
                    $doctorBreakdown[$docId] = [
                        'name' => $doc->user->name ?? ('Bác sĩ #' . $docId),
                        'specialty' => $doc->specialty ?? 'Răng Hàm Mặt',
                        'cases' => 0,
                        'revenue' => 0,
                    ];
                }
                $doctorBreakdown[$docId]['cases'] += 1;
                $doctorBreakdown[$docId]['revenue'] += floatval($inv->final_amount);
            }
        }

        $topServices = collect($serviceBreakdown)->sortByDesc('revenue')->take(6)->values();
        $doctorStats = collect($doctorBreakdown)->sortByDesc('revenue')->values();

        // 2. Bệnh nhân mới trong tháng
        $newPatients = Patient::whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. Số lượt khám hoàn thành & tổng lượt khám trong tháng
        $completedAppointments = Appointment::where('status', 'completed')
            ->whereBetween('appointment_time', [$startDate, $endDate])
            ->count();
        $totalAppointmentsMonth = Appointment::whereBetween('appointment_time', [$startDate, $endDate])->count();

        // 4. Doanh thu theo từng ngày trong tháng
        $dailyRevenue = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as invoice_count, SUM(vat_amount) as vat_total, SUM(final_amount) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyChartLabels = $dailyRevenue->map(fn ($d) => Carbon::parse($d->date)->format('d/m'))->values()->toArray();
        $dailyChartTotals = $dailyRevenue->map(fn ($d) => round(floatval($d->total)))->values()->toArray();

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
            'totalDiscount',
            'paidInvoiceCount',
            'unpaidAmount',
            'unpaidInvoiceCount',
            'newPatients',
            'completedAppointments',
            'totalAppointmentsMonth',
            'dailyRevenue',
            'dailyChartLabels',
            'dailyChartTotals',
            'paymentMethods',
            'topServices',
            'doctorStats',
            'lowStockMedicines'
        ));
    }

    public function export(Request $request)
    {
        [$month, $year] = $this->resolvePeriod($request);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $dailyRevenue = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as invoice_count, SUM(vat_amount) as vat_total, SUM(final_amount) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $csvFileName = "baocao_doanhthu_{$month}_{$year}.csv";

        return response()->streamDownload(function () use ($dailyRevenue) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['Ngày', 'Số hóa đơn', 'Thuế VAT (VNĐ)', 'Tổng doanh thu thực thu (VNĐ)']);

            foreach ($dailyRevenue as $day) {
                fputcsv($handle, [
                    Carbon::parse($day->date)->format('d/m/Y'),
                    $day->invoice_count,
                    $day->vat_total,
                    $day->total,
                ]);
            }

            fclose($handle);
        }, $csvFileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
