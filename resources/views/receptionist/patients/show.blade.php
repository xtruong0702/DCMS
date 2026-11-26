<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Hồ sơ bệnh nhân: <span class="text-[#0D7A68]">{{ $patient->name }}</span>
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        {{ $patient->patient_code }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">SĐT: {{ $patient->phone }} • Giới tính: {{ $patient->gender ?? '---' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.patients.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    &larr; Quay lại
                </a>
                <a href="{{ route('receptionist.patients.edit', $patient) }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>✏️ Chỉnh sửa hồ sơ</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin cá nhân -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-3 mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Thông tin cá nhân</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block">Mã bệnh nhân</span>
                            <span class="font-mono font-bold text-slate-900 text-sm">{{ $patient->patient_code }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Số điện thoại</span>
                            <span class="font-bold text-slate-900 text-sm">{{ $patient->phone }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Ngày sinh</span>
                            <span class="font-medium text-slate-800">{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Giới tính</span>
                            <span class="font-medium text-slate-800">{{ $patient->gender ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Nghề nghiệp</span>
                            <span class="font-medium text-slate-800">{{ $patient->job ?? '---' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Người liên hệ</span>
                            <span class="font-medium text-slate-800">{{ $patient->contact_person ?? '---' }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-slate-400 block">Địa chỉ</span>
                            <span class="font-medium text-slate-800">{{ $patient->address ?? '---' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tiền sử y khoa -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Tiền sử y khoa & Cảnh báo</h3>
                    </div>
                    <div class="bg-red-50/50 border border-red-200/80 rounded-xl p-3.5">
                        <span class="text-[11px] font-bold uppercase text-red-700 block mb-1">⚠️ Dị ứng thuốc / Vật liệu</span>
                        <p class="text-xs font-semibold text-red-900">{{ $patient->allergy_history ?: 'Không ghi nhận tiền sử dị ứng' }}</p>
                    </div>
                    <div class="bg-amber-50/50 border border-amber-200/80 rounded-xl p-3.5">
                        <span class="text-[11px] font-bold uppercase text-amber-800 block mb-1">🩺 Tiền sử bệnh lý nền</span>
                        <p class="text-xs font-semibold text-amber-900">{{ $patient->medical_history ?: 'Không ghi nhận bệnh lý nền' }}</p>
                    </div>
                </div>
            </div>

            <!-- Lịch sử khám bệnh & Đơn thuốc Bác sĩ đã kê -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        <h3 class="text-sm font-bold text-slate-900">Lịch sử khám bệnh & Đơn thuốc ({{ $patient->medicalRecords->count() }})</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ngày khám</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bác sĩ điều trị</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Triệu chứng & Chẩn đoán</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">💊 Đơn thuốc Bác sĩ đã kê</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($patient->medicalRecords as $record)
                                <tr class="hover:bg-slate-50/70 align-top transition">
                                    <td class="px-4 py-3.5 font-bold text-[#0D7A68] whitespace-nowrap">{{ $record->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800 whitespace-nowrap">BS. {{ $record->doctor->user->name ?? 'Chuyên khoa' }}</td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-600"><span class="font-medium text-slate-400">Triệu chứng:</span> {{ $record->symptoms ?? '---' }}</p>
                                        <p class="font-bold text-slate-900 mt-1"><span class="font-medium text-slate-400">Chẩn đoán:</span> {{ $record->diagnosis ?? '---' }}</p>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @if($record->prescription && $record->prescription->details && $record->prescription->details->count() > 0)
                                            <div class="space-y-1.5 bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-200/60">
                                                @foreach($record->prescription->details as $pDetail)
                                                    <div class="text-xs">
                                                        <span class="font-bold text-emerald-950">• {{ $pDetail->medicine_name }}</span>
                                                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px] ml-1">SL: {{ $pDetail->quantity }}</span>
                                                        <div class="text-[11px] text-slate-500 pl-2.5">
                                                            Liều: {{ $pDetail->dosage ?: 'Theo chỉ định' }} — {{ $pDetail->instructions ?: 'Uống sau ăn' }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if(!empty($record->prescription->notes))
                                                    <div class="text-[11px] text-emerald-800 pt-1 border-t border-emerald-200/60">
                                                        <strong>Lời dặn:</strong> {{ $record->prescription->notes }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic">Không kê đơn thuốc</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">Chưa có lịch sử khám bệnh.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
