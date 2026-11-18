@extends('layouts.patient')

@section('title', 'Tổng quan - Patient Portal')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tổng quan</h1>
    <p class="text-gray-500 mt-1">Xin chào, <span class="font-bold text-blue-600">{{ Auth::user()->name }}</span>! Dưới đây là thông tin hoạt động của bạn tại phòng khám.</p>
</div>

<!-- KHỐI THÔNG BÁO TỰ ĐỘNG CHO BỆNH NHÂN (XÁC NHẬN LỊCH / ĐẾN GIỜ HẸN / QUÁ GIỜ HẸN) -->
@php
    $dueAppointments = $upcomingAppointments->filter(fn($a) => $a->isDueNow());
    $overdueAppointments = $upcomingAppointments->filter(fn($a) => $a->isOverdue());
    $confirmedFuture = $upcomingAppointments->filter(fn($a) => $a->status === 'confirmed' && !$a->isDueNow() && !$a->isOverdue());
@endphp

<div id="patient-live-notifications" class="space-y-4 mb-8">
    @foreach($dueAppointments as $dueApp)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-2xl shadow-sm flex items-start gap-3">
            <span class="text-2xl animate-bounce">🔔</span>
            <div class="text-sm text-amber-900">
                <p class="font-extrabold text-base text-amber-800">ĐẾN THỜI GIAN HẸN KHÁM!</p>
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
        <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-2xl shadow-sm flex items-start gap-3">
            <span class="text-2xl">⚠️</span>
            <div class="text-sm text-red-900">
                <p class="font-extrabold text-base text-red-700">QUÁ THỜI GIAN HẸN!</p>
                <p class="mt-0.5">
                    Lịch hẹn khám lúc <strong>{{ \Carbon\Carbon::parse($overApp->appointment_time)->format('H:i - d/m/Y') }}</strong>
                    @if($overApp->doctor && $overApp->doctor->user)
                        (BS. {{ $overApp->doctor->user->name }})
                    @endif
                    đã <strong>quá thời gian hẹn</strong> mà chưa ghi nhận Check-in tại phòng khám. Vui lòng đến phòng khám ngay hoặc đặt lại lịch hẹn mới.
                </p>
            </div>
        </div>
    @endforeach

    @foreach($confirmedFuture as $confApp)
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-2xl shadow-sm flex items-start gap-3">
            <span class="text-xl">✅</span>
            <div class="text-sm text-blue-900">
                <p class="font-bold text-blue-800">Lịch khám đã được xác nhận</p>
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

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('patient.profile') }}" class="glass-card rounded-2xl p-6 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
        <div>
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-1">Hồ sơ Của Tôi</h3>
            <p class="text-sm text-gray-500">Cập nhật thông tin cá nhân, tiểu sử bệnh lý</p>
        </div>
        <div class="mt-4 text-indigo-600 font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
            Xem chi tiết <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
    </a>
    
    <a href="{{ route('patient.history') }}" class="glass-card rounded-2xl p-6 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
        <div>
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-1">Lịch Sử Khám Bệnh</h3>
            <p class="text-sm text-gray-500">Xem lại các lần khám, đơn thuốc, chẩn đoán</p>
        </div>
        <div class="mt-4 text-emerald-600 font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
            Xem chi tiết <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
    </a>
    
    <a href="{{ route('patient.invoices') }}" class="glass-card rounded-2xl p-6 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
        <div>
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
            </div>
            <h3 class="font-bold text-lg text-slate-800 mb-1">Thanh Toán & Hóa Đơn</h3>
            <p class="text-sm text-gray-500">Lịch sử thanh toán chi phí tại phòng khám</p>
        </div>
        <div class="mt-4 text-amber-600 font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
            Xem chi tiết <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </div>
    </a>
</div>

<div class="glass-card rounded-[2rem] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100/50 bg-white/40 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Lịch hẹn sắp tới của bạn</h3>
        <a href="{{ route('public.booking') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Đặt lịch mới +</a>
    </div>
    
    <div class="p-6">
        @if($upcomingAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingAppointments as $app)
                    <div class="p-5 border border-gray-100 rounded-2xl flex flex-col md:flex-row justify-between md:items-center bg-white/60 hover:bg-white hover:shadow-md transition-all gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex flex-col items-center justify-center font-bold flex-shrink-0">
                                <span class="text-xl leading-none">{{ \Carbon\Carbon::parse($app->appointment_time)->format('d') }}</span>
                                <span class="text-[10px] uppercase">{{ \Carbon\Carbon::parse($app->appointment_time)->format('M') }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-lg mb-0.5">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}</p>
                                <div class="text-sm text-gray-500 font-medium">Dịch vụ: <span class="text-blue-600">{{ $app->service->name ?? 'Khám tổng quát' }}</span></div>
                                <div class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> 
                                    Bác sĩ: {{ $app->doctor->user->name ?? 'Chưa phân công' }}
                                </div>
                            </div>
                        </div>
                        <div class="md:text-right flex flex-wrap items-center md:justify-end gap-2"
                             data-apt-card="{{ $app->id }}"
                             data-apt-time="{{ \Carbon\Carbon::parse($app->appointment_time)->format('Y-m-d\TH:i:s') }}"
                             data-apt-status="{{ $app->status }}"
                             data-apt-doctor="{{ $app->doctor->user->name ?? 'Phòng khám' }}"
                             data-apt-display-time="{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}">

                            <!-- Nhãn cảnh báo Thời gian (Đến giờ hẹn / Quá thời gian hẹn) -->
                            <span class="apt-time-badge">
                                @if($app->isOverdue())
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-300">
                                        ⚠️ Quá thời gian hẹn
                                    </span>
                                @elseif($app->isDueNow())
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                        🔔 Đến thời gian hẹn
                                    </span>
                                @endif
                            </span>

                            <!-- Nhãn trạng thái xác nhận -->
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold
                                @if($app->status == 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @elseif($app->status == 'confirmed') bg-blue-100 text-blue-800 border border-blue-200
                                @elseif($app->status == 'waiting') bg-orange-100 text-orange-800 border border-orange-200
                                @endif
                            ">
                                @if($app->status == 'pending') Đang chờ xác nhận
                                @elseif($app->status == 'confirmed') ✓ Bác sĩ đã xác nhận
                                @elseif($app->status == 'waiting') Đang chờ khám tại sảnh
                                @endif
                            </span>

                            @if(in_array($app->status, ['pending', 'confirmed']))
                                <form action="{{ route('patient.appointments.cancel', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition-colors">
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
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium text-lg">Bạn không có lịch hẹn nào sắp tới.</p>
                <a href="{{ route('public.booking') }}" class="mt-4 inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold shadow-lg shadow-blue-500/30 transition-all">Đặt lịch ngay</a>
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

                // Quá thời gian hẹn (> 15 phút sau giờ hẹn)
                if (now > aptTime + 15 * 60) {
                    badgeContainer.innerHTML = '<span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-300">⚠️ Quá thời gian hẹn</span>';
                }
                // Đến thời gian hẹn (từ 30 phút trước đến 15 phút sau giờ hẹn)
                else if (now >= aptTime - 30 * 60 && now <= aptTime + 15 * 60) {
                    badgeContainer.innerHTML = '<span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">🔔 Đến thời gian hẹn</span>';
                }
            });
        }

        checkAppointmentTimes();
        setInterval(checkAppointmentTimes, 15000);
    });
</script>
@endsection
