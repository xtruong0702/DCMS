<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        // If not coming with a valid session OTP and not having a token
        if (!session('auth_reset_otp') && !$request->route('token')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if resetting via OTP session
        if (session('auth_reset_otp') && session('auth_reset_user_id')) {
            $request->validate([
                'otp' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ], [
                'otp.required' => 'Vui lòng nhập mã xác thực OTP.',
                'password.required' => 'Vui lòng nhập mật khẩu mới.',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
            ]);

            $savedOtp = session('auth_reset_otp');
            $userId = session('auth_reset_user_id');
            $expiresAt = session('auth_reset_expires_at');

            if (!$savedOtp || !$userId || !$expiresAt || now()->gt($expiresAt)) {
                return redirect()->route('password.request')->withErrors(['email' => 'Phiên xác thực đã hết hạn. Vui lòng thực hiện lại.']);
            }

            if (trim($request->otp) !== (string) $savedOtp) {
                return back()->withInput()->withErrors(['otp' => 'Mã xác thực OTP không chính xác. Vui lòng kiểm tra lại.']);
            }

            $user = User::find($userId);
            if (!$user) {
                return redirect()->route('password.request')->withErrors(['email' => 'Không tìm thấy tài khoản người dùng.']);
            }

            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));

            session()->forget(['auth_reset_user_id', 'auth_reset_identity', 'auth_reset_otp', 'auth_reset_expires_at']);

            if ($user->role && strtolower($user->role->name) === 'patient') {
                return redirect()->route('patient.login')->with('success', 'Đặt lại mật khẩu thành công! Quý khách vui lòng đăng nhập bằng mật khẩu mới.');
            }

            return redirect()->route('login')->with('status', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập với mật khẩu mới.');
        }

        // Fallback for standard token
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
