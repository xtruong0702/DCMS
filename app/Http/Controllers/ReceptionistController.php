<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Doctor;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $todayAppointments = Appointment::with(['patient', 'doctor.user', 'service'])
            ->whereDate('appointment_time', today())
            ->orderBy('appointment_time', 'ASC')
            ->get();

        // Lịch hẹn khách đặt trước (từ ngày mai trở đi hoặc đang chờ xác nhận) để Lễ tân gọi điện xác nhận & phân công Bác sĩ
        $advanceBookings = Appointment::with(['patient', 'doctor.user', 'service'])
            ->where(function ($q) {
                $q->whereDate('appointment_time', '>', today())
                  ->orWhere('status', 'pending');
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('appointment_time', 'ASC')
            ->take(20)
            ->get();

        $doctors = Doctor::with('user')->get();

        $totalToday = $todayAppointments->count();
        $waitingCount = $todayAppointments->where('status', 'waiting')->count();
        $inProgressCount = $todayAppointments->where('status', 'in_progress')->count();
        $completedCount = $todayAppointments->where('status', 'completed')->count();
        $pendingConfirmCount = Appointment::where('status', 'pending')->count();

        // Danh sách khách cần thu tiền (Hóa đơn chưa thanh toán)
        $unpaidInvoices = Invoice::with(['patient', 'details'])
            ->where('status', 'unpaid')
            ->latest()
            ->get();

        // Yêu cầu tư vấn / liên hệ từ Website đang chờ gọi lại
        $contactInquiries = \App\Support\ContactInquiryStore::all()->take(10);
        $pendingInquiriesCount = \App\Support\ContactInquiryStore::pending()->count();

        return view('receptionist.dashboard', compact(
            'todayAppointments',
            'advanceBookings',
            'doctors',
            'totalToday',
            'waitingCount',
            'inProgressCount',
            'completedCount',
            'pendingConfirmCount',
            'unpaidInvoices',
            'contactInquiries',
            'pendingInquiriesCount'
        ));
    }
}
