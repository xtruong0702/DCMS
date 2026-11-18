<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📅 Quản Lý Toàn Bộ Lịch Hẹn</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Theo dõi trạng thái lịch khám, cảnh báo đến giờ hẹn / quá thời gian hẹn trên toàn phòng khám</p>
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                + Đặt Lịch Mới
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Bộ lọc -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.appointments.index') }}" method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-3">
                    <select name="status" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✓ Đã xác nhận</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>⏳ Đang chờ khám</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🩺 Đang khám</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Đã hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>✕ Đã hủy</option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>Không đến</option>
                    </select>
                    <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                        Lọc danh sách
                    </button>
                    @if(request('status') || request('date'))
                        <a href="{{ route('admin.appointments.index') }}" class="px-3 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 font-bold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong>{{ $appointments->total() }}</strong> lịch hẹn
                </span>
            </div>

            <!-- Bảng danh sách -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Thời gian hẹn</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bệnh nhân</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bác sĩ phụ trách</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Dịch vụ</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Trạng thái & Cảnh báo</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($appointments as $appointment)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-extrabold text-indigo-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</div>
                                        <div class="text-[11px] text-slate-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900">{{ $appointment->patient->name ?? 'Không rõ' }}</div>
                                        <div class="text-[11px] text-slate-500 font-mono">{{ $appointment->patient->patient_code ?? '' }} • {{ $appointment->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap font-semibold text-slate-700">
                                        {{ $appointment->doctor->user->name ?? 'Chưa phân công' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-slate-700">
                                        {{ $appointment->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'waiting' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                'no_show' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => '✓ Đã xác nhận',
                                                'waiting' => '⏳ Đang chờ khám',
                                                'in_progress' => '🩺 Đang khám',
                                                'completed' => '✓ Hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                                'no_show' => 'Không đến',
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if($appointment->isOverdue())
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-red-100 text-red-700 border border-red-300">
                                                    ⚠️ Quá thời gian hẹn
                                                </span>
                                            @elseif($appointment->isDueNow())
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                                    🔔 Đến thời gian hẹn
                                                </span>
                                            @endif
                                            <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full border {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold transition">Cập nhật</a>
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg font-bold transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                        Không tìm thấy lịch hẹn nào theo điều kiện lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($appointments->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $appointments->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
