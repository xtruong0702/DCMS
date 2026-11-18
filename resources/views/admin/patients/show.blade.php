<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    👤 Hồ Sơ Bệnh Nhân & Đơn Thuốc: <span class="text-indigo-600">{{ $patient->name }}</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Mã BN: {{ $patient->patient_code }} • Điện thoại: {{ $patient->phone }}</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.patients.edit', $patient) }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    ✏️ Chỉnh sửa hồ sơ
                </a>
                <a href="{{ route('admin.patients.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    &larr; Quay lại danh sách
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin cá nhân -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold uppercase text-indigo-700 border-b border-gray-100 pb-3 mb-4">Thông tin hành chính</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-slate-400 block">Mã bệnh nhân</span>
                            <span class="font-mono font-bold text-slate-900">{{ $patient->patient_code }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Số điện thoại</span>
                            <span class="font-bold text-slate-900">{{ $patient->phone }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Ngày sinh</span>
                            <span class="font-semibold text-slate-800">{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Giới tính</span>
                            <span class="font-semibold text-slate-800">{{ $patient->gender ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-xs text-slate-400 block">Địa chỉ</span>
                            <span class="font-semibold text-slate-800">{{ $patient->address ?? '---' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tiền sử y khoa -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="text-sm font-bold uppercase text-indigo-700 border-b border-gray-100 pb-3">Tiền sử y khoa & Cảnh báo</h3>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <span class="text-xs font-bold uppercase text-red-700 block mb-1">⚠️ Dị ứng thuốc / Vật liệu</span>
                        <p class="text-sm font-semibold text-red-900">{{ $patient->allergy_history ?: 'Không ghi nhận tiền sử dị ứng' }}</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <span class="text-xs font-bold uppercase text-amber-800 block mb-1">🩺 Tiền sử bệnh lý nền</span>
                        <p class="text-sm font-semibold text-amber-900">{{ $patient->medical_history ?: 'Không ghi nhận bệnh lý nền' }}</p>
                    </div>
                </div>
            </div>

            <!-- Lịch sử khám bệnh & Đơn thuốc Bác sĩ đã kê -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-gray-200">
                    <h3 class="text-sm font-bold uppercase text-slate-700">📋 Lịch sử khám bệnh & Đơn thuốc Bác sĩ đã kê ({{ $patient->medicalRecords->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left font-bold text-slate-600 uppercase">Ngày khám</th>
                                <th class="px-5 py-3 text-left font-bold text-slate-600 uppercase">Bác sĩ điều trị</th>
                                <th class="px-5 py-3 text-left font-bold text-slate-600 uppercase">Triệu chứng & Chẩn đoán</th>
                                <th class="px-5 py-3 text-left font-bold text-slate-600 uppercase">💊 Đơn thuốc Bác sĩ đã kê</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($patient->medicalRecords as $record)
                                <tr class="hover:bg-gray-50 align-top">
                                    <td class="px-5 py-3.5 font-semibold text-indigo-700 whitespace-nowrap">{{ $record->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-5 py-3.5 font-bold text-slate-800 whitespace-nowrap">BS. {{ $record->doctor->user->name ?? 'Chuyên khoa' }}</td>
                                    <td class="px-5 py-3.5">
                                        <p class="text-slate-600"><span class="font-semibold text-slate-500">Triệu chứng:</span> {{ $record->symptoms ?? '---' }}</p>
                                        <p class="font-bold text-slate-900 mt-1"><span class="font-semibold text-slate-500">Chẩn đoán:</span> {{ $record->diagnosis ?? '---' }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($record->prescription && $record->prescription->details && $record->prescription->details->count() > 0)
                                            <div class="space-y-1.5 bg-emerald-50/60 p-2.5 rounded-xl border border-emerald-200/70">
                                                @foreach($record->prescription->details as $pDetail)
                                                    <div class="text-xs">
                                                        <span class="font-extrabold text-emerald-900">• {{ $pDetail->medicine_name }}</span>
                                                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px] ml-1">SL: {{ $pDetail->quantity }}</span>
                                                        <div class="text-[11px] text-slate-600 pl-2.5">
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
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">Chưa có lịch sử khám bệnh.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

