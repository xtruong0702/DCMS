<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user', 'service']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('appointment_time', $request->date);
        }

        $appointments = $query->orderBy('appointment_time', 'desc')->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $services = Service::where('is_active', true)->get();
        return view('admin.appointments.create', compact('patients', 'doctors', 'services'));
    }

    public function store(Request $request)
    {
        $status = $request->input('status', 'pending');
        $dateRule = in_array($status, ['pending', 'confirmed']) ? 'required|date|after_or_equal:tomorrow' : 'required|date|after_or_equal:today';

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'service_id' => 'nullable|exists:services,id',
            'appointment_date' => $dateRule,
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,waiting,in_progress,completed,cancelled,no_show',
            'note' => 'nullable|string',
        ], [
            'appointment_date.after_or_equal' => 'Chỉ nhận đặt lịch hẹn trước từ ngày hôm sau trở đi. Nếu khách khám trực tiếp trong ngày, vui lòng chọn trạng thái "Đang chờ khám (Khách đang ở phòng khám)".',
        ]);

        $dateTime = $request->appointment_date . ' ' . $request->appointment_time . ':00';
        $parsedTime = \Carbon\Carbon::parse($dateTime);

        if (in_array($status, ['pending', 'confirmed']) && ($request->appointment_time < '08:00' || $request->appointment_time > '20:00')) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Giờ hẹn phải nằm trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
            ]);
        }

        if ($request->doctor_id && in_array($request->status, ['pending', 'confirmed', 'waiting', 'in_progress'])) {
            $conflict = Appointment::findDoctorConflict(
                (int) $request->doctor_id,
                $parsedTime,
                $request->filled('service_id') ? (int) $request->service_id : null
            );

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'doctor_id' => "Bác sĩ đã có lịch hẹn trong khung giờ {$conflict['start']} – {$conflict['end']} ({$conflict['duration']} phút)."
                ]);
            }
        }

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'appointment_time' => $dateTime,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Tạo lịch hẹn thành công!');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $services = Service::where('is_active', true)->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'service_id' => 'nullable|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,waiting,in_progress,completed,cancelled,no_show',
            'note' => 'nullable|string',
        ]);

        $dateTime = $request->appointment_date . ' ' . $request->appointment_time . ':00';
        $parsedTime = \Carbon\Carbon::parse($dateTime);

        if (in_array($request->status, ['pending', 'confirmed']) && ($request->appointment_time < '08:00' || $request->appointment_time > '20:00')) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Giờ hẹn phải nằm trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
            ]);
        }

        if ($request->doctor_id && in_array($request->status, ['pending', 'confirmed', 'waiting', 'in_progress'])) {
            $conflict = Appointment::findDoctorConflict(
                (int) $request->doctor_id,
                $parsedTime,
                $request->filled('service_id') ? (int) $request->service_id : null,
                $appointment->id
            );

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'doctor_id' => "Bác sĩ đã có lịch hẹn trong khung giờ {$conflict['start']} – {$conflict['end']} ({$conflict['duration']} phút)."
                ]);
            }
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'appointment_time' => $dateTime,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Cập nhật lịch hẹn thành công!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Đã xóa lịch hẹn!');
    }
}
