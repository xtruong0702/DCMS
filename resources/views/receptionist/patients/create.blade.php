<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    ➕ Thêm Hồ Sơ Bệnh Nhân Mới
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tạo mã bệnh nhân mới và lưu trữ tiền sử dị ứng, bệnh lý nền</p>
            </div>
            <a href="{{ route('receptionist.patients.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách bệnh nhân
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
                <form method="POST" action="{{ route('receptionist.patients.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn A" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0901234567" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Ngày sinh</label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Giới tính</label>
                            <select name="gender" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ old('gender') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Nghề nghiệp</label>
                            <input type="text" name="job" value="{{ old('job') }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Người liên hệ khẩn cấp</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Họ tên & SĐT người thân" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Địa chỉ</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-red-700 mb-1.5">⚠️ Tiền sử dị ứng thuốc</label>
                            <textarea name="allergy_history" rows="3" placeholder="Ghi rõ thuốc hoặc hoạt chất gây dị ứng (nếu có)..." class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('allergy_history') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-amber-700 mb-1.5">🩺 Tiền sử bệnh lý nền</label>
                            <textarea name="medical_history" rows="3" placeholder="Cao huyết áp, tiểu đường, tim mạch..." class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('medical_history') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('receptionist.patients.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-sm rounded-xl transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            Lưu Hồ Sơ Bệnh Nhân
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
