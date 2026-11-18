<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa Vật Tư') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.supplies.update', $supply) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Cột trái -->
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Tên Vật Tư <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $supply->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="unit" class="block text-sm font-medium text-gray-700">Đơn Vị Tính <span class="text-red-500">*</span></label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit', $supply->unit) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Số Lượng Tồn Kho <span class="text-red-500">*</span></label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $supply->stock_quantity) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('stock_quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <!-- Cột phải -->
                            <div>
                                <div class="mb-4">
                                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Mức Tồn Kho Tối Thiểu (Cảnh Báo) <span class="text-red-500">*</span></label>
                                    <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $supply->minimum_stock) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('minimum_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="import_price" class="block text-sm font-medium text-gray-700">Giá Nhập (VNĐ)</label>
                                    <input type="number" name="import_price" id="import_price" value="{{ old('import_price', $supply->import_price) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('import_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Ngày Hết Hạn</label>
                                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $supply->expiry_date ? \Carbon\Carbon::parse($supply->expiry_date)->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Mô Tả / Ghi Chú</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $supply->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.supplies.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Cập nhật Vật Tư</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
