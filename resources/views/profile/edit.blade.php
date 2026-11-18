<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    👤 Hồ Sơ Tài Khoản & Bảo Mật
                </h2>
                <p class="text-xs text-slate-500 mt-1">Cập nhật thông tin cá nhân và mật khẩu đăng nhập hệ thống</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
