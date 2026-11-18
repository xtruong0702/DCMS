@extends('layouts.public')

@section('title', 'Đặt lại mật khẩu - Nha Khoa Smile')

@section('content')
<div class="min-h-screen flex bg-slate-50">
    <!-- Left: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-blue-600 overflow-hidden items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700/80 to-cyan-500/80"></div>
        </div>
        
        <div class="relative z-10 p-12 text-white max-w-lg">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-xl border border-white/30 mb-8">
                NK
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Bảo vệ nụ cười, <br><span class="text-cyan-300">an tâm trọn vẹn</span></h1>
            <p class="text-blue-100 text-lg mb-8">Thiết lập mật khẩu mới có độ bảo mật cao để bảo vệ hồ sơ bệnh án và dữ liệu khám chữa bệnh của quý khách.</p>
            
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20 text-white space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-cyan-400 text-blue-900 font-bold text-xs flex items-center justify-center">✓</span>
                    <span class="text-sm">Tối thiểu 6 ký tự</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-cyan-400 text-blue-900 font-bold text-xs flex items-center justify-center">✓</span>
                    <span class="text-sm">Kết hợp chữ cái và số để tăng độ an toàn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="w-full max-w-md relative z-10 bg-white/70 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50">
            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-cyan-50 text-cyan-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Đặt lại mật khẩu</h2>
                <p class="text-gray-500 text-sm">
                    Tài khoản: <span class="font-bold text-slate-800">{{ $identity ?? session('patient_reset_identity') }}</span>
                </p>
            </div>

            @if (session('status'))
                <div class="bg-cyan-50/90 border border-cyan-200 text-cyan-900 p-4 rounded-2xl text-sm mb-6 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="font-medium leading-relaxed">{{ session('status') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50/80 backdrop-blur-sm border border-red-100 text-red-600 p-4 rounded-2xl text-sm mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <ul class="list-none m-0 p-0 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patient.password.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- OTP Input -->
                <div class="space-y-1">
                    <label for="otp" class="block text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Mã xác thực OTP (6 chữ số)</label>
                    <div class="relative group">
                        <label for="otp" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                        <input id="otp" name="otp" type="text" maxlength="6" required autofocus
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 tracking-widest font-mono text-lg font-bold placeholder-gray-300" 
                               placeholder="123456" value="{{ old('otp') }}">
                    </div>
                </div>

                <!-- New Password Input -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Mật khẩu mới</label>
                    <div class="relative group">
                        <label for="password" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Tối thiểu 6 ký tự">
                    </div>
                </div>

                <!-- Password Confirmation Input -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Nhập lại mật khẩu mới</label>
                    <div class="relative group">
                        <label for="password_confirmation" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Xác nhận mật khẩu">
                    </div>
                </div>

                <button type="submit" class="w-full relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Xác nhận & Lưu mật khẩu mới
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600 flex items-center justify-between">
                <a href="{{ route('patient.password.request') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    &larr; Gửi lại mã OTP
                </a>
                <a href="{{ route('patient.login') }}" class="font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    Hủy bỏ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

