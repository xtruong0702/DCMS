<section>
    <header>
        <h2 class="text-base font-extrabold text-slate-800 uppercase">
            Thông Tin Tài Khoản
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            Cập nhật họ tên hiển thị và địa chỉ email đăng nhập của bạn.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Họ và tên" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Địa chỉ Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>Lưu thông tin</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-600">
                    ✓ Đã lưu thành công.
                </p>
            @endif
        </div>
    </form>
</section>
