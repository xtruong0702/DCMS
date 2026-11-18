<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">💳 Thu Ngân & Quản Lý Hóa Đơn</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Theo dõi hóa đơn khám chữa bệnh, thu tiền và in phiếu thanh toán VietQR</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    📋 Phòng chờ
                </a>
                <a href="{{ route('receptionist.invoices.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                    + Tạo Hóa Đơn Mới
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Bộ lọc & Tìm kiếm -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('receptionist.invoices.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <select name="status" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>⏳ Chưa thanh toán</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>✓ Đã thanh toán</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>✕ Đã hủy</option>
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã HĐ, tên BN hoặc SĐT..." class="rounded-xl border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500 w-56">

                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                        Tìm kiếm
                    </button>

                    @if(request('status') || request('search'))
                        <a href="{{ route('receptionist.invoices.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-bold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong>{{ $invoices->total() }}</strong> hóa đơn
                </span>
            </div>

            <!-- Bảng danh sách hóa đơn -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Mã HĐ / Ngày lập</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bệnh nhân</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Tổng cộng</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Trạng thái</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($invoices as $invoice)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-extrabold text-indigo-700 font-mono">#{{ $invoice->invoice_code }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $invoice->patient->name ?? 'Khách vãng lai' }}</div>
                                        <div class="text-[11px] text-slate-500 font-mono">{{ $invoice->patient->patient_code ?? '' }} • {{ $invoice->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-extrabold text-red-600">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        @if($invoice->status === 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                ✓ Đã thanh toán
                                            </span>
                                        @elseif($invoice->status === 'unpaid')
                                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                                ⏳ Chờ thu tiền
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                ✕ Đã hủy
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right space-x-2">
                                        <a href="{{ route('receptionist.invoices.show', $invoice) }}" class="inline-flex items-center px-3 py-1.5 {{ $invoice->status === 'unpaid' ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm' : 'bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200' }} rounded-lg font-bold text-xs transition">
                                            {{ $invoice->status === 'unpaid' ? '💳 Thu tiền & VietQR' : 'Chi tiết' }}
                                        </a>
                                        <a href="{{ route('receptionist.invoices.print', $invoice) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-lg font-bold text-xs transition">
                                            🖨️ In
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">
                                        Chưa có hóa đơn nào phù hợp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($invoices->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $invoices->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

