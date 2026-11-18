<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Vật tư Nha khoa') }}
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
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-gray-700">Danh sách Vật tư</h3>
                        
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <form action="{{ route('admin.supplies.index') }}" method="GET" class="w-full sm:w-64 relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên vật tư..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10">
                                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('admin.supplies.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition-colors whitespace-nowrap">
                                + Thêm vật tư
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên Vật Tư</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tồn Kho</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mức Tối Thiểu</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Giá Nhập</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Hạn Sử Dụng</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($supplies as $supply)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $supply->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($supply->stock_quantity <= $supply->minimum_stock)
                                                <span class="text-red-600 font-bold">{{ $supply->stock_quantity }}</span> {{ $supply->unit }}
                                                <span class="text-xs text-red-500 block">(Cần nhập thêm)</span>
                                            @else
                                                {{ $supply->stock_quantity }} {{ $supply->unit }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $supply->minimum_stock }} {{ $supply->unit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supply->import_price ? number_format($supply->import_price, 0, ',', '.') . ' đ' : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($supply->expiry_date)
                                                @php
                                                    $isExpired = \Carbon\Carbon::parse($supply->expiry_date)->isPast();
                                                    $isNearExpiry = \Carbon\Carbon::parse($supply->expiry_date)->isBetween(now(), now()->addDays(30));
                                                @endphp
                                                <span class="{{ $isExpired ? 'text-red-600 font-bold' : ($isNearExpiry ? 'text-yellow-600 font-bold' : '') }}">
                                                    {{ \Carbon\Carbon::parse($supply->expiry_date)->format('d/m/Y') }}
                                                    @if($isExpired) <br><span class="text-xs text-red-500">(Đã HSD)</span> @endif
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.supplies.edit', $supply) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            <form action="{{ route('admin.supplies.destroy', $supply) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vật tư này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Không tìm thấy vật tư nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $supplies->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
