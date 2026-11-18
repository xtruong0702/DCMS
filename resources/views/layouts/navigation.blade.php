<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 shadow-xs">
    <!-- Top Accent Gradient Strip -->
    <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500"></div>

    @php
        $role = auth()->check() ? strtolower(auth()->user()->role->name ?? '') : '';
        $roleBadge = match($role) {
            'admin' => ['label' => 'Quản trị viên', 'dot' => 'bg-purple-500', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
            'doctor' => ['label' => 'Bác sĩ điều trị', 'dot' => 'bg-blue-500', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
            'receptionist' => ['label' => 'Lễ tân & Thu ngân', 'dot' => 'bg-emerald-500', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            default => ['label' => 'Thành viên', 'dot' => 'bg-slate-400', 'class' => 'bg-slate-100 text-slate-700 border-slate-200'],
        };

        $todayAlertsCount = 0;
        $waitingQueueCount = 0;
        $pendingAppsCount = 0;
        $dueOrOverdueCount = 0;
        $unpaidInvoicesCount = 0;
        $lowStockCount = 0;

        if (auth()->check()) {
            try {
                $appQuery = \App\Models\Appointment::whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress']);
                if ($role === 'doctor') {
                    $docId = auth()->user()->doctor->id ?? 0;
                    $appQuery->where(function ($q) use ($docId) {
                        $q->where('doctor_id', $docId)->orWhereNull('doctor_id');
                    });
                } elseif ($role === 'patient') {
                    $patId = auth()->user()->patient->id ?? 0;
                    $appQuery->where('patient_id', $patId);
                }

                $activeApps = $appQuery->get();
                $waitingQueueCount = $activeApps->where('status', 'waiting')->count();
                $pendingAppsCount = $activeApps->where('status', 'pending')->count();
                $dueOrOverdueCount = $activeApps->filter(function ($a) {
                    return $a->isDueNow() || ($a->isOverdue() && \Carbon\Carbon::parse($a->appointment_time)->gte(now()->subDays(7)));
                })->count();

                $pendingInquiriesNavCount = 0;
                if ($role === 'receptionist' || $role === 'admin') {
                    $unpaidInvoicesCount = \App\Models\Invoice::where('status', 'unpaid')->count();
                    $pendingInquiriesNavCount = \App\Support\ContactInquiryStore::pending()->count();
                }
                if ($role === 'admin' && \Illuminate\Support\Facades\Schema::hasTable('medicines')) {
                    $lowStockCount = \App\Models\Medicine::where('stock_quantity', '<=', 20)->count();
                }

                $todayAlertsCount = $waitingQueueCount + $pendingAppsCount + $dueOrOverdueCount + $unpaidInvoicesCount + $lowStockCount + $pendingInquiriesNavCount;
            } catch (\Throwable $e) {
                // Ignore if tables not migrated
            }
        }
    @endphp

    <!-- Primary Taskbar Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-2">
            <!-- Left: Brand + Primary Navigation -->
            <div class="flex items-center gap-3 lg:gap-4 shrink-0">
                <!-- Logo Nha Khoa Smile -->
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center gap-2.5 group focus:outline-none pr-2 border-r border-slate-200" title="Bảng điều khiển Nha Khoa Smile">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col whitespace-nowrap">
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-sm lg:text-base leading-none tracking-tight text-slate-900">Nha Khoa <span class="text-indigo-600">Smile</span></span>
                            <span class="hidden xl:inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-extrabold uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-200">DCMS</span>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400 mt-1 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full {{ $roleBadge['dot'] }}"></span>
                            {{ $roleBadge['label'] }}
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Pills -->
                <div class="hidden md:flex items-center gap-1 shrink-0">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('doctor.dashboard') || request()->routeIs('receptionist.dashboard')">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Tổng quan</span>
                    </x-nav-link>

                    @auth
                        @if($role === 'admin')
                            @php
                                $isUsersActive = request()->routeIs('admin.patients.*') || request()->routeIs('admin.doctors.*') || request()->routeIs('admin.staff.*');
                                $isScheduleActive = request()->routeIs('admin.appointments.*') || request()->routeIs('admin.schedules.*');
                                $isServiceActive = request()->routeIs('admin.specialties.*') || request()->routeIs('admin.service-categories.*') || request()->routeIs('admin.services.*');
                                $isInventoryActive = request()->routeIs('admin.medicines.*') || request()->routeIs('admin.supplies.*') || request()->routeIs('admin.invoices.*');
                            @endphp

                            <!-- Dropdown 1: Nhân sự & Bệnh nhân -->
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 transition duration-150 ease-in-out whitespace-nowrap shrink-0 {{ $isUsersActive ? 'text-indigo-700 bg-indigo-50 border border-indigo-200 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Nhân sự & BN</span>
                                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Quản lý con người</div>
                                    <x-dropdown-link :href="route('admin.patients.index')">
                                        <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">👥</span>
                                        <span>Hồ sơ Bệnh nhân</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.doctors.index')">
                                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs shrink-0">🩺</span>
                                        <span>Đội ngũ Bác sĩ</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.staff.index')">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">💼</span>
                                        <span>Nhân viên & Lễ tân</span>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <!-- Dropdown 2: Lịch & Ca trực -->
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 transition duration-150 ease-in-out whitespace-nowrap shrink-0 {{ $isScheduleActive ? 'text-indigo-700 bg-indigo-50 border border-indigo-200 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Lịch & Ca trực</span>
                                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Điều phối lịch khám</div>
                                    <x-dropdown-link :href="route('admin.appointments.index')">
                                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs shrink-0">📅</span>
                                        <span>Danh sách Lịch hẹn</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.schedules.index')">
                                        <span class="w-6 h-6 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center text-xs shrink-0">🕒</span>
                                        <span>Phân lịch trực Bác sĩ</span>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <!-- Dropdown 3: Dịch vụ -->
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 transition duration-150 ease-in-out whitespace-nowrap shrink-0 {{ $isServiceActive ? 'text-indigo-700 bg-indigo-50 border border-indigo-200 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                        <span>Dịch vụ</span>
                                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Danh mục chuyên môn</div>
                                    <x-dropdown-link :href="route('admin.specialties.index')">
                                        <span class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs shrink-0">🏥</span>
                                        <span>Chuyên khoa nha</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.service-categories.index')">
                                        <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">📂</span>
                                        <span>Nhóm dịch vụ</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.services.index')">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">🏷️</span>
                                        <span>Bảng giá dịch vụ</span>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <!-- Dropdown 4: Kho & Hóa đơn -->
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 transition duration-150 ease-in-out whitespace-nowrap shrink-0 {{ $isInventoryActive ? 'text-indigo-700 bg-indigo-50 border border-indigo-200 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent' }}">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <span>Kho & Hóa đơn</span>
                                        @if($unpaidInvoicesCount > 0)
                                            <span class="px-1.5 py-0.5 bg-amber-100 text-amber-800 rounded-full text-[10px] font-extrabold leading-none">{{ $unpaidInvoicesCount }}</span>
                                        @endif
                                        <svg class="w-3.5 h-3.5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Dược & Tài chính</div>
                                    <x-dropdown-link :href="route('admin.medicines.index')">
                                        <span class="w-6 h-6 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs shrink-0">💊</span>
                                        <span>Kho Thuốc</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.supplies.index')">
                                        <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs shrink-0">🧰</span>
                                        <span>Vật tư tiêu hao</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.invoices.index')">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">🧾</span>
                                        <div class="flex items-center justify-between w-full">
                                            <span>Quản lý Hóa đơn</span>
                                            @if($unpaidInvoicesCount > 0)
                                                <span class="px-1.5 py-0.5 bg-amber-100 text-amber-800 rounded-md text-[10px] font-extrabold">{{ $unpaidInvoicesCount }} chờ thu</span>
                                            @endif
                                        </div>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <span>Báo cáo</span>
                            </x-nav-link>

                            <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Cấu hình</span>
                            </x-nav-link>

                        @elseif($role === 'doctor')
                            <x-nav-link :href="route('doctor.queue.index')" :active="request()->routeIs('doctor.queue.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Hàng đợi khám</span>
                                @if($waitingQueueCount > 0)
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 leading-none">{{ $waitingQueueCount }}</span>
                                @endif
                            </x-nav-link>

                            <x-nav-link :href="route('doctor.consultations.index')" :active="request()->routeIs('doctor.consultations.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                <span>Khám & Điều trị</span>
                            </x-nav-link>

                            <x-nav-link :href="route('doctor.prescriptions.index')" :active="request()->routeIs('doctor.prescriptions.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Đơn thuốc</span>
                            </x-nav-link>

                            <x-nav-link :href="route('doctor.patient-history.index')" :active="request()->routeIs('doctor.patient-history.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span>Tra cứu Y bạ</span>
                            </x-nav-link>

                            <x-nav-link :href="route('doctor.material-usage.index')" :active="request()->routeIs('doctor.material-usage.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                <span>Vật tư tiêu hao</span>
                            </x-nav-link>

                        @elseif($role === 'receptionist')
                            <x-nav-link :href="route('receptionist.queue.index')" :active="request()->routeIs('receptionist.queue.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Danh sách chờ</span>
                                @if($waitingQueueCount > 0)
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300 leading-none">{{ $waitingQueueCount }}</span>
                                @endif
                            </x-nav-link>

                            <x-nav-link :href="route('receptionist.appointments.index')" :active="request()->routeIs('receptionist.appointments.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Lịch hẹn</span>
                            </x-nav-link>

                            <x-nav-link :href="route('receptionist.patients.index')" :active="request()->routeIs('receptionist.patients.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Bệnh nhân</span>
                            </x-nav-link>

                            <x-nav-link :href="route('receptionist.invoices.index')" :active="request()->routeIs('receptionist.invoices.*')">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                                <span>Hóa đơn & VietQR</span>
                                @if($unpaidInvoicesCount > 0)
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 leading-none">{{ $unpaidInvoicesCount }}</span>
                                @endif
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right: Notifications + User Menu (Never shrinks or wraps) -->
            <div class="hidden sm:flex items-center gap-2 shrink-0">
                @auth
                    <!-- Nút mở trang chủ công khai (Icon gọn gàng, không xuống dòng) -->
                    <a href="{{ route('home') }}" target="_blank" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl border border-transparent hover:border-indigo-100 transition shrink-0" title="Mở trang chủ công khai (Tab mới)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </a>

                    <!-- Chuông thông báo có Dropdown xem nhanh & badge đếm chính xác -->
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button type="button" class="relative p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl border border-transparent hover:border-indigo-100 transition shrink-0 focus:outline-none" title="Trung tâm Thông báo & Nhắc việc">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @if($todayAlertsCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-600 px-1 text-[10px] font-extrabold text-white shadow-xs animate-pulse">
                                        {{ $todayAlertsCount > 99 ? '99+' : $todayAlertsCount }}
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-extrabold text-slate-900">🔔 Thông Báo Hệ Thống</span>
                                @if($todayAlertsCount > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700">{{ $todayAlertsCount }} cần xử lý</span>
                                @else
                                    <span class="text-[10px] font-semibold text-slate-400">Không có việc tồn đọng</span>
                                @endif
                            </div>

                            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                                @if($waitingQueueCount > 0)
                                    <a href="{{ $role === 'doctor' ? route('doctor.queue.index') : ($role === 'receptionist' ? route('receptionist.queue.index') : route('notifications.index')) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-orange-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center text-sm shrink-0">🪑</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $waitingQueueCount }} bệnh nhân đang chờ tại sảnh</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Đã Check-in, sẵn sàng gọi vào phòng khám</div>
                                        </div>
                                    </a>
                                @endif

                                @if($pendingAppsCount > 0)
                                    <a href="{{ $role === 'receptionist' ? route('receptionist.appointments.index') : ($role === 'admin' ? route('admin.appointments.index') : route('notifications.index')) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-indigo-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm shrink-0">⏳</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $pendingAppsCount }} lịch hẹn mới chờ xác nhận</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Khách vừa đặt lịch, cần gọi xác nhận & phân công BS</div>
                                        </div>
                                    </a>
                                @endif

                                @if($unpaidInvoicesCount > 0 && in_array($role, ['receptionist', 'admin']))
                                    <a href="{{ $role === 'receptionist' ? route('receptionist.invoices.index') : route('admin.invoices.index') }}" class="flex items-start gap-3 px-4 py-3 hover:bg-emerald-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm shrink-0">🧾</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $unpaidInvoicesCount }} hóa đơn & đơn thuốc chờ thu</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Bác sĩ đã kê đơn, chờ thu ngân & phát thuốc</div>
                                        </div>
                                    </a>
                                @endif

                                @if($dueOrOverdueCount > 0)
                                    <a href="{{ route('notifications.index') }}" class="flex items-start gap-3 px-4 py-3 hover:bg-amber-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm shrink-0">⏰</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $dueOrOverdueCount }} lịch hẹn đến giờ / quá giờ</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Cần hỗ trợ khách Check-in hoặc liên hệ xác nhận</div>
                                        </div>
                                    </a>
                                @endif

                                @if(($pendingInquiriesNavCount ?? 0) > 0 && in_array($role, ['receptionist', 'admin']))
                                    <a href="{{ route('notifications.index') }}" class="flex items-start gap-3 px-4 py-3 hover:bg-cyan-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-sm shrink-0">📩</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $pendingInquiriesNavCount }} yêu cầu tư vấn từ Website</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Khách để lại SĐT & câu hỏi, chờ gọi tư vấn</div>
                                        </div>
                                    </a>
                                @endif

                                @if($lowStockCount > 0 && $role === 'admin')
                                    <a href="{{ route('admin.medicines.index') }}" class="flex items-start gap-3 px-4 py-3 hover:bg-rose-50/60 transition">
                                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-sm shrink-0">💊</span>
                                        <div class="text-xs">
                                            <div class="font-extrabold text-slate-900">{{ $lowStockCount }} loại thuốc sắp hết tồn kho</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">Tồn kho ≤ 20 đơn vị, cần nhập bổ sung</div>
                                        </div>
                                    </a>
                                @endif

                                @if($todayAlertsCount === 0)
                                    <div class="px-4 py-6 text-center text-xs text-slate-400">
                                        Hiện tại không có thông báo mới cần xử lý.
                                    </div>
                                @endif
                            </div>

                            <div class="p-2 bg-slate-50 border-t border-slate-100">
                                <a href="{{ route('notifications.index') }}" class="block w-full text-center py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-extrabold transition">
                                    Mở Trung Tâm Thông Báo Đầy Đủ &rarr;
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endauth

                <!-- User Profile Pill Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center gap-2 pl-2 pr-2.5 py-1.5 border border-slate-200 text-xs font-bold rounded-xl text-slate-700 bg-slate-50 hover:bg-white hover:border-indigo-300 focus:outline-none transition duration-150 ease-in-out whitespace-nowrap shrink-0">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-600 to-blue-500 text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                                {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-left hidden xl:block whitespace-nowrap">
                                <div class="text-xs font-extrabold text-slate-800 leading-none truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] font-semibold text-slate-500 mt-0.5 leading-none">{{ $roleBadge['label'] }}</div>
                            </div>
                            <svg class="h-3.5 w-3.5 text-slate-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-xs font-extrabold text-slate-900 truncate">{{ Auth::user()->name }}</span>
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full border {{ $roleBadge['class'] }}">
                                    {{ $roleBadge['label'] }}
                                </span>
                            </div>
                            <p class="text-[11px] font-medium text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs shrink-0">👤</span>
                                <span>Hồ sơ & Bảo mật tài khoản</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('notifications.index')">
                                <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs shrink-0">🔔</span>
                                <div class="flex items-center justify-between w-full">
                                    <span>Thông báo hệ thống</span>
                                    @if($todayAlertsCount > 0)
                                        <span class="px-1.5 py-0.5 bg-red-100 text-red-700 rounded-md text-[10px] font-extrabold">{{ $todayAlertsCount }} mới</span>
                                    @endif
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('home')">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">🌐</span>
                                <span>Xem Trang chủ Phòng khám</span>
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-slate-100 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="text-red-600 hover:bg-red-50 hover:text-red-700 font-bold"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span class="w-6 h-6 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-xs shrink-0">🚪</span>
                                    <span>Đăng xuất khỏi hệ thống</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center gap-2 md:hidden">
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-600 hover:text-indigo-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($todayAlertsCount > 0)
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-600 rounded-full"></span>
                    @endif
                </a>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-slate-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                📊 Tổng quan
            </x-responsive-nav-link>

            @auth
                @if($role === 'admin')
                    <div class="px-4 pt-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Nhân sự & Bệnh nhân</div>
                    <x-responsive-nav-link :href="route('admin.patients.index')" :active="request()->routeIs('admin.patients.*')">👥 Hồ sơ Bệnh nhân</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.doctors.index')" :active="request()->routeIs('admin.doctors.*')">🩺 Đội ngũ Bác sĩ</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">💼 Nhân sự khác</x-responsive-nav-link>

                    <div class="px-4 pt-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Lịch & Ca trực</div>
                    <x-responsive-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">📅 Quản lý Lịch hẹn</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.*')">🕒 Phân lịch trực</x-responsive-nav-link>

                    <div class="px-4 pt-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Dịch vụ & Kho</div>
                    <x-responsive-nav-link :href="route('admin.specialties.index')" :active="request()->routeIs('admin.specialties.*')">🏥 Chuyên khoa</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.service-categories.index')" :active="request()->routeIs('admin.service-categories.*')">📂 Danh mục DV</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services.*')">🏷️ Giá dịch vụ</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.medicines.index')" :active="request()->routeIs('admin.medicines.*')">💊 Kho Thuốc</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.supplies.index')" :active="request()->routeIs('admin.supplies.*')">🧰 Vật tư</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.invoices.index')" :active="request()->routeIs('admin.invoices.*')">🧾 Hóa đơn</x-responsive-nav-link>

                    <div class="px-4 pt-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Hệ thống</div>
                    <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">📈 Báo cáo thống kê</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">⚙️ Cấu hình & VietQR</x-responsive-nav-link>
                @elseif($role === 'doctor')
                    <x-responsive-nav-link :href="route('doctor.queue.index')" :active="request()->routeIs('doctor.queue.*')">⏳ Hàng đợi khám ({{ $waitingQueueCount }})</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('doctor.consultations.index')" :active="request()->routeIs('doctor.consultations.*')">🩺 Khám & Điều trị</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('doctor.prescriptions.index')" :active="request()->routeIs('doctor.prescriptions.*')">💊 Đơn thuốc đã kê</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('doctor.patient-history.index')" :active="request()->routeIs('doctor.patient-history.*')">📋 Lịch sử Y bạ</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('doctor.material-usage.index')" :active="request()->routeIs('doctor.material-usage.*')">🧪 Vật tư tiêu hao</x-responsive-nav-link>
                @elseif($role === 'receptionist')
                    <x-responsive-nav-link :href="route('receptionist.queue.index')" :active="request()->routeIs('receptionist.queue.*')">🪑 Danh sách chờ ({{ $waitingQueueCount }})</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('receptionist.appointments.index')" :active="request()->routeIs('receptionist.appointments.*')">📅 Lịch hẹn</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('receptionist.patients.index')" :active="request()->routeIs('receptionist.patients.*')">👥 Hồ sơ Bệnh nhân</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('receptionist.invoices.index')" :active="request()->routeIs('receptionist.invoices.*')">🧾 Hóa đơn & VietQR ({{ $unpaidInvoicesCount }})</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-200 bg-slate-50">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-bold text-sm text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
                <span class="px-2.5 py-0.5 text-[10px] font-extrabold rounded-full border {{ $roleBadge['class'] }}">
                    {{ $roleBadge['label'] }}
                </span>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 Hồ sơ cá nhân
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('notifications.index')">
                    🔔 Thông báo hệ thống ({{ $todayAlertsCount }})
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home')">
                    🌐 Về trang chủ công khai
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-red-600 font-bold"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        🚪 Đăng xuất
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
