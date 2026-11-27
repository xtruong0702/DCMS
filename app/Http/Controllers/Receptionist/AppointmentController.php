<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user', 'service']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_time', $request->date);
        }

        $appointments = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 WHEN status = 'waiting' THEN 1 WHEN status = 'confirmed' THEN 2 ELSE 3 END")
            ->orderBy('appointment_time', 'ASC')
            ->paginate(20);
        return view('receptionist.appointments.index', compact('appointments'));
    }

    public function create(Request $request)
    {
        $selectedPatientId = $request->input('patient_id');

        if (!$selectedPatientId && $request->filled('phone') && $request->filled('name')) {
            $patient = Patient::firstOrCreate(
                ['phone' => trim($request->phone)],
                [
                    'patient_code' => 'BN' . date('YmdHis') . random_int(100, 999),
                    'name' => trim($request->name),
                ]
            );
            $selectedPatientId = $patient->id;
        }

        $patients = Patient::latest()->get();
        $doctors = Doctor::with('user')->get();
        $services = Service::where('is_active', true)->get();
        return view('receptionist.appointments.create', compact('patients', 'doctors', 'services', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $status = $request->input('status', 'confirmed');

        if ($request->filled('appointment_date')) {
            $dateRule = in_array($status, ['pending', 'confirmed']) ? 'required|date|after_or_equal:tomorrow' : 'required|date|after_or_equal:today';
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'nullable|exists:doctors,id',
                'service_id' => 'nullable|exists:services,id',
                'appointment_date' => $dateRule,
                'appointment_time' => 'required|date_format:H:i',
                'status' => 'nullable|in:pending,confirmed,waiting,in_progress,completed,cancelled,no_show',
                'note' => 'nullable|string',
            ], [
                'appointment_date.after_or_equal' => 'Chỉ nhận đặt lịch hẹn trước từ ngày hôm sau trở đi. Nếu khách khám trực tiếp trong ngày, vui lòng chọn "Khách đến khám trực tiếp trong ngày (Vào phòng chờ)".',
            ]);
            $dateTime = $request->appointment_date . ' ' . $request->appointment_time . ':00';
        } else {
            $timeRule = in_array($status, ['pending', 'confirmed']) ? 'required|date|after_or_equal:tomorrow' : 'required|date|after_or_equal:today';
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'nullable|exists:doctors,id',
                'service_id' => 'nullable|exists:services,id',
                'appointment_time' => $timeRule,
                'status' => 'nullable|in:pending,confirmed,waiting,in_progress,completed,cancelled,no_show',
                'note' => 'nullable|string',
            ], [
                'appointment_time.after_or_equal' => 'Chỉ nhận đặt lịch hẹn trước từ ngày hôm sau trở đi. Nếu khách khám trực tiếp trong ngày, không cần đặt lịch mà chọn "Khách đến khám trực tiếp trong ngày (Vào phòng chờ)".',
            ]);
            $dateTime = $request->appointment_time;
        }

        $parsedTime = \Carbon\Carbon::parse($dateTime);
        $hourMinute = $parsedTime->format('H:i');
        if ($status !== 'waiting' && ($hourMinute < '08:00' || $hourMinute > '20:00')) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Giờ khám phải nằm trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
            ]);
        }

        if ($request->doctor_id) {
            $conflict = Appointment::findDoctorConflict(
                (int) $request->doctor_id,
                $parsedTime,
                $request->filled('service_id') ? (int) $request->service_id : null
            );

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'doctor_id' => "Bác sĩ này đã có lịch hẹn trong khung giờ {$conflict['start']} – {$conflict['end']} ({$conflict['duration']} phút)."
                ]);
            }
        }

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'appointment_time' => $dateTime,
            'status' => $status,
            'note' => $request->note,
        ]);

        return redirect()->route('receptionist.appointments.index')->with('success', 'Tạo lịch hẹn / tiếp nhận thành công!');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $services = Service::where('is_active', true)->get();
        return view('receptionist.appointments.edit', compact('appointment', 'patients', 'doctors', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'service_id' => 'nullable|exists:services,id',
            'appointment_time' => 'nullable|date',
            'status' => 'required|in:pending,confirmed,waiting,in_progress,completed,cancelled,no_show',
            'note' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->has('doctor_id')) {
            $updateData['doctor_id'] = $request->doctor_id;
        }
        if ($request->has('service_id')) {
            $updateData['service_id'] = $request->service_id;
        }
        if ($request->has('note')) {
            $updateData['note'] = $request->note;
        }
        if ($request->filled('appointment_time')) {
            $parsedTime = \Carbon\Carbon::parse($request->appointment_time);
            $hourMinute = $parsedTime->format('H:i');
            if (in_array($request->status, ['pending', 'confirmed']) && ($hourMinute < '08:00' || $hourMinute > '20:00')) {
                return back()->withInput()->withErrors([
                    'appointment_time' => 'Giờ khám phải nằm trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
                ]);
            }
            $updateData['appointment_time'] = $request->appointment_time;
        }

        $targetDoctorId = array_key_exists('doctor_id', $updateData) ? $updateData['doctor_id'] : $appointment->doctor_id;
        $targetServiceId = array_key_exists('service_id', $updateData) ? $updateData['service_id'] : $appointment->service_id;
        $rawTargetTime = array_key_exists('appointment_time', $updateData) ? $updateData['appointment_time'] : $appointment->appointment_time;
        $targetTime = $rawTargetTime ? \Carbon\Carbon::parse($rawTargetTime) : null;

        $isChangingDoctorOrTime = (
            (array_key_exists('doctor_id', $updateData) && (string) $updateData['doctor_id'] !== (string) $appointment->doctor_id)
            || array_key_exists('appointment_time', $updateData)
            || (array_key_exists('service_id', $updateData) && (string) $updateData['service_id'] !== (string) $appointment->service_id)
        );

        if ($isChangingDoctorOrTime && $targetDoctorId && $targetTime && in_array($request->status, ['pending', 'confirmed', 'waiting', 'in_progress'])) {
            $conflict = Appointment::findDoctorConflict(
                (int) $targetDoctorId,
                $targetTime,
                $targetServiceId ? (int) $targetServiceId : null,
                $appointment->id
            );

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'doctor_id' => "Bác sĩ này đã có lịch hẹn trong khung giờ {$conflict['start']} – {$conflict['end']} ({$conflict['duration']} phút)."
                ]);
            }
        }

        $appointment->update($updateData);

        if ($request->status === 'in_progress' && !$request->has('appointment_time')) {
            return redirect()->back()->with('success', 'Đã mời bệnh nhân vào phòng khám!');
        }

        return redirect()->route('receptionist.appointments.index')->with('success', 'Đã cập nhật thông tin lịch hẹn!');
    }

    public function checkIn(Request $request, Appointment $appointment)
    {
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Chỉ có thể Check-in lịch hẹn đang ở trạng thái Chờ xác nhận hoặc Đã xác nhận.');
        }

        // Khi khách đến phòng khám, lễ tân ấn Check-in
        $appointment->update(['status' => 'waiting']);
        
        return redirect()->back()->with('success', 'Đã Check-in! Bệnh nhân đang ở Hàng đợi.');
    }
}
