<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý toàn bộ lịch hẹn
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Toàn hệ thống
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi trạng thái lịch khám, cảnh báo đến giờ hẹn / quá thời gian hẹn trên toàn phòng khám</p>
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                <span>+ Đặt Lịch Mới</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Bộ lọc -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.appointments.index') }}" method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-3">
                    <select name="status" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Đang chờ khám</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang khám</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>Không đến</option>
                    </select>
                    <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                        Lọc danh sách
                    </button>
                    @if(request('status') || request('date'))
                        <a href="{{ route('admin.appointments.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong class="text-slate-800">{{ $appointments->total() }}</strong> lịch hẹn
                </span>
            </div>

            <!-- Bảng danh sách -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thời gian hẹn</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bác sĩ phụ trách</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái & Cảnh báo</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($appointments as $appointment)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="font-bold text-xs text-slate-900">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</div>
                                        <div class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="font-bold text-xs text-slate-900">{{ $appointment->patient->name ?? 'Không rõ' }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $appointment->patient->patient_code ?? '' }} • {{ $appointment->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap font-medium text-slate-800">
                                        {{ $appointment->doctor->user->name ?? 'Chưa phân công' }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-slate-700">
                                        {{ $appointment->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        @php
                                            $statusBadges = [
                                                'pending' => 'bg-[#FEF3C7] text-[#92400E]',
                                                'confirmed' => 'bg-[#ECFDF5] text-[#065F46]',
                                                'waiting' => 'bg-[#FFFBEB] text-[#B45309]',
                                                'in_progress' => 'bg-[#EEF2FF] text-[#3730A3]',
                                                'completed' => 'bg-[#D1FAE5] text-[#065F46]',
                                                'cancelled' => 'bg-[#FEE2E2] text-[#991B1B]',
                                                'no_show' => 'bg-slate-100 text-slate-600',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => 'Đã xác nhận',
                                                'waiting' => 'Đang chờ khám',
                                                'in_progress' => 'Đang khám',
                                                'completed' => 'Hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                                'no_show' => 'Không đến',
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if($appointment->isOverdue())
                                                <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                                    ⚠️ Quá giờ hẹn
                                                </span>
                                            @elseif($appointment->isDueNow())
                                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md animate-pulse">
                                                    🔔 Đến giờ hẹn
                                                </span>
                                            @endif
                                            <span class="{{ $statusBadges[$appointment->status] ?? 'bg-slate-100 text-slate-700' }} font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                                {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">Cập nhật</a>
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">
                                        Không tìm thấy lịch hẹn nào theo điều kiện lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($appointments->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $appointments->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
