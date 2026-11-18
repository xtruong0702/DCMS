<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📅 Quản Lý Lịch Hẹn & Tiếp Nhận</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Theo dõi lịch hẹn khách hàng, xác nhận lịch và check-in vào phòng chờ</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-bold transition">
                    ⏳ Phòng chờ hôm nay
                </a>
                <a href="{{ route('receptionist.appointments.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    + Đặt Lịch / Tiếp Nhận Mới
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Thanh bộ lọc theo ngày -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('receptionist.appointments.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <label class="text-xs font-bold uppercase text-slate-600">Xem theo ngày:</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Lọc dữ liệu
                    </button>
                    @if(request('date') && request('date') !== date('Y-m-d'))
                        <a href="{{ route('receptionist.appointments.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-xs rounded-xl transition">
                            Hôm nay
                        </a>
                    @endif
                </form>

                <div class="text-xs text-slate-500 font-medium">
                    Ngày đang xem: <strong class="text-indigo-700">{{ \Carbon\Carbon::parse(request('date', date('Y-m-d')))->format('d/m/Y') }}</strong> ({{ $appointments->count() }} lịch)
                </div>
            </div>

            <!-- Bảng danh sách lịch hẹn -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Thời gian</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bệnh nhân</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bác sĩ phụ trách</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Dịch vụ</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Trạng thái & Cảnh báo</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($appointments as $apt)
                                <tr class="{{ $apt->status == 'cancelled' ? 'bg-red-50/40 text-gray-400' : 'hover:bg-indigo-50/30' }} transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="font-extrabold text-sm text-indigo-700">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</span>
                                        <span class="block text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-900 text-sm">{{ $apt->patient->name ?? 'N/A' }}</div>
                                        <div class="text-[11px] text-slate-500 font-mono">{{ $apt->patient->patient_code ?? '' }} • {{ $apt->patient->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-700">
                                        {{ $apt->doctor->user->name ?? 'Chưa phân công' }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-700 font-medium">
                                        {{ $apt->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'waiting' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                'no_show' => 'bg-gray-200 text-gray-700 border-gray-300'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => '✓ Đã xác nhận',
                                                'waiting' => '⏳ Đang chờ khám',
                                                'in_progress' => '🩺 Đang khám',
                                                'completed' => '✓ Hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                                'no_show' => 'Không đến'
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if($apt->isOverdue())
                                                <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-red-100 text-red-700 border border-red-300">
                                                    ⚠️ Quá thời gian hẹn
                                                </span>
                                            @elseif($apt->isDueNow())
                                                <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                                    🔔 Đến thời gian hẹn
                                                </span>
                                            @endif
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusColors[$apt->status] ?? 'bg-gray-100' }}">
                                                {{ $statusLabels[$apt->status] ?? ucfirst($apt->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                        @if($apt->status === 'pending')
                                            <form action="{{ route('receptionist.appointments.update', $apt) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                    ✓ Xác nhận
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($apt->status, ['pending', 'confirmed']))
                                            <form action="{{ route('receptionist.appointments.checkin', $apt) }}" method="POST" class="inline-block" onsubmit="return confirm('Xác nhận bệnh nhân đã đến phòng khám và đưa vào sảnh chờ?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                    Check-in
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('receptionist.appointments.edit', $apt) }}" class="inline-flex items-center px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-lg font-bold text-xs transition">
                                            Sửa
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
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
