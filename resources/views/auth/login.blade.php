<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl text-white font-bold text-3xl shadow-lg mb-4">
            NK
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Đăng nhập Hệ thống</h2>
        <p class="text-gray-500 mt-2 text-sm">DCMS - Nha Khoa Smile</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Email / Tên đăng nhập</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">Mật khẩu</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-shadow"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Nhớ đăng nhập</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-blue-600 hover:text-blue-500 hover:underline" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors cursor-pointer">
                Đăng Nhập
            </button>
        </div>
    </form>
</x-guest-layout>
