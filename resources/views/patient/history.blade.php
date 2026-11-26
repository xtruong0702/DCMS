@extends('layouts.patient')

@section('title', 'Lịch sử khám - Patient Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2.5">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Lịch sử khám & Bệnh án</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                Hồ sơ điều trị cá nhân • Hôm nay: {{ date('d/m/Y') }}
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Quản lý và tra cứu toàn bộ hồ sơ khám chữa bệnh, lịch hẹn đã hoàn thành và chi tiết bệnh án của bạn</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('booking.index') }}" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
            <span>+ Đặt lịch khám mới</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Danh sách các lần khám</h3>
        <span class="text-xs text-slate-500 font-medium">Tổng số: <strong class="text-slate-800">{{ $appointments->count() }}</strong> lượt hẹn</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                    <th class="px-5 py-3">Ngày khám</th>
                    <th class="px-5 py-3">Dịch vụ & Bác sĩ</th>
                    <th class="px-5 py-3">Trạng thái</th>
                    <th class="px-5 py-3 text-right">Chi tiết</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex flex-col items-center justify-center font-bold">
                                <span class="text-base leading-none">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d') }}</span>
                                <span class="text-[9px] uppercase tracking-wider mt-0.5">Th{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('m') }}</span>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y') }}</div>
                                <div class="text-[11px] text-slate-500 font-medium flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="font-bold text-slate-900 mb-0.5">{{ $appointment->service ? $appointment->service->name : 'Khám tổng quát' }}</div>
                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $appointment->doctor ? 'BS. ' . $appointment->doctor->user->name : 'Chưa chỉ định BS' }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @if($appointment->status == 'completed')
                                <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                    ✓ Đã hoàn thành
                                </span>
                            @elseif($appointment->status == 'cancelled' || $appointment->status == 'no_show')
                                <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                    Đã hủy
                                </span>
                            @else
                                @if($appointment->isOverdue())
                                    <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                        ⚠️ Quá thời gian hẹn
                                    </span>
                                @elseif($appointment->isDueNow())
                                    <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md animate-pulse">
                                        🔔 Đến giờ khám
                                    </span>
                                @endif

                                @if($appointment->status == 'confirmed')
                                    <span class="bg-[#EEF2FF] text-[#3730A3] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                        ✓ Đã xác nhận
                                    </span>
                                @elseif($appointment->status == 'pending')
                                    <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                        Chờ xác nhận
                                    </span>
                                @else
                                    <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                        Đang chờ khám
                                    </span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        @php
                            $record = \App\Models\MedicalRecord::where('appointment_id', $appointment->id)->first();
                        @endphp
                        <div class="flex items-center justify-end gap-1.5">
                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-lg font-bold text-xs transition">
                                        Hủy lịch
                                    </button>
                                </form>
                            @endif
                            @if($record)
                                <a href="{{ route('patient.medical_records.show', $record->id) }}" class="px-3 py-1 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-lg font-bold text-xs shadow-xs transition">
                                    Xem Bệnh Án
                                </a>
                            @else
                                <span class="px-2.5 py-1 text-slate-400 font-medium text-xs bg-slate-50 rounded-lg border border-slate-100">Chưa có BA</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-2 text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <p class="text-slate-500 font-semibold text-xs">Bạn chưa có lịch khám nào trong hồ sơ.</p>
                            <a href="{{ route('booking.index') }}" class="mt-3 text-xs font-bold text-[#0D7A68] hover:underline">Đặt lịch khám ngay &rarr;</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
