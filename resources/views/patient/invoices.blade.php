@extends('layouts.patient')

@section('title', 'Hóa đơn & Thanh toán - Patient Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2.5">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Hóa đơn & Thanh toán</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                Quản lý viện phí & VietQR • Hôm nay: {{ date('d/m/Y') }}
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Quản lý chi phí khám chữa bệnh, theo dõi trạng thái thanh toán và quét mã QR chuyển khoản chính xác</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Danh sách Hóa đơn</h3>
        <span class="text-xs text-slate-500 font-medium">Tổng cộng: <strong class="text-slate-800">{{ $invoices->total() }}</strong> hóa đơn</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                    <th class="px-5 py-3">Thông tin Hóa đơn</th>
                    <th class="px-5 py-3">Tổng tiền</th>
                    <th class="px-5 py-3">Trạng thái</th>
                    <th class="px-5 py-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-mono font-bold text-slate-900 text-sm">#{{ $invoice->invoice_code }}</div>
                                <div class="text-[11px] text-slate-500 font-medium mt-0.5">Xuất ngày: {{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="font-bold text-sm text-slate-900 tracking-tight">
                            {{ number_format($invoice->final_amount, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-400">đ</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($invoice->status == 'paid')
                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Đã thanh toán
                            </span>
                        @elseif($invoice->status == 'cancelled')
                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                Đã hủy
                            </span>
                        @else
                            <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Chưa thanh toán
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <a href="{{ route('patient.invoices.show', $invoice->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                            <span>Chi Tiết & VietQR</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-2 text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                            <p class="text-slate-500 font-semibold text-xs">Bạn chưa có hóa đơn nào.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection
