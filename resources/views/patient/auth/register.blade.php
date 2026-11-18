@extends('layouts.public')

@section('title', 'Đăng ký - Nha Khoa Smile')

@section('content')
<div class="min-h-screen flex bg-slate-50">
    <!-- Left: Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden order-2 lg:order-1">
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="w-full max-w-md relative z-10 bg-white/70 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Tạo tài khoản</h2>
                <p class="text-gray-500 text-sm">Gia nhập cộng đồng chăm sóc nụ cười hoàn mỹ.</p>
            </div>

            <form action="{{ route('patient.register.store') }}" method="POST" class="space-y-5">
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

                <div class="space-y-4">
                    <div class="relative group">
                        <label for="name" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </label>
                        <input id="name" name="name" type="text" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Họ và tên" value="{{ old('name') }}">
                    </div>

                    <div class="relative group">
                        <label for="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </label>
                        <input id="phone" name="phone" type="text" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Số điện thoại (dùng để liên kết hồ sơ)" value="{{ old('phone') }}">
                    </div>

                    <div class="relative group">
                        <label for="password" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Mật khẩu (Tối thiểu 6 ký tự)">
                    </div>

                    <div class="relative group">
                        <label for="password_confirmation" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <div class="flex items-start mt-4">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500">
                    </div>
                    <div class="ml-2 text-xs text-gray-600">
                        Tôi đồng ý với <a href="#" class="text-cyan-600 hover:underline">Điều khoản dịch vụ</a> và <a href="#" class="text-cyan-600 hover:underline">Chính sách bảo mật</a> của Nha Khoa Smile.
                    </div>
                </div>

                <button type="submit" class="w-full relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-cyan-500/30 transform hover:-translate-y-0.5 transition-all duration-200 mt-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    Đăng ký tài khoản
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                Đã có tài khoản? 
                <a href="{{ route('patient.login') }}" class="font-bold text-cyan-600 hover:text-cyan-700 transition-colors">Đăng nhập</a>
            </div>
        </div>
    </div>

    <!-- Right: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-cyan-700 overflow-hidden items-center justify-center order-1 lg:order-2">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1598256989800-fea5f6c8d0bd?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-tr from-cyan-800/90 to-blue-600/80"></div>
        </div>
        
        <div class="relative z-10 p-12 text-white max-w-lg text-right flex flex-col items-end">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-xl border border-white/30 mb-8">
                NK
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Bắt đầu hành trình <br><span class="text-blue-200">Nụ Cười Mới</span></h1>
            <p class="text-cyan-100 text-lg mb-8">Chỉ mất 1 phút để tạo tài khoản. Đặc biệt: Hệ thống sẽ tự động đồng bộ hồ sơ cũ nếu bạn sử dụng cùng số điện thoại đã từng khám tại Nha Khoa Smile.</p>
            
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl inline-flex items-center gap-3">
                <div class="w-10 h-10 bg-cyan-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="text-left">
                    <p class="font-bold text-white leading-tight">Bảo mật tuyệt đối</p>
                    <p class="text-xs text-cyan-200">Dữ liệu y tế được mã hóa 100%</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
