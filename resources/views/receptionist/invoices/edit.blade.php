<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Chi tiết Hóa Đơn - #{{ $invoice->invoice_code }}
            </h2>
            <a href="{{ route('receptionist.invoices.show', $invoice) }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Quay lại chi tiết hóa đơn
            </a>
        </div>
    </x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 text-center">
            <p class="text-sm text-slate-600 mb-4">Vui lòng thực hiện thu tiền và cập nhật thanh toán tại trang Chi tiết hóa đơn.</p>
            <a href="{{ route('receptionist.invoices.show', $invoice) }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-xs">Mở trang Thu tiền & VietQR</a>
        </div>
    </div>
</x-app-layout>

