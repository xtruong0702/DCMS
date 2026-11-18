<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    ✏️ Cập Nhật Lịch Hẹn #{{ $appointment->id }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">Điều chỉnh thời gian hẹn, bác sĩ phụ trách hoặc trạng thái khám của bệnh nhân</p>
            </div>
            <a href="{{ route('receptionist.appointments.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách lịch hẹn
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
                <div class="mb-6 bg-indigo-50/70 p-4 rounded-xl border border-indigo-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <span class="text-xs font-bold uppercase text-indigo-600 block">Thông tin Bệnh nhân</span>
                        <span class="text-base font-extrabold text-slate-900">{{ $appointment->patient->name }}</span>
                        <span class="text-xs text-slate-600 ml-2">({{ $appointment->patient->patient_code }} • SĐT: {{ $appointment->patient->phone }})</span>
                    </div>
                    <div>
                        @if($appointment->isOverdue())
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-300">⚠️ Quá thời gian hẹn</span>
                        @elseif($appointment->isDueNow())
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300">🔔 Đến thời gian hẹn</span>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('receptionist.appointments.update', $appointment) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Trạng thái lịch hẹn <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>🕒 Chờ xác nhận</option>
                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>✓ Đã xác nhận</option>
                                <option value="waiting" {{ $appointment->status == 'waiting' ? 'selected' : '' }}>⏳ Đang chờ khám (Check-in)</option>
                                <option value="in_progress" {{ $appointment->status == 'in_progress' ? 'selected' : '' }}>🩺 Đang khám trong phòng</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>✕ Đã hủy</option>
                                <option value="no_show" {{ $appointment->status == 'no_show' ? 'selected' : '' }}>⚠️ Không đến</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Bác sĩ phụ trách</label>
                            <select name="doctor_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Dịch vụ khám</label>
                            <select name="service_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Khám tổng quát --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Thời gian khám <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d\TH:i')) }}" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('appointment_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Ghi chú</label>
                        <textarea name="note" rows="3" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('note', $appointment->note) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('receptionist.appointments.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-sm rounded-xl transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            Lưu Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
