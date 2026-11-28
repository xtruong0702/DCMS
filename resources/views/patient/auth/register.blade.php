@extends('layouts.public')

@section('title', 'Đăng ký tài khoản bệnh nhân - ' . $clinicSettings['clinic_name'])

@section('content')
<div class="min-h-[calc(100vh-80px)] flex bg-[#effcf9]">
    <!-- Left: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-10 lg:p-14 order-2 lg:order-1">
        <div class="clinic-card w-full max-w-md p-8 sm:p-10 rounded-3xl">
            <div class="mb-7">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 mb-3">
                    <span class="pulse-dot pulse-dot-emerald"></span>
                    Đăng Ký Cổng Bệnh Nhân • DCMS
                </div>
                <h2 class="font-heading-clinic !text-2xl font-bold text-slate-900 tracking-tight">Tạo tài khoản mới</h2>
                <p class="text-xs text-slate-500 mt-1">Tự động liên kết hồ sơ cũ nếu bạn dùng cùng số điện thoại đã khám tại phòng khám.</p>
            </div>

            <form action="{{ route('patient.register.store') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-500/15 text-rose-700 p-3.5 rounded-xl text-xs mb-4 flex items-start gap-2.5">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-none m-0 p-0 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Họ và tên <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Nhập họ và tên của bạn">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Số điện thoại <span class="text-rose-500">*</span></label>
                    <input id="phone" name="phone" type="text" required value="{{ old('phone') }}"
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium tabular-nums"
                           placeholder="Ví dụ: 0912 345 678">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Mật khẩu <span class="text-rose-500">*</span></label>
                    <input id="password" name="password" type="password" required
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Tối thiểu 6 ký tự">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Nhập lại mật khẩu <span class="text-rose-500">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="input-clinic w-full px-3.5 py-2.5 rounded-xl text-xs font-medium"
                           placeholder="Xác nhận lại mật khẩu">
                </div>

                <div class="flex items-start pt-1">
                    <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded mt-0.5">
                    <label for="terms" class="ml-2 block text-xs text-slate-600 leading-relaxed">
                        Tôi đồng ý với chính sách bảo mật hồ sơ y tế điện tử của {{ $clinicSettings['clinic_name'] }}.
                    </label>
                </div>

                <button type="submit" class="btn-press btn-clinic-primary w-full py-3 rounded-xl text-xs flex items-center justify-center gap-2 mt-2">
                    <span>Đăng ký tài khoản bệnh nhân</span>
                    <span>&rarr;</span>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100/70 text-center text-xs text-slate-500">
                Đã có tài khoản?
                <a href="{{ route('patient.login') }}" class="font-bold text-teal-700 hover:underline ml-1">Đăng nhập ngay</a>
            </div>
        </div>
    </div>

    <!-- Right: Clinic Branding Panel -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0f3e36] overflow-hidden items-center justify-center order-1 lg:order-2">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1598256989800-fea5f6c8d0bd?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0f3e36] via-[#0c2d27] to-[#081412]"></div>
        </div>

        <div class="relative z-10 p-12 text-white max-w-lg space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-[#d4af37]/35">
                    <svg class="w-7 h-7 text-[#f3e5ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-[#f3e5ab]">{{ $clinicSettings['clinic_name'] }}</span>
                    <h2 class="font-heading-clinic text-xl font-bold !text-white">Hồ Sơ Điện Tử DCMS</h2>
                </div>
            </div>

            <h1 class="font-heading-clinic text-3xl font-bold tracking-tight leading-tight !text-white">
                Theo dõi lộ trình điều trị <br><span class="text-[#f3e5ab]">Nhanh chóng & Minh bạch</span>
            </h1>
            <p class="text-[#d9ebe7] text-sm leading-relaxed">
                Chỉ mất 1 phút để tạo tài khoản. Xem lại lịch sử khám, sơ đồ 32 răng chuẩn FDI, đơn thuốc và hóa đơn VietQR mọi lúc mọi nơi.
            </p>

            <div class="bg-white/10 backdrop-blur-md border border-[#d4af37]/25 p-4 rounded-2xl inline-flex items-center gap-3">
                <div class="w-10 h-10 bg-[#d4af37] text-[#081412] rounded-xl flex items-center justify-center font-bold">🛡️</div>
                <div>
                    <p class="font-bold text-white text-xs leading-tight">Bảo mật tuyệt đối</p>
                    <p class="text-[11px] text-[#b0c4be] mt-0.5">Hồ sơ y tế chỉ do Bác sĩ & Lễ tân cập nhật</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
