<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý lịch hẹn & Tiếp nhận
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Ngày: {{ \Carbon\Carbon::parse(request('date', date('Y-m-d')))->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi lịch hẹn khách hàng, xác nhận lịch và check-in vào phòng chờ</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Sảnh chờ hôm nay
                </a>
                <a href="{{ route('receptionist.appointments.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>+ Tiếp nhận khách / Đặt lịch</span>
                </a>
            </div>
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

            <!-- Thanh bộ lọc theo ngày -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('receptionist.appointments.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <label class="text-xs font-bold text-slate-600">Xem theo ngày:</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Lọc dữ liệu
                    </button>
                    @if(request('date') && request('date') !== date('Y-m-d'))
                        <a href="{{ route('receptionist.appointments.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl transition">
                            Hôm nay
                        </a>
                    @endif
                </form>

                <div class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong class="text-slate-800">{{ $appointments->count() }}</strong> lịch hẹn
                </div>
            </div>

            <!-- Bảng danh sách lịch hẹn -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thời gian</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bác sĩ phụ trách</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái & Cảnh báo</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($appointments as $apt)
                                <tr class="{{ $apt->status == 'cancelled' ? 'bg-slate-50/40 text-slate-400' : 'hover:bg-slate-50/70' }} transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <span class="font-bold text-xs text-slate-900">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</span>
                                        <span class="block text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-slate-900 text-xs">{{ $apt->patient->name ?? 'N/A' }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $apt->patient->patient_code ?? '' }} • {{ $apt->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">
                                        {{ $apt->doctor->user->name ?? 'Chưa chỉ định' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-700 font-medium">
                                        {{ $apt->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @php
                                            $badgeClasses = [
                                                'pending' => 'bg-[#FEF3C7] text-[#92400E]',
                                                'confirmed' => 'bg-[#ECFDF5] text-[#065F46]',
                                                'waiting' => 'bg-[#FFFBEB] text-[#B45309]',
                                                'in_progress' => 'bg-[#EEF2FF] text-[#3730A3]',
                                                'completed' => 'bg-[#D1FAE5] text-[#065F46]',
                                                'cancelled' => 'bg-[#FEE2E2] text-[#991B1B]',
                                                'no_show' => 'bg-slate-100 text-slate-600'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => 'Đã xác nhận',
                                                'waiting' => 'Đang chờ khám',
                                                'in_progress' => 'Đang khám',
                                                'completed' => 'Hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                                'no_show' => 'Không đến'
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if($apt->isOverdue())
                                                <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                                    ⚠️ Quá giờ hẹn
                                                </span>
                                            @elseif($apt->isDueNow())
                                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md animate-pulse">
                                                    🔔 Đến giờ hẹn
                                                </span>
                                            @endif
                                            <span class="{{ $badgeClasses[$apt->status] ?? 'bg-slate-100 text-slate-700' }} font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                                {{ $statusLabels[$apt->status] ?? ucfirst($apt->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                        @if($apt->status === 'pending')
                                            <form action="{{ route('receptionist.appointments.update', $apt) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                    ✓ Xác nhận
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($apt->status, ['pending', 'confirmed']))
                                            <form action="{{ route('receptionist.appointments.checkin', $apt) }}" method="POST" class="inline-block" onsubmit="return confirm('Xác nhận bệnh nhân đã đến phòng khám và đưa vào sảnh chờ?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                    Check-in
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('receptionist.appointments.edit', $apt) }}" class="inline-flex items-center px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs shadow-xs transition">
                                            Sửa
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                        Không có lịch hẹn nào trong ngày này.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
