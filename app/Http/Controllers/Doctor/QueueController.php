<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class QueueController extends Controller
{
    public function index()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Chưa tìm thấy hồ sơ Bác sĩ liên kết.');
        }

        $doctorId = $doctor->id;

        // Bệnh nhân đang khám
        $inProgressAppointment = Appointment::with(['patient', 'service'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', today())
            ->where('status', 'in_progress')
            ->first();

        // Danh sách đang chờ vào khám (status = waiting)
        $waitingList = Appointment::with(['patient', 'service'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', today())
            ->where('status', 'waiting')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Các lịch đã xác nhận trong ngày nhưng chưa check-in
        $confirmedList = Appointment::with(['patient', 'service'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', today())
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Các ca đã hoàn thành trong ngày
        $completedList = Appointment::with(['patient', 'service'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_time', today())
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('doctor.queue.index', compact(
            'doctor',
            'inProgressAppointment',
            'waitingList',
            'confirmedList',
            'completedList'
        ));
    }
}
