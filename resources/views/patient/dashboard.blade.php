@extends('layouts.patient')

@section('title', 'Tổng quan - Patient Portal')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2.5">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tổng quan tài khoản</h1>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
            Bệnh nhân
        </span>
    </div>
    <p class="text-xs text-slate-500 mt-1">Xin chào, <span class="font-bold text-[#0D7A68]">{{ Auth::user()->name }}</span>! Dưới đây là thông tin hoạt động và lịch hẹn của bạn tại phòng khám.</p>
</div>

<!-- KHỐI THÔNG BÁO TỰ ĐỘNG CHO BỆNH NHÂN -->
@php
    $dueAppointments = $upcomingAppointments->filter(fn($a) => $a->isDueNow());
    $overdueAppointments = $upcomingAppointments->filter(fn($a) => $a->isOverdue());
    $confirmedFuture = $upcomingAppointments->filter(fn($a) => $a->status === 'confirmed' && !$a->isDueNow() && !$a->isOverdue());
@endphp

<div id="patient-live-notifications" class="space-y-4 mb-6">
    @foreach($dueAppointments as $dueApp)
        <div class="bg-amber-50/70 border border-amber-200 p-4 rounded-2xl shadow-xs flex items-start gap-3">
            <span class="text-xl animate-bounce">🔔</span>
            <div class="text-xs text-amber-900">
                <p class="font-bold text-sm text-amber-900">ĐẾN THỜI GIAN HẸN KHÁM!</p>
                <p class="mt-0.5">
                    Lịch khám của bạn lúc <strong>{{ \Carbon\Carbon::parse($dueApp->appointment_time)->format('H:i - d/m/Y') }}</strong>
                    @if($dueApp->doctor && $dueApp->doctor->user)
                        với <strong>BS. {{ $dueApp->doctor->user->name }}</strong>
                    @endif
                    đã đến giờ hẹn. Vui lòng đến quầy Lễ tân phòng khám để làm thủ tục Check-in!
                </p>
            </div>
        </div>
    @endforeach

    @foreach($overdueAppointments as $overApp)
        <div class="bg-red-50/70 border border-red-200 p-4 rounded-2xl shadow-xs flex items-start gap-3">
            <span class="text-xl">⚠️</span>
            <div class="text-xs text-red-900">
                <p class="font-bold text-sm text-red-900">QUÁ THỜI GIAN HẸN!</p>
                <p class="mt-0.5">
                    Lịch hẹn khám lúc <strong>{{ \Carbon\Carbon::parse($overApp->appointment_time)->format('H:i - d/m/Y') }}</strong>
                    @if($overApp->doctor && $overApp->doctor->user)
                        (BS. {{ $overApp->doctor->user->name }})
                    @endif
                    đã <strong>quá thời gian hẹn</strong> mà chưa ghi nhận Check-in tại phòng khám. Vui lòng đến phòng khám ngay hoặc liên hệ để được hỗ trợ.
                </p>
            </div>
        </div>
    @endforeach

    @foreach($confirmedFuture as $confApp)
        <div class="bg-emerald-50/60 border border-emerald-200 p-4 rounded-2xl shadow-xs flex items-start gap-3">
            <span class="text-lg">✅</span>
            <div class="text-xs text-emerald-900">
                <p class="font-bold text-emerald-950">Lịch khám đã được xác nhận</p>
                <p class="mt-0.5">
                    Lịch hẹn lúc <strong>{{ \Carbon\Carbon::parse($confApp->appointment_time)->format('H:i - d/m/Y') }}</strong>
                    @if($confApp->doctor && $confApp->doctor->user)
                        đã được <strong>BS. {{ $confApp->doctor->user->name }}</strong> xác nhận.
                    @else
                        đã được phòng khám xác nhận.
                    @endif
                    Hệ thống sẽ nhắc bạn khi đến thời gian hẹn.
                </p>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('patient.profile') }}" class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between hover:border-slate-300 transition group">
        <div>
            <div class="w-10 h-10 bg-[#0D7A68]/10 text-[#0D7A68] rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-900 mb-0.5">Hồ Sơ Của Tôi</h3>
            <p class="text-xs text-slate-400">Thông tin cá nhân, tiền sử y khoa</p>
        </div>
        <div class="mt-4 text-[#0D7A68] font-bold text-xs flex items-center gap-1 group-hover:gap-1.5 transition-all">
            Xem chi tiết &rarr;
        </div>
    </a>
    
    <a href="{{ route('patient.history') }}" class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between hover:border-slate-300 transition group">
        <div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-900 mb-0.5">Lịch Sử & Bệnh Án</h3>
            <p class="text-xs text-slate-400">Xem lại các lần khám, đơn thuốc, chẩn đoán</p>
        </div>
        <div class="mt-4 text-[#0D7A68] font-bold text-xs flex items-center gap-1 group-hover:gap-1.5 transition-all">
            Xem chi tiết &rarr;
        </div>
    </a>
    
    <a href="{{ route('patient.invoices') }}" class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between hover:border-slate-300 transition group">
        <div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-900 mb-0.5">Thanh Toán & Hóa Đơn</h3>
            <p class="text-xs text-slate-400">Lịch sử thanh toán chi phí tại phòng khám</p>
        </div>
        <div class="mt-4 text-[#0D7A68] font-bold text-xs flex items-center gap-1 group-hover:gap-1.5 transition-all">
            Xem chi tiết &rarr;
        </div>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
            <h3 class="font-bold text-sm text-slate-900">Lịch hẹn sắp tới của bạn</h3>
        </div>
        <a href="{{ route('public.booking') }}" class="text-xs font-bold text-[#0D7A68] hover:underline">+ Đặt lịch mới</a>
    </div>
    
    <div class="p-5">
        @if($upcomingAppointments->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingAppointments as $app)
                    <div class="p-4 border border-slate-200/80 rounded-xl flex flex-col md:flex-row justify-between md:items-center bg-slate-50/40 hover:bg-white hover:shadow-xs transition gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#0D7A68]/10 text-[#0D7A68] flex flex-col items-center justify-center font-bold flex-shrink-0">
                                <span class="text-base leading-none">{{ \Carbon\Carbon::parse($app->appointment_time)->format('d') }}</span>
                                <span class="text-[9px] uppercase mt-0.5">Thg {{ \Carbon\Carbon::parse($app->appointment_time)->format('m') }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-sm mb-0.5">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }} • {{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m/Y') }}</p>
                                <div class="text-xs text-slate-500 font-medium">Dịch vụ: <span class="text-[#0D7A68] font-semibold">{{ $app->service->name ?? 'Khám tổng quát' }}</span></div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    Bác sĩ phụ trách: {{ $app->doctor->user->name ?? 'Chưa phân công' }}
                                </div>
                            </div>
                        </div>
                        <div class="md:text-right flex flex-wrap items-center md:justify-end gap-2"
                             data-apt-card="{{ $app->id }}"
                             data-apt-time="{{ \Carbon\Carbon::parse($app->appointment_time)->format('Y-m-d\TH:i:s') }}"
                             data-apt-status="{{ $app->status }}"
                             data-apt-doctor="{{ $app->doctor->user->name ?? 'Phòng khám' }}"
                             data-apt-display-time="{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}">

                            <!-- Nhãn cảnh báo Thời gian -->
                            <span class="apt-time-badge">
                                @if($app->isOverdue())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEE2E2] text-[#991B1B]">
                                        ⚠️ Quá giờ hẹn
                                    </span>
                                @elseif($app->isDueNow())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEF3C7] text-[#92400E] animate-pulse">
                                        🔔 Đến giờ hẹn
                                    </span>
                                @endif
                            </span>

                            <!-- Nhãn trạng thái xác nhận -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold
                                @if($app->status == 'pending') bg-[#FEF3C7] text-[#92400E]
                                @elseif($app->status == 'confirmed') bg-[#ECFDF5] text-[#065F46]
                                @elseif($app->status == 'waiting') bg-[#FFFBEB] text-[#B45309]
                                @endif
                            ">
                                @if($app->status == 'pending') Đang chờ xác nhận
                                @elseif($app->status == 'confirmed') Đã xác nhận
                                @elseif($app->status == 'waiting') Đang chờ tại sảnh
                                @endif
                            </span>

                            @if(in_array($app->status, ['pending', 'confirmed']))
                                <form action="{{ route('patient.appointments.cancel', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-white text-red-600 hover:bg-red-50 border border-slate-200 transition">
                                        Hủy lịch
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-slate-400 text-xs">Bạn không có lịch hẹn nào sắp tới.</p>
                <a href="{{ route('public.booking') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">Đặt lịch ngay</a>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function checkAppointmentTimes() {
            const now = Math.floor(Date.now() / 1000);
            document.querySelectorAll('[data-apt-card]').forEach(function (el) {
                const status = el.getAttribute('data-apt-status');
                if (status !== 'pending' && status !== 'confirmed') return;

                const aptTime = parseInt(el.getAttribute('data-apt-time'), 10);
                if (!aptTime) return;

                const badgeContainer = el.querySelector('.apt-time-badge');
                if (!badgeContainer) return;

                if (now > aptTime + 15 * 60) {
                    badgeContainer.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEE2E2] text-[#991B1B]">⚠️ Quá giờ hẹn</span>';
                }
                else if (now >= aptTime - 30 * 60 && now <= aptTime + 15 * 60) {
                    badgeContainer.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEF3C7] text-[#92400E] animate-pulse">🔔 Đến giờ hẹn</span>';
                }
            });
        }

        checkAppointmentTimes();
        setInterval(checkAppointmentTimes, 15000);
    });
</script>
@endsection
