<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl text-slate-900 tracking-tight">Báo Cáo & Thống Kê Doanh Thu</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Phân tích tài chính • Tháng {{ $month }}/{{ $year }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Bóc tách doanh thu dịch vụ nha khoa, tiền thuốc kê đơn, thuế GTGT (10%) và kiểm soát tồn kho dược phẩm</p>
            </div>
            <div class="flex items-center gap-2 print:hidden">
                <a href="{{ route('admin.reports.export', ['month' => $month, 'year' => $year]) }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Xuất Excel (CSV)</span>
                </a>
                <button onclick="window.print()" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>In Báo Cáo</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Bộ lọc Tháng / Năm -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold uppercase text-slate-500">Tháng:</label>
                    <select name="month" class="rounded-xl border-slate-200 text-xs font-semibold focus:border-[#0D7A68] focus:ring-[#0D7A68] w-32 py-1.5">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold uppercase text-slate-500">Năm:</label>
                    <select name="year" class="rounded-xl border-slate-200 text-xs font-semibold focus:border-[#0D7A68] focus:ring-[#0D7A68] w-28 py-1.5">
                        @for($y=date('Y')-2; $y<=date('Y'); $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="px-4 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                    Xem báo cáo
                </button>
            </form>

            <span class="text-xs text-slate-500 font-medium">
                Kỳ báo cáo: <strong class="text-slate-900 font-bold">Tháng {{ $month }}/{{ $year }}</strong>
            </span>
        </div>

        <!-- 4 Thẻ KPI Dot Indicator Stitch UI -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Tổng thực thu (Gồm VAT)
                    </span>
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Đã thu</span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-2">
                    {{ number_format($totalRevenue, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">đ</span>
                </div>
                <div class="text-[11px] text-slate-500 mt-1">Đã hoàn tất thanh toán trong tháng {{ $month }}/{{ $year }}</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Doanh thu Dịch vụ khám
                    </span>
                    <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $completedAppointments }} ca</span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-2">
                    {{ number_format($serviceRevenue ?? 0, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">đ</span>
                </div>
                <div class="text-[11px] text-slate-500 mt-1">Chưa gồm thuế GTGT • Ca điều trị hoàn tất</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Doanh thu Tiền thuốc
                    </span>
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Dược phẩm</span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-2">
                    {{ number_format($medicineRevenue ?? 0, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">đ</span>
                </div>
                <div class="text-[11px] text-slate-500 mt-1">Thuốc kê đơn & Gói thuốc kèm theo</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Thuế GTGT (theo hóa đơn)
                    </span>
                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">+{{ $newPatients }} BN</span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-2">
                    {{ number_format($totalVat ?? 0, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">đ</span>
                </div>
                <div class="text-[11px] text-slate-500 mt-1">Bệnh nhân mới đăng ký hồ sơ: <strong>+{{ $newPatients }}</strong></div>
            </div>
        </div>

        <!-- Cảnh báo tồn kho thuốc -->
        @if(isset($lowStockMedicines) && $lowStockMedicines->count() > 0)
            <div class="bg-amber-50/70 rounded-2xl p-4 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xs font-extrabold text-amber-900 flex items-center gap-2">
                        <span>⚠️</span> Cảnh Báo Tồn Kho Dược Phẩm Sắp Hết ({{ $lowStockMedicines->count() }} mặt hàng &le; 20 đơn vị)
                    </h3>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($lowStockMedicines as $med)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-xs font-bold text-amber-900 shadow-2xs">
                                💊 {{ $med->name }}: <strong class="text-rose-600">còn {{ $med->stock_quantity }} {{ $med->unit }}</strong>
                            </span>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('admin.medicines.index') }}" class="px-3.5 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold whitespace-nowrap self-start sm:self-center transition shadow-xs">
                    Nhập thêm kho thuốc &rarr;
                </a>
            </div>
        @endif

        <!-- Hàng Biểu đồ: Doanh thu theo ngày + Cơ cấu Doanh thu & Phương thức thanh toán -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">📈 Biểu đồ Doanh thu theo ngày (Tháng {{ $month }}/{{ $year }})</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $paidInvoiceCount ?? 0 }} hóa đơn đã thu • Công nợ chưa thu: <strong class="text-amber-600">{{ number_format($unpaidAmount ?? 0, 0, ',', '.') }} đ</strong> ({{ $unpaidInvoiceCount ?? 0 }} HĐ)</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="monthlyDailyRevenueChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5 flex flex-col justify-between">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">💳 Cơ cấu & Kênh Thanh Toán</h3>
                    <div class="h-40 flex items-center justify-center">
                        <canvas id="revenueSplitChart"></canvas>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs">
                    @foreach(($paymentMethods ?? []) as $methodLabel => $methodVal)
                        @if($methodVal > 0 || $methodLabel !== 'Khác')
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600 font-medium">{{ $methodLabel }}</span>
                                <span class="font-bold text-slate-900 tabular-nums">{{ number_format($methodVal, 0, ',', '.') }} đ</span>
                            </div>
                        @endif
                    @endforeach
                    <div class="flex items-center justify-between pt-1.5 border-t border-slate-100">
                        <span class="text-slate-500">Tổng ưu đãi / chiết khấu</span>
                        <span class="font-semibold text-rose-600 tabular-nums">-{{ number_format($totalDiscount ?? 0, 0, ',', '.') }} đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hàng Phân tích: Top Dịch vụ & Hiệu suất Bác sĩ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Dịch vụ -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/90">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">🦷 Top Dịch vụ Tạo Doanh Thu Cao Nhất</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 font-bold text-[11px] uppercase">
                                <th class="py-2.5 px-5">Dịch vụ / Thủ thuật</th>
                                <th class="py-2.5 px-4 text-center">Số lượt</th>
                                <th class="py-2.5 px-5 text-right">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse(($topServices ?? collect()) as $srv)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="py-2.5 px-5 font-semibold text-slate-800">{{ $srv['name'] }}</td>
                                    <td class="py-2.5 px-4 text-center font-bold text-slate-600">{{ $srv['qty'] }}</td>
                                    <td class="py-2.5 px-5 text-right font-bold text-[#0D7A68] tabular-nums">{{ number_format($srv['revenue'], 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-8 text-center text-slate-400">Chưa có dữ liệu dịch vụ trong tháng này.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hiệu suất Bác sĩ -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/90">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">👨‍⚕️ Hiệu Suất Bác Sĩ Trong Tháng</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 font-bold text-[11px] uppercase">
                                <th class="py-2.5 px-5">Bác sĩ phụ trách</th>
                                <th class="py-2.5 px-4 text-center">Ca đã thu</th>
                                <th class="py-2.5 px-5 text-right">Doanh số (Gồm VAT)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse(($doctorStats ?? collect()) as $doc)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="py-2.5 px-5">
                                        <div class="font-bold text-slate-800">{{ $doc['name'] }}</div>
                                        <div class="text-[11px] text-slate-400 truncate max-w-[220px]">{{ $doc['specialty'] }}</div>
                                    </td>
                                    <td class="py-2.5 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 font-bold">{{ $doc['cases'] }} ca</span>
                                    </td>
                                    <td class="py-2.5 px-5 text-right font-bold text-[#0D7A68] tabular-nums">{{ number_format($doc['revenue'], 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-8 text-center text-slate-400">Chưa có dữ liệu bác sĩ trong tháng này.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết doanh thu theo ngày -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="px-5 py-4 bg-slate-50/70 border-b border-slate-200/90 flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">📋 Chi tiết doanh thu theo ngày (Tháng {{ $month }}/{{ $year }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-2.5 px-5">Ngày ghi nhận</th>
                            <th class="py-2.5 px-5 text-center">Số hóa đơn đã thu</th>
                            <th class="py-2.5 px-5 text-right">Thuế VAT (10%)</th>
                            <th class="py-2.5 px-5 text-right">Tổng thực thu trong ngày</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($dailyRevenue as $day)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-5 font-semibold text-slate-800">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                <td class="py-3 px-5 text-center font-bold text-slate-700">{{ $day->invoice_count ?? 1 }} hóa đơn</td>
                                <td class="py-3 px-5 text-right font-semibold text-amber-700">{{ number_format($day->vat_total ?? 0, 0, ',', '.') }} đ</td>
                                <td class="py-3 px-5 text-right font-bold text-[#0D7A68] text-sm">{{ number_format($day->total, 0, ',', '.') }} đ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 text-xs">Chưa có dữ liệu doanh thu trong tháng này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dailyCtx = document.getElementById('monthlyDailyRevenueChart');
            if (dailyCtx) {
                new Chart(dailyCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($dailyChartLabels ?? []),
                        datasets: [{
                            label: 'Doanh thu thực thu (VNĐ)',
                            data: @json($dailyChartTotals ?? []),
                            backgroundColor: 'rgba(13, 122, 104, 0.85)',
                            borderRadius: 6,
                            maxBarThickness: 32,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => new Intl.NumberFormat('vi-VN').format(ctx.parsed.y) + ' đ'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: (v) => v >= 1000000 ? (v / 1000000) + 'tr' : new Intl.NumberFormat('vi-VN').format(v)
                                },
                                grid: { color: '#f1f5f9' }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const splitCtx = document.getElementById('revenueSplitChart');
            if (splitCtx) {
                new Chart(splitCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Dịch vụ khám', 'Tiền thuốc', 'Thuế VAT'],
                        datasets: [{
                            data: [{{ round($serviceRevenue ?? 0) }}, {{ round($medicineRevenue ?? 0) }}, {{ round($totalVat ?? 0) }}],
                            backgroundColor: ['#0D7A68', '#3B82F6', '#F59E0B'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '64%',
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => ctx.label + ': ' + new Intl.NumberFormat('vi-VN').format(ctx.parsed) + ' đ'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
