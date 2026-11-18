<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết Bệnh án') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-center mb-6">HỒ SƠ BỆNH ÁN</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4 mb-4">
                        <div>
                            <p><strong>Bệnh nhân:</strong> {{ $medicalRecord->patient->name }}</p>
                            <p><strong>Mã BN:</strong> {{ $medicalRecord->patient->patient_code }}</p>
                            <p><strong>Ngày sinh:</strong> {{ $medicalRecord->patient->dob ? \Carbon\Carbon::parse($medicalRecord->patient->dob)->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p><strong>Ngày khám:</strong> {{ $medicalRecord->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Bác sĩ khám:</strong> BS. {{ $medicalRecord->doctor->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mb-6 border-b pb-4">
                        <h4 class="font-bold text-lg text-blue-800">1. Khám Lâm Sàng</h4>
                        <p class="mt-2"><strong>Triệu chứng:</strong> {{ $medicalRecord->symptoms }}</p>
                        <p class="mt-2"><strong>Chẩn đoán:</strong> {{ $medicalRecord->diagnosis }}</p>
                        <p class="mt-2"><strong>Ghi chú:</strong> {{ $medicalRecord->note ?? 'Không' }}</p>
                    </div>

                    <div class="mb-6 border-b pb-4">
                        <h4 class="font-bold text-lg text-blue-800">2. Dịch vụ Chỉ định</h4>
                        @if($medicalRecord->details->count() > 0)
                            <ul class="list-disc list-inside mt-2">
                                @foreach($medicalRecord->details as $detail)
                                    <li>{{ $detail->service->name ?? 'Dịch vụ không rõ' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 mt-2">Không có dịch vụ chỉ định thêm.</p>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-lg text-blue-800">3. Đơn thuốc</h4>
                        @if($medicalRecord->prescription && $medicalRecord->prescription->details->count() > 0)
                            <table class="min-w-full bg-white border text-sm mt-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b text-left">Tên thuốc</th>
                                        <th class="py-2 px-4 border-b text-center">Hàm lượng</th>
                                        <th class="py-2 px-4 border-b text-center">Số lượng</th>
                                        <th class="py-2 px-4 border-b text-center">Sáng</th>
                                        <th class="py-2 px-4 border-b text-center">Trưa</th>
                                        <th class="py-2 px-4 border-b text-center">Chiều</th>
                                        <th class="py-2 px-4 border-b text-center">Tối</th>
                                        <th class="py-2 px-4 border-b text-left">Cách dùng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalRecord->prescription->details as $med)
                                        <tr>
                                            <td class="py-2 px-4 border-b font-semibold">{{ $med->medicine_name }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->dosage }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->quantity }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->usage_morning }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->usage_noon }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->usage_evening }}</td>
                                            <td class="py-2 px-4 border-b text-center">{{ $med->usage_night }}</td>
                                            <td class="py-2 px-4 border-b text-left">{{ $med->instructions }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <p><strong>Lời dặn:</strong> {{ $medicalRecord->prescription->note ?? 'Không' }}</p>
                                <p class="text-red-600 font-bold mt-1"><strong>Hẹn tái khám:</strong> {{ $medicalRecord->prescription->follow_up_date ? \Carbon\Carbon::parse($medicalRecord->prescription->follow_up_date)->format('d/m/Y') : 'Không' }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 mt-2">Không kê đơn thuốc.</p>
                        @endif
                    </div>

                    <div class="text-center mt-8">
                        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold print:hidden">
                            In Hồ Sơ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
