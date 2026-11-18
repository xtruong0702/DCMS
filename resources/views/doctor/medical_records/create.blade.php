<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Phiếu Khám Bệnh - BN: ') }} {{ $appointment->patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-gray-50 border-b">
                    <p><strong>Mã BN:</strong> {{ $appointment->patient->patient_code }} | <strong>SĐT:</strong> {{ $appointment->patient->phone }}</p>
                    <p><strong>Dị ứng thuốc:</strong> <span class="text-red-500 font-bold">{{ $appointment->patient->allergy_history ?: 'Không có' }}</span></p>
                    <p><strong>Tiền sử bệnh lý:</strong> {{ $appointment->patient->medical_history ?: 'Không có' }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('doctor.medical_records.store') }}">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                        <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">

                        <h3 class="text-lg font-bold border-b pb-2 mb-4">1. Khám Lâm Sàng</h3>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Triệu chứng (Lý do khám) *</label>
                            <textarea name="symptoms" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('symptoms', $appointment->note) }}</textarea>
                            @error('symptoms') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Chẩn đoán bệnh *</label>
                            <textarea name="diagnosis" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('diagnosis') }}</textarea>
                            @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ghi chú thêm</label>
                            <textarea name="note" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('note') }}</textarea>
                        </div>

                        <h3 class="text-lg font-bold border-b pb-2 mt-8 mb-4">2. Chỉ Định Dịch Vụ</h3>
                        <div class="mb-4">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($services as $service)
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-checkbox text-blue-600"
                                                {{ ($appointment->service_id == $service->id) ? 'checked' : '' }}>
                                            <span class="ml-2">{{ $service->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h3 class="text-lg font-bold border-b pb-2 mt-8 mb-4">3. Kê Đơn Thuốc</h3>
                        <div class="mb-4">
                            <table class="min-w-full bg-white border text-sm mb-2" id="medicineTable">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-2 border-b">Tên Thuốc</th>
                                        <th class="py-2 px-2 border-b">Hàm lượng</th>
                                        <th class="py-2 px-2 border-b">Số lượng</th>
                                        <th class="py-2 px-2 border-b">Sáng</th>
                                        <th class="py-2 px-2 border-b">Trưa</th>
                                        <th class="py-2 px-2 border-b">Chiều</th>
                                        <th class="py-2 px-2 border-b">Tối</th>
                                        <th class="py-2 px-2 border-b">Ghi chú (Cách dùng)</th>
                                        <th class="py-2 px-2 border-b">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][name]" class="w-full border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][dosage]" class="w-full border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="number" name="medicines[0][quantity]" class="w-20 border p-1 rounded" value="1"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][morning]" class="w-12 border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][noon]" class="w-12 border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][evening]" class="w-12 border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][night]" class="w-12 border p-1 rounded"></td>
                                        <td class="p-1 border-b"><input type="text" name="medicines[0][instructions]" class="w-full border p-1 rounded" placeholder="VD: Sau ăn"></td>
                                        <td class="p-1 border-b text-center"><button type="button" class="text-red-500 font-bold" onclick="removeMedRow(this)">X</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" onclick="addMedRow()" class="text-blue-500 text-sm font-semibold hover:underline">+ Thêm thuốc</button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Ngày Tái Khám (Nếu có)</label>
                                <input type="date" name="follow_up_date" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Lời dặn dò</label>
                                <textarea name="prescription_note" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 border-t pt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline text-lg w-full md:w-auto">Hoàn tất Khám bệnh</button>
                            <a href="{{ route('doctor.dashboard') }}" class="text-gray-500 hover:text-gray-700 ml-4">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let medIndex = 1;
        function addMedRow() {
            const table = document.getElementById('medicineTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][name]" class="w-full border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][dosage]" class="w-full border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="number" name="medicines[${medIndex}][quantity]" class="w-20 border p-1 rounded" value="1"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][morning]" class="w-12 border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][noon]" class="w-12 border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][evening]" class="w-12 border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][night]" class="w-12 border p-1 rounded"></td>
                <td class="p-1 border-b"><input type="text" name="medicines[${medIndex}][instructions]" class="w-full border p-1 rounded" placeholder="VD: Sau ăn"></td>
                <td class="p-1 border-b text-center"><button type="button" class="text-red-500 font-bold" onclick="removeMedRow(this)">X</button></td>
            `;
            medIndex++;
        }
        function removeMedRow(btn) {
            const row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</x-app-layout>
