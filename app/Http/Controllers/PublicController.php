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
        try {
            if (\App\Models\Patient::count() === 0 && \Illuminate\Support\Facades\Schema::hasTable('patients')) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Auto seed on home: ' . $e->getMessage());
        }

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
            $doctors = $this->getAllDoctors();
            return view($viewMap[$slug]['view'], compact('services', 'targetService', 'doctors'));
        }

        abort(404);
    }

    public function about()
    {
        return view('public.about');
    }

    /**
     * Đồng bộ tự động mọi tài khoản có vai trò Doctor vào bảng doctors để hiển thị đầy đủ
     */
    protected function getAllDoctors()
    {
        $doctorUsers = \App\Models\User::whereHas('role', function ($q) {
            $q->whereRaw('LOWER(name) = ?', ['doctor']);
        })->get();

        foreach ($doctorUsers as $u) {
            \App\Models\Doctor::firstOrCreate(
                ['user_id' => $u->id],
                ['specialty' => 'Chuyên khoa Răng Hàm Mặt']
            );
        }

        return \App\Models\Doctor::with('user')
            ->whereHas('user')
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
            'phone' => 'required|string|max:20',
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

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'appointment_time' => 'required|date|after_or_equal:tomorrow',
            'service_id' => 'nullable|exists:services,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'note' => 'nullable|string'
        ], [
            'appointment_time.after_or_equal' => 'Chỉ nhận đặt lịch hẹn từ ngày hôm sau trở đi. Nếu khám trong ngày, quý khách không cần đặt lịch mà vui lòng đến trực tiếp phòng khám.',
            'appointment_time.required' => 'Vui lòng chọn thời gian đặt lịch khám.',
            'appointment_time.date' => 'Thời gian đặt lịch không hợp lệ.',
            'doctor_id.exists' => 'Bác sĩ đã chọn không hợp lệ.',
        ]);

        $parsedTime = \Carbon\Carbon::parse($request->appointment_time);
        $hourMinute = $parsedTime->format('H:i');
        if ($hourMinute < '08:00' || $hourMinute > '20:00') {
            return back()->withInput()->withErrors([
                'appointment_time' => 'Vui lòng chọn giờ hẹn trong khung giờ làm việc của phòng khám (08:00 - 20:00).'
            ]);
        }

        if ($request->filled('doctor_id')) {
            $conflict = Appointment::where('doctor_id', $request->doctor_id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress'])
                ->whereBetween('appointment_time', [
                    $parsedTime->copy()->subMinutes(29),
                    $parsedTime->copy()->addMinutes(29),
                ])
                ->exists();

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'doctor_id' => 'Bác sĩ bạn chọn đã có lịch hẹn khác trong khung giờ này (cách nhau dưới 30 phút). Vui lòng chọn khung giờ khác hoặc bác sĩ khác.'
                ]);
            }
        }

        // Kiểm tra xem bệnh nhân đã tồn tại qua số điện thoại chưa
        $patient = Patient::where('phone', $request->phone)->first();

        // Nếu chưa có, tạo bệnh nhân mới
        if (!$patient) {
            $patient = Patient::create([
                'patient_code' => 'BN' . date('YmdHis'),
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
        } else {
            // Cập nhật lại tên nếu họ dùng tên mới cho sđt cũ
            $patient->update(['name' => $request->name]);
        }

        // Tạo lịch hẹn trạng thái 'pending'
        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id ?: null,
            'service_id' => $request->service_id ?: null,
            'appointment_time' => $request->appointment_time,
            'note' => $request->note,
            'status' => 'pending' // Chờ duyệt
        ]);

        return redirect()->route('public.booking')->with('success', 'Đặt lịch thành công! Phòng khám sẽ liên hệ lại để xác nhận với bạn sớm nhất.');
    }

    public function lookup(Request $request)
    {
        $phone = trim((string) $request->input('phone', ''));
        $patient = null;
        $appointments = collect();
        $invoices = collect();
        $settings = \App\Models\SystemSetting::pluck('setting_value', 'setting_key')->toArray();

        if ($phone !== '') {
            $patient = Patient::where('phone', $phone)
                ->orWhere('patient_code', $phone)
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

        return view('public.lookup', compact('phone', 'patient', 'appointments', 'invoices', 'settings'));
    }
}
