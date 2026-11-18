@extends('layouts.patient')

@section('title', 'Lịch sử khám - Patient Portal')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Lịch sử khám & Bệnh án</h1>
    <p class="text-gray-500 mt-1">Quản lý và tra cứu toàn bộ hồ sơ khám chữa bệnh của bạn</p>
</div>

<div class="glass-card rounded-[2rem] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100/50 bg-white/40">
        <h3 class="font-bold text-slate-800">Danh sách các lần khám</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100/50 text-gray-500 text-sm">
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Ngày khám</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Dịch vụ & Bác sĩ</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Chi tiết</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/50 bg-white/40">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-blue-100/50 text-blue-600 flex flex-col items-center justify-center font-bold">
                                <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d') }}</span>
                                <span class="text-[10px] uppercase">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M') }}</span>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y') }}</div>
                                <div class="text-xs text-gray-500 font-medium flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 mb-0.5 group-hover:text-blue-600 transition-colors">{{ $appointment->service ? $appointment->service->name : 'Khám tổng quát' }}</div>
                        <div class="text-sm text-gray-500 flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $appointment->doctor ? $appointment->doctor->user->name : 'Chưa xếp' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @if($appointment->status == 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    ✓ Đã hoàn thành
                                </span>
                            @elseif($appointment->status == 'cancelled' || $appointment->status == 'no_show')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    Đã hủy
                                </span>
                            @else
                                @if($appointment->isOverdue())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-300">
                                        ⚠️ Quá thời gian hẹn
                                    </span>
                                @elseif($appointment->isDueNow())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                        🔔 Đến thời gian hẹn
                                    </span>
                                @endif

                                @if($appointment->status == 'confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                        ✓ Bác sĩ đã xác nhận
                                    </span>
                                @elseif($appointment->status == 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Chờ xác nhận
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                        Đang chờ khám
                                    </span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @php
                            $record = \App\Models\MedicalRecord::where('appointment_id', $appointment->id)->first();
                        @endphp
                        <div class="flex items-center justify-end gap-2">
                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center justify-center bg-red-50 border border-red-200 hover:bg-red-100 text-red-600 px-3 py-2 rounded-xl font-bold text-xs transition-all">
                                        Hủy lịch
                                    </button>
                                </form>
                            @endif
                            @if($record)
                                <a href="{{ route('patient.medical_records.show', $record->id) }}" class="inline-flex items-center justify-center bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-blue-600 px-4 py-2 rounded-xl font-bold text-sm shadow-sm transition-all group-hover:-translate-y-0.5">
                                    Xem Bệnh Án
                                </a>
                            @else
                                <span class="inline-block px-4 py-2 text-gray-400 font-medium text-sm bg-gray-50 rounded-xl border border-gray-100">Không có BA</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <p class="text-slate-500 font-medium text-lg">Bạn chưa có lịch sử khám nào.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($appointments->hasPages())
        <div class="px-6 py-4 border-t border-gray-100/50 bg-white/40">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
