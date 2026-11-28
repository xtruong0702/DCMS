@extends('layouts.public')

@section('title', 'Quên mật khẩu - ' . $clinicSettings['clinic_name'])

@section('content')
<div class="min-h-[calc(100vh-80px)] flex bg-[#effcf9]">
    <!-- Left: Emerald & Gold Clinic Branding Panel -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0f3e36] overflow-hidden items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=1200" alt="{{ $clinicSettings['clinic_name'] }}" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0f3e36] via-[#0c2d27] to-[#081412]"></div>
        </div>

        <div class="relative z-10 p-12 text-white max-w-lg space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-[#d4af37]/35">
                    <svg class="w-7 h-7 text-[#f3e5ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-[#f3e5ab]">{{ $clinicSettings['clinic_name'] }}</span>
                    <h2 class="font-heading-clinic text-xl font-bold !text-white">Khôi Phục Tài Khoản</h2>
                </div>
            </div>

            <h1 class="font-heading-clinic text-3xl font-bold tracking-tight leading-tight !text-white">
                Khôi phục quyền truy cập <br><span class="text-[#f3e5ab]">Nhanh chóng &amp; An toàn</span>
            </h1>
            <p class="text-[#d9ebe7] text-sm leading-relaxed">
                Nhập địa chỉ Gmail đã đăng ký để hệ thống gửi mã xác thực OTP 6 chữ số trực tiếp vào hộp thư của quý khách.
            </p>

            <div class="bg-white/10 backdrop-blur-md border border-[#d4af37]/25 p-4 rounded-2xl inline-flex items-center gap-3">
                <div class="w-10 h-10 bg-[#d4af37] text-[#081412] rounded-xl flex items-center justify-center font-bold">✉️</div>
                <div>
                    <p class="font-bold text-white text-xs leading-tight">Xác thực OTP qua Gmail</p>
                    <p class="text-[11px] text-[#b0c4be] mt-0.5">Mã có hiệu lực trong 15 phút &amp; bảo mật tuyệt đối</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Forgot Password Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-10 lg:p-14">
        <div class="clinic-card w-full max-w-md p-8 sm:p-10 rounded-3xl">
            <div class="mb-7">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 mb-3">
                    <span class="pulse-dot pulse-dot-emerald"></span>
                    Khôi Phục Mật Khẩu • DCMS
                </div>
                <h2 class="font-heading-clinic !text-2xl font-bold text-slate-900 tracking-tight">Quên mật khẩu?</h2>
                <p class="text-xs text-slate-500 mt-1">Nhập địa chỉ <strong>Email (Gmail)</strong> quý khách đã dùng khi đăng ký tài khoản bệnh nhân.</p>
            </div>

            <form action="{{ route('patient.password.email') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-500/20 text-rose-700 p-3.5 rounded-xl text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-none m-0 p-0 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Địa chỉ Email (Gmail) <span class="text-rose-500">*</span></label>
                    <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Ví dụ: nguyenvana@gmail.com">
                    <p class="mt-1.5 text-[11px] text-slate-400">Chỉ hỗ trợ nhận mã xác thực OTP qua Email (Gmail), không nhập số điện thoại.</p>
                </div>

                <button type="submit" class="btn-press btn-clinic-primary w-full py-3 rounded-xl text-xs flex items-center justify-center gap-2 mt-2">
                    <span>Gửi mã OTP về Gmail</span>
                    <span>&rarr;</span>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100/70 text-center text-xs text-slate-500 space-y-2">
                <div>
                    Nhớ mật khẩu rồi?
                    <a href="{{ route('patient.login') }}" class="font-bold text-teal-700 hover:underline ml-1">Đăng nhập ngay</a>
                </div>
                <div>
                    Chưa có tài khoản?
                    <a href="{{ route('patient.register') }}" class="font-bold text-teal-700 hover:underline ml-1">Đăng ký mới</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
