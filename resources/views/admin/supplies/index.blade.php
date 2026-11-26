<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl text-slate-900 tracking-tight">Quản Lý Vật Tư Nha Khoa</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Kho vật tư tiêu hao • Hôm nay: {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi số lượng vật tư tiêu hao, mức tồn kho tối thiểu, đơn giá nhập và hạn sử dụng</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.supplies.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>+ Thêm Vật Tư Mới</span>
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
            <form action="{{ route('admin.supplies.index') }}" method="GET" class="w-full sm:w-80 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên vật tư..." class="w-full rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68] pr-10 py-2">
                <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-[#0D7A68]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <span class="text-xs text-slate-500 font-medium">
                Tổng cộng: <strong class="text-slate-900 font-bold">{{ $supplies->total() }}</strong> mặt hàng vật tư
            </span>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-2.5 px-5">Tên Vật Tư</th>
                            <th class="py-2.5 px-5 text-center">Tồn Kho</th>
                            <th class="py-2.5 px-5 text-center">Mức Tối Thiểu</th>
                            <th class="py-2.5 px-5 text-right">Giá Nhập</th>
                            <th class="py-2.5 px-5 text-center">Hạn Sử Dụng</th>
                            <th class="py-2.5 px-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($supplies as $supply)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-5 font-bold text-slate-900 text-xs">{{ $supply->name }}</td>
                                <td class="py-3 px-5 text-center">
                                    @if($supply->stock_quantity <= $supply->minimum_stock)
                                        <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            ⚠️ {{ $supply->stock_quantity }} {{ $supply->unit }} (Cần nhập)
                                        </span>
                                    @else
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            {{ $supply->stock_quantity }} {{ $supply->unit }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-center text-slate-500 font-medium">{{ $supply->minimum_stock }} {{ $supply->unit }}</td>
                                <td class="py-3 px-5 text-right font-medium text-slate-900">{{ $supply->import_price ? number_format($supply->import_price, 0, ',', '.') . ' đ' : '-' }}</td>
                                <td class="py-3 px-5 text-center">
                                    @if($supply->expiry_date)
                                        @php
                                            $isExpired = \Carbon\Carbon::parse($supply->expiry_date)->isPast();
                                            $isNearExpiry = \Carbon\Carbon::parse($supply->expiry_date)->isBetween(now(), now()->addDays(30));
                                        @endphp
                                        <span class="{{ $isExpired ? 'text-rose-600 font-bold' : ($isNearExpiry ? 'text-amber-600 font-bold' : 'text-slate-600 font-medium') }}">
                                            {{ \Carbon\Carbon::parse($supply->expiry_date)->format('d/m/Y') }}
                                            @if($isExpired) <br><span class="text-[10px] text-rose-500 font-semibold">(Đã quá HSD)</span> @endif
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-right space-x-1.5">
                                    <a href="{{ route('admin.supplies.edit', $supply) }}" class="px-2.5 py-1 bg-white hover:bg-slate-50 text-[#0D7A68] border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Sửa</a>
                                    <form action="{{ route('admin.supplies.destroy', $supply) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vật tư này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                                    Không tìm thấy vật tư nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($supplies->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                    {{ $supplies->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
