<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    ➕ Thêm Tài Khoản Nhân Sự Mới
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tạo tài khoản đăng nhập cho Bác sĩ điều trị, Lễ tân & Thu ngân hoặc Quản trị viên</p>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách nhân sự
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 px-5 py-4 rounded-2xl text-sm">
                    <div class="font-extrabold mb-1.5 flex items-center gap-2">
                        <span>⚠️ Vui lòng kiểm tra lại thông tin nhập:</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-1 text-xs font-semibold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
                <form method="POST" action="{{ route('admin.staff.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Họ và tên nhân sự <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: BS. Nguyễn Văn Minh / Lễ tân Thu Hà" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('name') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Email đăng nhập <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="VD: bacsi.minh@smile.com" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('email') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Mật khẩu khởi tạo (Tối thiểu 6 ký tự) <span class="text-red-500">*</span></label>
                            <input type="password" name="password" placeholder="Nhập ít nhất 6 ký tự (VD: 123456)" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required minlength="6">
                            @error('password') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số điện thoại liên hệ</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="VD: 0909123456" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số CCCD / CMND (Tùy chọn)</label>
                            <input type="text" name="cccd" value="{{ old('cccd') }}" placeholder="Nhập 12 số CCCD (không bắt buộc)" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('cccd') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Địa chỉ nơi ở (Tùy chọn)</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Quận/Huyện, Tỉnh/Thành phố" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="p-5 border border-indigo-200 rounded-2xl bg-indigo-50/50 space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-indigo-900 mb-1.5">Phân quyền (Vai trò hệ thống) <span class="text-red-500">*</span></label>
                            <select name="role_id" id="role_id" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500" required onchange="toggleSpecialty(this)">
                                <option value="">-- Chọn vai trò nhân sự --</option>
                                @foreach($roles as $role)
                                    @php
                                        $rLower = strtolower($role->name);
                                        $viRoleName = match($rLower) {
                                            'admin' => '🛡️ Quản trị viên hệ thống (Admin)',
                                            'doctor' => '🩺 Bác sĩ điều trị (Doctor)',
                                            'receptionist' => '🛎️ Lễ tân & Thu ngân (Receptionist)',
                                            default => $role->name,
                                        };
                                    @endphp
                                    <option value="{{ $role->id }}" data-name="{{ $rLower }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $viRoleName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div id="specialty_div" style="display: none;" class="space-y-4 pt-2 border-t border-indigo-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-indigo-900 mb-1.5">Chuyên khoa Bác sĩ</label>
                                    <input type="text" name="specialty" list="specialty_suggestions" value="{{ old('specialty') }}" placeholder="Chọn hoặc nhập chuyên khoa (VD: Cấy ghép Implant)" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <datalist id="specialty_suggestions">
                                        @if(isset($specialties))
                                            @foreach($specialties as $spec)
                                                <option value="{{ $spec->name }}"></option>
                                            @endforeach
                                        @endif
                                        <option value="Nha khoa tổng quát"></option>
                                        <option value="Chỉnh nha - Niềng răng"></option>
                                        <option value="Cấy ghép Implant"></option>
                                        <option value="Phục hình răng sứ thẩm mỹ"></option>
                                    </datalist>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-indigo-900 mb-1.5">Mô tả kinh nghiệm / Học vị</label>
                                    <input type="text" name="description" value="{{ old('description') }}" placeholder="VD: Bác sĩ CKI - 10 năm kinh nghiệm" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.staff.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-sm rounded-xl transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            ✓ Lưu Nhân Sự Mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSpecialty(select) {
            const selectedOption = select.options[select.selectedIndex];
            const roleName = selectedOption ? selectedOption.getAttribute('data-name') : '';
            document.getElementById('specialty_div').style.display = (roleName === 'doctor') ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_id');
            if (roleSelect && roleSelect.value) toggleSpecialty(roleSelect);
        });
    </script>
</x-app-layout>
