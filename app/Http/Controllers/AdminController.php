<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Supply;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $prevMonthDate = now()->copy()->subMonthNoOverflow();
        $prevMonthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', $prevMonthDate->month)
            ->whereYear('created_at', $prevMonthDate->year)
            ->sum('final_amount');

        $monthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('final_amount');

        $monthGrowthPct = $prevMonthRevenue > 0
            ? round((($monthRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100, 1)
            : null;

        // Thống kê quản trị tổng thể
        $data = [
            'total_doctors' => Doctor::count(),
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('appointment_time', today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'today_revenue' => Invoice::where('status', 'paid')->whereDate('created_at', today())->sum('final_amount'),
            'month_revenue' => $monthRevenue,
            'month_growth_pct' => $monthGrowthPct,
            'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
            'low_stock_medicines' => Medicine::where('stock_quantity', '<=', 20)->count(),
        ];

        // Lấy dữ liệu doanh thu 7 ngày gần nhất
        $revenueLast7Days = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(final_amount) as total')
        )
        ->where('status', 'paid')
        ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $chartDates = [];
        $chartRevenues = [];
        $peakRevenue = 0;
        $peakDate = now()->format('d/m');

        for ($i = 6; $i >= 0; $i--) {
            $dateObj = Carbon::now()->subDays($i);
            $dateStr = $dateObj->format('Y-m-d');
            $label = $dateObj->format('d/m');
            $chartDates[] = $label;

            $revenue = $revenueLast7Days->firstWhere('date', $dateStr);
            $val = $revenue ? floatval($revenue->total) : 0;
            $chartRevenues[] = $val;

            if ($val >= $peakRevenue && $val > 0) {
                $peakRevenue = $val;
                $peakDate = $label;
            }
        }

        // Lấy lịch hẹn hôm nay & các ngày tới
        $upcomingAppointments = Appointment::with(['patient', 'doctor.user', 'service'])
            ->where('appointment_time', '>=', today())
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->orderByRaw("CASE WHEN status = 'in_progress' THEN 0 WHEN status = 'waiting' THEN 1 WHEN status = 'confirmed' THEN 2 ELSE 3 END")
            ->orderBy('appointment_time', 'ASC')
            ->take(6)
            ->get();

        // Danh sách bệnh nhân kèm lịch sử khám & hóa đơn (hỗ trợ tìm kiếm, lọc trạng thái & phân trang 6/trang)
        $patientQuery = Patient::with([
            'appointments' => fn ($q) => $q->with(['service', 'doctor.user'])->latest('appointment_time'),
            'invoices' => fn ($q) => $q->latest(),
            'medicalRecords',
        ]);

        if ($request->filled('patient_search')) {
            $kw = trim($request->patient_search);
            $patientQuery->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('phone', 'like', "%{$kw}%")
                  ->orWhere('patient_code', 'like', "%{$kw}%")
                  ->orWhere('email', 'like', "%{$kw}%");
            });
        }

        if ($request->filled('invoice_status')) {
            $invStatus = $request->invoice_status;
            if ($invStatus === 'paid') {
                $patientQuery->whereHas('invoices', fn ($q) => $q->where('status', 'paid'));
            } elseif ($invStatus === 'unpaid') {
                $patientQuery->whereHas('invoices', fn ($q) => $q->where('status', 'unpaid'));
            }
        }

        $patientsList = $patientQuery->latest()->paginate(6)->withQueryString();
        $recentPatients = $patientsList;

        // Yêu cầu tư vấn / liên hệ từ Website
        $contactInquiries = \App\Support\ContactInquiryStore::all()->take(6);
        $data['pending_inquiries'] = \App\Support\ContactInquiryStore::pending()->count();

        return view('admin.dashboard', compact(
            'data',
            'chartDates',
            'chartRevenues',
            'peakRevenue',
            'peakDate',
            'upcomingAppointments',
            'recentPatients',
            'patientsList',
            'contactInquiries'
        ));
    }
}
