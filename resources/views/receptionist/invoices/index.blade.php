<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quầy thu ngân & Quản lý hóa đơn
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hôm nay: {{ now()->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi hóa đơn khám chữa bệnh, thu tiền và in phiếu thanh toán VietQR</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Sảnh chờ
                </a>
                <a href="{{ route('receptionist.invoices.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                    <span>+ Tạo hóa đơn mới</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Bộ lọc & Tìm kiếm -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('receptionist.invoices.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <select name="status" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã HĐ, tên BN hoặc SĐT..." class="rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68] w-56">

                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                        Tìm kiếm
                    </button>

                    @if(request('status') || request('search'))
                        <a href="{{ route('receptionist.invoices.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong class="text-slate-800">{{ $invoices->total() }}</strong> hóa đơn
                </span>
            </div>

            <!-- Bảng danh sách hóa đơn -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mã HĐ / Ngày lập</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng cộng</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($invoices as $invoice)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="text-xs font-bold text-slate-900 font-mono">#{{ $invoice->invoice_code }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="text-xs font-bold text-slate-900">{{ $invoice->patient->name ?? 'Khách vãng lai' }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $invoice->patient->patient_code ?? '' }} • {{ $invoice->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right">
                                        <span class="text-xs font-bold text-slate-900">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                        @if($invoice->status === 'paid')
                                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                                <span>✓ Đã thanh toán</span>
                                            </span>
                                        @elseif($invoice->status === 'unpaid')
                                            <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1 animate-pulse">
                                                <span>⏳ Chờ thu tiền</span>
                                            </span>
                                        @else
                                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                                <span>✕ Đã hủy</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('receptionist.invoices.show', $invoice) }}" class="inline-flex items-center px-3 py-1.5 {{ $invoice->status === 'unpaid' ? 'bg-[#0D7A68] hover:bg-[#0B6858] text-white shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200' }} rounded-xl font-bold text-xs transition">
                                            {{ $invoice->status === 'unpaid' ? 'Thu tiền & VietQR' : 'Chi tiết' }}
                                        </a>
                                        <a href="{{ route('receptionist.invoices.print', $invoice) }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                                            In
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">
                                        Chưa có hóa đơn nào phù hợp.
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
