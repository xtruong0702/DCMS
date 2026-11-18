<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đặt Lịch Hẹn Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-r mb-6 text-sm">
                        <strong>Lưu ý quy định đặt lịch:</strong> Chỉ nhận đặt lịch hẹn trước từ <strong>ngày hôm sau ({{ \Carbon\Carbon::tomorrow()->format('d/m/Y') }})</strong> trở đi. Nếu khách hàng đến khám trực tiếp trong ngày hôm nay (không cần đặt lịch), vui lòng chọn trạng thái <em>"Đang chờ khám (Khách đang ở phòng khám)"</em>.
                    </div>

                    <form action="{{ route('admin.appointments.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Cột trái -->
                            <div>
                                <div class="mb-4">
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Bệnh nhân <span class="text-red-500">*</span></label>
                                    <select name="patient_id" id="patient_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Chọn bệnh nhân --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} ({{ $patient->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1"><a href="{{ route('admin.patients.create') }}" class="text-indigo-600 hover:underline">Chưa có hồ sơ? Tạo mới tại đây.</a></p>
                                    @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Bác sĩ phụ trách</label>
                                    <select name="doctor_id" id="doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Chọn bác sĩ (Không bắt buộc) --</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                BS. {{ $doctor->user->name ?? 'Không rõ' }} ({{ $doctor->specialty ?? 'Đa khoa' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="service_id" class="block text-sm font-medium text-gray-700">Dịch vụ yêu cầu</label>
                                    <select name="service_id" id="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Khám tổng quát (Mặc định) --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <!-- Cột phải -->
                            <div>
                                <div class="mb-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="appointment_date" class="block text-sm font-medium text-gray-700">Ngày hẹn <span class="text-red-500">*</span></label>
                                        <input type="date" name="appointment_date" id="appointment_date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" value="{{ old('appointment_date', \Carbon\Carbon::tomorrow()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="appointment_time" class="block text-sm font-medium text-gray-700">Giờ hẹn <span class="text-red-500">*</span></label>
                                        <input type="time" name="appointment_time" id="appointment_time" value="{{ old('appointment_time', '09:00') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('appointment_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                                    <select name="status" id="status" onchange="toggleAdminBookingDate(this.value)" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận (Đặt lịch từ ngày mai)</option>
                                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận (Đặt lịch từ ngày mai)</option>
                                        <option value="waiting" {{ old('status') == 'waiting' ? 'selected' : '' }}>Đang chờ khám (Khách đến trực tiếp trong ngày)</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Đang khám</option>
                                    </select>
                                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <script>
                                    function toggleAdminBookingDate(status) {
                                        const dateInput = document.getElementById('appointment_date');
                                        const tomorrow = "{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}";
                                        const today = "{{ date('Y-m-d') }}";
                                        if (status === 'waiting' || status === 'in_progress') {
                                            dateInput.min = today;
                                            dateInput.value = today;
                                        } else {
                                            dateInput.min = tomorrow;
                                            if (dateInput.value < tomorrow) {
                                                dateInput.value = tomorrow;
                                            }
                                        }
                                    }
                                </script>
                                <div class="mb-4">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú (Dành cho Lễ tân/Bác sĩ)</label>
                                    <textarea name="note" id="note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('note') }}</textarea>
                                    @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Tạo Lịch Hẹn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
