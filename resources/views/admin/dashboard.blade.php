<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Trung tâm điều hành & Quản trị
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hôm nay: {{ now()->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Giám sát tài chính, nhân sự, phân lịch trực Bác sĩ, bảng giá dịch vụ, kho dược & cấu hình hệ thống</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.schedules.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Phân lịch trực Bác sĩ
                </a>
                <a href="{{ route('admin.reports.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Báo cáo Doanh thu
                </a>
                <a href="{{ route('admin.settings.index') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>⚙️ Cấu hình VietQR & VAT</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 4 Thẻ KPI Quản trị Cốt lõi (Stitch UI Dot Indicators) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Doanh thu tháng -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Doanh thu tháng {{ now()->format('m/Y') }}</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($data['month_revenue'] ?? 0, 0, ',', '.') }} đ</div>
                    <div class="mt-1 text-[11px] text-slate-400">Hôm nay: <strong class="text-emerald-700 font-bold">{{ number_format($data['today_revenue'], 0, ',', '.') }} đ</strong></div>
                </div>

                <!-- Điều phối Lịch hẹn -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Lịch khám hôm nay</span>
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $data['today_appointments'] }} <span class="text-xs font-normal text-slate-400">ca</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Chờ duyệt toàn viện: <strong class="text-amber-700 font-semibold">{{ $data['pending_appointments'] ?? 0 }} lịch</strong></div>
                </div>

                <!-- Quản trị Nhân sự & Bác sĩ -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Bác sĩ & Bệnh nhân</span>
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $data['total_doctors'] }} <span class="text-xs font-normal text-slate-400">Bác sĩ</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Tổng số hồ sơ: <strong class="text-slate-700">{{ $data['total_patients'] }} bệnh nhân</strong></div>
                </div>

                <!-- Kiểm soát Kho Dược & Hóa đơn -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Tài chính & Dược phẩm</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $data['unpaid_invoices'] ?? 0 }} <span class="text-xs font-normal text-slate-400">HĐ chờ thu</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Thuốc sắp hết kho: <strong class="text-red-700">{{ $data['low_stock_medicines'] ?? 0 }} loại</strong></div>
                </div>
            </div>

            <!-- Phân quyền & Bảng điều khiển nhanh của Admin -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Phân khu quản trị chuyên biệt</h3>
                    </div>
                    <span class="text-[11px] text-slate-400">Quản trị toàn hệ thống DCMS Pro</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('admin.staff.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">👥</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Tài khoản Nhân sự</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Admin, Bác sĩ, Lễ tân</div>
                    </a>
                    <a href="{{ route('admin.doctors.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">🩺</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Hồ sơ Bác sĩ</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Chuyên khoa & Lịch trực</div>
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">🕒</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Phân lịch trực</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Ca sáng / chiều / tối</div>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">🏷️</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Bảng giá Dịch vụ</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Niêm yết giá tự động</div>
                    </a>
                    <a href="{{ route('admin.medicines.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">💊</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Kho Thuốc & Giá</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Nhập kho & Đơn giá thuốc</div>
                    </a>
                    <a href="{{ route('admin.supplies.index') }}" class="p-3.5 rounded-xl bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/70 transition text-center group">
                        <div class="text-xl mb-1">🧰</div>
                        <div class="text-xs font-bold text-slate-900 group-hover:text-[#0D7A68]">Vật tư tiêu hao</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Vật tư y tế nha khoa</div>
                    </a>
                </div>
            </div>

            <!-- Biểu đồ & Lịch hẹn sắp tới -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Biểu đồ Doanh thu (Chart) -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Biểu đồ doanh thu (7 ngày qua)</h3>
                        </div>
                        <a href="{{ route('admin.invoices.index') }}" class="text-xs font-semibold text-[#0D7A68] hover:underline">Đối soát Hóa đơn &rarr;</a>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Lịch hẹn hôm nay & các ngày tới -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Giám sát lịch hẹn</h3>
                        </div>
                        <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-[#0D7A68] hover:underline">Tất cả &rarr;</a>
                    </div>
                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1 text-xs">
                        @forelse($upcomingAppointments as $app)
                            <div class="p-3 bg-slate-50/70 rounded-xl border border-slate-200/80 hover:border-slate-300 transition">
                                <div class="flex justify-between items-start gap-2 mb-1">
                                    <span class="font-bold text-slate-900 text-xs">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}</span>
                                    <div class="flex flex-wrap gap-1">
                                        @if($app->isOverdue())
                                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[10px] px-2 py-0.5 rounded-md">⚠️ Quá hạn</span>
                                        @elseif($app->isDueNow())
                                            <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md animate-pulse">🔔 Đến giờ</span>
                                        @endif
                                        <span class="bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded-md font-semibold">
                                            @if($app->status == 'pending') Chờ duyệt
                                            @elseif($app->status == 'confirmed') Đã xác nhận
                                            @elseif($app->status == 'waiting') Sảnh chờ
                                            @elseif($app->status == 'in_progress') Đang khám
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <p class="font-bold text-slate-900">{{ $app->patient->name ?? 'Không rõ' }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">BS: <span class="font-medium text-slate-700">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</span> • {{ $app->service->name ?? 'Khám tổng quát' }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-400 text-xs">
                                Không có lịch khám nào sắp tới.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- BẢNG QUẢN LÝ DANH SÁCH BỆNH NHÂN TRỰC TIẾP TRÊN BẢNG ĐIỀU KHIỂN -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden" x-data="{ searchPatient: '' }">
                <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                            <h3 class="text-sm font-bold text-slate-900">
                                Danh sách bệnh nhân & Hồ sơ y khoa
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                {{ $patientsList->count() }} hồ sơ
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Quản lý toàn bộ thông tin bệnh nhân, tiền sử bệnh và lịch sử khám nha khoa trực tiếp</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Ô tìm kiếm nhanh bệnh nhân -->
                        <div class="relative">
                            <input type="text" x-model="searchPatient" placeholder="Tìm tên, SĐT, mã BN..." 
                                   class="pl-3 pr-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] w-48 shadow-xs">
                        </div>

                        <!-- Nút Tự động nạp dữ liệu mẫu -->
                        <form action="{{ route('admin.seed-demo-data') }}" method="POST" onsubmit="return confirm('Bạn có muốn tự động nạp/làm mới danh sách bệnh nhân, bác sĩ và lịch sử khám mẫu?');">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5">
                                <span>⚡ Nạp dữ liệu mẫu</span>
                            </button>
                        </form>

                        <a href="{{ route('admin.patients.create') }}" class="px-3.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1">
                            <span>+ Tiếp nhận BN</span>
                        </a>
                        <a href="{{ route('admin.patients.index') }}" class="px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition">
                            Tất cả &rarr;
                        </a>
                    </div>
                </div>

                @if($patientsList->isEmpty())
                    <div class="p-12 text-center text-xs text-slate-400">
                        Chưa có dữ liệu bệnh nhân.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-xs">
                            <thead class="bg-slate-50/70 text-slate-400 uppercase font-bold tracking-wider text-[11px]">
                                <tr>
                                    <th class="px-4 py-2.5 text-left">Bệnh nhân</th>
                                    <th class="px-4 py-2.5 text-left">Liên hệ</th>
                                    <th class="px-4 py-2.5 text-left">Tiền sử bệnh & Cảnh báo</th>
                                    <th class="px-4 py-2.5 text-left">Ca khám gần nhất</th>
                                    <th class="px-4 py-2.5 text-left">Chi phí / Hóa đơn</th>
                                    <th class="px-4 py-2.5 text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($patientsList as $pat)
                                    @php
                                        $latestApp = $pat->appointments->sortByDesc('appointment_time')->first();
                                        $latestInvoice = $pat->invoices->sortByDesc('created_at')->first();
                                        $age = $pat->dob ? \Carbon\Carbon::parse($pat->dob)->age : null;
                                        $hasAllergy = !empty($pat->allergy_history) && !str_contains(mb_strtolower($pat->allergy_history), 'không');
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition"
                                        x-show="!searchPatient || '{{ strtolower($pat->name . ' ' . $pat->phone . ' ' . $pat->patient_code . ' ' . $pat->allergy_history) }}'.includes(searchPatient.toLowerCase())">
                                        <!-- Cột 1: Thông tin bệnh nhân -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-[#0D7A68]/10 text-[#0D7A68] font-bold flex items-center justify-center text-xs flex-shrink-0">
                                                    {{ mb_strtoupper(mb_substr($pat->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.patients.show', $pat->id) }}" class="font-bold text-xs text-slate-900 hover:text-[#0D7A68] transition">
                                                        {{ $pat->name }}
                                                    </a>
                                                    <div class="flex items-center gap-1.5 mt-0.5">
                                                        <span class="font-mono text-[10px] font-bold text-[#0D7A68] bg-[#0D7A68]/10 px-1.5 py-0.2 rounded">
                                                            {{ $pat->patient_code }}
                                                        </span>
                                                        <span class="text-slate-400">•</span>
                                                        <span class="text-slate-500 text-[11px]">
                                                            {{ $pat->gender ?? '---' }} {{ $age ? "({$age} tuổi)" : '' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Cột 2: Liên hệ -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            <div class="font-medium text-slate-800">
                                                <a href="tel:{{ $pat->phone }}" class="hover:underline font-mono">{{ $pat->phone ?? '---' }}</a>
                                            </div>
                                            <div class="text-[11px] text-slate-400 truncate max-w-[160px] mt-0.5">
                                                {{ $pat->email ?? ($pat->job ?? '---') }}
                                            </div>
                                        </td>

                                        <!-- Cột 3: Tiền sử & Dị ứng -->
                                        <td class="px-4 py-3.5">
                                            <div class="space-y-1 max-w-[200px]">
                                                @if($hasAllergy)
                                                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#FEE2E2] text-[#991B1B]">
                                                        <span>⚠️</span> {{ $pat->allergy_history }}
                                                    </div>
                                                @else
                                                    <span class="text-[11px] text-slate-400">Không có dị ứng</span>
                                                @endif

                                                @if(!empty($pat->medical_history) && !str_contains(mb_strtolower($pat->medical_history), 'không') && !str_contains(mb_strtolower($pat->medical_history), 'bình thường'))
                                                    <div class="text-[11px] text-amber-800 font-medium truncate">
                                                        🩺 {{ $pat->medical_history }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Cột 4: Ca khám gần nhất -->
                                        <td class="px-4 py-3.5">
                                            @if($latestApp)
                                                <div class="max-w-[200px]">
                                                    <div class="font-bold text-slate-800 text-[11px] truncate">
                                                        {{ $latestApp->service->name ?? 'Khám tổng quát' }}
                                                    </div>
                                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                                        BS: {{ $latestApp->doctor->user->name ?? 'Bác sĩ' }} • {{ \Carbon\Carbon::parse($latestApp->appointment_time)->format('d/m H:i') }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs italic">Chưa có lịch hẹn</span>
                                            @endif
                                        </td>

                                        <!-- Cột 5: Chi phí & Hóa đơn -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            @if($latestInvoice)
                                                <div class="font-bold text-slate-900 font-mono text-xs">
                                                    {{ number_format($latestInvoice->final_amount) }} đ
                                                </div>
                                                <div class="mt-1">
                                                    @if($latestInvoice->status === 'paid')
                                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                                            ✓ Đã thanh toán
                                                        </span>
                                                    @else
                                                        <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[10px] px-2 py-0.5 rounded-md">
                                                            ⏳ Chưa thanh toán
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs">--</span>
                                            @endif
                                        </td>

                                        <!-- Cột 6: Thao tác -->
                                        <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1">
                                            <a href="{{ route('admin.patients.show', $pat->id) }}" 
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs transition shadow-xs">
                                                Hồ sơ
                                            </a>
                                            <a href="{{ route('admin.patients.edit', $pat->id) }}" 
                                               class="inline-flex items-center px-2 py-1.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs transition">
                                                Sửa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Yêu cầu Tư vấn / Liên hệ từ Website -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Yêu cầu tư vấn từ Website</h3>
                        @if(($data['pending_inquiries'] ?? 0) > 0)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FFFBEB] text-[#B45309]">{{ $data['pending_inquiries'] }} chờ gọi</span>
                        @endif
                    </div>
                    <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-[#0D7A68] hover:underline">Xem tại Trung tâm Thông báo &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($contactInquiries ?? [] as $inq)
                        <div class="p-4 px-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/70 transition">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-bold text-slate-900 text-xs">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                    <span class="font-mono font-medium text-slate-700">📞 {{ $inq['phone'] ?? '---' }}</span>
                                    @if(($inq['status'] ?? 'pending') === 'pending')
                                        <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[10px] px-2 py-0.5 rounded-md">⏳ Chờ gọi</span>
                                    @else
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2 py-0.5 rounded-md">✓ Đã tư vấn ({{ $inq['resolved_by'] ?? 'Lễ tân' }})</span>
                                    @endif
                                    <span class="text-slate-400">• {{ $inq['created_at'] ?? '' }}</span>
                                </div>
                                <p class="text-slate-500">{{ $inq['message'] ?? '' }}</p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if(($inq['status'] ?? 'pending') === 'pending')
                                    <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold transition">
                                            ✓ Đánh dấu đã gọi
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('contact-inquiries.destroy', $inq['id']) }}" method="POST" onsubmit="return confirm('Xóa yêu cầu liên hệ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl text-xs font-semibold transition">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Chưa có yêu cầu tư vấn / liên hệ nào từ khách hàng trên Website.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const labels = {!! json_encode($chartDates) !!};
            const data = {!! json_encode($chartRevenues) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: data,
                        borderColor: '#0D7A68',
                        backgroundColor: 'rgba(13, 122, 104, 0.08)',
                        borderWidth: 2,
                        pointBackgroundColor: '#0D7A68',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#0D7A68',
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' đ';
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000) + ' Tr';
                                    if (value >= 1000) return (value / 1000) + ' k';
                                    return value;
                                }
                            },
                            grid: { borderDash: [2, 4], color: '#f1f5f9' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
