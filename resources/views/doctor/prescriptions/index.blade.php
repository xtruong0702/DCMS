<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">💊 Danh Sách Đơn Thuốc Đã Kê</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Theo dõi các toa thuốc đã kê cho bệnh nhân trong quá trình điều trị</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition">
                &larr; Về Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Ngày kê đơn</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Bệnh nhân</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Thuốc đã kê</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Hẹn tái khám</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($prescriptions as $pres)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap font-semibold text-slate-700">
                                        {{ $pres->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-900 text-sm">{{ $pres->medicalRecord->patient->name ?? 'N/A' }}</div>
                                        <div class="text-slate-500 font-mono text-[11px]">{{ $pres->medicalRecord->patient->patient_code ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse($pres->details as $d)
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-800 border border-blue-200 rounded-md font-semibold">
                                                    {{ $d->medicine_name }} ({{ $d->quantity }} {{ $d->dosage }})
                                                </span>
                                            @empty
                                                <span class="text-gray-400 italic">Chưa thêm thuốc</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($pres->follow_up_date)
                                            <span class="font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full">
                                                {{ \Carbon\Carbon::parse($pres->follow_up_date)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">Không hẹn</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap">
                                        @if($pres->medicalRecord && $pres->medicalRecord->appointment_id)
                                            <a href="{{ route('doctor.consultations.show', $pres->medicalRecord->appointment_id) }}" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold transition">
                                                Mở ca khám &rarr;
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Chưa có đơn thuốc nào được kê.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($prescriptions->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $prescriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

