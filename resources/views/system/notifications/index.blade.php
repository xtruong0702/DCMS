<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Trung tâm thông báo & Nhắc việc
                    </h2>
                    @if(($totalNotificationsCount ?? 0) > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FEE2E2] text-[#991B1B] border border-red-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                            {{ $totalNotificationsCount }} cần xử lý
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1">Cập nhật thời gian thực: Lịch hẹn mới, bệnh nhân sảnh chờ, đến giờ khám, quá giờ và hóa đơn chờ thu</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition self-start sm:self-auto">
                &larr; Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Thanh tóm tắt nhanh số lượng thông báo (Stitch UI Dot indicators) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                    <span>Chờ tại sảnh</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $waitingList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                    <span>Chờ duyệt</span>
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $pendingList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                    <span>Đến giờ hẹn</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $dueNowList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                    <span>Quá giờ hẹn</span>
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $overdueList->count() }}</div>
            </div>
            @if(in_array($role, ['admin', 'receptionist']))
                <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                        <span>HĐ chờ thu</span>
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                    </div>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $unpaidInvoices->count() }}</div>
                </div>
            @endif
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-medium text-slate-500">
                    <span>Đã xác nhận</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $confirmedList->count() }}</div>
            </div>
        </div>

        <!-- 1. Bệnh nhân đã Check-in đang chờ tại sảnh -->
        @if($waitingList->count() > 0 || in_array($role, ['doctor', 'receptionist']))
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <h3 class="font-bold text-slate-900 text-sm">Bệnh nhân đã check-in sảnh chờ ({{ $waitingList->count() }})</h3>
                    </div>
                    <span class="text-[11px] font-semibold bg-[#FFFBEB] text-[#B45309] px-2.5 py-0.5 rounded-md">Đang ở sảnh</span>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($waitingList as $app)
                        <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                        Đang chờ khám
                                    </span>
                                    <span class="font-bold text-slate-900 text-xs">
                                        Giờ hẹn: {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                    </span>
                                </div>
                                <p class="text-slate-800 mt-1">
                                    Bệnh nhân: <strong class="text-slate-900">{{ $app->patient->full_name ?? ($app->patient->name ?? 'N/A') }}</strong> ({{ $app->patient->phone ?? '---' }})
                                    • Bác sĩ: <strong class="text-[#0D7A68]">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                                </p>
                                <p class="text-slate-400 text-[11px] mt-0.5">
                                    Dịch vụ: {{ $app->service->name ?? 'Khám tổng quát' }}
                                    @if($app->reason) • Ghi chú: {{ $app->reason }} @endif
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if($role === 'doctor')
                                    <a href="{{ route('doctor.consultations.show', $app->id) }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                        Khám & Kê đơn &rarr;
                                    </a>
                                @elseif($role === 'receptionist')
                                    <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                                        Mở hàng đợi &rarr;
                                    </a>
                                @elseif($role === 'admin')
                                    <a href="{{ route('admin.appointments.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                                        Chi tiết &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Hiện không có bệnh nhân nào đang ngồi chờ ngoài sảnh.</div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- 2. Lịch hẹn mới đặt chờ xác nhận -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Lịch hẹn mới chờ duyệt ({{ $pendingList->count() }})</h3>
                </div>
                <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">Khách đặt lịch mới</span>
            </div>
            <div class="divide-y divide-slate-100 text-xs">
                @forelse($pendingList as $app)
                    <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                    Chờ xác nhận
                                </span>
                                <span class="font-bold text-slate-900 text-xs">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                                <span class="text-slate-400 text-[11px]">({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})</span>
                            </div>
                            <p class="text-slate-800 mt-1">
                                Bệnh nhân: <strong class="text-slate-900">{{ $app->patient->full_name ?? ($app->patient->name ?? 'N/A') }}</strong> ({{ $app->patient->phone ?? '---' }})
                                • Bác sĩ yêu cầu: <strong class="text-slate-800">{{ $app->doctor->user->name ?? 'Chưa chọn Bác sĩ' }}</strong>
                            </p>
                            <p class="text-slate-400 text-[11px] mt-0.5">
                                Dịch vụ: {{ $app->service->name ?? 'Khám & Tư vấn' }}
                                @if($app->reason) • Ghi chú: {{ $app->reason }} @endif
                            </p>
                        </div>
                        <div class="shrink-0 flex flex-wrap items-center gap-2">
                            @if($role === 'receptionist')
                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                    ✓ Xác nhận & Phân BS
                                </a>
                            @elseif($role === 'doctor')
                                <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                        ✓ Bác sĩ duyệt lịch
                                    </button>
                                </form>
                            @elseif($role === 'admin')
                                <a href="{{ route('admin.appointments.edit', $app->id) }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                    Điều phối lịch &rarr;
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Không có lịch hẹn mới nào đang chờ duyệt.</div>
                @endforelse
            </div>
        </div>

        <!-- 3. Hóa đơn & Đơn thuốc chờ thu ngân -->
        @if(in_array($role, ['admin', 'receptionist']))
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        <h3 class="font-bold text-slate-900 text-sm">Hóa đơn & Đơn thuốc chờ thu ngân ({{ $unpaidInvoices->count() }})</h3>
                    </div>
                    <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">Chờ thanh toán</span>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($unpaidInvoices as $inv)
                        <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                        Chờ thu tiền
                                    </span>
                                    <span class="font-mono font-bold text-slate-900 text-xs">#{{ $inv->invoice_code }}</span>
                                    <span class="text-slate-400 text-[11px]">({{ $inv->created_at->format('H:i - d/m/Y') }})</span>
                                </div>
                                <p class="text-slate-800 mt-1">
                                    Bệnh nhân: <strong class="text-slate-900">{{ $inv->patient->full_name ?? ($inv->patient->name ?? 'Khách hàng') }}</strong> ({{ $inv->patient->phone ?? '---' }})
                                    • Cần thu: <strong class="text-slate-900 font-bold">{{ number_format($inv->final_amount, 0, ',', '.') }} đ</strong>
                                </p>
                                <p class="text-slate-400 text-[11px] mt-0.5">
                                    Gồm {{ $inv->details->count() }} khoản mục dịch vụ & thuốc Bác sĩ đã kê.
                                </p>
                            </div>
                            <div class="shrink-0">
                                @if($role === 'receptionist')
                                    <a href="{{ route('receptionist.invoices.show', $inv->id) }}" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                        Thu tiền & VietQR &rarr;
                                    </a>
                                @else
                                    <a href="{{ route('admin.invoices.show', $inv->id) }}" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                        Xem hóa đơn &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Tất cả hóa đơn và đơn thuốc đã được thanh toán hoàn tất.</div>
                    @endforelse
                </div>
            </div>

            <!-- 3B. Yêu Cầu Tư Vấn / Liên Hệ Từ Website -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h3 class="font-bold text-slate-900 text-sm">Yêu cầu tư vấn từ Website ({{ ($contactInquiries ?? collect())->where('status', 'pending')->count() }} chờ gọi)</h3>
                    </div>
                    <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">Website</span>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($contactInquiries ?? [] as $inq)
                        <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if(($inq['status'] ?? 'pending') === 'pending')
                                        <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                            Chờ gọi
                                        </span>
                                    @else
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                            ✓ Đã gọi ({{ $inq['resolved_by'] ?? 'Lễ tân' }})
                                        </span>
                                    @endif
                                    <span class="font-bold text-slate-900 text-xs">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                    <a href="tel:{{ $inq['phone'] ?? '' }}" class="font-mono text-slate-700 hover:underline">• SĐT: {{ $inq['phone'] ?? '---' }}</a>
                                    <span class="text-slate-400 text-[11px]">({{ $inq['created_at'] ?? '' }})</span>
                                </div>
                                <p class="text-slate-600 text-xs mt-1 bg-slate-50/80 p-2.5 rounded-xl border border-slate-200/60">
                                    {{ $inq['message'] ?? '' }}
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if(($inq['status'] ?? 'pending') === 'pending')
                                    <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                            ✓ Đã gọi tư vấn
                                        </button>
                                    </form>
                                @endif
                                @if($role === 'receptionist')
                                    <a href="{{ route('receptionist.appointments.create', ['name' => $inq['name'] ?? '', 'phone' => $inq['phone'] ?? '']) }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                                        Tạo lịch hẹn
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Hiện không có yêu cầu tư vấn nào từ Website.</div>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- 4. Thông báo: Đến thời gian hẹn -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Đến thời gian hẹn khám ({{ $dueNowList->count() }})</h3>
                </div>
                <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">Khung giờ hẹn</span>
            </div>
            <div class="divide-y divide-slate-100 text-xs">
                @forelse($dueNowList as $app)
                    <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md animate-pulse">
                                    🔔 Đến giờ hẹn
                                </span>
                                <span class="font-bold text-slate-900 text-xs">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                            </div>
                            <p class="text-slate-800 mt-1">
                                Bệnh nhân: <strong class="text-slate-900">{{ $app->patient->full_name ?? ($app->patient->name ?? 'N/A') }}</strong> ({{ $app->patient->phone ?? '' }})
                                • Bác sĩ: <strong class="text-slate-800">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                            </p>
                            <p class="text-slate-400 text-[11px] mt-0.5">Dịch vụ: {{ $app->service->name ?? ($app->reason ?? 'Khám nha khoa') }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            @if($role === 'receptionist')
                                <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                                        Check-in vào sảnh
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold {{ $app->status === 'confirmed' ? 'bg-[#ECFDF5] text-[#065F46]' : 'bg-[#FEF3C7] text-[#92400E]' }}">
                                    {{ $app->status === 'confirmed' ? 'Đã xác nhận' : 'Chờ xác nhận' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Hiện không có lịch hẹn nào đang trong khung giờ đến hẹn.</div>
                @endforelse
            </div>
        </div>

        <!-- 5. Thông báo: Quá thời gian hẹn -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Quá thời gian hẹn chưa check-in ({{ $overdueList->count() }})</h3>
                </div>
                <span class="text-[11px] font-semibold bg-[#FEE2E2] text-[#991B1B] px-2.5 py-0.5 rounded-full">Trễ hẹn</span>
            </div>
            <div class="divide-y divide-slate-100 text-xs">
                @forelse($overdueList as $app)
                    <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                    ⚠️ Quá giờ hẹn
                                </span>
                                <span class="font-bold text-red-700 text-xs">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                                <span class="text-red-500 text-[11px] font-medium">
                                    ({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})
                                </span>
                            </div>
                            <p class="text-slate-800 mt-1">
                                Bệnh nhân: <strong class="text-slate-900">{{ $app->patient->full_name ?? ($app->patient->name ?? 'N/A') }}</strong> ({{ $app->patient->phone ?? '' }})
                                • Bác sĩ: <strong class="text-slate-800">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                            </p>
                            <p class="text-slate-400 text-[11px] mt-0.5">Dịch vụ: {{ $app->service->name ?? ($app->reason ?? 'Khám nha khoa') }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            @if($role === 'receptionist')
                                <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold transition">
                                        Check-in muộn
                                    </button>
                                </form>
                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition">
                                    Đổi giờ
                                </a>
                            @elseif($role === 'admin')
                                <a href="{{ route('admin.appointments.edit', $app->id) }}" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition">
                                    Xử lý &rarr;
                                </a>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold {{ $app->status === 'confirmed' ? 'bg-[#ECFDF5] text-[#065F46]' : 'bg-[#FEF3C7] text-[#92400E]' }}">
                                    {{ $app->status === 'confirmed' ? 'Đã xác nhận' : 'Chưa xác nhận' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Không có lịch hẹn nào bị quá thời gian hẹn.</div>
                @endforelse
            </div>
        </div>

        <!-- 6. Cảnh báo Kho thuốc sắp hết -->
        @if($role === 'admin' && $lowStockMedicines->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        <h3 class="font-bold text-slate-900 text-sm">Kho thuốc sắp hết ({{ $lowStockMedicines->count() }})</h3>
                    </div>
                    <a href="{{ route('admin.medicines.index') }}" class="text-xs font-semibold text-[#0D7A68] hover:underline">Quản lý kho thuốc &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($lowStockMedicines as $med)
                        <div class="p-4 px-5 flex items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                            <div>
                                <p class="text-xs font-bold text-slate-900">{{ $med->name }}</p>
                                <p class="text-[11px] text-slate-400">Đơn vị: {{ $med->unit ?? 'Viên' }} • Giá bán: {{ number_format($med->price ?? 0, 0, ',', '.') }} đ</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEE2E2] text-[#991B1B]">
                                    Tồn kho: {{ $med->stock_quantity }} {{ $med->unit ?? '' }}
                                </span>
                                <a href="{{ route('admin.medicines.edit', $med->id) }}" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold transition">
                                    Nhập thêm
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 7. Thông báo: Lịch khám sắp tới đã xác nhận -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Lịch khám sắp tới đã xác nhận ({{ $confirmedList->count() }})</h3>
                </div>
                <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">Đã duyệt</span>
            </div>
            <div class="divide-y divide-slate-100 text-xs">
                @forelse($confirmedList as $app)
                    <div class="p-4 px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-[#ECFDF5] text-[#065F46] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                    ✓ Đã xác nhận
                                </span>
                                <span class="font-bold text-slate-900 text-xs">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                            </div>
                            <p class="text-slate-800 mt-1">
                                Bệnh nhân: <strong class="text-slate-900">{{ $app->patient->full_name ?? ($app->patient->name ?? 'N/A') }}</strong> ({{ $app->patient->phone ?? '---' }})
                                • Bác sĩ: <strong class="text-slate-800">{{ $app->doctor->user->name ?? 'Phòng khám sắp xếp' }}</strong>
                            </p>
                            <p class="text-slate-400 text-[11px] mt-0.5">Dịch vụ: {{ $app->service->name ?? 'Khám & Tư vấn' }}</p>
                        </div>
                        <div class="shrink-0">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600">
                                Sắp tới ({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Chưa có lịch hẹn nào ở trạng thái đã xác nhận.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
