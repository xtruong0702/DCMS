<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    💊 Quản Lý Kho Thuốc & Bảng Giá Dược Phẩm
                </h2>
                <p class="text-xs text-slate-500 mt-1">Quản lý số lượng tồn kho, giá nhập, đơn giá bán (tự động đồng bộ sang đơn thuốc Bác sĩ & Hóa đơn)</p>
            </div>
            <a href="{{ route('admin.medicines.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition whitespace-nowrap">
                + Nhập Thêm Thuốc Mới
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.medicines.index') }}" method="GET" class="flex items-center gap-2.5 w-full sm:w-2/3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên thuốc, phân nhóm hoặc đơn vị tính..." class="flex-1 rounded-xl border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Tìm kiếm
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.medicines.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-xl transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-semibold">
                    Tổng cộng: <strong class="text-indigo-700">{{ $medicines->total() }}</strong> mặt hàng thuốc
                </span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Mã</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Tên Thuốc & Phân Nhóm</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Tồn Kho</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Giá Nhập</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Giá Bán Niêm Yết</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Hạn Sử Dụng</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($medicines as $medicine)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-5 py-4 whitespace-nowrap font-mono font-extrabold text-indigo-600">{{ $medicine->medicine_code }}</td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $medicine->name }}</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold">{{ $medicine->category ?? 'Dược phẩm' }}</span>
                                            @if($medicine->description)
                                                <span class="ml-1.5 italic">{{ $medicine->description }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        @if($medicine->stock_quantity <= 20)
                                            <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 font-extrabold border border-rose-200">
                                                ⚠️ {{ $medicine->stock_quantity }} {{ $medicine->unit }} (Sắp hết)
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-200">
                                                {{ $medicine->stock_quantity }} {{ $medicine->unit }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right text-slate-500 font-semibold">
                                        {{ $medicine->import_price ? number_format($medicine->import_price, 0, ',', '.') . ' đ' : '---' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-extrabold text-emerald-700">
                                        {{ number_format($medicine->price ?? 0, 0, ',', '.') }} đ
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        @if($medicine->expiry_date)
                                            @php
                                                $isExpired = \Carbon\Carbon::parse($medicine->expiry_date)->isPast();
                                                $isNearExpiry = \Carbon\Carbon::parse($medicine->expiry_date)->isBetween(now(), now()->addDays(30));
                                            @endphp
                                            <span class="{{ $isExpired ? 'text-red-600 font-bold' : ($isNearExpiry ? 'text-amber-600 font-bold' : 'text-slate-700 font-medium') }}">
                                                {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d/m/Y') }}
                                                @if($isExpired) <br><span class="text-[10px] text-red-500">(Đã quá HSD)</span> @endif
                                            </span>
                                        @else
                                            <span class="text-slate-400">---</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.medicines.edit', $medicine) }}" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold transition">Sửa / Nhập kho</a>
                                        <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thuốc {{ $medicine->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg font-bold transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                        Không tìm thấy loại thuốc nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($medicines->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $medicines->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
