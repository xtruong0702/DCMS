<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Dịch vụ Khám chữa bệnh') }}
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
                        <h3 class="text-lg font-bold text-gray-700">Danh sách Dịch vụ</h3>
                        
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <form action="{{ route('admin.services.index') }}" method="GET" class="w-full sm:w-64 relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã hoặc tên dịch vụ..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10">
                                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition-colors whitespace-nowrap">
                                + Thêm Dịch vụ
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã Dịch vụ</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên Dịch vụ</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phân loại</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Thời gian</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Đơn giá</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($services as $service)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $service->service_code }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $service->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->type ?? 'Chung' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->duration_minutes }} phút</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">{{ number_format($service->price, 0, ',', '.') }} đ</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full border transition {{ $service->is_active ? 'bg-green-100 text-green-800 border-green-200 hover:bg-green-200' : 'bg-red-100 text-red-800 border-red-200 hover:bg-red-200' }}">
                                                    {{ $service->is_active ? '● Khả dụng' : '○ Tạm ngưng' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.services.edit', $service) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Không tìm thấy dịch vụ nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $services->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
