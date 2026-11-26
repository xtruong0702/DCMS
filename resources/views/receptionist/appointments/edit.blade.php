<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Cập nhật lịch hẹn #{{ $appointment->id }}
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Chỉnh sửa
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Điều chỉnh thời gian hẹn, bác sĩ phụ trách hoặc trạng thái khám của bệnh nhân</p>
            </div>
            <a href="{{ route('receptionist.appointments.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                &larr; Danh sách lịch hẹn
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden p-6 md:p-8">
                <div class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block">Thông tin Bệnh nhân</span>
                        <span class="text-sm font-bold text-slate-900">{{ $appointment->patient->name }}</span>
                        <span class="text-xs text-slate-500 ml-2">({{ $appointment->patient->patient_code }} • SĐT: {{ $appointment->patient->phone }})</span>
                    </div>
                    <div>
                        @if($appointment->isOverdue())
                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md">⚠️ Quá thời gian hẹn</span>
                        @elseif($appointment->isDueNow())
                            <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md">🔔 Đến thời gian hẹn</span>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('receptionist.appointments.update', $appointment) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Trạng thái lịch hẹn <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="waiting" {{ $appointment->status == 'waiting' ? 'selected' : '' }}>Đang chờ khám (Check-in)</option>
                                <option value="in_progress" {{ $appointment->status == 'in_progress' ? 'selected' : '' }}>Đang khám trong phòng</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                <option value="no_show" {{ $appointment->status == 'no_show' ? 'selected' : '' }}>Không đến</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Bác sĩ phụ trách</label>
                            <select name="doctor_id" class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                                <option value="">-- Chưa chỉ định --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        BS. {{ $doctor->user->name ?? 'N/A' }} ({{ $doctor->specialty ?? 'Đa khoa' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Dịch vụ khám</label>
                            <select name="service_id" class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                                <option value="">-- Khám tổng quát --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Thời gian khám <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d\TH:i')) }}" class="w-full rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]" required>
                            @error('appointment_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ghi chú</label>
                        <textarea name="note" rows="3" class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">{{ old('note', $appointment->note) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('receptionist.appointments.index') }}" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                            Lưu Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
