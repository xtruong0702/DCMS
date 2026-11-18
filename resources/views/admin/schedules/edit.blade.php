<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa Lịch Trực') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Chọn Bác sĩ <span class="text-red-500">*</span></label>
                            <select name="doctor_id" id="doctor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        BS. {{ $doctor->user->name ?? 'Không rõ' }} ({{ $doctor->specialty ?? 'Đa khoa' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Ngày Trực <span class="text-red-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date', $schedule->date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="shift" class="block text-sm font-medium text-gray-700">Ca Làm Việc <span class="text-red-500">*</span></label>
                                <select name="shift" id="shift" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="updateTimes()">
                                    <option value="morning" {{ old('shift', $schedule->shift) == 'morning' ? 'selected' : '' }}>Sáng (08:00 - 12:00)</option>
                                    <option value="afternoon" {{ old('shift', $schedule->shift) == 'afternoon' ? 'selected' : '' }}>Chiều (13:30 - 17:30)</option>
                                    <option value="evening" {{ old('shift', $schedule->shift) == 'evening' ? 'selected' : '' }}>Tối (18:00 - 20:30)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Giờ Bắt Đầu <span class="text-red-500">*</span></label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Giờ Kết Thúc <span class="text-red-500">*</span></label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="available" {{ old('status', $schedule->status) == 'available' ? 'selected' : '' }}>Sẵn sàng nhận khám</option>
                                <option value="booked" {{ old('status', $schedule->status) == 'booked' ? 'selected' : '' }}>Đã có lịch hẹn (Kín)</option>
                                <option value="time_off" {{ old('status', $schedule->status) == 'time_off' ? 'selected' : '' }}>Nghỉ phép (Báo bận)</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function updateTimes() {
            // Only update if user explicitly changes the shift, we don't auto update on page load for edit
            const shift = document.getElementById('shift').value;
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');
            
            if(shift === 'morning') {
                startTime.value = '08:00';
                endTime.value = '12:00';
            } else if (shift === 'afternoon') {
                startTime.value = '13:30';
                endTime.value = '17:30';
            } else if (shift === 'evening') {
                startTime.value = '18:00';
                endTime.value = '20:30';
            }
        }
    </script>
</x-app-layout>
