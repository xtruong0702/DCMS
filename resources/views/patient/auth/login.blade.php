@extends('layouts.public')

@section('title', 'Đăng nhập Cổng Bệnh Nhân - ' . $clinicSettings['clinic_name'])

@section('content')
<div class="min-h-[calc(100vh-80px)] flex bg-[#effcf9]">
    <!-- Left: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0f3e36] overflow-hidden items-center justify-center">
        <!-- Abstract Background -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0f3e36] via-[#0c2d27] to-[#081412]"></div>
        </div>
        
        <div class="relative z-10 p-12 text-white max-w-lg">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-[#d4af37]/35">
                    <svg class="w-7 h-7 text-[#f3e5ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-[#f3e5ab]">Cổng Bệnh Nhân</span>
                    <h2 class="font-heading-clinic text-xl font-bold !text-white">{{ $clinicSettings['clinic_name'] }}</h2>
                </div>
            </div>

            <h1 class="font-heading-clinic text-3xl font-bold tracking-tight mb-4 leading-tight !text-white">Quản lý sức khỏe nụ cười <br><span class="text-[#f3e5ab]">Chủ động & Tiện lợi</span></h1>
            <p class="text-[#d9ebe7] text-sm mb-8 leading-relaxed">Truy cập hồ sơ bệnh án điện tử, tra cứu đơn thuốc, theo dõi lịch hẹn và quét mã VietQR thanh toán viện phí tức thì.</p>
            
            <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                <div class="flex -space-x-2">
                    <img class="w-9 h-9 rounded-full border-2 border-[#0f3e36]" src="https://i.pravatar.cc/100?img=1" alt="User">
                    <img class="w-9 h-9 rounded-full border-2 border-[#0f3e36]" src="https://i.pravatar.cc/100?img=2" alt="User">
                    <img class="w-9 h-9 rounded-full border-2 border-[#0f3e36]" src="https://i.pravatar.cc/100?img=3" alt="User">
                </div>
                <div>
                    <p class="text-xs font-bold text-white">+15.000 bệnh nhân tin dùng</p>
                    <p class="text-[11px] text-[#b0c4be]">Hệ thống nha khoa tiêu chuẩn số DCMS</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-10 lg:p-16">
        <div class="clinic-card w-full max-w-md p-8 sm:p-10 rounded-3xl">
            <div class="mb-7">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 mb-3">
                    <span class="pulse-dot pulse-dot-emerald"></span>
                    Cổng Tra Cứu Bệnh Nhân • DCMS
                </div>
                <h2 class="font-heading-clinic !text-2xl font-bold text-slate-900 tracking-tight">Đăng nhập tài khoản</h2>
                <p class="text-xs text-slate-500 mt-1">Dành cho khách hàng tra cứu lịch hẹn, hồ sơ bệnh án & hóa đơn</p>
            </div>

            @if (session('success') || session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl text-xs mb-5 flex items-start gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="font-medium">{{ session('success') ?? session('status') }}</div>
                </div>
            @endif

            <form action="{{ route('patient.login.store') }}" method="POST" class="space-y-4">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 p-3.5 rounded-xl text-xs mb-5 flex items-start gap-2.5">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-none m-0 p-0 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="login" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Số điện thoại hoặc Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input id="login" name="login" type="text" required 
                               class="input-clinic w-full pl-10 pr-4 py-2.5 rounded-xl text-xs font-medium" 
                               placeholder="Ví dụ: 0982223344" value="{{ old('login') }}">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold uppercase text-slate-600">Mật khẩu</label>
                        <a href="{{ route('patient.password.request') }}" class="text-xs font-semibold text-teal-700 hover:underline">Quên mật khẩu?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input id="password" name="password" type="password" required 
                               class="input-clinic w-full pl-10 pr-4 py-2.5 rounded-xl text-xs font-medium" 
                               placeholder="Nhập mật khẩu của bạn">
                    </div>
                </div>

                <div class="flex items-center pt-1">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded">
                    <label for="remember_me" class="ml-2 block text-xs text-slate-600 font-medium">Ghi nhớ đăng nhập trên thiết bị này</label>
                </div>

                <button type="submit" class="btn-press btn-clinic-primary w-full py-3 rounded-xl text-xs flex items-center justify-center gap-2 mt-2">
                    <span>Đăng Nhập</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100/70 text-center text-xs text-slate-500">
                Chưa có tài khoản bệnh nhân? 
                <a href="{{ route('patient.register') }}" class="font-bold text-teal-700 hover:underline ml-1">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection
