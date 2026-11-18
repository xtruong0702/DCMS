<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Chuyên khoa') }}
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
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Danh sách Chuyên khoa</h3>
                        <a href="{{ route('admin.specialties.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition-colors">
                            + Thêm mới
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên chuyên khoa</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mô tả</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($specialties as $specialty)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $specialty->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $specialty->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($specialty->description, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($specialty->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hoạt động</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tạm khóa</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.specialties.edit', $specialty) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            <form action="{{ route('admin.specialties.destroy', $specialty) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chuyên khoa này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Chưa có chuyên khoa nào được tạo.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $specialties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
