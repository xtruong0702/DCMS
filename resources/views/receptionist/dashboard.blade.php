<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-emerald-600 font-extrabold">🛎️ Quầy Tiếp Đón, Điều Phối Sảnh & Thu Ngân (Lễ Tân)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tiếp nhận khách khám trực tiếp trong ngày, xác nhận lịch đặt trước, điều phối hàng đợi Bác sĩ và thu ngân VietQR ({{ date('d/m/Y') }})</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('receptionist.patients.create') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition">
                    👤 + Tạo Hồ Sơ Bệnh Nhân
                </a>
                <a href="{{ route('receptionist.appointments.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                    🪑 + Tiếp Nhận Khách / Đặt Lịch
                </a>
                <a href="{{ route('receptionist.invoices.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                    🧾 + Lập Hóa Đơn Thu Tiền
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm font-bold flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- 5 Thẻ Thống Kê Nghiệp Vụ Lễ Tân -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-2xl shadow-xs border border-amber-200 p-4">
                    <p class="text-[11px] font-extrabold uppercase text-amber-700">Lịch đặt trước chờ duyệt</p>
                    <p class="text-2xl font-black text-amber-600 mt-1">{{ $pendingConfirmCount ?? 0 }} <span class="text-xs font-semibold text-slate-400">lịch</span></p>
                </div>
                <div class="bg-white rounded-2xl shadow-xs border border-blue-200 p-4">
                    <p class="text-[11px] font-extrabold uppercase text-blue-700">Ca khám hôm nay</p>
                    <p class="text-2xl font-black text-blue-700 mt-1">{{ $totalToday }} <span class="text-xs font-semibold text-slate-400">ca</span></p>
                </div>
                <div class="bg-white rounded-2xl shadow-xs border border-orange-200 p-4">
                    <p class="text-[11px] font-extrabold uppercase text-orange-700">Đang chờ tại sảnh</p>
                    <p class="text-2xl font-black text-orange-600 mt-1">{{ $waitingCount }} <span class="text-xs font-semibold text-slate-400">khách</span></p>
                </div>
                <div class="bg-white rounded-2xl shadow-xs border border-purple-200 p-4">
                    <p class="text-[11px] font-extrabold uppercase text-purple-700">Đang trong phòng khám</p>
                    <p class="text-2xl font-black text-purple-600 mt-1">{{ $inProgressCount }} <span class="text-xs font-semibold text-slate-400">ca</span></p>
                </div>
                <div class="bg-white rounded-2xl shadow-xs border border-rose-200 p-4 col-span-2 sm:col-span-1">
                    <p class="text-[11px] font-extrabold uppercase text-rose-700">Hóa đơn chờ thu ngân</p>
                    <p class="text-2xl font-black text-rose-600 mt-1">{{ $unpaidInvoices->count() }} <span class="text-xs font-semibold text-slate-400">HĐ</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Cột trái (8/12): Điều phối Lịch hẹn & Sảnh chờ -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- KHỐI 1: Lịch hẹn đặt trước chờ Lễ tân xác nhận & phân công Bác sĩ -->
                    <div class="bg-white rounded-2xl shadow-xs border border-amber-200 overflow-hidden">
                        <div class="px-6 py-4 bg-amber-50/70 border-b border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-extrabold uppercase text-amber-900 flex items-center gap-2">
                                    <span>📞</span> 1. Lịch Hẹn Đặt Trước (Từ Ngày Mai) & Chờ Gọi Xác Nhận ({{ $advanceBookings->count() }})
                                </h3>
                                <p class="text-xs text-amber-800 mt-0.5">Lễ tân gọi xác nhận với khách, phân công Bác sĩ phụ trách (nếu chưa có) và bấm Xác nhận lịch.</p>
                            </div>
                            <a href="{{ route('receptionist.appointments.index') }}" class="text-xs font-extrabold text-amber-900 hover:underline whitespace-nowrap">Xem tất cả lịch hẹn &rarr;</a>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse($advanceBookings as $app)
                                <div class="p-4 sm:px-6 hover:bg-slate-50/70 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 font-extrabold text-xs">
                                                ⏰ {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                            </span>
                                            @if($app->status === 'pending')
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300">⏳ Chờ xác nhận</span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200">✓ Đã xác nhận</span>
                                            @endif
                                        </div>
                                        <p class="text-sm font-extrabold text-slate-900">
                                            {{ $app->patient->name ?? 'Khách hàng' }}
                                            <span class="text-xs font-semibold text-blue-600 ml-1">({{ $app->patient->phone ?? 'Chưa có SĐT' }})</span>
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            🦷 Dịch vụ: <strong class="text-slate-700">{{ $app->service->name ?? 'Khám & Tư vấn tổng quát' }}</strong>
                                        </p>
                                    </div>

                                    <!-- Form Phân công Bác sĩ & Xác nhận nhanh ngay trên Dashboard -->
                                    <form action="{{ route('receptionist.appointments.update', $app->id) }}" method="POST" class="flex flex-wrap items-center gap-2 shrink-0">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <select name="doctor_id" class="rounded-xl border-slate-300 text-xs font-semibold py-1.5 pl-2.5 pr-7 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Chọn Bác sĩ --</option>
                                            @foreach($doctors as $doc)
                                                <option value="{{ $doc->id }}" @selected($app->doctor_id == $doc->id)>
                                                    BS. {{ $doc->user->name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($app->status === 'pending')
                                            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-xs transition">
                                                ✓ Xác nhận & Lưu BS
                                            </button>
                                        @else
                                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-indigo-600 text-slate-700 hover:text-white text-xs font-bold transition">
                                                Đổi Bác sĩ
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @empty
                                <div class="p-8 text-center text-xs text-slate-400">
                                    Hiện không có lịch hẹn đặt trước nào đang chờ xác nhận.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- KHỐI 2: Luồng khách hàng khám trong ngày hôm nay (Walk-in & Check-in) -->
                    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-extrabold uppercase text-slate-800">🪑 2. Luồng Khách Khám Trong Ngày Hôm Nay ({{ date('d/m/Y') }})</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Khách đến trực tiếp trong ngày hoặc khách có lịch hẹn hôm nay đến quầy làm thủ tục Check-in vào sảnh chờ.</p>
                            </div>
                            <a href="{{ route('receptionist.queue.index') }}" class="text-xs font-extrabold text-indigo-600 hover:underline whitespace-nowrap">Mở màn hình Hàng đợi &rarr;</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-xs">
                                <thead class="bg-slate-50/70">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold text-slate-500 uppercase">Giờ</th>
                                        <th class="px-4 py-3 text-left font-bold text-slate-500 uppercase">Bệnh nhân</th>
                                        <th class="px-4 py-3 text-left font-bold text-slate-500 uppercase">Bác sĩ phụ trách</th>
                                        <th class="px-4 py-3 text-left font-bold text-slate-500 uppercase">Trạng thái sảnh</th>
                                        <th class="px-4 py-3 text-right font-bold text-slate-500 uppercase">Điều phối</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100">
                                    @forelse($todayAppointments as $app)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="px-4 py-3.5 whitespace-nowrap font-extrabold {{ $app->status == 'waiting' ? 'text-orange-600' : 'text-slate-900' }}">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                            </td>
                                            <td class="px-4 py-3.5 whitespace-nowrap">
                                                <div class="font-extrabold text-slate-900">{{ $app->patient->name }}</div>
                                                <div class="text-[11px] text-slate-500">{{ $app->patient->phone ?? '' }} • {{ $app->service->name ?? 'Khám tổng quát' }}</div>
                                            </td>
                                            <td class="px-4 py-3.5 whitespace-nowrap font-semibold text-slate-700">
                                                {{ $app->doctor && $app->doctor->user ? 'BS. ' . $app->doctor->user->name : 'Chưa phân công' }}
                                            </td>
                                            <td class="px-4 py-3.5 whitespace-nowrap">
                                                <div class="flex flex-wrap items-center gap-1">
                                                    @if($app->isOverdue())
                                                        <span class="px-2 py-0.5 font-extrabold rounded-full bg-red-100 text-red-700 border border-red-300">⚠️ Quá giờ</span>
                                                    @elseif($app->isDueNow())
                                                        <span class="px-2 py-0.5 font-extrabold rounded-full bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">🔔 Đến giờ</span>
                                                    @endif

                                                    @if($app->status == 'pending')
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-yellow-100 text-yellow-800">Chờ xác nhận</span>
                                                    @elseif($app->status == 'confirmed')
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-blue-100 text-blue-800">Đã xác nhận</span>
                                                    @elseif($app->status == 'waiting')
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-orange-100 text-orange-800">Đang chờ khám</span>
                                                    @elseif($app->status == 'in_progress')
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-purple-100 text-purple-800">Đang khám</span>
                                                    @elseif($app->status == 'completed')
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-emerald-100 text-emerald-800">Đã khám xong</span>
                                                    @else
                                                        <span class="px-2.5 py-0.5 font-bold rounded-full bg-slate-100 text-slate-600">Hủy/Vắng</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1">
                                                @if($app->status == 'pending' || $app->status == 'confirmed')
                                                    <form action="{{ route('receptionist.appointments.checkin', $app->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-xl shadow-xs font-extrabold transition">
                                                            🪑 Check-in vào sảnh
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('receptionist.appointments.edit', $app->id) }}" class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Sửa</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                                Hôm nay chưa có khách khám trực tiếp. Nhấn <strong>"+ Tiếp Nhận Khách / Đặt Lịch"</strong> khi có khách đến quầy.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cột phải (4/12): Quầy Thu Ngân & VietQR -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-xs border border-rose-200 p-6">
                        <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="text-sm font-extrabold uppercase text-rose-700">💳 3. Quầy Thu Ngân & VietQR</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Hóa đơn từ phòng Bác sĩ chuyển sang chờ thu tiền</p>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-extrabold">{{ $unpaidInvoices->count() }}</span>
                        </div>

                        <div class="space-y-3 max-h-[540px] overflow-y-auto pr-1">
                            @forelse($unpaidInvoices as $invoice)
                                <div class="p-4 bg-rose-50/60 border border-rose-200/80 rounded-2xl">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-extrabold text-rose-700 text-xs">#{{ $invoice->invoice_code }}</span>
                                        <span class="text-[11px] text-slate-400 font-semibold">{{ $invoice->created_at->format('H:i - d/m') }}</span>
                                    </div>
                                    <p class="font-extrabold text-slate-900 text-sm">{{ $invoice->patient->name ?? 'Khách hàng' }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Gồm {{ $invoice->details->count() }} mục (Dịch vụ khám & Thuốc kèm theo)</p>
                                    <div class="flex justify-between items-center mt-3 pt-2.5 border-t border-rose-200/70">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Cần thanh toán (Gồm VAT 10%)</span>
                                            <span class="font-black text-base text-rose-600">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                                        </div>
                                        <a href="{{ route('receptionist.invoices.show', $invoice->id) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition">
                                            Thu Tiền / VietQR &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400 text-xs">
                                    Hiện không có hóa đơn nào đang chờ thu tiền.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <a href="{{ route('receptionist.invoices.create') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-extrabold transition">
                                + Lập Hóa Đơn Dịch Vụ / Thuốc Mới
                            </a>
                        </div>
                    </div>

                    <!-- Khối Yêu Cầu Tư Vấn / Liên Hệ Từ Website -->
                    <div class="bg-white overflow-hidden shadow-xs rounded-2xl p-6 border border-cyan-200 mt-6">
                        <div class="flex justify-between items-center mb-4 border-b border-cyan-100 pb-3">
                            <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                <span class="bg-cyan-600 text-white p-1.5 rounded-lg text-xs">📩</span>
                                Yêu Cầu Tư Vấn Từ Website
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold {{ ($pendingInquiriesCount ?? 0) > 0 ? 'bg-cyan-100 text-cyan-800 animate-pulse' : 'bg-slate-100 text-slate-500' }}">
                                {{ $pendingInquiriesCount ?? 0 }} chờ gọi
                            </span>
                        </div>

                        <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                            @forelse($contactInquiries ?? [] as $inq)
                                <div class="p-3.5 border rounded-xl transition {{ ($inq['status'] ?? 'pending') === 'pending' ? 'border-cyan-200 bg-cyan-50/40' : 'border-slate-200 bg-slate-50/60 opacity-80' }}">
                                    <div class="flex justify-between items-start gap-2 mb-1">
                                        <div>
                                            <span class="font-extrabold text-slate-900 text-sm">{{ $inq['name'] ?? 'Khách hàng' }}</span>
                                            <a href="tel:{{ $inq['phone'] ?? '' }}" class="ml-1.5 font-mono font-bold text-xs text-indigo-600 hover:underline">
                                                📞 {{ $inq['phone'] ?? '---' }}
                                            </a>
                                        </div>
                                        @if(($inq['status'] ?? 'pending') === 'pending')
                                            <span class="text-[10px] bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-extrabold">Chờ gọi tư vấn</span>
                                        @else
                                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">✓ Đã tư vấn</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-700 bg-white p-2.5 rounded-lg border border-slate-200/80 mt-1.5 leading-relaxed">
                                        {{ $inq['message'] ?? '' }}
                                    </p>
                                    <div class="flex flex-wrap items-center justify-between gap-2 mt-2.5 pt-2 border-t border-slate-200/60 text-[11px]">
                                        <span class="text-slate-400 font-medium">{{ $inq['created_at'] ?? '' }}</span>
                                        <div class="flex items-center gap-1.5">
                                            @if(($inq['status'] ?? 'pending') === 'pending')
                                                <form action="{{ route('contact-inquiries.resolve', $inq['id']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold transition">
                                                        ✓ Đã gọi tư vấn
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('receptionist.appointments.create', ['name' => $inq['name'] ?? '', 'phone' => $inq['phone'] ?? '']) }}" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg font-bold transition">
                                                📅 Đặt lịch
                                            </a>
                                            <form action="{{ route('contact-inquiries.destroy', $inq['id']) }}" method="POST" onsubmit="return confirm('Xóa yêu cầu tư vấn này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 text-rose-600 hover:bg-rose-50 rounded-lg font-bold">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    Chưa có yêu cầu tư vấn mới nào từ trang Liên hệ.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
