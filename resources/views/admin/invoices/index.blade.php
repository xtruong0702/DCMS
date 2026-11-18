<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Hóa đơn') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-gray-700">Danh sách Hóa đơn</h3>
                        
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <form action="{{ route('admin.invoices.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-2">
                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã HĐ hoặc Tên BN" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-semibold text-sm transition-colors whitespace-nowrap">
                                    Lọc
                                </button>
                                @if(request('status') || request('search'))
                                    <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 font-semibold text-sm transition-colors whitespace-nowrap">
                                        Xóa lọc
                                    </a>
                                @endif
                            </form>

                            <a href="{{ route('admin.invoices.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition-colors whitespace-nowrap">
                                + Tạo Hóa đơn
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã HĐ / Ngày lập</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bệnh nhân</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tổng tiền (Sau giảm giá)</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($invoices as $invoice)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-indigo-600">{{ $invoice->invoice_code }}</div>
                                            <div class="text-xs text-gray-500">{{ $invoice->created_at->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $invoice->patient->name ?? 'Không rõ' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                                            {{ number_format($invoice->final_amount, 0, ',', '.') }} đ
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($invoice->status == 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Đã thanh toán</span>
                                            @elseif($invoice->status == 'unpaid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Chưa thanh toán</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900 mr-3">Xem</a>
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Không có hóa đơn nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $invoices->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
