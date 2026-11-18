<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📈 Báo Cáo & Thống Kê Doanh Thu Chuyên Sâu</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Bóc tách doanh thu Dịch vụ khám, Tiền thuốc kèm theo, Thuế VAT (10%) và kiểm soát tồn kho thuốc</p>
            </div>
            <div class="flex items-center gap-2.5 print:hidden">
                <a href="{{ route('admin.reports.export', ['month' => $month, 'year' => $year]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    📥 Xuất File Excel (CSV)
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    🖨️ In Báo Cáo
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Bộ lọc Tháng / Năm -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-bold uppercase text-slate-600">Tháng:</label>
                        <select name="month" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500 w-32">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-bold uppercase text-slate-600">Năm:</label>
                        <select name="year" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500 w-28">
                            @for($y=date('Y')-2; $y<=date('Y'); $y++)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Xem báo cáo
                    </button>
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Kỳ báo cáo: <strong class="text-indigo-700">Tháng {{ $month }}/{{ $year }}</strong>
                </span>
            </div>

            <!-- 4 Thẻ KPI Bóc tách Doanh thu Dịch vụ / Thuốc / VAT -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-5 shadow-md text-white">
                    <span class="text-xs font-extrabold uppercase text-blue-100 tracking-wider">💰 Tổng Thực Thu (Gồm VAT)</span>
                    <p class="text-2xl sm:text-3xl font-black mt-2">{{ number_format($totalRevenue, 0, ',', '.') }} <span class="text-xs font-bold text-blue-200">đ</span></p>
                    <p class="text-[11px] text-blue-100 mt-1.5">Đã thanh toán hoàn tất trong tháng {{ $month }}/{{ $year }}</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-indigo-200">
                    <span class="text-xs font-extrabold uppercase text-indigo-600 tracking-wider">🦷 Doanh Thu Dịch Vụ Khám</span>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($serviceRevenue ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">đ</span></p>
                    <p class="text-[11px] text-slate-500 mt-1.5">Chưa gồm thuế GTGT • {{ $completedAppointments }} ca hoàn thành</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-200">
                    <span class="text-xs font-extrabold uppercase text-emerald-600 tracking-wider">💊 Doanh Thu Tiền Thuốc</span>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($medicineRevenue ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">đ</span></p>
                    <p class="text-[11px] text-slate-500 mt-1.5">Thuốc kê đơn & Gói thuốc kèm theo</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-200">
                    <span class="text-xs font-extrabold uppercase text-amber-600 tracking-wider">🧾 Thuế GTGT (VAT 10%)</span>
                    <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($totalVat ?? 0, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">đ</span></p>
                    <p class="text-[11px] text-slate-500 mt-1.5">Hồ sơ bệnh nhân mới: <strong>+{{ $newPatients }}</strong></p>
                </div>
            </div>

            <!-- Cảnh báo tồn kho thuốc (nếu có thuốc sắp hết) -->
            @if(isset($lowStockMedicines) && $lowStockMedicines->count() > 0)
                <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-amber-900 flex items-center gap-2">
                            <span>⚠️</span> Cảnh Báo Tồn Kho Thuốc Sắp Hết ({{ $lowStockMedicines->count() }} mặt hàng &le; 20 đơn vị)
                        </h3>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($lowStockMedicines as $med)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white border border-amber-300 text-xs font-bold text-amber-900">
                                    💊 {{ $med->name }}: <strong class="text-rose-600">còn {{ $med->stock_quantity }} {{ $med->unit }}</strong>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('admin.medicines.index') }}" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-extrabold whitespace-nowrap self-start sm:self-center transition">
                        Nhập thêm kho thuốc →
                    </a>
                </div>
            @endif

            <!-- Bảng chi tiết doanh thu theo ngày -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold uppercase text-slate-700">📋 Chi tiết doanh thu theo ngày (Tháng {{ $month }}/{{ $year }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3.5 px-6 text-left font-bold text-slate-600 uppercase">Ngày ghi nhận</th>
                                <th class="py-3.5 px-6 text-center font-bold text-slate-600 uppercase">Số hóa đơn đã thu</th>
                                <th class="py-3.5 px-6 text-right font-bold text-slate-600 uppercase">Thuế VAT (10%)</th>
                                <th class="py-3.5 px-6 text-right font-bold text-slate-600 uppercase">Tổng thực thu trong ngày</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($dailyRevenue as $day)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="py-3.5 px-6 font-semibold text-slate-800">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</td>
                                    <td class="py-3.5 px-6 text-center font-bold text-slate-700">{{ $day->invoice_count ?? 1 }} hóa đơn</td>
                                    <td class="py-3.5 px-6 text-right font-semibold text-amber-700">{{ number_format($day->vat_total ?? 0, 0, ',', '.') }} đ</td>
                                    <td class="py-3.5 px-6 text-right font-extrabold text-indigo-700 text-sm">{{ number_format($day->total, 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400 text-sm">Chưa có dữ liệu doanh thu trong tháng này.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
