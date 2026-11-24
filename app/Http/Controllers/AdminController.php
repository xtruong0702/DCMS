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
    public function dashboard()
    {
        // Tự động nạp dữ liệu mẫu nếu hệ thống chưa có dữ liệu bệnh nhân
        try {
            if (Patient::count() === 0 && \Illuminate\Support\Facades\Schema::hasTable('patients')) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Auto seed failed: ' . $e->getMessage());
        }
        // Thống kê quản trị tổng thể
        $data = [
            'total_doctors' => Doctor::count(),
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('appointment_time', today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'today_revenue' => Invoice::where('status', 'paid')->whereDate('created_at', today())->sum('final_amount'),
            'month_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('final_amount'),
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

        for ($i = 6; $i >= 0; $i--) {
            $dateStr = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartDates[] = Carbon::now()->subDays($i)->format('d/m');

            $revenue = $revenueLast7Days->firstWhere('date', $dateStr);
            $chartRevenues[] = $revenue ? $revenue->total : 0;
        }

        // Lấy lịch hẹn hôm nay & các ngày tới
        $upcomingAppointments = Appointment::with(['patient', 'doctor.user', 'service'])
            ->where('appointment_time', '>=', today())
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->orderBy('appointment_time', 'ASC')
            ->take(8)
            ->get();

        // Danh sách bệnh nhân kèm lịch sử khám & hóa đơn hiển thị chi tiết tại Dashboard
        $patientsList = Patient::with(['appointments.service', 'appointments.doctor.user', 'invoices', 'medicalRecords'])
            ->latest()
            ->take(20)
            ->get();
        $recentPatients = $patientsList;

        // Yêu cầu tư vấn / liên hệ từ Website
        $contactInquiries = \App\Support\ContactInquiryStore::all()->take(8);
        $data['pending_inquiries'] = \App\Support\ContactInquiryStore::pending()->count();

        return view('admin.dashboard', compact('data', 'chartDates', 'chartRevenues', 'upcomingAppointments', 'recentPatients', 'patientsList', 'contactInquiries'));
    }
}
