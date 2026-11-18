<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span>🔔 Trung Tâm Thông Báo & Nhắc Việc Hệ Thống</span>
                    @if(($totalNotificationsCount ?? 0) > 0)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700 border border-rose-200">
                            {{ $totalNotificationsCount }} cần xử lý
                        </span>
                    @endif
                </h2>
                <p class="text-xs text-slate-500 mt-1">Cập nhật theo thời gian thực: Lịch hẹn mới đặt, bệnh nhân chờ khám, lịch đến giờ/trễ hẹn, hóa đơn & đơn thuốc chờ thu ngân</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition self-start sm:self-auto">
                &larr; Quay lại Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Thanh tóm tắt nhanh số lượng thông báo -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="bg-white rounded-2xl p-3.5 border border-orange-200 shadow-xs">
                <div class="text-[11px] font-bold text-orange-700 uppercase">🪑 Chờ tại sảnh</div>
                <div class="text-2xl font-black text-orange-600 mt-1">{{ $waitingList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-indigo-200 shadow-xs">
                <div class="text-[11px] font-bold text-indigo-700 uppercase">⏳ Chờ duyệt lịch</div>
                <div class="text-2xl font-black text-indigo-600 mt-1">{{ $pendingList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-amber-200 shadow-xs">
                <div class="text-[11px] font-bold text-amber-700 uppercase">🔔 Đến giờ hẹn</div>
                <div class="text-2xl font-black text-amber-600 mt-1">{{ $dueNowList->count() }}</div>
            </div>
            <div class="bg-white rounded-2xl p-3.5 border border-red-200 shadow-xs">
                <div class="text-[11px] font-bold text-red-700 uppercase">⚠️ Quá giờ hẹn</div>
                <div class="text-2xl font-black text-red-600 mt-1">{{ $overdueList->count() }}</div>
            </div>
            @if(in_array($role, ['admin', 'receptionist']))
                <div class="bg-white rounded-2xl p-3.5 border border-emerald-200 shadow-xs">
                    <div class="text-[11px] font-bold text-emerald-700 uppercase">🧾 HĐ & Đơn thuốc</div>
                    <div class="text-2xl font-black text-emerald-600 mt-1">{{ $unpaidInvoices->count() }}</div>
                </div>
            @endif
            <div class="bg-white rounded-2xl p-3.5 border border-blue-200 shadow-xs">
                <div class="text-[11px] font-bold text-blue-700 uppercase">✓ Đã xác nhận</div>
                <div class="text-2xl font-black text-blue-600 mt-1">{{ $confirmedList->count() }}</div>
            </div>
        </div>

        <!-- 1. Bệnh nhân đã Check-in đang chờ tại sảnh (Ưu tiên số 1 cho Bác sĩ & Lễ tân) -->
        @if($waitingList->count() > 0 || in_array($role, ['doctor', 'receptionist']))
            <div class="bg-white rounded-2xl shadow-sm border border-orange-200 overflow-hidden">
                <div class="px-6 py-4 bg-orange-50 border-b border-orange-200 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-orange-500 animate-ping"></span>
                        <h3 class="font-extrabold text-orange-900 text-base">🪑 Bệnh Nhân Đã Check-in Đang Chờ Khám ({{ $waitingList->count() }})</h3>
                    </div>
                    <span class="text-xs font-bold text-orange-800 bg-orange-100 px-3 py-1 rounded-full">Đang đợi ngoài sảnh</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($waitingList as $app)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-orange-50/30 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-orange-100 text-orange-800 border border-orange-300">
                                        🪑 Đang chờ khám
                                    </span>
                                    <span class="font-bold text-slate-800 text-sm">
                                        Giờ hẹn: {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-800 mt-1.5">
                                    Bệnh nhân: <strong>{{ $app->patient->full_name ?? 'N/A' }}</strong> ({{ $app->patient->phone ?? '---' }})
                                    • Bác sĩ phụ trách: <strong class="text-indigo-700">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Dịch vụ: <strong>{{ $app->service->name ?? 'Khám tổng quát' }}</strong>
                                    @if($app->reason) • Ghi chú: {{ $app->reason }} @endif
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if($role === 'doctor')
                                    <a href="{{ route('doctor.consultations.show', $app->id) }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        🩺 Khám & Kê đơn ngay &rarr;
                                    </a>
                                @elseif($role === 'receptionist')
                                    <a href="{{ route('receptionist.queue.index') }}" class="px-3.5 py-2 bg-orange-100 hover:bg-orange-200 text-orange-800 rounded-xl text-xs font-extrabold transition">
                                        Mở Hàng đợi sảnh &rarr;
                                    </a>
                                @elseif($role === 'admin')
                                    <a href="{{ route('admin.appointments.index') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
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

        <!-- 2. Lịch hẹn mới đặt chờ xác nhận (status = pending) -->
        <div class="bg-white rounded-2xl shadow-sm border border-indigo-200 overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                    <h3 class="font-extrabold text-indigo-900 text-base">⏳ Lịch Hẹn Mới Đặt Chờ Xác Nhận ({{ $pendingList->count() }})</h3>
                </div>
                <span class="text-xs font-bold text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full">Khách đặt lịch mới</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($pendingList as $app)
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-indigo-50/30 transition">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300">
                                    ⏳ Chờ xác nhận
                                </span>
                                <span class="font-extrabold text-indigo-700 text-sm">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                                <span class="text-xs text-slate-400">({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})</span>
                            </div>
                            <p class="text-sm text-slate-800 mt-1.5">
                                Bệnh nhân: <strong>{{ $app->patient->full_name ?? 'N/A' }}</strong> ({{ $app->patient->phone ?? '---' }})
                                • Bác sĩ yêu cầu: <strong>{{ $app->doctor->user->name ?? 'Chưa chọn Bác sĩ' }}</strong>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Dịch vụ: <strong>{{ $app->service->name ?? 'Khám & Tư vấn' }}</strong>
                                @if($app->reason) • Ghi chú: {{ $app->reason }} @endif
                            </p>
                        </div>
                        <div class="shrink-0 flex flex-wrap items-center gap-2">
                            @if($role === 'receptionist')
                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                    ✓ Xác nhận & Phân BS
                                </a>
                            @elseif($role === 'doctor')
                                <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        ✓ Bác sĩ duyệt lịch
                                    </button>
                                </form>
                            @elseif($role === 'admin')
                                <a href="{{ route('admin.appointments.edit', $app->id) }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
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

        <!-- 3. Hóa đơn & Đơn thuốc chờ thu ngân (Dành cho Lễ tân & Admin) -->
        @if(in_array($role, ['admin', 'receptionist']))
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-200 overflow-hidden">
                <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-200 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                        <h3 class="font-extrabold text-emerald-900 text-base">🧾 Hóa Đơn & Đơn Thuốc Bác Sĩ Vừa Kê Chờ Thu Ngân ({{ $unpaidInvoices->count() }})</h3>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Chờ thanh toán & phát thuốc</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($unpaidInvoices as $inv)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-emerald-50/30 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700 border border-rose-200">
                                        💳 Chờ thu tiền
                                    </span>
                                    <span class="font-mono font-extrabold text-slate-800 text-sm">#{{ $inv->invoice_code }}</span>
                                    <span class="text-xs text-slate-400">({{ $inv->created_at->format('H:i - d/m/Y') }})</span>
                                </div>
                                <p class="text-sm text-slate-800 mt-1.5">
                                    Bệnh nhân: <strong>{{ $inv->patient->full_name ?? 'Khách hàng' }}</strong> ({{ $inv->patient->phone ?? '---' }})
                                    • Tổng thanh toán: <strong class="text-rose-600">{{ number_format($inv->final_amount, 0, ',', '.') }} đ</strong>
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Gồm {{ $inv->details->count() }} khoản mục dịch vụ & đơn thuốc Bác sĩ đã kê.
                                </p>
                            </div>
                            <div class="shrink-0">
                                @if($role === 'receptionist')
                                    <a href="{{ route('receptionist.invoices.show', $inv->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        💊 Xem Đơn thuốc & Thu tiền &rarr;
                                    </a>
                                @else
                                    <a href="{{ route('admin.invoices.show', $inv->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        💊 Xem Hóa đơn & Đơn thuốc &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Tất cả hóa đơn và đơn thuốc đã được thanh toán hoàn tất.</div>
                    @endforelse
                </div>
            </div>

            <!-- 3B. Yêu Cầu Tư Vấn / Liên Hệ Từ Website (Dành cho Lễ tân & Admin) -->
            <div class="bg-white rounded-2xl shadow-sm border border-cyan-200 overflow-hidden">
                <div class="px-6 py-4 bg-cyan-50 border-b border-cyan-200 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-cyan-600"></span>
                        <h3 class="font-extrabold text-cyan-950 text-base">📩 Yêu Cầu Tư Vấn / Liên Hệ Từ Website ({{ ($contactInquiries ?? collect())->where('status', 'pending')->count() }} chờ gọi)</h3>
                    </div>
                    <span class="text-xs font-bold text-cyan-800 bg-cyan-100 px-3 py-1 rounded-full">Gửi từ trang Liên hệ</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($contactInquiries ?? [] as $inq)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-cyan-50/30 transition">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if(($inq['status'] ?? 'pending') === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                            📞 Chờ gọi tư vấn
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            ✓ Đã gọi tư vấn ({{ $inq['resolved_by'] ?? 'Lễ tân' }})
                                        </span>
                                    @endif
                                    <span class="font-extrabold text-slate-900 text-sm">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                    <a href="tel:{{ $inq['phone'] ?? '' }}" class="font-mono font-bold text-indigo-600 text-xs hover:underline">• SĐT: {{ $inq['phone'] ?? '---' }}</a>
                                    <span class="text-xs text-slate-400">({{ $inq['created_at'] ?? '' }})</span>
                                </div>
                                <p class="text-xs text-slate-700 mt-1.5 bg-slate-50 p-2.5 rounded-xl border border-slate-200/80">
                                    {{ $inq['message'] ?? '' }}
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if(($inq['status'] ?? 'pending') === 'pending')
                                    <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                            ✓ Đã gọi tư vấn
                                        </button>
                                    </form>
                                @endif
                                @if($role === 'receptionist')
                                    <a href="{{ route('receptionist.appointments.create', ['name' => $inq['name'] ?? '', 'phone' => $inq['phone'] ?? '']) }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        📅 Tạo lịch hẹn
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
        <div class="bg-white rounded-2xl shadow-sm border border-amber-200 overflow-hidden">
            <div class="px-6 py-4 bg-amber-50 border-b border-amber-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
                    <h3 class="font-extrabold text-amber-900 text-base">🔔 Đến Thời Gian Hẹn Khám ({{ $dueNowList->count() }})</h3>
                </div>
                <span class="text-xs font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">Trong khung giờ hẹn (±30 phút)</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($dueNowList as $app)
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-amber-50/30 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300">
                                    🔔 Đến thời gian hẹn
                                </span>
                                <span class="font-bold text-slate-800">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-700 mt-1.5">
                                Bệnh nhân: <strong>{{ $app->patient->full_name ?? 'N/A' }}</strong> ({{ $app->patient->phone ?? '' }})
                                • Bác sĩ: <strong>{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">Dịch vụ: {{ $app->service->name ?? ($app->reason ?? 'Khám nha khoa') }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            @if($role === 'receptionist')
                                <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                        🪑 Check-in vào sảnh
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $app->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $app->status === 'confirmed' ? '✓ Đã xác nhận' : 'Chờ xác nhận' }}
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
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
            <div class="px-6 py-4 bg-red-50 border-b border-red-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-3 h-3 rounded-full bg-red-600"></span>
                    <h3 class="font-extrabold text-red-900 text-base">⚠️ Quá Thời Gian Hẹn Mà Chưa Check-in ({{ $overdueList->count() }})</h3>
                </div>
                <span class="text-xs font-bold text-red-700 bg-red-100 px-3 py-1 rounded-full">Trễ hẹn > 15 phút</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($overdueList as $app)
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-red-50/30 transition">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-300">
                                    ⚠️ Quá thời gian hẹn
                                </span>
                                <span class="font-bold text-red-700">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                                <span class="text-xs text-red-500 font-semibold">
                                    ({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})
                                </span>
                            </div>
                            <p class="text-sm text-slate-700 mt-1.5">
                                Bệnh nhân: <strong>{{ $app->patient->full_name ?? 'N/A' }}</strong> ({{ $app->patient->phone ?? '' }})
                                • Bác sĩ: <strong>{{ $app->doctor->user->name ?? 'Chưa phân công' }}</strong>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">Dịch vụ: {{ $app->service->name ?? ($app->reason ?? 'Khám nha khoa') }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            @if($role === 'receptionist')
                                <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
                                        Check-in muộn
                                    </button>
                                </form>
                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                                    Đổi giờ / Hủy
                                </a>
                            @elseif($role === 'admin')
                                <a href="{{ route('admin.appointments.edit', $app->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                                    Xử lý lịch &rarr;
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $app->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $app->status === 'confirmed' ? '✓ Đã xác nhận' : 'Chưa xác nhận' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Không có lịch hẹn nào bị quá thời gian hẹn.</div>
                @endforelse
            </div>
        </div>

        <!-- 6. Cảnh báo Kho thuốc sắp hết (Dành riêng cho Admin) -->
        @if($role === 'admin' && $lowStockMedicines->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-rose-200 overflow-hidden">
                <div class="px-6 py-4 bg-rose-50 border-b border-rose-200 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-rose-600"></span>
                        <h3 class="font-extrabold text-rose-900 text-base">💊 Cảnh Báo Kho Thuốc Sắp Hết ({{ $lowStockMedicines->count() }})</h3>
                    </div>
                    <a href="{{ route('admin.medicines.index') }}" class="text-xs font-extrabold text-rose-700 hover:underline">Quản lý Kho thuốc &rarr;</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($lowStockMedicines as $med)
                        <div class="p-4 px-6 flex items-center justify-between gap-4 hover:bg-rose-50/20">
                            <div>
                                <p class="text-sm font-extrabold text-slate-900">{{ $med->name }}</p>
                                <p class="text-xs text-slate-500">Đơn vị: {{ $med->unit ?? 'Viên' }} • Giá bán: {{ number_format($med->price ?? 0, 0, ',', '.') }} đ</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700 border border-rose-200">
                                    Tồn kho: {{ $med->stock_quantity }} {{ $med->unit ?? '' }}
                                </span>
                                <a href="{{ route('admin.medicines.edit', $med->id) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl text-xs font-bold transition">
                                    Nhập thêm
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 7. Thông báo: Lịch khám sắp tới đã xác nhận -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-200 overflow-hidden">
            <div class="px-6 py-4 bg-blue-50 border-b border-blue-200 flex items-center justify-between">
                <h3 class="font-extrabold text-blue-900 text-base">✓ Lịch Khám Sắp Tới Đã Xác Nhận ({{ $confirmedList->count() }})</h3>
                <span class="text-xs font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">Đã duyệt lịch</span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($confirmedList as $app)
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-blue-50/20 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                    ✓ Phòng khám đã xác nhận
                                </span>
                                <span class="font-bold text-slate-800">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-700 mt-1.5">
                                Bệnh nhân: <strong>{{ $app->patient->full_name ?? 'N/A' }}</strong> ({{ $app->patient->phone ?? '---' }})
                                • Bác sĩ phụ trách: <strong>{{ $app->doctor->user->name ?? 'Phòng khám sắp xếp' }}</strong>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">Dịch vụ: {{ $app->service->name ?? 'Khám & Tư vấn' }}</p>
                        </div>
                        <div class="shrink-0">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
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
