<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Role;
use App\Traits\EnsuresClinicDataSeeded;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPasswordOtpMail;
use App\Models\SystemSetting;

class PatientAuthController extends Controller
{
    use EnsuresClinicDataSeeded;
    public function showRegister()
    {
        return view('patient.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'phone.unique' => 'Số điện thoại này đã được đăng ký tài khoản.',
            'email.email' => 'Địa chỉ Email (Gmail) không hợp lệ.',
            'email.unique' => 'Địa chỉ Email này đã được sử dụng cho tài khoản khác.',
        ]);

        // Tạo role Patient nếu chưa có
        $patientRole = Role::firstOrCreate(
            ['name' => 'Patient'],
            ['description' => 'Bệnh nhân']
        );

        $cleanEmail = $request->filled('email') ? strtolower(trim((string) $request->email)) : null;

        $cleanPhone = trim($request->phone);
        $normalizedPhone = preg_replace('/\D+/', '', $cleanPhone);

        $user = DB::transaction(function () use ($request, $patientRole, $cleanEmail, $cleanPhone, $normalizedPhone) {
            $user = User::create([
                'name' => trim($request->name),
                'phone' => $cleanPhone,
                'email' => $cleanEmail,
                'password' => Hash::make($request->password),
                'role_id' => $patientRole->id,
                'is_active' => true,
            ]);

            // Liên kết hồ sơ bệnh nhân chưa có tài khoản (từ đặt lịch online / khám trực tiếp) cùng SĐT nếu có
            $existingPatient = Patient::whereNull('user_id')
                ->whereNotNull('phone')
                ->orderBy('id')
                ->get()
                ->first(fn ($p) => preg_replace('/\D+/', '', (string) $p->phone) === $normalizedPhone);

            if ($existingPatient) {
                $existingPatient->update([
                    'user_id' => $user->id,
                    'email' => $existingPatient->email ?: $cleanEmail,
                ]);
            } else {
                Patient::create([
                    'patient_code' => 'BN' . date('YmdHis') . random_int(100, 999),
                    'name' => trim($request->name),
                    'phone' => $cleanPhone,
                    'email' => $cleanEmail,
                    'user_id' => $user->id,
                ]);
            }

            return $user;
        });

        Auth::login($user);

        return redirect()->route('patient.dashboard')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function showLogin()
    {
        $this->ensureClinicData();

        return view('patient.auth.login');
    }

    public function login(Request $request)
    {
        $this->ensureClinicData();

        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$loginType => $credentials['login'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $hotline = \App\Models\SystemSetting::where('setting_key', 'clinic_hotline')->value('setting_value') ?: '0775 761 388';
                return back()->withErrors([
                    'login' => "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Quản trị viên hoặc Hotline {$hotline}.",
                ])->onlyInput('login');
            }

            $request->session()->regenerate();
            
            // Redirect to the generic dashboard route which handles role-based redirection
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('patient.auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ Email (Gmail) đã đăng ký.',
            'email.email' => 'Vui lòng nhập đúng định dạng Email (Gmail), không nhập số điện thoại.',
        ]);

        $email = strtolower(trim((string) $request->input('email')));
        $patient = null;

        // Chỉ cho phép đặt lại mật khẩu qua luồng này đối với tài khoản Bệnh nhân (Patient) bằng Email
        $user = User::whereHas('role', function ($q) {
                $q->whereRaw('LOWER(name) = ?', ['patient']);
            })
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (!$user) {
            $patient = Patient::whereRaw('LOWER(email) = ?', [$email])->whereNotNull('user_id')->with('user.role')->first();
            if ($patient && $patient->user && strtolower($patient->user->role->name ?? '') === 'patient') {
                $user = $patient->user;
            }
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'email' => 'Không tìm thấy tài khoản bệnh nhân nào với địa chỉ Email này. Nhân viên phòng khám vui lòng liên hệ Quản trị viên.',
            ]);
        }

        $hotline = SystemSetting::where('setting_key', 'clinic_hotline')->value('setting_value') ?: '0775 761 388';

        if (isset($user->is_active) && !$user->is_active) {
            return back()->withInput()->withErrors([
                'email' => "Tài khoản này đã bị khóa. Vui lòng liên hệ Hotline {$hotline}.",
            ]);
        }

        $otp = (string) random_int(100000, 999999);

        // Gửi email chứa OTP về chính địa chỉ Email vừa nhập
        $recipientEmail = $user->email ?: ($patient->email ?? $email);
        $mailSent = false;

        if ($recipientEmail && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            $mailSent = $this->deliverOtpEmail($recipientEmail, $otp, $user->name);
        }

        if (!$mailSent && !app()->isLocal()) {
            return back()->withInput()->withErrors([
                'email' => "Không thể gửi mã OTP tới email này lúc này. Vui lòng thử lại sau hoặc liên hệ Hotline {$hotline}.",
            ]);
        }

        session([
            'patient_reset_user_id' => $user->id,
            'patient_reset_identity' => $recipientEmail,
            'patient_reset_otp' => $otp,
            'patient_reset_expires_at' => now()->addMinutes(15),
            'patient_reset_attempts' => 0,
        ]);

        if ($mailSent) {
            $maskedEmail = substr(explode('@', $recipientEmail)[0], 0, 2) . '***@' . explode('@', $recipientEmail)[1];
            $statusMessage = "Mã xác thực OTP đã được gửi đến hộp thư {$maskedEmail}. Vui lòng kiểm tra email (bao gồm cả thư mục Spam/Rác).";
        } else {
            // Chỉ hiển thị OTP trực tiếp trên môi trường local dev để kiểm thử
            $statusMessage = "[Local Dev] Mã xác thực OTP của bạn là: {$otp} (Hiệu lực trong 15 phút).";
        }

        return redirect()->route('patient.password.reset')->with('status', $statusMessage);
    }

    public function showResetPassword()
    {
        if (!session('patient_reset_user_id') || !session('patient_reset_otp')) {
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Vui lòng nhập thông tin tài khoản trước khi tiếp tục.',
            ]);
        }

        return view('patient.auth.reset-password', [
            'identity' => session('patient_reset_identity'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP xác thực.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có tối thiểu 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $savedOtp = session('patient_reset_otp');
        $userId = session('patient_reset_user_id');
        $expiresAt = session('patient_reset_expires_at');
        $attempts = (int) session('patient_reset_attempts', 0);

        if (!$savedOtp || !$userId || !$expiresAt || now()->gt($expiresAt)) {
            session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at', 'patient_reset_attempts']);
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Phiên xác thực đã hết hạn. Vui lòng thực hiện lại.',
            ]);
        }

        if ($attempts >= 5) {
            session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at', 'patient_reset_attempts']);
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Bạn đã nhập sai mã OTP quá 5 lần. Vui lòng yêu cầu mã mới.',
            ]);
        }

        if (!hash_equals((string) $savedOtp, trim($request->otp))) {
            $attempts++;
            session(['patient_reset_attempts' => $attempts]);

            if ($attempts >= 5) {
                session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at', 'patient_reset_attempts']);
                return redirect()->route('patient.password.request')->withErrors([
                    'login' => 'Bạn đã nhập sai mã OTP quá 5 lần. Vui lòng yêu cầu mã mới.',
                ]);
            }

            return back()->withInput()->withErrors([
                'otp' => "Mã xác thực OTP không chính xác. Còn lại " . (5 - $attempts) . " lần thử.",
            ]);
        }

        $user = User::whereHas('role', function ($q) {
            $q->whereRaw('LOWER(name) = ?', ['patient']);
        })->find($userId);

        if (!$user) {
            session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at', 'patient_reset_attempts']);
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Không tìm thấy tài khoản bệnh nhân hợp lệ.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at', 'patient_reset_attempts']);

        return redirect()->route('patient.login')->with('success', 'Đổi mật khẩu thành công! Quý khách vui lòng đăng nhập bằng mật khẩu mới.');
    }

    /**
     * Gửi email OTP qua Brevo API / Resend API (HTTPS - không bị chặn cổng SMTP trên Railway)
     * hoặc fallback sang Laravel Mail (Gmail SMTP / log).
     */
    private function deliverOtpEmail(string $recipientEmail, string $otp, string $name): bool
    {
        $settings = SystemSetting::pluck('setting_value', 'setting_key')->toArray();
        $clinicName = trim((string) ($settings['clinic_name'] ?? '')) ?: 'Nha Khoa Smile';
        $subject = "Mã xác thực OTP đặt lại mật khẩu - {$clinicName}";
        $fromEmail = config('mail.from.address') ?: ($settings['clinic_email'] ?? 'contact@nhakhoasmile.vn');
        $fromName = config('mail.from.name') ?: $clinicName;

        $clinicSettings = [
            'clinic_name' => $clinicName,
            'clinic_hotline' => trim((string) ($settings['clinic_hotline'] ?? '')) ?: '0775 761 388',
            'clinic_email' => trim((string) ($settings['clinic_email'] ?? '')) ?: 'contact@nhakhoasmile.vn',
        ];

        // Ưu tiên 0: Google Apps Script Web App (gửi trực tiếp từ Gmail của bạn qua HTTPS 443)
        $gmailWebhookUrl = config('services.gmail_webhook.url') ?? env('GMAIL_WEBHOOK_URL');
        if (!empty($gmailWebhookUrl)) {
            try {
                $html = view('emails.otp', [
                    'otp' => $otp,
                    'name' => $name,
                    'clinicSettings' => $clinicSettings,
                ])->render();

                $response = Http::timeout(15)
                    ->withOptions(['allow_redirects' => true])
                    ->post($gmailWebhookUrl, [
                        'secret' => (string) (config('services.gmail_webhook.secret') ?? env('GMAIL_WEBHOOK_SECRET', '')),
                        'to' => $recipientEmail,
                        'subject' => $subject,
                        'html' => $html,
                        'from_name' => $fromName,
                    ]);

                $json = $response->json();
                if ($response->successful() && (!is_array($json) || ($json['success'] ?? true) === true)) {
                    return true;
                }

                Log::warning('Gmail Apps Script gửi OTP thất bại: HTTP ' . $response->status() . ' - ' . mb_substr($response->body(), 0, 300));
            } catch (\Throwable $e) {
                Log::warning('Gmail Apps Script gửi OTP lỗi: ' . $e->getMessage());
            }
        }

        $brevoKey = config('services.brevo.api_key') ?? env('BREVO_API_KEY');
        if (!empty($brevoKey)) {
            try {
                $html = view('emails.otp', [
                    'otp' => $otp,
                    'name' => $name,
                    'clinicSettings' => $clinicSettings,
                ])->render();

                $response = Http::timeout(12)
                    ->withHeaders([
                        'api-key' => $brevoKey,
                        'accept' => 'application/json',
                    ])
                    ->post('https://api.brevo.com/v3/smtp/email', [
                        'sender' => ['name' => $fromName, 'email' => $fromEmail],
                        'to' => [['email' => $recipientEmail, 'name' => $name]],
                        'subject' => $subject,
                        'htmlContent' => $html,
                    ]);

                if ($response->successful()) {
                    return true;
                }

                Log::warning('Brevo API gửi OTP thất bại: HTTP ' . $response->status() . ' - ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('Brevo API gửi OTP lỗi: ' . $e->getMessage());
            }
        }

        $resendKey = config('services.resend.key') ?? env('RESEND_API_KEY');
        if (!empty($resendKey)) {
            try {
                $html = view('emails.otp', [
                    'otp' => $otp,
                    'name' => $name,
                    'clinicSettings' => $clinicSettings,
                ])->render();

                $response = Http::timeout(12)
                    ->withToken($resendKey)
                    ->post('https://api.resend.com/emails', [
                        'from' => "{$fromName} <{$fromEmail}>",
                        'to' => [$recipientEmail],
                        'subject' => $subject,
                        'html' => $html,
                    ]);

                if ($response->successful()) {
                    return true;
                }

                Log::warning('Resend API gửi OTP thất bại: HTTP ' . $response->status() . ' - ' . $response->body());
            } catch (\Throwable $e) {
                Log::warning('Resend API gửi OTP lỗi: ' . $e->getMessage());
            }
        }

        try {
            Mail::to($recipientEmail)->send(new ResetPasswordOtpMail($otp, $name));
            return true;
        } catch (\Throwable $e) {
            Log::warning('Không thể gửi email OTP đặt lại mật khẩu qua SMTP: ' . $e->getMessage());
            return false;
        }
    }
}
