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

            <!-- Bệnh nhân mới -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-extrabold uppercase text-slate-700">👥 Hồ Sơ Bệnh Nhân Mới Tiếp Nhận</h3>
                    <a href="{{ route('admin.patients.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Quản lý Bệnh nhân &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold text-slate-600 uppercase">Mã BN</th>
                                <th class="px-6 py-3 text-left font-bold text-slate-600 uppercase">Họ và Tên</th>
                                <th class="px-6 py-3 text-left font-bold text-slate-600 uppercase">Số điện thoại</th>
                                <th class="px-6 py-3 text-left font-bold text-slate-600 uppercase">Ngày đăng ký</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($recentPatients as $patient)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-6 py-3.5 whitespace-nowrap font-mono font-bold text-indigo-600">{{ $patient->patient_code }}</td>
                                    <td class="px-6 py-3.5 whitespace-nowrap text-sm font-bold text-slate-900">{{ $patient->name }}</td>
                                    <td class="px-6 py-3.5 whitespace-nowrap font-semibold text-slate-600">{{ $patient->phone ?? '-' }}</td>
                                    <td class="px-6 py-3.5 whitespace-nowrap text-slate-500">{{ $patient->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
