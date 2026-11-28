<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Role;
use App\Traits\EnsuresClinicDataSeeded;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPasswordOtpMail;

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
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Tạo role Patient nếu chưa có
        $patientRole = Role::firstOrCreate(
            ['name' => 'Patient'],
            ['description' => 'Bệnh nhân']
        );

        // A phone number alone does not prove identity. Create a private profile
        // for the new account; staff can link an existing clinical record later.
        $user = DB::transaction(function () use ($request, $patientRole) {
            $user = User::create([
                'name' => $request->name,
                'phone' => trim($request->phone),
                'password' => Hash::make($request->password),
                'role_id' => $patientRole->id,
                'is_active' => true,
            ]);

            Patient::create([
                'patient_code' => 'BN' . date('YmdHis') . random_int(100, 999),
                'name' => $request->name,
                'phone' => trim($request->phone),
                'user_id' => $user->id,
            ]);
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
            'login' => 'required|string',
        ], [
            'login.required' => 'Vui lòng nhập Số điện thoại hoặc Email đã đăng ký.',
        ]);

        $login = trim($request->input('login'));
        $patient = null;

        // Chỉ cho phép đặt lại mật khẩu qua luồng này đối với tài khoản Bệnh nhân (Patient)
        $user = User::whereHas('role', function ($q) {
                $q->whereRaw('LOWER(name) = ?', ['patient']);
            })
            ->where(function ($q) use ($login) {
                $q->where('phone', $login)->orWhere('email', $login);
            })
            ->first();

        if (!$user) {
            $patient = Patient::where('phone', $login)->whereNotNull('user_id')->with('user.role')->first();
            if ($patient && $patient->user && strtolower($patient->user->role->name ?? '') === 'patient') {
                $user = $patient->user;
            }
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'login' => 'Không tìm thấy tài khoản bệnh nhân với thông tin đã nhập. Nhân viên phòng khám vui lòng liên hệ Quản trị viên.',
            ]);
        }

        if (isset($user->is_active) && !$user->is_active) {
            return back()->withInput()->withErrors([
                'login' => 'Tài khoản này đã bị khóa. Vui lòng liên hệ Hotline 0775 761 388.',
            ]);
        }

        $otp = (string) random_int(100000, 999999);

        // Gửi email chứa OTP nếu tài khoản có email
        $recipientEmail = $user->email ?? ($patient->email ?? null);
        $mailSent = false;

        if ($recipientEmail && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($recipientEmail)->send(new ResetPasswordOtpMail($otp, $user->name));
                $mailSent = true;
            } catch (\Throwable $e) {
                Log::warning('Không thể gửi email OTP đặt lại mật khẩu: ' . $e->getMessage());
            }
        }

        if (!$mailSent && !app()->isLocal()) {
            return back()->withInput()->withErrors([
                'login' => 'Tài khoản chưa liên kết email hợp lệ hoặc không thể gửi mã OTP lúc này. Vui lòng liên hệ Hotline 0775 761 388 để được hỗ trợ đặt lại mật khẩu.',
            ]);
        }

        session([
            'patient_reset_user_id' => $user->id,
            'patient_reset_identity' => $login,
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
}
