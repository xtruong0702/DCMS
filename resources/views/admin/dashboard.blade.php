<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">🛡️ Trung Tâm Điều Hành & Quản Trị Phòng Khám (Admin)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Giám sát tài chính, nhân sự, phân lịch trực Bác sĩ, bảng giá dịch vụ, kho dược & cấu hình hệ thống ({{ now()->format('d/m/Y') }})</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.schedules.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition">
                    🕒 Phân lịch trực Bác sĩ
                </a>
                <a href="{{ route('admin.reports.index') }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                    📈 Báo cáo Doanh thu
                </a>
                <a href="{{ route('admin.settings.index') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                    ⚙️ Cấu hình VietQR & VAT
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- 4 Thẻ KPI Quản trị Cốt lõi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Doanh thu tháng -->
                <div class="bg-white rounded-2xl shadow-sm border border-emerald-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Doanh thu tháng {{ now()->format('m/Y') }}</p>
                        <p class="text-2xl font-extrabold text-emerald-700 mt-1">{{ number_format($data['month_revenue'] ?? 0, 0, ',', '.') }} đ</p>
                        <p class="text-[11px] text-slate-500 mt-1">Hôm nay: <strong class="text-emerald-600">{{ number_format($data['today_revenue'], 0, ',', '.') }} đ</strong></p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 text-xl">
                        💰
                    </div>
                </div>

                <!-- Điều phối Lịch hẹn -->
                <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Lịch khám hôm nay</p>
                        <p class="text-2xl font-extrabold text-blue-700 mt-1">{{ $data['today_appointments'] }} <span class="text-xs font-semibold text-slate-400">ca</span></p>
                        <p class="text-[11px] text-amber-600 font-bold mt-1">Chờ duyệt toàn hệ thống: {{ $data['pending_appointments'] ?? 0 }} lịch</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 text-xl">
                        📅
                    </div>
                </div>

                <!-- Quản trị Nhân sự & Bác sĩ -->
                <div class="bg-white rounded-2xl shadow-sm border border-purple-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Đội ngũ Bác sĩ & Hồ sơ BN</p>
                        <p class="text-2xl font-extrabold text-purple-700 mt-1">{{ $data['total_doctors'] }} <span class="text-xs font-semibold text-slate-400">Bác sĩ</span></p>
                        <p class="text-[11px] text-slate-500 mt-1">Tổng bệnh nhân: <strong>{{ $data['total_patients'] }} hồ sơ</strong></p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 text-xl">
                        👨‍⚕️
                    </div>
                </div>

                <!-- Kiểm soát Kho Dược & Hóa đơn -->
                <div class="bg-white rounded-2xl shadow-sm border border-amber-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tài chính & Kho Dược</p>
                        <p class="text-2xl font-extrabold text-amber-700 mt-1">{{ $data['unpaid_invoices'] ?? 0 }} <span class="text-xs font-semibold text-slate-400">HĐ chờ thu</span></p>
                        <p class="text-[11px] text-rose-600 font-bold mt-1">Thuốc sắp hết kho: {{ $data['low_stock_medicines'] ?? 0 }} loại</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 text-xl">
                        💊
                    </div>
                </div>
            </div>

            <!-- Phân quyền & Bảng điều khiển nhanh của Admin -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 mb-5 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-800">⚡ Phân Khu Quản Trị Chuyên Biệt Của Admin</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Admin quản lý nhân sự, phân ca trực, bảng giá niêm yết, kho thuốc/vật tư và báo cáo tài chính (không làm thay việc khám lâm sàng của Bác sĩ hay thu ngân trực tiếp của Lễ tân).</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('admin.staff.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">👥</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Tài khoản Nhân sự</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Admin, Bác sĩ, Lễ tân</div>
                    </a>
                    <a href="{{ route('admin.doctors.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">🩺</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Hồ sơ Bác sĩ</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Chuyên khoa & Kinh nghiệm</div>
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">🕒</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Phân lịch trực</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Ca sáng / chiều / tối</div>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">🏷️</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Bảng giá Dịch vụ</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Niêm yết giá tự động</div>
                    </a>
                    <a href="{{ route('admin.medicines.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">💊</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Kho Thuốc & Giá</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Nhập kho & Đơn giá thuốc</div>
                    </a>
                    <a href="{{ route('admin.supplies.index') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50 border border-slate-200/80 hover:border-indigo-200 transition text-center group">
                        <div class="text-xl mb-1">🧰</div>
                        <div class="text-xs font-extrabold text-slate-800 group-hover:text-indigo-700">Vật tư tiêu hao</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Găng tay, kim tiêm, sứ...</div>
                    </a>
                </div>
            </div>

            <!-- Biểu đồ & Lịch hẹn sắp tới -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Biểu đồ Doanh thu (Chart) -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
                        <h3 class="text-base font-extrabold text-slate-800">📈 Biểu Đồ Doanh Thu (7 Ngày Qua)</h3>
                        <a href="{{ route('admin.invoices.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Đối soát Hóa đơn &rarr;</a>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Lịch hẹn hôm nay & các ngày tới -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
                        <h3 class="text-base font-extrabold text-slate-800">📅 Giám Sát Lịch Hẹn Sắp Tới</h3>
                        <a href="{{ route('admin.appointments.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Tất cả &rarr;</a>
                    </div>
                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                        @forelse($upcomingAppointments as $app)
                            <div class="p-3.5 bg-slate-50 rounded-xl border border-gray-200 hover:border-indigo-200 transition">
                                <div class="flex justify-between items-start gap-2 mb-1">
                                    <span class="font-extrabold text-indigo-700 text-xs">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}</span>
                                    <div class="flex flex-wrap gap-1">
                                        @if($app->isOverdue())
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-extrabold border border-red-300">⚠️ Quá hạn</span>
                                        @elseif($app->isDueNow())
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-extrabold border border-amber-300 animate-pulse">🔔 Đến giờ</span>
                                        @endif
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-bold">
                                            @if($app->status == 'pending') Chờ xác nhận
                                            @elseif($app->status == 'confirmed') ✓ Đã xác nhận
                                            @elseif($app->status == 'waiting') Đang đợi
                                            @elseif($app->status == 'in_progress') Đang khám
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm font-bold text-slate-900">{{ $app->patient->name ?? 'Không rõ' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">BS: <span class="font-semibold text-slate-700">{{ $app->doctor->user->name ?? 'Chưa phân công' }}</span> • {{ $app->service->name ?? 'Khám tổng quát' }}</p>
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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ searchPatient: '' }">
                <div class="p-5 sm:p-6 bg-slate-50/80 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                                <span>👥</span> Danh Sách Bệnh Nhân & Hồ Sơ Y Khoa
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-indigo-100 text-indigo-700">
                                {{ $patientsList->count() }} hồ sơ
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Quản lý toàn bộ thông tin bệnh nhân, tiền sử bệnh, dị ứng thuốc và lịch sử khám nha khoa trực tiếp tại bảng điều khiển</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <!-- Ô tìm kiếm nhanh bệnh nhân -->
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" x-model="searchPatient" placeholder="Tìm tên, SĐT, mã BN..." 
                                   class="pl-9 pr-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-48 sm:w-56 shadow-2xs">
                        </div>

                        <!-- Nút Tự động nạp dữ liệu mẫu -->
                        <form action="{{ route('admin.seed-demo-data') }}" method="POST" onsubmit="return confirm('Bạn có muốn tự động nạp/làm mới danh sách bệnh nhân, bác sĩ và lịch sử khám mẫu?');">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                                <span>⚡</span> Tự động nạp dữ liệu mẫu
                            </button>
                        </form>

                        <a href="{{ route('admin.patients.create') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1">
                            <span>➕</span> Tiếp nhận BN
                        </a>
                        <a href="{{ route('admin.patients.index') }}" class="px-3 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition">
                            Tất cả &rarr;
                        </a>
                    </div>
                </div>

                @if($patientsList->isEmpty())
                    <!-- Trạng thái trống: Cho phép bấm 1 click để tự nạp bệnh nhân -->
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                            👥
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800 mb-1">Chưa có danh sách bệnh nhân</h4>
                        <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">Hệ thống đang trống dữ liệu bệnh nhân. Bạn có thể bấm nút bên dưới để hệ thống tự động nạp danh sách 6 bệnh nhân thực tế cùng hồ sơ bệnh án mẫu!</p>
                        <form action="{{ route('admin.seed-demo-data') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-extrabold shadow-md shadow-indigo-500/20 transition inline-flex items-center gap-2">
                                <span>⚡</span> Tự động thêm danh sách bệnh nhân mẫu ngay
                            </button>
                        </form>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-xs">
                            <thead class="bg-slate-50 text-slate-600 uppercase font-bold tracking-wider text-[11px]">
                                <tr>
                                    <th class="px-5 py-3.5 text-left">Bệnh nhân</th>
                                    <th class="px-5 py-3.5 text-left">Liên hệ & CCCD</th>
                                    <th class="px-5 py-3.5 text-left">Tiền sử bệnh & Cảnh báo</th>
                                    <th class="px-5 py-3.5 text-left">Ca khám gần nhất</th>
                                    <th class="px-5 py-3.5 text-left">Chi phí / Hóa đơn</th>
                                    <th class="px-5 py-3.5 text-right">Thao tác</th>
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
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white font-extrabold flex items-center justify-center text-sm shadow-xs flex-shrink-0">
                                                    {{ mb_strtoupper(mb_substr($pat->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.patients.show', $pat->id) }}" class="font-extrabold text-sm text-slate-900 hover:text-indigo-600 transition">
                                                        {{ $pat->name }}
                                                    </a>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        <span class="font-mono text-[11px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">
                                                            {{ $pat->patient_code }}
                                                        </span>
                                                        <span class="text-slate-400">•</span>
                                                        <span class="text-slate-500 font-medium">
                                                            {{ $pat->gender ?? '---' }} {{ $age ? "({$age} tuổi)" : '' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Cột 2: Liên hệ -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-800 flex items-center gap-1.5">
                                                <span class="text-indigo-600">📞</span>
                                                <a href="tel:{{ $pat->phone }}" class="hover:underline font-mono">{{ $pat->phone ?? '---' }}</a>
                                            </div>
                                            <div class="text-[11px] text-slate-500 truncate max-w-[180px] mt-0.5">
                                                {{ $pat->email ?? ($pat->job ?? '---') }}
                                            </div>
                                        </td>

                                        <!-- Cột 3: Tiền sử & Dị ứng -->
                                        <td class="px-5 py-4">
                                            <div class="space-y-1 max-w-[220px]">
                                                @if($hasAllergy)
                                                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200">
                                                        <span>⚠️</span> {{ $pat->allergy_history }}
                                                    </div>
                                                @else
                                                    <span class="text-[11px] font-medium text-slate-400">Không dị ứng thuốc</span>
                                                @endif

                                                @if(!empty($pat->medical_history) && !str_contains(mb_strtolower($pat->medical_history), 'không') && !str_contains(mb_strtolower($pat->medical_history), 'bình thường'))
                                                    <div class="text-[11px] text-amber-700 font-semibold truncate">
                                                        🏥 {{ $pat->medical_history }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Cột 4: Ca khám gần nhất -->
                                        <td class="px-5 py-4">
                                            @if($latestApp)
                                                <div class="max-w-[220px]">
                                                    <div class="font-bold text-slate-800 text-[11px] truncate">
                                                        {{ $latestApp->service->name ?? 'Khám tổng quát' }}
                                                    </div>
                                                    <div class="text-[10px] text-slate-500 mt-0.5 flex items-center gap-1.5">
                                                        <span>👨‍⚕️ {{ $latestApp->doctor->user->name ?? 'Bác sĩ' }}</span>
                                                        <span>•</span>
                                                        <span>{{ \Carbon\Carbon::parse($latestApp->appointment_time)->format('d/m H:i') }}</span>
                                                    </div>
                                                    <div class="mt-1">
                                                        @if($latestApp->status === 'completed')
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">✓ Đã khám xong</span>
                                                        @elseif($latestApp->status === 'in_progress')
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800 animate-pulse">⏳ Đang khám</span>
                                                        @elseif($latestApp->status === 'waiting')
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">🛋️ Ghế chờ</span>
                                                        @elseif($latestApp->status === 'confirmed')
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-800">📅 Đã hẹn lịch</span>
                                                        @else
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-700">{{ $latestApp->status }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs italic">Chưa có lịch hẹn</span>
                                            @endif
                                        </td>

                                        <!-- Cột 5: Chi phí & Hóa đơn -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if($latestInvoice)
                                                <div class="font-extrabold text-slate-900 font-mono text-xs">
                                                    {{ number_format($latestInvoice->final_amount) }} đ
                                                </div>
                                                <div class="mt-1">
                                                    @if($latestInvoice->status === 'paid')
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                            ✓ Đã thanh toán
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200">
                                                            ⏳ Chưa thanh toán
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-slate-400 text-xs">--</span>
                                            @endif
                                        </td>

                                        <!-- Cột 6: Thao tác -->
                                        <td class="px-5 py-4 whitespace-nowrap text-right space-x-1">
                                            <a href="{{ route('admin.patients.show', $pat->id) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs transition border border-indigo-200/60 shadow-2xs">
                                                <span>📋</span> Bệnh án
                                            </a>
                                            <a href="{{ route('admin.patients.edit', $pat->id) }}" 
                                               class="inline-flex items-center px-2 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                                                ✏️
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
            <div class="bg-white rounded-2xl shadow-sm border border-cyan-200 overflow-hidden">
                <div class="px-6 py-4 bg-cyan-50/70 border-b border-cyan-200 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-extrabold uppercase text-cyan-950">📩 Yêu Cầu Tư Vấn / Liên Hệ Từ Website</h3>
                        @if(($data['pending_inquiries'] ?? 0) > 0)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-cyan-600 text-white">{{ $data['pending_inquiries'] }} chờ gọi</span>
                        @endif
                    </div>
                    <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-cyan-700 hover:text-cyan-900">Xem tại Trung tâm Thông báo &rarr;</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($contactInquiries ?? [] as $inq)
                        <div class="p-4 px-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-cyan-50/20 transition">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-extrabold text-slate-900 text-sm">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                    <span class="font-mono font-bold text-xs text-indigo-600">📞 {{ $inq['phone'] ?? '---' }}</span>
                                    @if(($inq['status'] ?? 'pending') === 'pending')
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800">⏳ Chờ gọi tư vấn</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">✓ Đã gọi tư vấn ({{ $inq['resolved_by'] ?? 'Lễ tân' }})</span>
                                    @endif
                                    <span class="text-xs text-slate-400">• {{ $inq['created_at'] ?? '' }}</span>
                                </div>
                                <p class="text-xs text-slate-600">{{ $inq['message'] ?? '' }}</p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if(($inq['status'] ?? 'pending') === 'pending')
                                    <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold transition">
                                            ✓ Đánh dấu Đã tư vấn
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('contact-inquiries.destroy', $inq['id']) }}" method="POST" onsubmit="return confirm('Xóa yêu cầu liên hệ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition">
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
                        borderColor: 'rgb(79, 70, 229)',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2.5,
                        pointBackgroundColor: 'rgb(79, 70, 229)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(79, 70, 229)',
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
                            grid: { borderDash: [2, 4], color: '#e5e7eb' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
