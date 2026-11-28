<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#0D7A68] rounded-xl text-white shadow-xs mb-3">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.5 2 6 4.5 6 8c0 2 .5 3.5 1 5.5.7 2.8 1.5 6.5 2.5 8.5.4.8 1.4 1 2 .5.7-.6 1.3-2 1.5-3 .2-1 .5-1 .7-1s.5 0 .7 1c.2 1 .8 2.4 1.5 3 .6.5 1.6.3 2-.5 1-2 1.8-5.7 2.5-8.5.5-2 1-3.5 1-5.5 0-3.5-2.5-6-6-6zm0 2c2.5 0 4 1.8 4 4.5 0 1.5-.4 2.8-.8 4.5-.7 2.8-1.5 6-2.2 7.5-.3-.5-.7-1.3-.9-2.2-.4-1.8-1.2-2.3-2.1-2.3s-1.7.5-2.1 2.3c-.2.9-.6 1.7-.9 2.2-.7-1.5-1.5-4.7-2.2-7.5-.4-1.7-.8-3-.8-4.5C8 5.8 9.5 4 12 4z"/>
            </svg>
        </div>
        <div class="flex items-center justify-center gap-2">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Đăng nhập Hệ thống</h2>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#D1FAE5] text-[#065F46] border border-emerald-200">
                v2.4
            </span>
        </div>
        <p class="text-slate-400 mt-1 text-xs">DCMS Pro • Hệ thống Quản trị {{ $clinicSettings['clinic_name'] }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-bold text-xs text-slate-700 mb-1">Email / Tài khoản</label>
            <div class="relative">
                <input id="email" class="block w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] text-xs shadow-xs" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block font-bold text-xs text-slate-700 mb-1">Mật khẩu</label>
            <div class="relative">
                <input id="password" class="block w-full px-3 py-2 border border-slate-200 rounded-xl focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] text-xs shadow-xs"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-5 text-xs">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#0D7A68] shadow-xs focus:ring-[#0D7A68]" name="remember">
                <span class="ms-2 text-slate-600 font-medium">Nhớ đăng nhập</span>
            </label>

            @if (Route::has('password.request'))
                <a class="font-medium text-[#0D7A68] hover:underline" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                Đăng nhập hệ thống
            </button>
        </div>
    </form>
</x-guest-layout>
