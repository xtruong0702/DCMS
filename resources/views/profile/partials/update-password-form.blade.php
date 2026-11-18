<section>
    <header>
        <h2 class="text-base font-extrabold text-slate-800 uppercase">
            Đổi Mật Khẩu Bảo Mật
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            Sử dụng mật khẩu có độ dài từ 8 ký tự trở lên để bảo vệ tài khoản của bạn.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Mật khẩu hiện tại" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Mật khẩu mới" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Xác nhận mật khẩu mới" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>Cập nhật mật khẩu</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-600">
                    ✓ Đã đổi mật khẩu thành công.
                </p>
            @endif
        </div>
    </form>
</section>
