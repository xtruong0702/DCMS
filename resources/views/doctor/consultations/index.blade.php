<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">🩺 Danh Sách Ca Khám & Điều Trị</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Quản lý các ca khám đang thực hiện, bệnh nhân chờ khám và lịch sử điều trị</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('doctor.queue.index') }}" class="px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-bold transition">
                    ⏳ Hàng đợi phòng khám
                </a>
                <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition">
                    &larr; Bảng điều khiển
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Bộ lọc ca khám -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('doctor.consultations.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <select name="status" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="in_progress" {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>🩺 Đang khám trong phòng</option>
                        <option value="waiting" {{ ($status ?? '') === 'waiting' ? 'selected' : '' }}>⏳ Đang chờ tại sảnh</option>
                        <option value="confirmed" {{ ($status ?? '') === 'confirmed' ? 'selected' : '' }}>✓ Bác sĩ đã xác nhận</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>🕒 Chờ xác nhận</option>
                        <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>✅ Đã hoàn thành</option>
                    </select>

                    <input type="date" name="date" value="{{ $date ?? '' }}" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">

                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                        Lọc danh sách
                    </button>

                    @if(!empty($status) || !empty($date))
                        <a href="{{ route('doctor.consultations.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng cộng: <strong>{{ $consultations->total() }}</strong> ca khám
                </span>
            </div>

            <!-- Bảng danh sách ca khám -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Thời gian hẹn</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bệnh nhân</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Dịch vụ / Lý do khám</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Chẩn đoán</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Trạng thái</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($consultations as $item)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="font-extrabold text-indigo-700 text-sm">{{ \Carbon\Carbon::parse($item->appointment_time)->format('H:i') }}</div>
                                        <div class="text-slate-500">{{ \Carbon\Carbon::parse($item->appointment_time)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-900 text-sm">{{ $item->patient->name ?? 'Không rõ' }}</div>
                                        <div class="text-slate-500 font-mono text-[11px]">{{ $item->patient->patient_code ?? '---' }} • {{ $item->patient->phone ?? '---' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-800">{{ $item->service->name ?? 'Khám nha khoa tổng quát' }}</div>
                                        @if($item->note)
                                            <div class="text-slate-500 italic truncate max-w-xs">{{ $item->note }}</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($item->medicalRecord && $item->medicalRecord->diagnosis)
                                            <span class="font-semibold text-indigo-900">{{ Str::limit($item->medicalRecord->diagnosis, 45) }}</span>
                                        @else
                                            <span class="text-gray-400 italic">Chưa ghi chẩn đoán</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <div class="flex flex-col items-center gap-1">
                                            @if($item->isOverdue())
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-red-100 text-red-700 border border-red-300">
                                                    ⚠️ Quá thời gian hẹn
                                                </span>
                                            @elseif($item->isDueNow())
                                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                                    🔔 Đến thời gian hẹn
                                                </span>
                                            @endif

                                            @if($item->status === 'in_progress')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">🩺 Đang khám</span>
                                            @elseif($item->status === 'waiting')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">⏳ Đang chờ khám</span>
                                            @elseif($item->status === 'confirmed')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">✓ Đã xác nhận</span>
                                            @elseif($item->status === 'pending')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Chờ xác nhận</span>
                                            @elseif($item->status === 'completed')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">✓ Hoàn thành</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                        @if($item->status === 'pending')
                                            <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                    ✓ Xác nhận lịch
                                                </button>
                                            </form>
                                        @endif

                                        @if($item->status === 'waiting')
                                            <form action="{{ route('doctor.consultations.update', $item->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                    Gọi vào khám &rarr;
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('doctor.consultations.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold text-xs transition">
                                            Mở bệnh án &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Chưa có ca khám nào phù hợp với bộ lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($consultations->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $consultations->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

