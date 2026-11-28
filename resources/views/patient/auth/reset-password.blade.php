@extends('layouts.public')

@section('title', 'Đặt lại mật khẩu - ' . $clinicSettings['clinic_name'])

@section('content')
<div class="min-h-[calc(100vh-80px)] flex bg-[#effcf9]">
    <!-- Left: Emerald & Gold Clinic Branding Panel -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0f3e36] overflow-hidden items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=1200" alt="{{ $clinicSettings['clinic_name'] }}" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0f3e36] via-[#0c2d27] to-[#081412]"></div>
        </div>

        <div class="relative z-10 p-12 text-white max-w-lg space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-[#d4af37]/35">
                    <svg class="w-7 h-7 text-[#f3e5ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-[#f3e5ab]">{{ $clinicSettings['clinic_name'] }}</span>
                    <h2 class="font-heading-clinic text-xl font-bold !text-white">Thiết Lập Mật Khẩu Mới</h2>
                </div>
            </div>

            <h1 class="font-heading-clinic text-3xl font-bold tracking-tight leading-tight !text-white">
                Bảo vệ nụ cười, <br><span class="text-[#f3e5ab]">An tâm trọn vẹn</span>
            </h1>
            <p class="text-[#d9ebe7] text-sm leading-relaxed">
                Nhập mã OTP 6 chữ số đã gửi về Gmail của bạn và đặt mật khẩu mới để bảo vệ hồ sơ bệnh án điện tử.
            </p>

            <div class="bg-white/10 backdrop-blur-md border border-[#d4af37]/25 p-5 rounded-2xl space-y-2.5 text-xs text-white">
                <div class="flex items-center gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-[#d4af37] text-[#081412] font-bold text-[10px] flex items-center justify-center">✓</span>
                    <span>Mật khẩu tối thiểu 6 ký tự</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-[#d4af37] text-[#081412] font-bold text-[10px] flex items-center justify-center">✓</span>
                    <span>Nên kết hợp chữ cái và số để tăng độ bảo mật</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Reset Password Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-10 lg:p-14">
        <div class="clinic-card w-full max-w-md p-8 sm:p-10 rounded-3xl">
            <div class="mb-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 mb-3">
                    <span class="pulse-dot pulse-dot-emerald"></span>
                    Xác Thực OTP • DCMS
                </div>
                <h2 class="font-heading-clinic !text-2xl font-bold text-slate-900 tracking-tight">Đặt lại mật khẩu</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Email tài khoản: <strong class="text-slate-900">{{ $identity ?? session('patient_reset_identity') }}</strong>
                </p>
            </div>

            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-500/20 text-emerald-800 p-3.5 rounded-xl text-xs mb-4 flex items-start gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="font-medium leading-relaxed">{{ session('status') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-500/20 text-rose-700 p-3.5 rounded-xl text-xs mb-4 flex items-start gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <ul class="list-none m-0 p-0 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patient.password.update') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="otp" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Mã xác thực OTP (6 chữ số) <span class="text-rose-500">*</span></label>
                    <input id="otp" name="otp" type="text" maxlength="6" required autofocus value="{{ old('otp') }}"
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-base font-mono font-bold tracking-widest"
                           placeholder="123456">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Mật khẩu mới <span class="text-rose-500">*</span></label>
                    <input id="password" name="password" type="password" required
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Tối thiểu 6 ký tự">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Nhập lại mật khẩu mới <span class="text-rose-500">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Xác nhận mật khẩu mới">
                </div>

                <button type="submit" class="btn-press btn-clinic-primary w-full py-3 rounded-xl text-xs flex items-center justify-center gap-2 mt-2">
                    <span>Xác nhận &amp; Lưu mật khẩu mới</span>
                    <span>✓</span>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100/70 flex items-center justify-between text-xs text-slate-500">
                <a href="{{ route('patient.password.request') }}" class="font-bold text-teal-700 hover:underline">
                    &larr; Gửi lại mã OTP
                </a>
                <a href="{{ route('patient.login') }}" class="font-semibold text-slate-500 hover:underline">
                    Hủy bỏ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
