<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        $doctors = Doctor::with('user')->get();

        $query = Appointment::with(['patient', 'doctor.user', 'service', 'invoice'])
            ->whereDate('appointment_time', today());

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        $allToday = $query->orderBy('appointment_time', 'asc')->get();

        // Phân loại
        $waitingList = $allToday->where('status', 'waiting');
        $inProgressList = $allToday->where('status', 'in_progress');
        $confirmedList = $allToday->where('status', 'confirmed');
        $completedList = $allToday->where('status', 'completed');

        return view('receptionist.queue.index', compact(
            'doctors',
            'doctorId',
            'waitingList',
            'inProgressList',
            'confirmedList',
            'completedList'
        ));
    }
}
