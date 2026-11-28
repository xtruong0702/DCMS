<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;

class PublicController extends Controller
{
    public function home()
    {
        $featuredServices = Service::where('is_active', true)->take(6)->get();
        $allServices = Service::where('is_active', true)->get();
        $doctors = $this->getAllDoctors()->take(4);

        return view('welcome', compact('featuredServices', 'allServices', 'doctors'));
    }
    public function services()
    {
        $services = Service::where('is_active', true)->get();
        return view('public.services', compact('services'));
    }

    public function serviceDetail($slug)
    {
        $viewMap = [
            'implant-chuyen-sau' => ['view' => 'public.services.implant-chuyen-sau', 'name' => 'Trồng răng implant chuyên sâu'],
            'rang-su-chuyen-sau' => ['view' => 'public.services.rang-su-chuyen-sau', 'name' => 'Răng sứ thẩm mỹ chuyên sâu'],
            'nieng-rang'         => ['view' => 'public.services.nieng-rang', 'name' => 'Niềng răng thẩm mỹ'],
            'rang-su'            => ['view' => 'public.services.rang-su', 'name' => 'Răng sứ thẩm mỹ'],
            'implant'            => ['view' => 'public.services.implant', 'name' => 'Trồng răng implant'],
            'nho-rang-khon'      => ['view' => 'public.services.nho-rang-khon', 'name' => 'Nhổ răng khôn'],
            'tay-trang-rang'     => ['view' => 'public.services.tay-trang-rang', 'name' => 'Tẩy trắng răng'],
            'dieu-tri-tuy'       => ['view' => 'public.services.dieu-tri-tuy', 'name' => 'Điều trị tủy răng'],
            'lay-cao-rang'       => ['view' => 'public.services.lay-cao-rang', 'name' => 'Lấy cao răng'],
            'tram-rang'          => ['view' => 'public.services.tram-rang', 'name' => 'Trám răng'],
        ];

        if (array_key_exists($slug, $viewMap)) {
            $services = Service::where('is_active', true)->get();
            $targetService = Service::where('name', $viewMap[$slug]['name'])->first();
            $packagePrefix = match ($slug) {
                'implant-chuyen-sau', 'implant' => 'PKG-IMPLANT-',
                'rang-su-chuyen-sau', 'rang-su' => 'PKG-CROWN-',
                'nieng-rang' => 'PKG-ORTHO-',
                'nho-rang-khon' => 'PKG-WISDOM-',
                'tay-trang-rang' => 'PKG-WHITENING-',
                'dieu-tri-tuy' => 'PKG-ROOT-',
                'lay-cao-rang' => 'PKG-SCALING-',
                'tram-rang' => 'PKG-FILLING-',
                default => null,
            };
            $packageRows = Service::where('is_active', true)
                ->where('service_code', 'like', $packagePrefix . '%')
                ->orderBy('price')
                ->get()
                ->map(function (Service $service) {
                    $description = (string) $service->description;
                    $warranty = 'Theo chính sách phòng khám';
                    if (preg_match('/^Bảo hành:\s*([^.]+)\.\s*(.*)$/u', $description, $matches)) {
                        $warranty = trim($matches[1]);
                        $description = trim($matches[2]);
                    }

                    return [
                        'name' => $service->name,
                        'desc' => $description,
                        'warranty' => $warranty,
                        'price' => number_format((float) $service->price, 0, ',', '.') . ' đ',
                        'service_id' => $service->id,
                    ];
                });
            $targetService = $services->firstWhere('id', $packageRows->first()['service_id'] ?? null) ?? $targetService;
            $doctors = $this->getAllDoctors();
            return view($viewMap[$slug]['view'], compact('services', 'targetService', 'doctors', 'packageRows'));
        }

        abort(404);
    }

    public function about()
    {
        return view('public.about');
    }

    protected function getAllDoctors()
    {
        return \App\Models\Doctor::with('user')
            ->whereHas('user.role', fn ($query) => $query->whereRaw('LOWER(name) = ?', ['doctor']))
            ->orderBy('id')
            ->get();
    }

    public function doctors()
    {
        $doctors = $this->getAllDoctors();
        return view('public.doctors', compact('doctors'));
    }

    public function knowledge()
    {
        return view('public.knowledge');
    }

    public function careers()
    {
        return view('public.careers');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'topic' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'Vui lòng nhập họ tên của bạn.',
            'phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
        ]);

        \App\Support\ContactInquiryStore::add([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email ?? '',
            'topic' => $request->topic ?? 'Tư vấn dịch vụ nha khoa',
            'message' => $request->message,
        ]);

        return redirect()->route('public.contact')->with('success', 'Cảm ơn bạn đã liên hệ! Yêu cầu tư vấn của bạn đã được chuyển đến bộ phận Lễ tân & CSKH Nha Khoa Smile và sẽ được phản hồi trong thời gian sớm nhất.');
    }

    public function booking()
    {
        $services = Service::where('is_active', true)->get();
        $doctors = $this->getAllDoctors();
        return view('public.booking', compact('services', 'doctors'));
    }

    public function doctorBusySlots(Request $request)
    {
        $doctorId = intval($request->query('doctor_id'));
        $date = trim((string) $request->query('date', ''));

        if ($doctorId <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json([
                'success' => true,
                'slots' => [],
            ]);
        }

        $slots = Appointment::getDoctorBusySlots($doctorId, $date);

        return response()->json([
            'success' => true,
            'doctor_id' => $doctorId,
            'date' => $date,
            'slots' => $slots,
        ]);
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'appointment_time' => 'required|date|after_or_equal:tomorrow',
            'service_id' => ['nullable', \Illuminate\Validation\Rule::exists('services', 'id')->where('is_active', true)],
            'doctor_id' => 'nullable|exists:doctors,id',
            'note' => 'nullable|string'
        ], [
            'appointment_time.after_or_equal' => 'Chỉ nhận đặt lịch hẹn từ ngày hôm sau trở đi. Nếu khám trong ngày, quý khách không cần đặt lịch mà vui lòng đến trực tiếp phòng khám.',
            'appointment_time.required' => 'Vui lòng chọn thời gian đặt lịch khám.',
            'appointment_time.date' => 'Thời gian đặt lịch không hợp lệ.',
            'service_id.exists' => 'Dịch vụ đã chọn hiện không khả dụng.',
            'doctor_id.exists' => 'Bác sĩ đã chọn không hợp lệ.',
        ]);

        $parsedTime = \Carbon\Carbon::parse($request->appointment_time);
        $hourMinute = $parsedTime->format('H:i');
        if ($hourMinute < '08:00' || $hourMinute > '20:00') {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Vui lòng chọn giờ hẹn trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
            ]);
        }

        $bookingResult = Appointment::withDoctorScheduleLock(
            $request->filled('doctor_id') ? (int) $request->doctor_id : null,
            function () use ($request, $parsedTime) {
            if ($request->filled('doctor_id')) {
                $conflict = Appointment::findDoctorConflict(
                    (int) $request->doctor_id,
                    $parsedTime,
                    $request->filled('service_id') ? (int) $request->service_id : null
                );

                if ($conflict) {
                    return ['conflict' => $conflict];
                }
            }

            $cleanPhone = trim($request->phone);
            $cleanName = trim($request->name);
            $patient = Patient::where('phone', $cleanPhone)->first();
            $bookingNote = $request->note;

            if (!$patient) {
                $patient = Patient::create([
                    'patient_code' => 'BN' . date('YmdHis') . random_int(100, 999),
                    'name' => $cleanName,
                    'phone' => $cleanPhone,
                ]);
            } elseif (mb_strtolower($patient->name) !== mb_strtolower($cleanName)) {
                $nameNote = '[Tên khi đặt lịch: ' . $cleanName . ']';
                $bookingNote = $bookingNote ? ($nameNote . ' ' . $bookingNote) : $nameNote;
            }

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id ?: null,
                'service_id' => $request->service_id ?: null,
                'appointment_time' => $request->appointment_time,
                'note' => $bookingNote,
                'status' => 'pending',
            ]);

            return ['conflict' => null];
        });

        if ($bookingResult['conflict']) {
            $conflict = $bookingResult['conflict'];
            return back()->withInput()->withErrors([
                'doctor_id' => "Bác sĩ bạn chọn đã có lịch hẹn trong khung giờ {$conflict['start']} – {$conflict['end']} ({$conflict['duration']} phút). Vui lòng chọn khung giờ khác hoặc bác sĩ khác."
            ]);
        }

        return redirect()->route('public.booking')->with('success', 'Đặt lịch thành công! Phòng khám sẽ liên hệ lại để xác nhận với bạn sớm nhất.');
    }

    public function lookup(Request $request)
    {
        $phone = trim((string) $request->input('phone', ''));
        $patientCode = strtoupper(trim((string) $request->input('patient_code', '')));
        $patient = null;
        $appointments = collect();
        $invoices = collect();
        $settings = \App\Models\SystemSetting::pluck('setting_value', 'setting_key')->toArray();

        if ($phone !== '' && $patientCode !== '') {
            $patient = Patient::where('phone', $phone)
                ->where('patient_code', $patientCode)
                ->first();

            if ($patient) {
                $appointments = Appointment::with(['doctor.user', 'service', 'invoice'])
                    ->where('patient_id', $patient->id)
                    ->orderByDesc('appointment_time')
                    ->get();

                $invoices = \App\Models\Invoice::with(['details', 'payments', 'appointment.doctor.user'])
                    ->where('patient_id', $patient->id)
                    ->latest()
                    ->get();
            }
        }

        return view('public.lookup', compact('phone', 'patientCode', 'patient', 'appointments', 'invoices', 'settings'));
    }
}
