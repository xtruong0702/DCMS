<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl text-slate-900 tracking-tight">Phân Lịch Trực Bác Sĩ</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Lịch công tác chuyên môn • Hôm nay: {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Quản lý ca trực sáng / chiều / tối của đội ngũ Bác sĩ, đồng bộ lịch khám tiếp đón & đặt lịch hẹn</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.schedules.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>+ Xếp Lịch Mới</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.schedules.index') }}" method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-2.5">
                <select name="doctor_id" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68] py-1.5">
                    <option value="">-- Tất cả bác sĩ --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            BS. {{ $doctor->user->name ?? 'Không rõ' }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68] py-1.5">
                <button type="submit" class="px-4 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                    Lọc lịch
                </button>
                @if(request('doctor_id') || request('date'))
                    <a href="{{ route('admin.schedules.index') }}" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition">
                        Xóa lọc
                    </a>
                @endif
            </form>

            <span class="text-xs text-slate-500 font-medium">
                Tổng cộng: <strong class="text-slate-900 font-bold">{{ $schedules->total() }}</strong> ca trực
            </span>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-2.5 px-5">Bác sĩ</th>
                            <th class="py-2.5 px-5">Ngày trực</th>
                            <th class="py-2.5 px-5">Ca làm việc</th>
                            <th class="py-2.5 px-5">Thời gian</th>
                            <th class="py-2.5 px-5">Trạng thái</th>
                            <th class="py-2.5 px-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($schedules as $schedule)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-5">
                                    <div class="font-bold text-slate-900 text-xs">
                                        BS. {{ $schedule->doctor->user->name ?? 'Không rõ' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $schedule->doctor->specialty ?? 'Răng Hàm Mặt' }}</div>
                                </td>
                                <td class="py-3 px-5 font-bold text-[#0D7A68]">
                                    {{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}
                                </td>
                                <td class="py-3 px-5 text-slate-800 font-medium">
                                    @if($schedule->shift == 'morning') Ca Sáng
                                    @elseif($schedule->shift == 'afternoon') Ca Chiều
                                    @else Ca Tối
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>
                                <td class="py-3 px-5">
                                    @if($schedule->status == 'available')
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Sẵn sàng</span>
                                    @elseif($schedule->status == 'booked')
                                        <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Đã có lịch hẹn</span>
                                    @else
                                        <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">Nghỉ phép</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-right space-x-1.5">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="px-2.5 py-1 bg-white hover:bg-slate-50 text-[#0D7A68] border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Sửa</a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch trực này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                                    Không tìm thấy lịch trực nào theo điều kiện lọc.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($schedules->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                    {{ $schedules->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
