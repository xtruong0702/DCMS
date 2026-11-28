<x-guest-layout>
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl text-white font-bold text-2xl shadow-lg mb-3">
            NK
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Đặt lại mật khẩu</h2>
        <p class="text-gray-500 mt-1 text-sm">Hệ thống DCMS - {{ $clinicSettings['clinic_name'] }}</p>
        @if (session('auth_reset_identity'))
            <p class="text-xs text-blue-600 font-semibold mt-2 bg-blue-50 py-1 px-3 rounded-full inline-block">
                Tài khoản: {{ session('auth_reset_identity') }}
            </p>
        @endif
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') ?? 'otp' }}">

        <!-- OTP Code -->
        <div class="mb-4">
            <label for="otp" class="block font-semibold text-sm text-gray-700 mb-1">Mã xác thực OTP (6 chữ số)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <input id="otp" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono tracking-widest text-base font-bold" 
                       type="text" name="otp" maxlength="6" value="{{ old('otp') }}" required autofocus placeholder="123456" />
            </div>
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="mb-4">
            <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">Mật khẩu mới (tối thiểu 6 ký tự)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                       type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block font-semibold text-sm text-gray-700 mb-1">Nhập lại mật khẩu mới</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <input id="password_confirmation" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                       type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Xác nhận & Cập nhật mật khẩu
            </button>
        </div>

        <div class="mt-6 flex items-center justify-between text-sm">
            <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-500 hover:underline">
                &larr; Gửi lại mã OTP
            </a>
            <a href="{{ route('login') }}" class="font-medium text-gray-500 hover:text-gray-700">
                Hủy bỏ
            </a>
        </div>
    </form>
</x-guest-layout>
