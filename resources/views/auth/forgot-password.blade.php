<x-guest-layout>
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl text-white font-bold text-2xl shadow-lg mb-3">
            NK
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Quên mật khẩu</h2>
        <p class="text-gray-500 mt-1 text-sm">Hệ thống DCMS - {{ $clinicSettings['clinic_name'] }}</p>
    </div>

    <div class="mb-5 text-sm text-gray-600 leading-relaxed bg-blue-50/70 p-4 rounded-xl border border-blue-100/80">
        Nhập <strong>Email hoặc Số điện thoại</strong> đã đăng ký tài khoản. Hệ thống sẽ tạo mã xác thực OTP để bạn thiết lập lại mật khẩu an toàn.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email or Phone -->
        <div>
            <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Email hoặc Số điện thoại</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" 
                       type="text" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com hoặc 0987654321" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Tiếp tục & Lấy mã OTP
            </button>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500 hover:underline">
                &larr; Quay lại Đăng nhập
            </a>
        </div>
    </form>
</x-guest-layout>
