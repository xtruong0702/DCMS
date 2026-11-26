<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Danh sách đơn thuốc đã kê
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Đơn thuốc
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Theo dõi các toa thuốc đã kê cho bệnh nhân trong quá trình điều trị</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                &larr; Tổng quan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ngày kê đơn</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bệnh nhân</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thuốc đã kê</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hẹn tái khám</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($prescriptions as $pres)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap font-medium text-slate-700">
                                        {{ $pres->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="font-bold text-slate-900 text-xs">{{ $pres->medicalRecord->patient->name ?? 'N/A' }}</div>
                                        <div class="text-slate-400 font-mono text-[11px]">{{ $pres->medicalRecord->patient->patient_code ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse($pres->details as $d)
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-800 border border-slate-200 rounded-md font-medium text-[11px]">
                                                    {{ $d->medicine_name }} ({{ $d->quantity }} {{ $d->dosage }})
                                                </span>
                                            @empty
                                                <span class="text-slate-400 italic">Chưa thêm thuốc</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        @if($pres->follow_up_date)
                                            <span class="bg-[#FFFBEB] text-[#B45309] font-bold text-[11px] px-2.5 py-0.5 rounded-md">
                                                {{ \Carbon\Carbon::parse($pres->follow_up_date)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">Không hẹn</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                        @if($pres->medicalRecord && $pres->medicalRecord->appointment_id)
                                            <a href="{{ route('doctor.consultations.show', $pres->medicalRecord->appointment_id) }}" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                                Mở ca khám &rarr;
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs">
                                        Chưa có đơn thuốc nào được kê.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($prescriptions->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $prescriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
