<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý toàn bộ hóa đơn & Thu ngân
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Tài chính phòng khám
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Giám sát tổng thể dòng tiền, doanh thu khám chữa bệnh và đối soát VietQR</p>
            </div>
            <a href="{{ route('admin.invoices.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                <span>+ Tạo Hóa Đơn Mới</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold" role="alert">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.invoices.index') }}" method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-3">
                    <select name="status" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã HĐ hoặc Tên BN..." class="rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68] w-56">
                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                        Lọc dữ liệu
                    </button>
                    @if(request('status') || request('search'))
                        <a href="{{ route('admin.invoices.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng số: <strong class="text-slate-800">{{ $invoices->total() }}</strong> hóa đơn
                </span>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mã HĐ / Ngày lập</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng tiền</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($invoices as $invoice)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="font-bold text-xs text-slate-900 font-mono">#{{ $invoice->invoice_code }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-900 font-bold">
                                        {{ $invoice->patient->name ?? 'Không rõ' }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right font-bold text-slate-900 text-xs">
                                        {{ number_format($invoice->final_amount, 0, ',', '.') }} đ
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                        @if($invoice->status == 'paid')
                                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                                ✓ Đã thanh toán
                                            </span>
                                        @elseif($invoice->status == 'unpaid')
                                            <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1 animate-pulse">
                                                ⏳ Chưa thanh toán
                                            </span>
                                        @else
                                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[10px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                                ✕ Đã hủy
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">Xem</a>
                                        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">Sửa</a>
                                        <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-xs text-slate-400">
                                        Không có hóa đơn nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($invoices->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $invoices->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
