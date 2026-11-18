<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">🩺 Hàng Đợi Bệnh Nhân:</span> {{ auth()->user()->name }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Danh sách bệnh nhân đang chờ khám của bác sĩ hôm nay ({{ now()->format('d/m/Y') }})</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('doctor.dashboard') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-bold transition">
                    &larr; Bảng điều khiển
                </a>
                <a href="{{ route('doctor.patient-history.index') }}" class="px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold transition">
                    Tra cứu hồ sơ bệnh nhân
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

            <!-- KHỐI CA ĐANG KHÁM (NẾU CÓ) -->
            @if($inProgressAppointment)
                <div class="bg-gradient-to-r from-indigo-900 to-blue-800 rounded-2xl p-6 text-white shadow-lg border border-indigo-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl shrink-0">
                            🦷
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-amber-400 text-slate-900 text-[10px] font-black uppercase px-2 py-0.5 rounded">ĐANG KHÁM TẠI GHẾ</span>
                                <span class="text-xs text-indigo-200">Bắt đầu từ: {{ $inProgressAppointment->updated_at->format('H:i') }}</span>
                            </div>
                            <h3 class="text-2xl font-black mt-1">{{ $inProgressAppointment->patient->name }}</h3>
                            <p class="text-xs text-indigo-200 mt-0.5">
                                Mã BN: {{ $inProgressAppointment->patient->patient_code }} | Dịch vụ: {{ $inProgressAppointment->service->name ?? 'Khám bệnh' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('doctor.consultations.show', $inProgressAppointment->id) }}" class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold rounded-xl shadow-md transition text-sm flex items-center gap-2">
                            <span>Vào Phòng Khám & Ghi Bệnh Án</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- DANH SÁCH BỆNH NHÂN ĐANG CHỜ KHÁM (WAITING) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-amber-500 text-white flex justify-between items-center">
                    <h3 class="font-bold text-base flex items-center gap-2">
                        <span>⏳ Bệnh Nhân Đang Chờ Tại Cửa Phòng Khám ({{ $waitingList->count() }})</span>
                    </h3>
                    <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full font-bold">Thứ tự ưu tiên khám</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-center font-bold text-gray-600 uppercase w-12">STT</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Bệnh nhân</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Giờ hẹn</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Dịch vụ yêu cầu</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Tiền sử bệnh / Dị ứng</th>
                                <th class="px-4 py-3 text-right font-bold text-gray-600 uppercase">Thao tác</th>
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
                                        @if($app->patient->allergy_history)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 block mb-1">Dị ứng: {{ $app->patient->allergy_history }}</span>
                                        @endif
                                        @if($app->patient->medical_history)
                                            <span class="text-gray-600 text-[11px] block">Bệnh nền: {{ $app->patient->medical_history }}</span>
                                        @endif
                                        @if(!$app->patient->allergy_history && !$app->patient->medical_history)
                                            <span class="text-gray-400 italic">Bình thường</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs shadow-sm transition flex items-center gap-1.5 ml-auto">
                                                <span>Mời vào khám</span>
                                                <span>&rarr;</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic">
                                        Hiện không có bệnh nhân nào đang chờ tại phòng khám của bạn.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- DANH SÁCH LỊCH HẸN TRONG NGÀY & CA ĐÃ KHÁM XONG -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Lịch hẹn sắp tới hôm nay -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-3.5 bg-blue-700 text-white flex justify-between items-center">
                        <h4 class="font-bold text-sm">📅 Lịch Đã Hẹn Hôm Nay Chưa Check-in ({{ $confirmedList->count() }})</h4>
                    </div>
                    <div class="p-4 divide-y divide-gray-100 text-xs">
                        @forelse($confirmedList as $item)
                            <div class="py-3 flex justify-between items-center gap-2">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm block">{{ $item->patient->name }}</span>
                                    <span class="text-gray-500">Giờ hẹn: {{ \Carbon\Carbon::parse($item->appointment_time)->format('H:i - d/m/Y') }} | {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($item->isOverdue())
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 border border-red-300 rounded-full font-bold text-[11px]">
                                            ⚠️ Quá thời gian hẹn
                                        </span>
                                    @elseif($item->isDueNow())
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-300 rounded-full font-bold text-[11px] animate-pulse">
                                            🔔 Đến thời gian hẹn
                                        </span>
                                    @endif

                                    @if($item->status === 'pending')
                                        <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded font-bold text-[11px] shadow-sm transition">
                                                ✓ Bác sĩ xác nhận
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded font-semibold text-[10px]">BS đã xác nhận</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="py-6 text-center text-gray-400 italic">Không có lịch hẹn chờ.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ca đã khám xong -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-3.5 bg-emerald-700 text-white flex justify-between items-center">
                        <h4 class="font-bold text-sm">✓ Ca Đã Hoàn Thành Hôm Nay ({{ $completedList->count() }})</h4>
                    </div>
                    <div class="p-4 divide-y divide-gray-100 text-xs">
                        @forelse($completedList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm block">{{ $item->patient->name }}</span>
                                    <span class="text-gray-500">Xong lúc: {{ $item->updated_at->format('H:i') }} | {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <a href="{{ route('doctor.consultations.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold">
                                    Xem bệnh án &rarr;
                                </a>
                            </div>
                        @empty
                            <p class="py-6 text-center text-gray-400 italic">Hôm nay chưa hoàn thành ca khám nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>