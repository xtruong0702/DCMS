<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Điều phối phòng chờ & Hàng đợi
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hôm nay: {{ now()->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi lưu lượng bệnh nhân tại sảnh chờ, phòng khám và thanh toán trong ngày</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.appointments.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Quản lý lịch hẹn
                </a>
                <a href="{{ route('receptionist.invoices.index') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>Quầy thu ngân & VietQR</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-semibold" role="alert">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- 4 Thẻ Thống kê KPI dot indicator -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Chờ tại sảnh</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $waitingList->count() }} <span class="text-xs font-normal text-slate-400">bệnh nhân</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Đã check-in sảnh chờ</div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Trong phòng khám</span>
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $inProgressList->count() }} <span class="text-xs font-normal text-slate-400">ca đang khám</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Ghế điều trị đang phục vụ</div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Lịch đã xác nhận</span>
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $confirmedList->count() }} <span class="text-xs font-normal text-slate-400">chưa check-in</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Dự kiến đến khám hôm nay</div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Đã khám xong</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-slate-900">{{ $completedList->count() }} <span class="text-xs font-normal text-slate-400">hoàn thành</span></div>
                    <div class="mt-1 text-[11px] text-slate-400">Chờ hoặc đã thu ngân</div>
                </div>
            </div>

            <!-- Bộ lọc Bác sĩ -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('receptionist.queue.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <label class="text-xs font-bold text-slate-600">Lọc theo Bác sĩ:</label>
                    <select name="doctor_id" onchange="this.form.submit()" class="rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả bác sĩ trực hôm nay --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ $doctorId == $doc->id ? 'selected' : '' }}>
                                {{ $doc->user->name ?? 'BS. #' . $doc->id }} ({{ $doc->specialty ?: 'Chuyên khoa' }})
                            </option>
                        @endforeach
                    </select>
                    @if($doctorId)
                        <a href="{{ route('receptionist.queue.index') }}" class="text-xs text-[#0D7A68] hover:underline font-semibold">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <div class="text-xs text-slate-400 font-medium">
                    Tự động đồng bộ với danh sách đặt lịch và quầy lễ tân
                </div>
            </div>

            <!-- BẢNG 1: BỆNH NHÂN ĐANG Ở PHÒNG CHỜ -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <h3 class="text-sm font-bold text-slate-900">Danh sách bệnh nhân tại sảnh chờ</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $waitingList->count() }}</span>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">Ưu tiên gọi theo thứ tự check-in sảnh</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider w-12">STT</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Giờ hẹn</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ yêu cầu</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bác sĩ phụ trách</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($waitingList as $idx => $app)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 text-center font-bold text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-slate-900 text-xs">{{ $app->patient->name }}</div>
                                        <div class="text-slate-400 font-mono text-[11px]">{{ $app->patient->patient_code }} • {{ $app->patient->phone }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                        <span class="text-[10px] text-slate-400 block">({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-700 font-medium">
                                        {{ $app->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">
                                        {{ $app->doctor->user->name ?? 'Chưa chỉ định' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            Đang chờ khám
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <form action="{{ route('receptionist.appointments.update', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mời bệnh nhân này vào phòng khám ngay?');">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                Mời vào khám &rarr;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                        Hiện không có bệnh nhân nào đang ngồi ở phòng chờ.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BẢNG 2: CÁC CA ĐANG KHÁM & ĐÃ KHÁM XONG CHỜ THANH TOÁN -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Ca đang khám -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                            <h4 class="text-sm font-bold text-slate-900">Đang trong phòng khám</h4>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $inProgressList->count() }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Ghế đang hoạt động</span>
                    </div>
                    <div class="p-4 divide-y divide-slate-100 text-xs">
                        @forelse($inProgressList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $item->patient->name }}</span>
                                    <span class="text-slate-400 text-[11px]">BS. {{ $item->doctor->user->name ?? '---' }} • {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <span class="bg-[#EEF2FF] text-[#3730A3] font-bold text-[11px] px-2.5 py-0.5 rounded-md animate-pulse">
                                    Đang khám...
                                </span>
                            </div>
                        @empty
                            <p class="py-6 text-center text-slate-400">Chưa có ca nào đang thực hiện khám.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ca đã khám xong (Chờ thu tiền) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h4 class="text-sm font-bold text-slate-900">Đã khám xong hôm nay</h4>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $completedList->count() }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Sẵn sàng thanh toán</span>
                    </div>
                    <div class="p-4 divide-y divide-slate-100 text-xs">
                        @forelse($completedList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $item->patient->name }}</span>
                                    <span class="text-slate-400 text-[11px]">Xong lúc {{ $item->updated_at->format('H:i') }} • BS. {{ $item->doctor->user->name ?? '---' }}</span>
                                </div>
                                <div>
                                    @if($item->invoice)
                                        @if($item->invoice->status === 'paid')
                                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                                Đã thu: {{ number_format($item->invoice->final_amount, 0, ',', '.') }} đ
                                            </span>
                                        @else
                                            <a href="{{ route('receptionist.invoices.show', $item->invoice) }}" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                                                Thu tiền ({{ number_format($item->invoice->final_amount, 0, ',', '.') }} đ) &rarr;
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('receptionist.invoices.create', ['appointment_id' => $item->id]) }}" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl shadow-xs transition">
                                            + Lập hóa đơn
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="py-6 text-center text-slate-400">Hôm nay chưa có ca khám nào hoàn thành.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
