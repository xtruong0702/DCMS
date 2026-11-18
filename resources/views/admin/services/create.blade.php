<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm Dịch vụ Khám chữa bệnh') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Cột trái -->
                            <div>
                                <div class="mb-4">
                                    <label for="service_code" class="block text-sm font-medium text-gray-700">Mã Dịch vụ <span class="text-red-500">*</span></label>
                                    <input type="text" name="service_code" id="service_code" value="{{ old('service_code', 'DV'.time()) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('service_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Tên Dịch vụ <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700">Phân loại (Danh mục)</label>
                                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Chọn --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}" {{ old('type') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <!-- Cột phải -->
                            <div>
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Đơn giá (VNĐ) <span class="text-red-500">*</span></label>
                                    <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Thời gian dự kiến (Phút) <span class="text-red-500">*</span></label>
                                    <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 30) }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('duration_minutes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4 flex items-center mt-8">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Cho phép đặt lịch (Hoạt động)</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô Tả Chi Tiết</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Lưu Dịch Vụ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
