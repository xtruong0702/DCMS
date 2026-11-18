<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm Bác Sĩ Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.doctors.store') }}" method="POST">
                        @csrf
                        
                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Thông tin Tài khoản</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email đăng nhập <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Thông tin Chuyên môn</h4>
                        <div class="mb-4">
                            <label for="specialty" class="block text-sm font-medium text-gray-700">Chuyên khoa</label>
                            <select name="specialty" id="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Chọn chuyên khoa --</option>
                                @forelse($specialties as $spec)
                                    <option value="{{ $spec->name }}" {{ old('specialty') == $spec->name ? 'selected' : '' }}>{{ $spec->name }}</option>
                                @empty
                                    @foreach(['Nha khoa tổng quát', 'Chỉnh nha - Niềng răng', 'Cấy ghép Implant', 'Phục hình răng sứ thẩm mỹ', 'Nội nha & Điều trị tủy', 'Nha khoa trẻ em'] as $defaultSpec)
                                        <option value="{{ $defaultSpec }}" {{ old('specialty') == $defaultSpec ? 'selected' : '' }}>{{ $defaultSpec }}</option>
                                    @endforeach
                                @endforelse
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả / Kinh nghiệm</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-6 flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Tài khoản đang hoạt động</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Lưu Bác sĩ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
