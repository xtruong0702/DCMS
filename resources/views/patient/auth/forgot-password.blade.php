@extends('layouts.public')

@section('title', 'Quên mật khẩu - ' . $clinicSettings['clinic_name'])

@section('content')
<div class="min-h-screen flex bg-slate-50">
    <!-- Left: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-blue-600 overflow-hidden items-center justify-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700/80 to-cyan-500/80"></div>
        </div>
        
        <div class="relative z-10 p-12 text-white max-w-lg">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-xl border border-white/30 mb-8">
                NK
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Khôi phục quyền truy cập tài khoản</h1>
            <p class="text-blue-100 text-lg mb-8">Chúng tôi sẽ hỗ trợ quý khách lấy lại mật khẩu nhanh chóng và bảo mật thông tin an toàn tuyệt đối.</p>
            
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <svg class="w-6 h-6 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-white text-base">Bảo mật đa lớp</h4>
                    <p class="text-sm text-blue-100">Xác thực OTP tức thì qua điện thoại / email</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="w-full max-w-md relative z-10 bg-white/70 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50">
            <div class="text-center mb-10">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Quên mật khẩu?</h2>
                <p class="text-gray-500 text-sm">Nhập số điện thoại hoặc email quý khách đã dùng khi đăng ký tài khoản.</p>
            </div>

            <form action="{{ route('patient.password.email') }}" method="POST" class="space-y-6">
                @csrf
                
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

                <div class="space-y-5">
                    <div class="relative group">
                        <label for="login" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </label>
                        <input id="login" name="login" type="text" required autofocus
                               class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Số điện thoại hoặc Email" value="{{ old('login') }}">
                    </div>
                </div>

                <button type="submit" class="w-full relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tiếp tục
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600 space-y-2">
                <div>
                    Nhớ mật khẩu rồi? 
                    <a href="{{ route('patient.login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Đăng nhập</a>
                </div>
                <div>
                    Chưa có tài khoản? 
                    <a href="{{ route('patient.register') }}" class="font-semibold text-slate-500 hover:text-blue-600 transition-colors">Đăng ký mới</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

