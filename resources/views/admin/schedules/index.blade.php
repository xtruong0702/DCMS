<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Phân Lịch Trực Bác Sĩ') }}
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
                        <h3 class="text-lg font-bold text-gray-700">Danh sách Lịch Trực</h3>
                        
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <form action="{{ route('admin.schedules.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-2">
                                <select name="doctor_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Tất cả bác sĩ --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            BS. {{ $doctor->user->name ?? 'Không rõ' }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="date" name="date" value="{{ request('date') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-semibold text-sm transition-colors whitespace-nowrap">
                                    Lọc
                                </button>
                                @if(request('doctor_id') || request('date'))
                                    <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 font-semibold text-sm transition-colors whitespace-nowrap">
                                        Xóa lọc
                                    </a>
                                @endif
                            </form>

                            <a href="{{ route('admin.schedules.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition-colors whitespace-nowrap">
                                + Xếp Lịch
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bác sĩ</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngày trực</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ca làm việc</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Thời gian</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($schedules as $schedule)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    BS. {{ $schedule->doctor->user->name ?? 'Không rõ' }}
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $schedule->doctor->specialty ?? 'Đa khoa' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($schedule->shift == 'morning') Sáng
                                            @elseif($schedule->shift == 'afternoon') Chiều
                                            @else Tối
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($schedule->status == 'available')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sẵn sàng</span>
                                            @elseif($schedule->status == 'booked')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Đã có lịch hẹn</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nghỉ phép</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch trực này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Không tìm thấy lịch trực nào theo điều kiện lọc.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $schedules->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
