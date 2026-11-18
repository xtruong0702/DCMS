@extends('layouts.patient')

@section('title', 'Hóa đơn & Thanh toán - Patient Portal')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Hóa đơn & Thanh toán</h1>
    <p class="text-gray-500 mt-1">Quản lý chi phí khám chữa bệnh và theo dõi trạng thái thanh toán</p>
</div>

<div class="glass-card rounded-[2rem] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100/50 bg-white/40">
        <h3 class="font-bold text-slate-800">Danh sách Hóa đơn</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100/50 text-gray-500 text-sm">
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Thông tin Hóa đơn</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Tổng tiền</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/50 bg-white/40">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 group-hover:bg-amber-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-black text-slate-800 text-lg group-hover:text-blue-600 transition-colors">#{{ $invoice->invoice_code }}</div>
                                <div class="text-sm text-gray-500 font-medium mt-0.5">Xuất ngày: {{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-black text-xl text-blue-600 tracking-tight">
                            {{ number_format($invoice->final_amount, 0, ',', '.') }} <span class="text-sm font-bold text-gray-400">VNĐ</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($invoice->status == 'paid')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Đã thanh toán
                            </span>
                        @elseif($invoice->status == 'cancelled')
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                Đã hủy
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                Chưa thanh toán
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('patient.invoices.show', $invoice->id) }}" class="inline-flex items-center justify-center bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-blue-600 px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all group-hover:-translate-y-0.5 gap-2">
                            Chi Tiết
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                            </div>
                            <p class="text-slate-500 font-medium text-lg">Bạn chưa có hóa đơn nào.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
        <div class="px-6 py-4 border-t border-gray-100/50 bg-white/40">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection
