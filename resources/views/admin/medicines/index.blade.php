<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl text-slate-900 tracking-tight">Kho Thuốc & Bảng Giá Dược Phẩm</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Quản lý dược & kê đơn • Hôm nay: {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Quản lý số lượng tồn kho, giá nhập, đơn giá bán (tự động đồng bộ sang đơn thuốc Bác sĩ & Hóa đơn viện phí)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.medicines.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>+ Nhập Thêm Thuốc Mới</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.medicines.index') }}" method="GET" class="flex items-center gap-2.5 w-full sm:w-2/3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên thuốc, phân nhóm hoặc đơn vị tính..." class="flex-1 rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68] py-2">
                <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                    Tìm kiếm
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.medicines.index') }}" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition">
                        Xóa lọc
                    </a>
                @endif
            </form>

            <span class="text-xs text-slate-500 font-medium">
                Tổng cộng: <strong class="text-slate-900 font-bold">{{ $medicines->total() }}</strong> mặt hàng thuốc
            </span>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-2.5 px-5">Mã</th>
                            <th class="py-2.5 px-5">Tên Thuốc & Phân Nhóm</th>
                            <th class="py-2.5 px-5 text-center">Tồn Kho</th>
                            <th class="py-2.5 px-5 text-right">Giá Nhập</th>
                            <th class="py-2.5 px-5 text-right">Giá Bán Niêm Yết</th>
                            <th class="py-2.5 px-5 text-center">Hạn Sử Dụng</th>
                            <th class="py-2.5 px-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($medicines as $medicine)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-5 font-mono font-bold text-[#0D7A68]">{{ $medicine->medicine_code }}</td>
                                <td class="py-3 px-5">
                                    <div class="font-bold text-slate-900 text-xs">{{ $medicine->name }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold">{{ $medicine->category ?? 'Dược phẩm' }}</span>
                                        @if($medicine->description)
                                            <span class="ml-1.5 italic text-slate-400">{{ $medicine->description }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-5 text-center">
                                    @if($medicine->stock_quantity <= 20)
                                        <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            ⚠️ {{ $medicine->stock_quantity }} {{ $medicine->unit }} (Sắp hết)
                                        </span>
                                    @else
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            {{ $medicine->stock_quantity }} {{ $medicine->unit }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-right text-slate-500 font-medium">
                                    {{ $medicine->import_price ? number_format($medicine->import_price, 0, ',', '.') . ' đ' : '---' }}
                                </td>
                                <td class="py-3 px-5 text-right font-bold text-slate-900 text-xs">
                                    {{ number_format($medicine->price ?? 0, 0, ',', '.') }} đ
                                </td>
                                <td class="py-3 px-5 text-center">
                                    @if($medicine->expiry_date)
                                        @php
                                            $isExpired = \Carbon\Carbon::parse($medicine->expiry_date)->isPast();
                                            $isNearExpiry = \Carbon\Carbon::parse($medicine->expiry_date)->isBetween(now(), now()->addDays(30));
                                        @endphp
                                        <span class="{{ $isExpired ? 'text-rose-600 font-bold' : ($isNearExpiry ? 'text-amber-600 font-bold' : 'text-slate-600 font-medium') }}">
                                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d/m/Y') }}
                                            @if($isExpired) <br><span class="text-[10px] text-rose-500 font-semibold">(Đã quá HSD)</span> @endif
                                        </span>
                                    @else
                                        <span class="text-slate-400">---</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-right space-x-1.5">
                                    <a href="{{ route('admin.medicines.edit', $medicine) }}" class="px-2.5 py-1 bg-white hover:bg-slate-50 text-[#0D7A68] border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Sửa / Nhập</a>
                                    <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thuốc {{ $medicine->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 text-xs">
                                    Không tìm thấy loại thuốc nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($medicines->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                    {{ $medicines->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
