<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📋 Điều Phối Phòng Chờ & Hàng Đợi Khám</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">Theo dõi lưu lượng bệnh nhân tại phòng khám ngày hôm nay ({{ now()->format('d/m/Y') }})</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.appointments.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-bold transition">
                    Quản lý lịch hẹn
                </a>
                <a href="{{ route('receptionist.invoices.index') }}" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                    Thu ngân & Hóa đơn
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between" role="alert">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 4 Thẻ Thống kê nhanh -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-amber-200 bg-amber-50/30">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase text-amber-700">Đang ở phòng chờ</span>
                        <span class="p-2 bg-amber-100 text-amber-600 rounded-xl">⏳</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-amber-800">{{ $waitingList->count() }}</span>
                        <span class="text-xs text-gray-500">bệnh nhân</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-indigo-200 bg-indigo-50/30">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase text-indigo-700">Đang trong phòng khám</span>
                        <span class="p-2 bg-indigo-100 text-indigo-600 rounded-xl">🩺</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-indigo-800">{{ $inProgressList->count() }}</span>
                        <span class="text-xs text-gray-500">ghế đang phục vụ</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-200 bg-blue-50/30">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase text-blue-700">Lịch đã xác nhận</span>
                        <span class="p-2 bg-blue-100 text-blue-600 rounded-xl">📅</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-blue-800">{{ $confirmedList->count() }}</span>
                        <span class="text-xs text-gray-500">chưa check-in</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-200 bg-emerald-50/30">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase text-emerald-700">Đã khám xong</span>
                        <span class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">✓</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-emerald-800">{{ $completedList->count() }}</span>
                        <span class="text-xs text-gray-500">hoàn thành</span>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc Bác sĩ -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('receptionist.queue.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <label class="text-xs font-bold uppercase text-gray-600">Lọc theo Bác sĩ:</label>
                    <select name="doctor_id" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Tất cả bác sĩ trực hôm nay --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ $doctorId == $doc->id ? 'selected' : '' }}>
                                {{ $doc->user->name ?? 'BS. #' . $doc->id }} ({{ $doc->specialty ?: 'Chuyên khoa' }})
                            </option>
                        @endforeach
                    </select>
                    @if($doctorId)
                        <a href="{{ route('receptionist.queue.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <div class="text-xs text-gray-500">
                    Tự động đồng bộ với danh sách đặt lịch và check-in của lễ tân
                </div>
            </div>

            <!-- BẢNG 1: BỆNH NHÂN ĐANG Ở PHÒNG CHỜ (WAITING) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-amber-500 text-white flex justify-between items-center">
                    <h3 class="font-bold text-base flex items-center gap-2">
                        <span>⏳ Danh Sách Bệnh Nhân Đang Ở Phòng Chờ ({{ $waitingList->count() }})</span>
                    </h3>
                    <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full font-bold">Ưu tiên gọi theo thứ tự check-in</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-center font-bold text-gray-600 uppercase w-12">STT</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Bệnh nhân</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Giờ hẹn</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Dịch vụ yêu cầu</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Bác sĩ phụ trách</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-600 uppercase">Trạng thái</th>
                                <th class="px-4 py-3 text-right font-bold text-gray-600 uppercase">Thao tác điều phối</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($waitingList as $idx => $app)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-4 py-3.5 text-center font-bold text-amber-800 bg-amber-50/50">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-gray-900 text-sm">{{ $app->patient->name }}</div>
                                        <div class="text-gray-500 font-mono text-[11px]">{{ $app->patient->patient_code }} | SĐT: {{ $app->patient->phone }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                        <span class="text-[10px] text-gray-400 block">({{ \Carbon\Carbon::parse($app->appointment_time)->diffForHumans() }})</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-indigo-700 font-semibold">
                                        {{ $app->service->name ?? 'Khám tổng quát' }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="font-bold text-gray-800">{{ $app->doctor->user->name ?? 'Chưa chỉ định' }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                            Đang đợi khám
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right space-x-2">
                                        <form action="{{ route('receptionist.appointments.update', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Mời bệnh nhân này vào phòng khám ngay?');">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-bold text-xs shadow-sm transition">
                                                Mời vào khám &rarr;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-400 italic">
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
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-3.5 bg-indigo-700 text-white flex justify-between items-center">
                        <h4 class="font-bold text-sm">🩺 Đang Trong Phòng Khám ({{ $inProgressList->count() }})</h4>
                        <span class="text-xs bg-white/20 px-2.5 py-0.5 rounded-full font-bold">Ghế hoạt động</span>
                    </div>
                    <div class="p-4 divide-y divide-gray-100 text-xs">
                        @forelse($inProgressList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm block">{{ $item->patient->name }}</span>
                                    <span class="text-gray-500">BS. {{ $item->doctor->user->name ?? '---' }} | {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 font-bold rounded-full animate-pulse">
                                    Đang khám...
                                </span>
                            </div>
                        @empty
                            <p class="py-6 text-center text-gray-400 italic">Chưa có ca nào đang thực hiện khám.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ca đã khám xong (Chờ thu tiền) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-3.5 bg-emerald-700 text-white flex justify-between items-center">
                        <h4 class="font-bold text-sm">✓ Đã Khám Xong Hôm Nay ({{ $completedList->count() }})</h4>
                        <span class="text-xs bg-white/20 px-2.5 py-0.5 rounded-full font-bold">Sẵn sàng thanh toán</span>
                    </div>
                    <div class="p-4 divide-y divide-gray-100 text-xs">
                        @forelse($completedList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm block">{{ $item->patient->name }}</span>
                                    <span class="text-gray-500">Xong lúc {{ $item->updated_at->format('H:i') }} | BS. {{ $item->doctor->user->name ?? '---' }}</span>
                                </div>
                                <div>
                                    @if($item->invoice)
                                        @if($item->invoice->status === 'paid')
                                            <span class="px-2.5 py-1 bg-green-100 text-green-800 font-bold rounded-full">
                                                Đã thu: {{ number_format($item->invoice->final_amount, 0, ',', '.') }} đ
                                            </span>
                                        @else
                                            <a href="{{ route('receptionist.invoices.show', $item->invoice) }}" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg transition">
                                                Thu tiền ({{ number_format($item->invoice->final_amount, 0, ',', '.') }} đ) &rarr;
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('receptionist.invoices.create', ['appointment_id' => $item->id]) }}" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition">
                                            + Lập hóa đơn
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="py-6 text-center text-gray-400 italic">Hôm nay chưa có ca khám nào hoàn thành.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>