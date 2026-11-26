<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Hàng đợi bệnh nhân: <span class="text-[#0D7A68]">{{ auth()->user()->name }}</span>
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hôm nay: {{ now()->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Danh sách bệnh nhân đang chờ tại cửa phòng khám của bác sĩ hôm nay</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    &larr; Tổng quan
                </a>
                <a href="{{ route('doctor.patient-history.index') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>Tra cứu hồ sơ</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold" role="alert">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- KHỐI CA ĐANG KHÁM (NẾU CÓ) -->
            @if($inProgressAppointment)
                <div class="bg-gradient-to-r from-[#095246] via-[#0D7A68] to-[#0A4B40] rounded-2xl p-6 text-white shadow-xs border border-teal-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center text-2xl shrink-0">
                            🦷
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-amber-400 text-slate-900 text-[10px] font-bold uppercase px-2 py-0.5 rounded">ĐANG KHÁM TẠI GHẾ</span>
                                <span class="text-xs text-teal-100">Bắt đầu lúc: {{ $inProgressAppointment->updated_at->format('H:i') }}</span>
                            </div>
                            <h3 class="text-xl font-bold mt-1">{{ $inProgressAppointment->patient->name }}</h3>
                            <p class="text-xs text-teal-100 mt-0.5">
                                Mã BN: {{ $inProgressAppointment->patient->patient_code }} • Dịch vụ: {{ $inProgressAppointment->service->name ?? 'Khám bệnh' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('doctor.consultations.show', $inProgressAppointment->id) }}" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-[#095246] font-bold rounded-xl shadow-xs transition text-xs flex items-center gap-2">
                            <span>Vào Phòng Khám & Ghi Bệnh Án</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- DANH SÁCH BỆNH NHÂN ĐANG CHỜ KHÁM (WAITING) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <h3 class="text-sm font-bold text-slate-900">Bệnh nhân đang chờ tại cửa phòng khám</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $waitingList->count() }}</span>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">Thứ tự ưu tiên gọi khám</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider w-12">STT</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Giờ hẹn</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ yêu cầu</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tiền sử bệnh / Cảnh báo</th>
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
                                    <td class="px-4 py-3.5">
                                        @if($app->patient->allergy_history)
                                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2 py-0.5 rounded block mb-1">Dị ứng: {{ $app->patient->allergy_history }}</span>
                                        @endif
                                        @if($app->patient->medical_history)
                                            <span class="text-slate-500 text-[11px] block">Bệnh nền: {{ $app->patient->medical_history }}</span>
                                        @endif
                                        @if(!$app->patient->allergy_history && !$app->patient->medical_history)
                                            <span class="text-slate-400 italic">Bình thường</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="px-3.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5 ml-auto">
                                                <span>Mời vào khám</span>
                                                <span>&rarr;</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-xs">
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
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <h4 class="text-sm font-bold text-slate-900">Lịch đã hẹn chưa check-in</h4>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $confirmedList->count() }}</span>
                        </div>
                    </div>
                    <div class="p-4 divide-y divide-slate-100 text-xs">
                        @forelse($confirmedList as $item)
                            <div class="py-3 flex justify-between items-center gap-2">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $item->patient->name }}</span>
                                    <span class="text-slate-400 text-[11px]">Hẹn: {{ \Carbon\Carbon::parse($item->appointment_time)->format('H:i - d/m/Y') }} • {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($item->isOverdue())
                                        <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                            ⚠️ Quá thời gian hẹn
                                        </span>
                                    @elseif($item->isDueNow())
                                        <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md animate-pulse">
                                            🔔 Đến thời gian hẹn
                                        </span>
                                    @endif

                                    @if($item->status === 'pending')
                                        <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="px-2.5 py-1 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-[11px] shadow-xs transition">
                                                ✓ Bác sĩ xác nhận
                                            </button>
                                        </form>
                                    @else
                                        <span class="bg-[#ECFDF5] text-[#065F46] font-bold text-[11px] px-2 py-0.5 rounded-md">Đã xác nhận</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="py-6 text-center text-slate-400 text-xs">Không có lịch hẹn chờ.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ca đã khám xong -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h4 class="text-sm font-bold text-slate-900">Ca đã hoàn thành hôm nay</h4>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $completedList->count() }}</span>
                        </div>
                    </div>
                    <div class="p-4 divide-y divide-slate-100 text-xs">
                        @forelse($completedList as $item)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $item->patient->name }}</span>
                                    <span class="text-slate-400 text-[11px]">Xong lúc: {{ $item->updated_at->format('H:i') }} • {{ $item->service->name ?? 'Khám bệnh' }}</span>
                                </div>
                                <a href="{{ route('doctor.consultations.show', $item->id) }}" class="text-[#0D7A68] hover:underline font-bold text-xs">
                                    Xem bệnh án &rarr;
                                </a>
                            </div>
                        @empty
                            <p class="py-6 text-center text-slate-400 text-xs">Hôm nay chưa hoàn thành ca khám nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
