<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    ➕ Thêm Lịch Hẹn / Tiếp Nhận Trực Tiếp
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tạo lịch hẹn từ ngày mai hoặc tiếp nhận bệnh nhân vãng lai vào thẳng phòng chờ hôm nay</p>
            </div>
            <a href="{{ route('receptionist.appointments.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách lịch hẹn
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-4 rounded-r-xl mb-6 text-xs leading-relaxed">
                    <strong>📌 Lưu ý quy định đặt lịch:</strong> Chỉ nhận đặt lịch hẹn trước từ <strong>ngày hôm sau ({{ \Carbon\Carbon::tomorrow()->format('d/m/Y') }})</strong> trở đi. Nếu khách hàng đến khám trực tiếp trong ngày hôm nay (không cần đặt lịch trước), vui lòng chọn hình thức <em>"Khách đến khám trực tiếp trong ngày (Vào phòng chờ)"</em>.
                </div>

                <form method="POST" action="{{ route('receptionist.appointments.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Bệnh nhân <span class="text-red-500">*</span></label>
                            <select name="patient_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Chọn hồ sơ bệnh nhân --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id', $selectedPatientId ?? '') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->patient_code }} - {{ $patient->name }} ({{ $patient->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Bác sĩ phụ trách (Tùy chọn)</label>
                            <select name="doctor_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Chưa chỉ định --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        BS. {{ $doctor->user->name ?? 'N/A' }} ({{ $doctor->specialty ?? 'Đa khoa' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Hình thức tiếp nhận <span class="text-red-500">*</span></label>
                            <select name="status" id="appointment_status" onchange="toggleBookingMode(this.value)" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="confirmed" {{ old('status', 'confirmed') == 'confirmed' ? 'selected' : '' }}>📅 Đặt lịch hẹn trước (Từ ngày mai)</option>
                                <option value="waiting" {{ old('status') == 'waiting' ? 'selected' : '' }}>🏥 Khách khám trực tiếp hôm nay (Vào phòng chờ)</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Dịch vụ yêu cầu</label>
                            <select name="service_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Khám tổng quát --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Thời gian khám <span class="text-red-500">*</span></label>
                            <input type="datetime-local" id="appointment_time_input" name="appointment_time" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T00:00') }}" value="{{ old('appointment_time', \Carbon\Carbon::tomorrow()->setTime(9, 0)->format('Y-m-d\TH:i')) }}" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p id="time_hint" class="text-[11px] text-slate-500 mt-1">Đặt lịch hẹn chỉ chọn được từ ngày mai (08:00 - 20:00).</p>
                            @error('appointment_time') <span class="text-red-500 text-xs font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Ghi chú / Triệu chứng ban đầu</label>
                        <textarea name="note" rows="3" placeholder="Ví dụ: Đau răng hàm dưới, muốn lấy cao răng..." class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('receptionist.appointments.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold text-sm rounded-xl transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            Lưu Lịch Hẹn
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleBookingMode(status) {
            const input = document.getElementById('appointment_time_input');
            const hint = document.getElementById('time_hint');
            const tomorrowMin = "{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T00:00') }}";
            const tomorrowDefault = "{{ \Carbon\Carbon::tomorrow()->setTime(9, 0)->format('Y-m-d\TH:i') }}";
            const nowStr = "{{ now()->format('Y-m-d\TH:i') }}";

            if (status === 'waiting') {
                input.min = "{{ now()->format('Y-m-d\T00:00') }}";
                input.value = nowStr;
                hint.textContent = "Khách đến trực tiếp phòng khám hôm nay (đưa ngay vào hàng đợi khám).";
            } else {
                input.min = tomorrowMin;
                if (input.value < tomorrowMin) {
                    input.value = tomorrowDefault;
                }
                hint.textContent = "Đặt lịch hẹn chỉ chọn được từ ngày mai trở đi (08:00 - 20:00).";
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('appointment_status');
            if (select && select.value === 'waiting') {
                toggleBookingMode('waiting');
            }
        });
    </script>
</x-app-layout>
