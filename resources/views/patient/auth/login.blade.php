@extends('layouts.public')

@section('title', 'Đăng nhập - Nha Khoa Smile')

@section('content')
<div class="min-h-screen flex bg-slate-50">
    <!-- Left: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-blue-600 overflow-hidden items-center justify-center">
        <!-- Abstract Background -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=1200" alt="Nha Khoa Smile" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700/80 to-cyan-500/80"></div>
        </div>
        
        <div class="relative z-10 p-12 text-white max-w-lg">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-xl border border-white/30 mb-8">
                NK
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Chào mừng trở lại với <br><span class="text-cyan-300">Nha Khoa Smile</span></h1>
            <p class="text-blue-100 text-lg mb-8">Truy cập cổng thông tin để dễ dàng quản lý hồ sơ bệnh án, theo dõi lịch hẹn và hóa đơn của bạn mọi lúc mọi nơi.</p>
            
            <div class="flex items-center gap-4">
                <div class="flex -space-x-3">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600" src="https://i.pravatar.cc/100?img=1" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600" src="https://i.pravatar.cc/100?img=2" alt="User">
                    <img class="w-10 h-10 rounded-full border-2 border-blue-600" src="https://i.pravatar.cc/100?img=3" alt="User">
                </div>
                <p class="text-sm text-blue-100 font-medium">+10,000 bệnh nhân tin dùng</p>
            </div>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="w-full max-w-md relative z-10 bg-white/70 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Đăng nhập</h2>
                <p class="text-gray-500">Hệ thống quản lý Nha Khoa Smile</p>
            </div>

            @if (session('success') || session('status'))
                <div class="bg-emerald-50/90 backdrop-blur-sm border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm mb-6 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="font-medium">{{ session('success') ?? session('status') }}</div>
                </div>
            @endif

            <form action="{{ route('patient.login.store') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50/80 backdrop-blur-sm border border-red-100 text-red-600 p-4 rounded-2xl text-sm mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-none m-0 p-0">
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
                        <input id="login" name="login" type="text" required 
                               class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Email hoặc Số điện thoại" value="{{ old('login') }}">
                    </div>

                    <div class="relative group">
                        <label for="password" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-gray-900 placeholder-gray-400 font-medium" 
                               placeholder="Mật khẩu">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('patient.password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">Quên mật khẩu?</a>
                    </div>
                </div>

                <button type="submit" class="w-full relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Đăng nhập hệ thống
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <!-- Tài khoản mẫu đăng nhập nhanh -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 text-center">⚡ Chọn nhanh tài khoản trải nghiệm (Mật khẩu: password)</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="fillLogin('admin@smile.com')" class="p-2.5 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 font-bold text-left border border-purple-200 transition-colors flex items-center gap-1.5">
                        <span>🛡️</span>
                        <div>
                            <div class="font-extrabold">Quản trị viên</div>
                            <div class="text-[10px] text-purple-600 font-normal">admin@smile.com</div>
                        </div>
                    </button>
                    <button type="button" onclick="fillLogin('bacsi@smile.com')" class="p-2.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-left border border-blue-200 transition-colors flex items-center gap-1.5">
                        <span>🩺</span>
                        <div>
                            <div class="font-extrabold">Bác sĩ khám</div>
                            <div class="text-[10px] text-blue-600 font-normal">bacsi@smile.com</div>
                        </div>
                    </button>
                    <button type="button" onclick="fillLogin('letan@smile.com')" class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-left border border-emerald-200 transition-colors flex items-center gap-1.5">
                        <span>👩‍💼</span>
                        <div>
                            <div class="font-extrabold">Lễ tân / Thu ngân</div>
                            <div class="text-[10px] text-emerald-600 font-normal">letan@smile.com</div>
                        </div>
                    </button>
                    <button type="button" onclick="fillLogin('0981112233')" class="p-2.5 rounded-xl bg-amber-50 text-amber-800 hover:bg-amber-100 font-bold text-left border border-amber-200 transition-colors flex items-center gap-1.5">
                        <span>🧑</span>
                        <div>
                            <div class="font-extrabold">Bệnh nhân</div>
                            <div class="text-[10px] text-amber-700 font-normal">0981112233</div>
                        </div>
                    </button>
                </div>
            </div>

            <script>
                function fillLogin(val) {
                    const inputLogin = document.getElementById('login');
                    const inputPass = document.getElementById('password');
                    if (inputLogin) inputLogin.value = val;
                    if (inputPass) inputPass.value = 'password';
                }
            </script>

            <div class="mt-8 text-center text-sm text-gray-600">
                Chưa có tài khoản? 
                <a href="{{ route('patient.register') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection
