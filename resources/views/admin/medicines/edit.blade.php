<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                ✏️ Cập Nhật & Nhập Bổ Sung Thuốc: <span class="text-indigo-600">{{ $medicine->name }}</span>
            </h2>
            <a href="{{ route('admin.medicines.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách Kho thuốc
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200 p-6 md:p-8">
                <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Tên Thuốc <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $medicine->name) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Phân nhóm dược phẩm</label>
                            <input type="text" name="category" id="category" list="med_categories" value="{{ old('category', $medicine->category) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <datalist id="med_categories">
                                <option value="Gói đơn thuốc"></option>
                                <option value="Kháng sinh"></option>
                                <option value="Giảm đau - Kháng viêm"></option>
                                <option value="Chống phù nề"></option>
                                <option value="Chăm sóc răng miệng"></option>
                                <option value="Thuốc bôi lợi"></option>
                            </datalist>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="unit" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Đơn Vị Tính <span class="text-red-500">*</span></label>
                            <input type="text" name="unit" id="unit" value="{{ old('unit', $medicine->unit) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('unit') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số Lượng Tồn Kho <span class="text-red-500">*</span></label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $medicine->stock_quantity) }}" min="0" required class="w-full rounded-xl border-gray-300 text-sm font-bold text-indigo-700 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('stock_quantity') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="expiry_date" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Hạn Sử Dụng</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d') : '') }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('expiry_date') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="import_price" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Giá Nhập Kho (VNĐ)</label>
                            <input type="number" name="import_price" id="import_price" value="{{ old('import_price', $medicine->import_price) }}" min="0" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('import_price') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Đơn Giá Bán Niêm Yết (VNĐ) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price', $medicine->price) }}" min="0" required class="w-full rounded-xl border-gray-300 text-sm font-bold text-emerald-700 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('price') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Hướng Dẫn Sử Dụng Chuẩn / Ghi Chú</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $medicine->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.medicines.index') }}" class="px-5 py-2.5 bg-gray-100 text-slate-700 rounded-xl hover:bg-gray-200 font-bold text-sm transition">Hủy</a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold text-sm shadow-sm transition">✓ Lưu Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
