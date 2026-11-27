<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        Trung tâm Điều hành &amp; Quản trị
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-[#0D7A68] border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hôm nay: {{ now()->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Giám sát doanh thu, lịch hẹn bác sĩ, yêu cầu tư vấn và hồ sơ bệnh nhân toàn phòng khám.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-2xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Phân lịch trực</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-2xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Báo cáo Doanh thu</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0D6E5E] hover:bg-[#09594C] text-white rounded-xl text-xs font-bold shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span>Cấu hình VietQR &amp; VAT</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-[#f6f9f8] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-2xs">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px]">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-2xs">
                    <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px]">!</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- 1. HÀNG 4 THẺ KPI CHÍNH -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- KPI 1: Doanh thu tháng -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-500">Doanh thu tháng {{ now()->format('m/Y') }}</span>
                        @if(!is_null($data['month_growth_pct'] ?? null))
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $data['month_growth_pct'] >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ $data['month_growth_pct'] >= 0 ? '+' : '' }}{{ $data['month_growth_pct'] }}%
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700">Thực thu</span>
                        @endif
                    </div>
                    <div class="mt-3 text-2xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                        {{ number_format($data['month_revenue'] ?? 0, 0, ',', '.') }} <span class="text-base font-bold text-slate-700">Đ</span>
                    </div>
                    <div class="mt-1.5 text-xs text-slate-500 tabular-nums">
                        Hôm nay: <strong class="text-slate-700 font-semibold">{{ number_format($data['today_revenue'] ?? 0, 0, ',', '.') }} đ</strong>
                    </div>
                </div>

                <!-- KPI 2: Lịch hẹn hôm nay -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-500">Lịch hẹn hôm nay</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 tabular-nums">{{ now()->format('d/m') }}</span>
                    </div>
                    <div class="mt-3 text-2xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                        {{ $data['today_appointments'] ?? 0 }} <span class="text-lg font-bold text-slate-700">ca khám</span>
                    </div>
                    <div class="mt-1.5 text-xs text-slate-500">
                        Chờ duyệt / kiểm tra: <strong class="text-slate-700 font-semibold">{{ $data['pending_appointments'] ?? 0 }} lịch</strong>
                    </div>
                </div>

                <!-- KPI 3: Bác sĩ & Bệnh nhân -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-500">Bác sĩ &amp; Bệnh nhân</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#0D6E5E]"></span>
                    </div>
                    <div class="mt-3 text-2xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                        {{ $data['total_doctors'] ?? 0 }} <span class="text-lg font-bold text-slate-700">Bác sĩ trực</span>
                    </div>
                    <div class="mt-1.5 text-xs text-slate-500">
                        Tổng hồ sơ: <strong class="text-slate-700 font-semibold">{{ $data['total_patients'] ?? 0 }} bệnh nhân</strong>
                    </div>
                </div>

                <!-- KPI 4: Tài chính & Dược phẩm -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-500">Tài chính &amp; Dược phẩm</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ ($data['unpaid_invoices'] > 0 || $data['low_stock_medicines'] > 0) ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                            {{ ($data['unpaid_invoices'] > 0 || $data['low_stock_medicines'] > 0) ? 'Cần chú ý' : 'Ổn định' }}
                        </span>
                    </div>
                    <div class="mt-3 text-2xl font-extrabold text-slate-900 tracking-tight tabular-nums">
                        {{ $data['unpaid_invoices'] ?? 0 }} <span class="text-lg font-bold text-slate-700">HĐ chờ thu</span>
                    </div>
                    <div class="mt-1.5 text-xs text-slate-500">
                        Thuốc sắp hết tồn: <strong class="text-rose-600 font-semibold">{{ $data['low_stock_medicines'] ?? 0 }} loại</strong>
                    </div>
                </div>
            </div>

            <!-- 2. PHÂN KHU QUẢN TRỊ CHUYÊN BIỆT (6 THẺ DỌC TRUY CẬP NHANH) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">Phân khu quản trị chuyên biệt</h3>
                    <span class="text-[11px] font-medium text-slate-400">Truy cập nhanh hệ thống DCMS Pro</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
                    <a href="{{ route('admin.staff.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Tài khoản Nhân sự</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Admin, Bác sĩ, Lễ tân</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.doctors.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Hồ sơ Bác sĩ</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Chuyên khoa &amp; Lịch</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.schedules.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Phân lịch trực</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Ca sáng / chiều / tối</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.services.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Bảng giá Dịch vụ</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Niêm yết giá tự động</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.medicines.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Kho Thuốc &amp; Giá</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Nhập kho &amp; Đơn giá</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.supplies.index') }}" class="group bg-white hover:border-[#0D6E5E]/40 rounded-2xl border border-slate-200/80 p-4 text-center shadow-2xs hover:shadow-sm transition flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800 group-hover:text-[#0D6E5E] transition">Vật tư tiêu hao</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Vật tư y tế nha khoa</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 3. BIỂU ĐỒ DOANH THU 7 NGÀY & GIÁM SÁT LỊCH HẸN -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                <!-- Trái (7/12): Biểu đồ đường cong doanh thu 7 ngày qua -->
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Biểu đồ doanh thu (7 ngày qua)</h3>
                            <p class="text-xs text-slate-500 mt-0.5 tabular-nums">
                                Đỉnh cao nhất: <strong class="text-slate-700">{{ number_format($peakRevenue ?? 0, 0, ',', '.') }} đ</strong> ({{ $peakDate ?? now()->format('d/m') }})
                            </p>
                        </div>
                        <a href="{{ route('admin.invoices.index') }}" class="text-xs font-bold text-[#0D6E5E] hover:underline whitespace-nowrap">
                            Đối soát Hóa đơn &rarr;
                        </a>
                    </div>
                    <div class="h-64 w-full">
                        <canvas id="adminRevenueSplineChart"></canvas>
                    </div>
                </div>

                <!-- Phải (5/12): Giám sát lịch hẹn -->
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Giám sát lịch hẹn</h3>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">{{ $upcomingAppointments->count() }} ca</span>
                        </div>
                        <a href="{{ route('admin.appointments.index') }}" class="text-xs font-bold text-[#0D6E5E] hover:underline">
                            Tất cả &rarr;
                        </a>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto max-h-[268px] pr-0.5">
                        @forelse($upcomingAppointments as $apt)
                            @php
                                $aptStatusMap = [
                                    'in_progress' => ['label' => '● Đang khám', 'cls' => 'bg-emerald-50 text-emerald-700 border-emerald-200/70'],
                                    'waiting' => ['label' => 'Chờ khám', 'cls' => 'bg-amber-50 text-amber-700 border-amber-200/70'],
                                    'confirmed' => ['label' => 'Đã xác nhận', 'cls' => 'bg-sky-50 text-sky-700 border-sky-200/70'],
                                    'pending' => ['label' => 'Lịch mới', 'cls' => 'bg-blue-50 text-blue-700 border-blue-200/70'],
                                ];
                                $st = $aptStatusMap[$apt->status] ?? ['label' => ucfirst($apt->status), 'cls' => 'bg-slate-100 text-slate-600 border-slate-200'];
                            @endphp
                            <div class="p-3.5 rounded-xl bg-slate-50/85 hover:bg-slate-100/70 border border-slate-200/60 transition space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[11px] font-bold text-slate-500 tabular-nums">
                                        {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i • d/m/Y') }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $st['cls'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                </div>
                                <div class="text-xs font-extrabold text-slate-900">
                                    {{ $apt->patient->name ?? 'Bệnh nhân' }}
                                </div>
                                <div class="text-[11px] text-slate-500 truncate">
                                    BS: {{ $apt->doctor->user->name ?? 'Chưa phân công' }} - {{ $apt->service->name ?? 'Khám tổng quát & Tư vấn' }}
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-xs text-slate-400">
                                Hiện không có lịch hẹn sắp tới nào.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 4. YÊU CẦU TƯ VẤN TỪ WEBSITE (LƯỚI 3 CỘT NGANG) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-slate-900">Yêu cầu tư vấn từ Website</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                            {{ $data['pending_inquiries'] ?? 0 }} chờ gọi
                        </span>
                    </div>
                    <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-[#0D6E5E] hover:underline">
                        Trung tâm Thông báo &rarr;
                    </a>
                </div>

                @if(($contactInquiries ?? collect())->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-xs text-slate-400 shadow-2xs">
                        Chưa có yêu cầu tư vấn / liên hệ nào từ khách hàng trên Website.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($contactInquiries->take(3) as $inq)
                            @php
                                $isPending = ($inq['status'] ?? 'pending') === 'pending';
                                $inqTime = !empty($inq['created_at']) ? \Carbon\Carbon::parse($inq['created_at'])->format('H:i') : '';
                            @endphp
                            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between gap-3">
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-extrabold text-slate-900 truncate">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                        @if($isPending)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/70 shrink-0">Chờ gọi</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70 shrink-0">Đã tư vấn</span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono">
                                        {{ $inq['phone'] ?? '---' }} @if($inqTime) • {{ $inqTime }} @endif
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                        {{ $inq['message'] ?? '' }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                                    @if($isPending)
                                        <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#0D6E5E] hover:bg-[#09594C] text-white text-[11px] font-bold transition">
                                                Đánh dấu đã gọi
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 text-[11px] font-semibold">
                                            Đã gọi
                                        </span>
                                    @endif

                                    <form action="{{ route('contact-inquiries.destroy', $inq['id']) }}" method="POST" onsubmit="return confirm('Xóa yêu cầu tư vấn này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1.5 text-[11px] font-semibold text-slate-500 hover:text-rose-600 transition">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 5. DANH SÁCH BỆNH NHÂN & HỒ SƠ Y KHOA -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Danh sách bệnh nhân &amp; Hồ sơ y khoa</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600">
                                {{ $data['total_patients'] ?? $patientsList->total() }} hồ sơ
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Quản lý thông tin hành chính, cảnh báo dị ứng, lịch sử điều trị và trạng thái hóa đơn.
                        </p>
                    </div>

                    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2">
                        <div class="relative">
                            <input
                                type="text"
                                name="patient_search"
                                value="{{ request('patient_search') }}"
                                placeholder="Tìm tên, SĐT, mã BN..."
                                class="pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs w-48 sm:w-56 focus:border-[#0D6E5E] focus:ring-[#0D6E5E]"
                            >
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>

                        <select name="invoice_status" onchange="this.form.submit()" class="rounded-xl border border-slate-200 text-xs py-2 pl-3 pr-7 text-slate-700 focus:border-[#0D6E5E] focus:ring-[#0D6E5E]">
                            <option value="">Tất cả trạng thái</option>
                            <option value="paid" @selected(request('invoice_status') === 'paid')>Đã thanh toán</option>
                            <option value="unpaid" @selected(request('invoice_status') === 'unpaid')>Chưa thanh toán</option>
                        </select>

                        <a href="{{ route('admin.patients.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#0D6E5E] hover:bg-[#09594C] text-white text-xs font-bold shadow-xs transition">
                            <span>+ Tiếp nhận BN</span>
                        </a>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr class="text-left text-[10.5px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-5">Bệnh nhân</th>
                                <th class="py-3 px-4">Liên hệ</th>
                                <th class="py-3 px-4">Tiền sử &amp; Cảnh báo</th>
                                <th class="py-3 px-4">Ca khám gần nhất</th>
                                <th class="py-3 px-4">Chi phí / Hóa đơn</th>
                                <th class="py-3 px-5 text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($patientsList as $pt)
                                @php
                                    $initial = mb_strtoupper(mb_substr(trim($pt->name ?? 'B'), 0, 1));
                                    $age = $pt->dob ? \Carbon\Carbon::parse($pt->dob)->age : null;
                                    $latestApt = $pt->appointments->first();
                                    $latestInv = $pt->invoices->first();
                                    $allergyRaw = trim((string) ($pt->allergy_history ?? ''));
                                    $allergyLower = mb_strtolower($allergyRaw);
                                    $hasRealAllergy = $allergyRaw !== '' && !in_array($allergyLower, ['không', 'khong', 'không có', 'không dị ứng', 'không ghi nhận', 'không có tiền sử dị ứng thuốc', 'none', 'no']);
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-emerald-50 text-[#0D6E5E] font-extrabold text-xs flex items-center justify-center border border-emerald-100 shrink-0">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ $pt->name }}</div>
                                                <div class="text-[11px] text-slate-400 font-mono">
                                                    {{ $pt->patient_code }} • {{ $pt->gender ?? '---' }}@if($age) ({{ $age }} tuổi)@endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 font-mono">{{ $pt->phone ?? '---' }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $pt->email ?? 'Chưa có email' }}</div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if($hasRealAllergy)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-200/80 text-[11px] font-bold">
                                                ⚠️ {{ \Illuminate\Support\Str::limit($allergyRaw, 28) }}
                                            </span>
                                        @else
                                            <div class="text-[11px] text-slate-400">Không có dị ứng</div>
                                        @endif
                                        <div class="text-[11px] text-slate-600 mt-0.5 truncate max-w-[190px]">
                                            {{ $pt->medical_history ?: 'Khỏe mạnh' }}
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if($latestApt)
                                            <div class="font-bold text-slate-800 truncate max-w-[210px]">
                                                {{ $latestApt->service->name ?? 'Khám tổng quát' }}
                                            </div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">
                                                BS. {{ $latestApt->doctor->user->name ?? 'Chưa phân công' }} • {{ \Carbon\Carbon::parse($latestApt->appointment_time)->format('d/m H:i') }}
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic">Chưa có ca khám</span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if($latestInv)
                                            <div class="font-extrabold text-slate-900 tabular-nums">
                                                {{ number_format($latestInv->final_amount, 0, ',', '.') }} đ
                                            </div>
                                            @if($latestInv->status === 'paid')
                                                <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">
                                                    ✓ Đã thanh toán
                                                </span>
                                            @elseif($latestInv->status === 'unpaid')
                                                <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold">
                                                    ⏳ Chưa thanh toán
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                                                    Đã hủy
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-slate-400">0 đ</span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.patients.show', $pt) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-[#0D6E5E] hover:bg-[#09594C] text-white font-bold text-[11px] transition shadow-2xs">
                                            Hồ sơ
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400 text-xs">
                                        Không tìm thấy hồ sơ bệnh nhân phù hợp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Phân trang -->
                <div class="px-5 py-3.5 bg-slate-50/60 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Hiển thị
                        <strong class="text-slate-800">{{ $patientsList->firstItem() ?? 0 }}–{{ $patientsList->lastItem() ?? 0 }}</strong>
                        trên tổng số
                        <strong class="text-slate-800">{{ $patientsList->total() }}</strong> hồ sơ bệnh nhân
                    </div>
                    <div>
                        {{ $patientsList->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('adminRevenueSplineChart');
            if (!ctx) return;

            const c2d = ctx.getContext('2d');
            const gradient = c2d.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(13, 110, 94, 0.24)');
            gradient.addColorStop(1, 'rgba(13, 110, 94, 0.01)');

            new Chart(c2d, {
                type: 'line',
                data: {
                    labels: @json($chartDates),
                    datasets: [{
                        label: 'Doanh thu thực thu (VNĐ)',
                        data: @json($chartRevenues),
                        borderColor: '#0D6E5E',
                        borderWidth: 2.5,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.42,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0D6E5E',
                        pointBorderWidth: 2.5,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#0D6E5E',
                        pointHoverBorderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: (context) => ' ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' đ'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: {
                                color: '#eef2f6',
                                tickLength: 0,
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: (v) => v === 0 ? '0 đ' : (v >= 1000000 ? (v / 1000000) + ' tr' : new Intl.NumberFormat('vi-VN').format(v))
                            }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { size: 11, weight: '600' }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
