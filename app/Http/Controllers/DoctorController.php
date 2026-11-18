<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\DoctorSchedule;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;
        
        if (!$doctor) {
            return redirect()->route('dashboard')->with('error', 'Tài khoản của bạn chưa được liên kết với hồ sơ Bác sĩ.');
        }

        $doctorId = $doctor->id;

        // Lấy lịch trực hôm nay
        $todaySchedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->whereDate('date', today())
            ->get();

        // Thống kê lịch khám hôm nay (của bác sĩ này hoặc khách chờ khám chưa phân bác sĩ)
        $todayAppointments = Appointment::with(['patient', 'service'])
            ->where(function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)
                  ->orWhereNull('doctor_id');
            })
            ->whereDate('appointment_time', today())
            ->orderBy('appointment_time', 'ASC')
            ->get();

        $waitingCount = $todayAppointments->where('status', 'waiting')->count();
        $completedCount = $todayAppointments->where('status', 'completed')->count();
        $totalToday = $todayAppointments->count();

        // Lấy ca đang khám (nếu có)
        $inProgress = $todayAppointments->where('status', 'in_progress')->first();

        // Danh sách đang chờ khám (ưu tiên theo giờ hẹn)
        $waitingList = $todayAppointments->where('status', 'waiting');

        // Danh sách lịch hẹn chờ Bác sĩ xác nhận (của bác sĩ này hoặc chưa gán bác sĩ)
        $pendingConfirmList = Appointment::with(['patient', 'service'])
            ->where(function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)
                  ->orWhereNull('doctor_id');
            })
            ->where('status', 'pending')
            ->orderBy('appointment_time', 'ASC')
            ->get();

        // Danh sách lịch hẹn Bác sĩ đã xác nhận (hôm nay và sắp tới)
        $confirmedUpcoming = Appointment::with(['patient', 'service'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'confirmed')
            ->orderBy('appointment_time', 'ASC')
            ->take(15)
            ->get();

        return view('doctor.dashboard', compact(
            'doctor', 'todaySchedule', 'totalToday', 'waitingCount', 'completedCount',
            'inProgress', 'waitingList', 'todayAppointments', 'pendingConfirmList', 'confirmedUpcoming'
        ));
    }
}
