<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPasswordOtpMail;

class PatientAuthController extends Controller
{
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

        // Tạo User
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $patientRole->id,
            'is_active' => true,
        ]);

        // Kiểm tra xem đã có bệnh nhân nào có số điện thoại này chưa
        $patient = Patient::where('phone', $request->phone)->first();

        if ($patient) {
            // Liên kết
            $patient->update(['user_id' => $user->id]);
        } else {
            // Tạo mới Patient record
            Patient::create([
                'patient_code' => 'BN' . date('YmdHis'),
                'name' => $request->name,
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

        return redirect()->route('patient.dashboard')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function showLogin()
    {
        return view('patient.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$loginType => $credentials['login'], 'password' => $credentials['password']])) {
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

        $user = User::where('phone', $login)->orWhere('email', $login)->first();

        if (!$user) {
            $patient = Patient::where('phone', $login)->whereNotNull('user_id')->first();
            if ($patient && $patient->user) {
                $user = $patient->user;
            }
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'login' => 'Không tìm thấy tài khoản với thông tin đã nhập. Vui lòng kiểm tra lại.',
            ]);
        }

        $otp = (string) rand(100000, 999999);

        session([
            'patient_reset_user_id' => $user->id,
            'patient_reset_identity' => $login,
            'patient_reset_otp' => $otp,
            'patient_reset_expires_at' => now()->addMinutes(15),
        ]);

        $masked = $login;
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $parts = explode('@', $login);
            $masked = substr($parts[0], 0, 2) . '***@' . $parts[1];
        } elseif (strlen($login) >= 6) {
            $masked = substr($login, 0, 3) . '****' . substr($login, -3);
        }

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

        if ($mailSent) {
            $maskedEmail = substr(explode('@', $recipientEmail)[0], 0, 2) . '***@' . explode('@', $recipientEmail)[1];
            $statusMessage = "Mã xác thực OTP đã được gửi đến hộp thư {$maskedEmail}. Vui lòng kiểm tra email (bao gồm cả thư mục Spam/Rác).";
        } else {
            $statusMessage = "Mã xác thực OTP đã được tạo cho {$masked}. Mã xác nhận của bạn là: {$otp} (Hiệu lực trong 15 phút).";
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

        if (!$savedOtp || !$userId || !$expiresAt || now()->gt($expiresAt)) {
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Phiên xác thực đã hết hạn. Vui lòng thực hiện lại.',
            ]);
        }

        if (trim($request->otp) !== (string) $savedOtp) {
            return back()->withInput()->withErrors([
                'otp' => 'Mã xác thực OTP không chính xác. Vui lòng kiểm tra lại.',
            ]);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('patient.password.request')->withErrors([
                'login' => 'Không tìm thấy tài khoản người dùng.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['patient_reset_user_id', 'patient_reset_identity', 'patient_reset_otp', 'patient_reset_expires_at']);

        return redirect()->route('patient.login')->with('success', 'Đổi mật khẩu thành công! Quý khách vui lòng đăng nhập bằng mật khẩu mới.');
    }
}
