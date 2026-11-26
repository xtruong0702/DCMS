<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 py-1">
            <div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tiếp đón, Điều phối sảnh & Thu ngân</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                        Hôm nay: {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Tiếp nhận khám trực tiếp, xác nhận lịch hẹn đặt trước, điều phối sảnh và thu ngân VietQR</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('receptionist.patients.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Tạo hồ sơ bệnh nhân</span>
                </a>
                <a href="{{ route('receptionist.invoices.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Lập hóa đơn thu tiền</span>
                </a>
                <a href="{{ route('receptionist.appointments.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tiếp nhận khách / Đặt lịch</span>
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

            <!-- 5 Thẻ Thống Kê Nghiệp Vụ (Designed to match Stitch UI) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                <!-- Thẻ 1: Lịch hẹn chờ duyệt -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Lịch hẹn chờ duyệt</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $pendingConfirmCount ?? 0 }}</span>
                        <span class="text-xs text-slate-500 font-medium">lịch hẹn</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">Từ ngày mai trở đi</div>
                </div>

                <!-- Thẻ 2: Ca khám hôm nay -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Ca khám hôm nay</span>
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalToday }}</span>
                        <span class="text-xs text-slate-500 font-medium">ca đã lên lịch</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">
                        @if($totalToday > 0)
                            Đạt {{ round(($completedCount / max(1, $totalToday)) * 100) }}% chỉ tiêu sáng
                        @else
                            Chưa có ca khám
                        @endif
                    </div>
                </div>

                <!-- Thẻ 3: Chờ tại sảnh -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Chờ tại sảnh</span>
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $waitingCount }}</span>
                        <span class="text-xs text-slate-500 font-medium">khách đang chờ</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">Thời gian chờ TB: 6 phút</div>
                </div>

                <!-- Thẻ 4: Trong phòng khám -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Trong phòng khám</span>
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $inProgressCount }}</span>
                        <span class="text-xs text-slate-500 font-medium">ca đang thực hiện</span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1 truncate">
                        @php
                            $inProgressApp = $todayAppointments->firstWhere('status', 'in_progress');
                        @endphp
                        {{ $inProgressApp && $inProgressApp->doctor && $inProgressApp->doctor->user ? 'Ghế 02 • BS. ' . $inProgressApp->doctor->user->name : 'Ghế 02 • BS. Thu Hà' }}
                    </div>
                </div>

                <!-- Thẻ 5: Hóa đơn chờ -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs col-span-2 sm:col-span-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-600">Hóa đơn chờ</span>
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    </div>
                    <div class="mt-2.5 flex items-baseline gap-1.5">
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $unpaidInvoices->count() }}</span>
                        <span class="text-xs text-slate-500 font-medium">hóa đơn mới</span>
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1 truncate">
                        Cần thanh toán: <span class="font-bold text-rose-600">{{ number_format($unpaidInvoices->sum('final_amount'), 0, ',', '.') }} đ</span>
                    </div>
                </div>
            </div>

            <!-- Bố cục 2 Cột: Trái (8/12) - Phải (4/12) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Cột trái (8/12): Lịch đặt trước & Luồng khám trong ngày -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- KHỐI 1: Lịch hẹn đặt trước (từ ngày mai) & chờ xác nhận -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <h2 class="text-sm font-bold text-slate-900">Lịch hẹn đặt trước (từ ngày mai) & chờ xác nhận</h2>
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                    {{ $advanceBookings->count() }}
                                </span>
                            </div>
                            <a href="{{ route('receptionist.appointments.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                                Xem tất cả lịch hẹn &gt;
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($advanceBookings as $app)
                                <div class="p-4 rounded-xl border border-slate-100 hover:border-slate-200 bg-white space-y-2 transition">
                                    <!-- Hàng 1: Tên + SĐT + Trạng thái + Thời gian -->
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-sm text-slate-900">{{ $app->patient->name ?? 'Khách hàng' }}</span>
                                            <span class="text-xs text-slate-500 font-normal">{{ $app->patient->phone ?? '' }}</span>
                                            @if($app->status === 'pending')
                                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-[#FEF3C7] text-[#92400E] border border-amber-200/80">
                                                    Chờ xác nhận
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-[#D1FAE5] text-[#065F46] border border-emerald-200/80">
                                                    Đã xác nhận
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1 text-xs text-slate-500">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i • d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Hàng 2: Dịch vụ -->
                                    <div class="text-xs text-slate-600">
                                        Dịch vụ: <span class="font-medium text-slate-800">{{ $app->service->name ?? 'Khám & tư vấn nha khoa tổng quát' }}</span>
                                    </div>

                                    <!-- Hàng 3: Bác sĩ phụ trách & Nút hành động -->
                                    <div class="pt-1 flex flex-wrap items-center justify-between gap-3">
                                        <form action="{{ route('receptionist.appointments.update', $app->id) }}" method="POST" class="flex flex-wrap items-center justify-between w-full gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">

                                            @if($app->status === 'pending')
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-slate-600 whitespace-nowrap">Bác sĩ phụ trách:</span>
                                                    <select name="doctor_id" class="rounded-lg border-slate-200 text-xs font-semibold py-1 pl-2.5 pr-7 focus:border-teal-600 focus:ring-teal-600 bg-white">
                                                        <option value="">-- Chọn Bác sĩ --</option>
                                                        @foreach($doctors as $doc)
                                                            <option value="{{ $doc->id }}" @selected($app->doctor_id == $doc->id)>
                                                                BS. {{ $doc->user->name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-[#0D7A68] hover:bg-[#0B6858] text-white text-xs font-bold shadow-xs transition">
                                                    ✓ Xác nhận &amp; Lưu BS
                                                </button>
                                            @else
                                                <div class="text-xs text-slate-600">
                                                    Phụ trách: <strong class="text-slate-800">BS. {{ $app->doctor && $app->doctor->user ? $app->doctor->user->name : 'Chưa phân công' }}</strong>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <select name="doctor_id" class="rounded-lg border-slate-200 text-xs font-semibold py-1 pl-2.5 pr-7 focus:border-teal-600 focus:ring-teal-600 bg-white">
                                                        @foreach($doctors as $doc)
                                                            <option value="{{ $doc->id }}" @selected($app->doctor_id == $doc->id)>
                                                                BS. {{ $doc->user->name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                                                        Đổi bác sĩ
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-xs text-slate-400">
                                    Hiện không có lịch hẹn đặt trước nào đang chờ xác nhận.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- KHỐI 2: Luồng khách khám trong ngày hôm nay -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900">
                                Luồng khách khám trong ngày hôm nay ({{ date('d/m/Y') }})
                            </h2>
                            <a href="{{ route('receptionist.queue.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                                Mở màn hình Hàng đợi ↗
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-xs">
                                <thead>
                                    <tr class="text-left text-[11px] font-bold text-slate-400 tracking-wider">
                                        <th class="py-2.5 pr-4 uppercase">Giờ</th>
                                        <th class="py-2.5 px-4 uppercase">Bệnh nhân &amp; Dịch vụ</th>
                                        <th class="py-2.5 px-4 uppercase">Bác sĩ phụ trách</th>
                                        <th class="py-2.5 px-4 uppercase">Trạng thái sảnh</th>
                                        <th class="py-2.5 pl-4 text-right uppercase">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($todayAppointments as $app)
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="py-3.5 pr-4 whitespace-nowrap font-bold text-slate-900">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                <div class="font-bold text-slate-900">
                                                    {{ $app->patient->name }}
                                                    <span class="text-slate-400 font-normal ml-1">{{ $app->patient->phone ?? '' }}</span>
                                                </div>
                                                <div class="text-[11px] text-slate-500 mt-0.5">
                                                    {{ $app->service->name ?? 'Khám tổng quát & Tư vấn' }}
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-700">
                                                {{ $app->doctor && $app->doctor->user ? 'BS. ' . $app->doctor->user->name : 'Chưa phân công' }}
                                            </td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                @if($app->status === 'completed')
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#D1FAE5] text-[#065F46]">
                                                        Đã khám xong
                                                    </span>
                                                @elseif($app->status === 'in_progress')
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#EEF2FF] text-[#3730A3]">
                                                        Đang khám
                                                    </span>
                                                @elseif($app->status === 'waiting')
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#FFFBEB] text-[#B45309]">
                                                        Đang chờ khám
                                                    </span>
                                                @elseif($app->status === 'confirmed')
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#EFF6FF] text-[#1D4ED8]">
                                                        Đã xác nhận
                                                    </span>
                                                @elseif($app->status === 'pending')
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#FEF3C7] text-[#92400E]">
                                                        Chờ xác nhận
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600">
                                                        Hủy / Vắng
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 pl-4 whitespace-nowrap text-right space-x-1">
                                                @if($app->status === 'pending' || $app->status === 'confirmed')
                                                    <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs transition shadow-xs">
                                                            🪑 Check-in
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                                                    Sửa
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400">
                                                Hôm nay chưa có lịch khám trực tiếp. Nhấn <strong>"+ Tiếp nhận khách / Đặt lịch"</strong> khi có khách đến phòng khám.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cột phải (4/12): Quầy thu ngân & Yêu cầu tư vấn -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- KHỐI 1: Quầy thu ngân & VietQR -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-sm font-bold text-slate-900">Quầy thu ngân &amp; VietQR</h2>
                                    <span class="px-2 py-0.2 rounded-full text-[11px] font-bold bg-[#DC2626] text-white leading-none">
                                        {{ $unpaidInvoices->count() }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">Hóa đơn từ phòng Bác sĩ chuyển sang chờ thu tiền</p>
                            </div>
                        </div>

                        @if($unpaidInvoices->count() > 0)
                            @php
                                $firstInvoice = $unpaidInvoices->first();
                            @endphp
                            <div class="mt-4 p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-slate-800">#{{ $firstInvoice->invoice_code }}</span>
                                    <span class="text-slate-400">{{ $firstInvoice->created_at->format('H:i • d/m') }}</span>
                                </div>

                                <div class="text-xs">
                                    <div class="font-bold text-slate-900">Bệnh nhân: {{ $firstInvoice->patient->name ?? 'Khách hàng' }}</div>
                                    <div class="text-slate-500 mt-0.5">SĐT: {{ $firstInvoice->patient->phone ?? '---' }}</div>
                                </div>

                                <!-- Chi tiết dịch vụ & thuốc trong hóa đơn -->
                                <div class="space-y-1.5 pt-1">
                                    @if($firstInvoice->details && $firstInvoice->details->count() > 0)
                                        @foreach($firstInvoice->details->take(3) as $idx => $item)
                                            <div class="flex items-center justify-between text-xs text-slate-700">
                                                <span class="truncate pr-2">{{ $idx + 1 }}. {{ $item->item_name }}</span>
                                                <span class="font-medium shrink-0">{{ number_format($item->total_price, 0, ',', '.') }} đ</span>
                                            </div>
                                        @endforeach
                                        @if($firstInvoice->details->count() > 3)
                                            <div class="text-[11px] text-slate-400 italic">... và {{ $firstInvoice->details->count() - 3 }} mục khác</div>
                                        @endif
                                    @else
                                        <div class="text-xs text-slate-500">Khám nha khoa và các dịch vụ chỉ định từ Bác sĩ.</div>
                                    @endif
                                </div>

                                <div class="border-t border-slate-200 pt-2 flex items-baseline justify-between">
                                    <div>
                                        <div class="text-xs text-slate-600 font-medium">Tổng cần thanh toán</div>
                                        <div class="text-[10px] text-slate-400">(đã bao gồm VAT 10%)</div>
                                    </div>
                                    <div class="text-xl font-black text-slate-900">
                                        {{ number_format($firstInvoice->final_amount, 0, ',', '.') }} đ
                                    </div>
                                </div>

                                <a href="{{ route('receptionist.invoices.show', $firstInvoice->id) }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-[#0D7A68] hover:bg-[#0B6858] text-white text-xs font-bold shadow-xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <span>Thu Tiền / Quét VietQR &rarr;</span>
                                </a>
                            </div>

                            @if($unpaidInvoices->count() > 1)
                                <div class="mt-2 text-center">
                                    <a href="{{ route('receptionist.invoices.index') }}" class="text-[11px] text-teal-700 hover:underline font-semibold">
                                        + Còn {{ $unpaidInvoices->count() - 1 }} hóa đơn khác đang chờ thu tiền &rarr;
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="py-8 text-center text-xs text-slate-400">
                                Hiện không có hóa đơn nào đang chờ thu tiền.
                            </div>
                        @endif

                        <div class="mt-3 pt-3 border-t border-slate-100 text-center">
                            <a href="{{ route('receptionist.invoices.create') }}" class="text-xs font-semibold text-slate-600 hover:text-[#0D7A68] transition">
                                + Lập Hóa Đơn Dịch Vụ / Thuốc Mới
                            </a>
                        </div>
                    </div>

                    <!-- KHỐI 2: Yêu cầu tư vấn từ Website -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900">Yêu cầu tư vấn từ Website</h2>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                {{ $pendingInquiriesCount ?? 0 }} chờ gọi
                            </span>
                        </div>

                        @if(($pendingInquiriesCount ?? 0) === 0 && ($contactInquiries ?? collect())->isEmpty())
                            <!-- Trạng thái trống giống hệt Stitch UI -->
                            <div class="py-8 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                                    ✉️
                                </div>
                                <div class="text-xs font-bold text-slate-800">Chưa có yêu cầu tư vấn mới</div>
                                <p class="text-[11px] text-slate-400 mt-1 max-w-[240px] mx-auto leading-relaxed">
                                    Chưa có yêu cầu tư vấn mới nào từ trang Liên hệ. Dữ liệu sẽ tự động đồng bộ khi có khách để lại số điện thoại.
                                </p>
                            </div>
                        @else
                            <div class="space-y-3 mt-3 max-h-[340px] overflow-y-auto pr-1">
                                @foreach($contactInquiries as $inq)
                                    <div class="p-3 border rounded-xl text-xs space-y-1.5 {{ ($inq['status'] ?? 'pending') === 'pending' ? 'border-amber-200 bg-amber-50/30' : 'border-slate-200 bg-slate-50/50' }}">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-slate-900">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $inq['created_at'] ?? '' }}</span>
                                        </div>
                                        <div class="text-indigo-600 font-semibold font-mono">{{ $inq['phone'] ?? '' }}</div>
                                        <p class="text-slate-600 line-clamp-2 text-[11px] leading-relaxed">{{ $inq['message'] ?? '' }}</p>
                                        <div class="flex items-center justify-end gap-1.5 pt-1">
                                            @if(($inq['status'] ?? 'pending') === 'pending')
                                                <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">
                                                        ✓ Đã tư vấn
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('receptionist.appointments.create', ['name' => $inq['name'] ?? '', 'phone' => $inq['phone'] ?? '']) }}" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[10px]">
                                                Đặt lịch
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
