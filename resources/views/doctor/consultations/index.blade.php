<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Danh sách ca khám & Điều trị
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Lâm sàng
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Quản lý các ca khám đang thực hiện, bệnh nhân chờ khám và lịch sử điều trị</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('doctor.queue.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    Hàng đợi phòng khám
                </a>
                <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>Tổng quan</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Bộ lọc ca khám -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('doctor.consultations.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <select name="status" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="in_progress" {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>Đang khám</option>
                        <option value="waiting" {{ ($status ?? '') === 'waiting' ? 'selected' : '' }}>Đang chờ tại sảnh</option>
                        <option value="confirmed" {{ ($status ?? '') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                    </select>

                    <input type="date" name="date" value="{{ $date ?? '' }}" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">

                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                        Lọc danh sách
                    </button>

                    @if(!empty($status) || !empty($date))
                        <a href="{{ route('doctor.consultations.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong class="text-slate-800">{{ $consultations->total() }}</strong> ca khám
                </span>
            </div>

            <!-- Bảng danh sách ca khám -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thời gian hẹn</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ / Lý do khám</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Chẩn đoán</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($consultations as $item)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="font-bold text-xs text-slate-900">{{ \Carbon\Carbon::parse($item->appointment_time)->format('H:i') }}</div>
                                        <div class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($item->appointment_time)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-slate-900 text-xs">{{ $item->patient->name ?? 'Không rõ' }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $item->patient->patient_code ?? '---' }} • {{ $item->patient->phone ?? '---' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-medium text-slate-800">{{ $item->service->name ?? 'Khám nha khoa tổng quát' }}</div>
                                        @if($item->note)
                                            <div class="text-slate-400 italic text-[11px] truncate max-w-xs">{{ $item->note }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @if($item->medicalRecord && $item->medicalRecord->diagnosis)
                                            <span class="font-medium text-slate-800">{{ Str::limit($item->medicalRecord->diagnosis, 45) }}</span>
                                        @else
                                            <span class="text-slate-400 italic">Chưa ghi chẩn đoán</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                        <div class="flex flex-col items-center gap-1">
                                            @if($item->isOverdue())
                                                <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2 py-0.5 rounded-md">
                                                    ⚠️ Quá giờ hẹn
                                                </span>
                                            @elseif($item->isDueNow())
                                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2 py-0.5 rounded-md animate-pulse">
                                                    🔔 Đến giờ hẹn
                                                </span>
                                            @endif

                                            @if($item->status === 'in_progress')
                                                <span class="bg-[#EEF2FF] text-[#3730A3] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Đang khám</span>
                                            @elseif($item->status === 'waiting')
                                                <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Đang chờ khám</span>
                                            @elseif($item->status === 'confirmed')
                                                <span class="bg-[#ECFDF5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Đã xác nhận</span>
                                            @elseif($item->status === 'pending')
                                                <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Chờ xác nhận</span>
                                            @elseif($item->status === 'completed')
                                                <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Hoàn thành</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                        @if($item->status === 'pending')
                                            <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                    ✓ Xác nhận
                                                </button>
                                            </form>
                                        @endif

                                        @if($item->status === 'waiting')
                                            <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                    Gọi vào khám &rarr;
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('doctor.consultations.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs shadow-xs transition">
                                            Mở bệnh án &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                        Chưa có ca khám nào phù hợp với bộ lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($consultations->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $consultations->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
