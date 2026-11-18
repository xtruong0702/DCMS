<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string'],
        ], [
            'email.required' => 'Vui lòng nhập Email hoặc Số điện thoại của bạn.',
        ]);

        $identity = trim($request->input('email'));

        $user = User::where('email', $identity)
            ->orWhere('phone', $identity)
            ->first();

        if (!$user) {
            $patient = Patient::where('phone', $identity)
                ->orWhere('email', $identity)
                ->first();
            if ($patient && $patient->user) {
                $user = $patient->user;
            }
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'email' => 'Không tìm thấy tài khoản với Email hoặc Số điện thoại này.',
            ]);
        }

        $otp = (string) rand(100000, 999999);

        session([
            'auth_reset_user_id' => $user->id,
            'auth_reset_identity' => $identity,
            'auth_reset_otp' => $otp,
            'auth_reset_expires_at' => now()->addMinutes(15),
        ]);

        $masked = $identity;
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $parts = explode('@', $identity);
            $masked = substr($parts[0], 0, 2) . '***@' . $parts[1];
        } elseif (strlen($identity) >= 6) {
            $masked = substr($identity, 0, 3) . '****' . substr($identity, -3);
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
            $statusMessage = "Mã xác thực OTP đã được gửi đến email {$maskedEmail}. Vui lòng kiểm tra hộp thư đến (hoặc hòm thư Spam/Rác).";
        } else {
            $statusMessage = "Mã xác thực OTP đã được tạo cho {$masked}. Mã xác nhận của bạn là: {$otp} (Hiệu lực trong 15 phút).";
        }

        return redirect()->route('password.reset', ['token' => 'otp'])
            ->with('status', $statusMessage);
    }
}
