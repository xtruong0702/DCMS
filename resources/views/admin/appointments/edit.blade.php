<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cập nhật Trạng thái Lịch Hẹn') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Cột trái -->
                            <div>
                                <div class="mb-4">
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Bệnh nhân <span class="text-red-500">*</span></label>
                                    <select name="patient_id" id="patient_id" required class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} ({{ $patient->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Bác sĩ phụ trách</label>
                                    <select name="doctor_id" id="doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Chọn bác sĩ (Không bắt buộc) --</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                                            <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
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
                                        <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="appointment_time" class="block text-sm font-medium text-gray-700">Giờ hẹn <span class="text-red-500">*</span></label>
                                        <input type="time" name="appointment_time" id="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('appointment_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="mb-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <label for="status" class="block text-sm font-bold text-gray-800 mb-2">Trạng thái Cuộc Hẹn <span class="text-red-500">*</span></label>
                                    <select name="status" id="status" required class="mt-1 block w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-semibold">
                                        <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                        <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                        <option value="waiting" {{ old('status', $appointment->status) == 'waiting' ? 'selected' : '' }}>Đang chờ khám (Khách đã đến)</option>
                                        <option value="in_progress" {{ old('status', $appointment->status) == 'in_progress' ? 'selected' : '' }}>Đang khám</option>
                                        <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                        <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        <option value="no_show" {{ old('status', $appointment->status) == 'no_show' ? 'selected' : '' }}>Không đến</option>
                                    </select>
                                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú (Dành cho Lễ tân/Bác sĩ)</label>
                                    <textarea name="note" id="note" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('note', $appointment->note) }}</textarea>
                                    @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Cập nhật Trạng thái</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
