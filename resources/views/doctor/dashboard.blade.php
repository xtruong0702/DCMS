<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 py-1">
            <div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Phòng Khám Chuyên Khoa &amp; Điều Trị</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                        BS. {{ $doctor->user->name ?? 'Nha sĩ' }} • {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Khám lâm sàng, chẩn đoán sơ đồ răng Odontogram, điều trị và kê đơn thuốc chuyển Thu ngân</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('doctor.queue.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Hàng đợi phòng khám</span>
                </a>
                <a href="{{ route('doctor.prescriptions.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Đơn thuốc</span>
                </a>
                <a href="{{ route('doctor.consultations.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Tất cả ca khám</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                    <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs">!</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- 4 Thẻ KPI Bác sĩ (Stitch UI) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Ca khám hôm nay</span>
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalToday }}</span>
                        <span class="text-xs text-slate-500 font-medium">ca đã lên lịch</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">Được chỉ định cho bạn</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Chờ tại sảnh</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $waitingCount }}</span>
                        <span class="text-xs text-slate-500 font-medium">bệnh nhân sẵn sàng</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">Đã làm thủ tục Check-in</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Đang khám trong phòng</span>
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $inProgress ? 1 : 0 }}</span>
                        <span class="text-xs text-slate-500 font-medium">ghế đang điều trị</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1 truncate">
                        {{ $inProgress ? $inProgress->patient->name : 'Hiện ghế khám đang trống' }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Đã khám xong</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $completedCount }}</span>
                        <span class="text-xs text-slate-500 font-medium">ca hoàn thành</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">Đã chuyển sang thu ngân</div>
                </div>
            </div>

            <!-- Bố cục 2 Cột: Trái (8/12) - Phải (4/12) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Cột trái (8/12): Ca khám hiện tại & Danh sách chờ tại sảnh -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- KHỐI 1: Ca khám hiện tại (nếu có) -->
                    @if($inProgress)
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs relative overflow-hidden">
                            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-sm font-bold text-slate-900">Ca Khám Hiện Tại</h2>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#EEF2FF] text-[#3730A3] border border-indigo-200/80 animate-pulse">
                                        ● Đang trên ghế khám
                                    </span>
                                </div>
                                <span class="text-xs font-bold text-slate-500">
                                    Giờ hẹn: {{ \Carbon\Carbon::parse($inProgress->appointment_time)->format('H:i') }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <div>
                                        <div class="text-xs text-slate-400 font-medium">Bệnh nhân:</div>
                                        <div class="text-lg font-bold text-slate-900">{{ $inProgress->patient->name }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 bg-slate-50/80 p-3 rounded-xl border border-slate-200/60">
                                        <div>Mã BN: <strong class="text-slate-900">{{ $inProgress->patient->patient_code }}</strong></div>
                                        <div>Tuổi: <strong class="text-slate-900">{{ $inProgress->patient->dob ? \Carbon\Carbon::parse($inProgress->patient->dob)->age . ' tuổi' : 'Chưa rõ' }}</strong></div>
                                        <div>Giới tính: <strong class="text-slate-900">{{ $inProgress->patient->gender ?? '---' }}</strong></div>
                                        <div>SĐT: <strong class="text-slate-900">{{ $inProgress->patient->phone ?? '---' }}</strong></div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="bg-teal-50/60 border border-teal-200/60 rounded-xl p-3.5">
                                        <div class="text-[11px] text-teal-800 font-bold uppercase tracking-wider">Dịch vụ yêu cầu:</div>
                                        <div class="text-sm font-bold text-teal-900 mt-0.5">{{ $inProgress->service->name ?? 'Khám tổng quát & Tư vấn' }}</div>
                                        @if($inProgress->note)
                                            <div class="mt-2 pt-2 border-t border-teal-200/60 text-xs text-teal-800">
                                                <span class="font-semibold">Ghi chú từ Lễ tân:</span> {{ $inProgress->note }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                                <a href="{{ route('doctor.consultations.show', $inProgress->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    <span>Ghi Bệnh Án &amp; Kê Đơn Thuốc &rarr;</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Khi chưa có ca khám trên ghế -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-slate-800">Ghế khám hiện đang sẵn sàng</div>
                                <p class="text-xs text-slate-400 mt-0.5">Chọn bệnh nhân đang chờ dưới danh sách để bấm "Mời vào khám".</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Sẵn sàng đón khách
                            </span>
                        </div>
                    @endif

                    <!-- KHỐI 2: Danh sách bệnh nhân chờ khám tại sảnh -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <h2 class="text-sm font-bold text-slate-900">Bệnh nhân đang chờ tại sảnh</h2>
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                    {{ $waitingList->count() }}
                                </span>
                            </div>
                            <a href="{{ route('doctor.queue.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                                Mở màn hình hàng đợi &gt;
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-xs">
                                <thead>
                                    <tr class="text-left text-[11px] font-bold text-slate-400 tracking-wider">
                                        <th class="py-2.5 pr-4 uppercase">Giờ hẹn</th>
                                        <th class="py-2.5 px-4 uppercase">Bệnh nhân</th>
                                        <th class="py-2.5 px-4 uppercase">Dịch vụ yêu cầu</th>
                                        <th class="py-2.5 px-4 uppercase">Trạng thái sảnh</th>
                                        <th class="py-2.5 pl-4 text-right uppercase">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($waitingList as $app)
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="py-3.5 pr-4 whitespace-nowrap font-bold text-slate-900">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                <div class="font-bold text-slate-900">{{ $app->patient->name }}</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $app->patient->phone ?? '' }} • Mã: {{ $app->patient->patient_code }}</div>
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-700">
                                                {{ $app->service->name ?? 'Khám & Tư vấn tổng quát' }}
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#FFFBEB] text-[#B45309]">
                                                    Đang chờ khám
                                                </span>
                                            </td>
                                            <td class="py-3.5 pl-4 whitespace-nowrap text-right">
                                                <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="in_progress">
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs transition shadow-xs">
                                                        🩺 Mời vào khám
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400">
                                                Hiện không có bệnh nhân nào đang chờ tại sảnh.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cột phải (4/12): Lịch trực & Lịch hẹn sắp tới -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Lịch trực hôm nay -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900">Lịch làm việc hôm nay</h2>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                {{ date('d/m') }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-2">
                            @forelse($todaySchedule as $sch)
                                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-200/60 flex items-center justify-between text-xs">
                                    <div>
                                        <div class="font-bold text-slate-800">
                                            @if($sch->shift === 'morning')
                                                🌅 Ca Sáng (08:00 - 12:00)
                                            @elseif($sch->shift === 'afternoon')
                                                ☀️ Ca Chiều (13:30 - 17:30)
                                            @else
                                                🌙 Ca Tối (18:00 - 20:30)
                                            @endif
                                        </div>
                                        <div class="text-slate-400 text-[11px] mt-0.5">Phòng khám chuyên khoa 01</div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px]">Đang trực</span>
                                </div>
                            @empty
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-500">
                                    Đang trực ca hành chính theo lịch khám tổng quát phòng khám.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Lịch khám đã hoàn thành hôm nay -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900">Ca đã hoàn thành hôm nay</h2>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-[#D1FAE5] text-[#065F46]">
                                {{ $completedCount }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-2.5 max-h-[360px] overflow-y-auto pr-1">
                            @forelse($todayAppointments->where('status', 'completed') as $cApp)
                                <div class="p-3 rounded-xl border border-slate-100 hover:border-slate-200 bg-white text-xs space-y-1 transition">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>{{ $cApp->patient->name }}</span>
                                        <span class="text-slate-400 font-normal text-[11px]">{{ \Carbon\Carbon::parse($cApp->appointment_time)->format('H:i') }}</span>
                                    </div>
                                    <div class="text-slate-500 text-[11px]">{{ $cApp->service->name ?? 'Khám tổng quát' }}</div>
                                    <div class="flex items-center justify-between pt-1">
                                        <span class="text-[10px] text-emerald-600 font-bold">✓ Đã chuyển thu ngân</span>
                                        <a href="{{ route('doctor.consultations.show', $cApp->id) }}" class="text-[11px] text-slate-500 hover:text-teal-700 font-semibold">
                                            Xem bệnh án &gt;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center text-xs text-slate-400">
                                    Hôm nay chưa có ca khám nào hoàn thành.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
