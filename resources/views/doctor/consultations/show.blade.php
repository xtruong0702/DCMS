<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Khám bệnh: <span class="text-[#0D7A68]">{{ $appointment->patient->name }}</span>
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60 font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        {{ $appointment->patient->patient_code }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Giờ hẹn: <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i - d/m/Y') }}</span>
                    @if($appointment->service)
                        • Dịch vụ đăng ký: <span class="font-semibold text-[#0D7A68]">{{ $appointment->service->name }}</span>
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    &larr; Tổng quan
                </a>
                @if($appointment->status !== 'completed')
                    <form action="{{ route('doctor.consultations.complete', $appointment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn kết thúc ca khám này và chuyển bệnh nhân sang bước thanh toán?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                            <span>✓ Hoàn Thành Ca Khám</span>
                        </button>
                    </form>
                @else
                    <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-3 py-1.5 rounded-xl border border-emerald-200 flex items-center gap-1">
                        ✓ Ca khám đã hoàn thành
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between" role="alert">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between" role="alert">
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Cột trái: Thông tin Bệnh nhân (1/3) -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                                Hồ Sơ Bệnh Nhân
                            </h3>
                        </div>
                        <div class="p-6 space-y-4 text-xs">
                            <div>
                                <span class="text-slate-400 text-[11px] uppercase font-bold block">Họ và tên</span>
                                <span class="font-bold text-base text-slate-900">{{ $appointment->patient->name }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                                <div>
                                    <span class="text-slate-400 block">Mã BN:</span>
                                    <span class="font-mono font-bold text-slate-900">{{ $appointment->patient->patient_code }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Năm sinh:</span>
                                    <span class="font-medium text-slate-800">{{ $appointment->patient->dob ? \Carbon\Carbon::parse($appointment->patient->dob)->format('d/m/Y') : 'Chưa rõ' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Giới tính:</span>
                                    <span class="font-medium text-slate-800">{{ $appointment->patient->gender ?: 'Chưa rõ' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Điện thoại:</span>
                                    <span class="font-medium text-slate-800">{{ $appointment->patient->phone ?: '---' }}</span>
                                </div>
                            </div>

                            <!-- Cảnh báo tiền sử & Cập nhật nhanh -->
                            <div class="pt-3 border-t border-gray-100 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold uppercase text-gray-600">An toàn y khoa</span>
                                    <button type="button" onclick="document.getElementById('quickHistoryForm').classList.toggle('hidden')" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                        ✏️ Cập nhật Dị ứng / Bệnh nền
                                    </button>
                                </div>

                                <div class="bg-red-50 border {{ $appointment->patient->allergy_history ? 'border-red-400 ring-2 ring-red-100' : 'border-red-200' }} rounded-lg p-3">
                                    <span class="text-red-700 text-xs font-bold uppercase flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        ⚠️ Tiền sử Dị ứng thuốc / Dị nguyên:
                                    </span>
                                    <p class="font-medium text-xs mt-1 {{ $appointment->patient->allergy_history ? 'text-red-700 font-extrabold' : 'text-gray-500 italic' }}">
                                        {{ $appointment->patient->allergy_history ?: 'Không có tiền sử dị ứng ghi nhận' }}
                                    </p>
                                </div>

                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                                    <span class="text-amber-700 text-xs font-bold uppercase flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        🩺 Bệnh lý nền:
                                    </span>
                                    <p class="font-medium text-xs mt-1 {{ $appointment->patient->medical_history ? 'text-amber-900 font-bold' : 'text-gray-500 italic' }}">
                                        {{ $appointment->patient->medical_history ?: 'Không có bệnh lý nền ghi nhận' }}
                                    </p>
                                </div>

                                <!-- Form cập nhật nhanh Dị ứng & Bệnh nền -->
                                <form id="quickHistoryForm" action="{{ route('doctor.medical-records.update', $medicalRecord->id) }}" method="POST" class="hidden bg-slate-50 p-3.5 rounded-xl border border-indigo-200 space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="update_patient_history_only" value="1">
                                    <div>
                                        <label class="block text-[11px] font-bold uppercase text-red-700 mb-1">Tiền sử dị ứng thuốc (Ngăn cách bằng dấu phẩy)</label>
                                        <input type="text" name="allergy_history" value="{{ $appointment->patient->allergy_history }}" placeholder="VD: Amoxicillin, Penicillin, Ibuprofen, Lidocain..." class="w-full rounded-lg border-red-300 text-xs focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold uppercase text-amber-800 mb-1">Bệnh lý nền cần lưu ý</label>
                                        <input type="text" name="medical_history" value="{{ $appointment->patient->medical_history }}" placeholder="VD: Cao huyết áp, Tiểu đường tuýp 2, Tim mạch..." class="w-full rounded-lg border-amber-300 text-xs focus:border-amber-500 focus:ring-amber-500">
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('quickHistoryForm').classList.add('hidden')" class="px-2.5 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-xs font-bold">Đóng</button>
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-xs font-bold shadow-sm">Lưu Cảnh Báo</button>
                                    </div>
                                </form>
                            </div>

                            <div class="pt-2 border-t border-gray-100 text-xs text-gray-500">
                                <span class="font-semibold text-gray-700">Ghi chú cuộc hẹn:</span>
                                <p class="mt-0.5 italic text-gray-600">{{ $appointment->note ?: 'Không có ghi chú' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng Tạm tính Chi phí Ca khám (Real-time sync với Hóa đơn Thu ngân) -->
                    @php
                        $mainServiceCost = $appointment->service ? floatval($appointment->service->price) : 0;
                        $extraServiceCost = 0;
                        foreach ($medicalRecord->details as $dItem) {
                            if ($dItem->service) {
                                $extraServiceCost += floatval($dItem->service->price) * max(1, intval($dItem->quantity));
                            }
                        }
                        $medsCost = 0;
                        foreach ($prescription->details as $pItem) {
                            $mPrice = ($pItem->medicine && $pItem->medicine->price > 0) ? floatval($pItem->medicine->price) : 15000;
                            $medsCost += $mPrice * max(1, intval($pItem->quantity));
                        }
                        $estimatedTotal = $mainServiceCost + $extraServiceCost + $medsCost;
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-white">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                                    Tạm Tính Chi Phí Ca Khám
                                </h3>
                            </div>
                            <span class="text-[11px] bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full font-semibold">Đồng bộ Thu ngân</span>
                        </div>
                        <div class="p-4 space-y-2.5 text-xs">
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Dịch vụ đăng ký ban đầu:</span>
                                <span class="font-bold text-slate-900">{{ number_format($mainServiceCost, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Thủ thuật chỉ định thêm ({{ $medicalRecord->details->count() }}):</span>
                                <span class="font-bold text-slate-900">{{ number_format($extraServiceCost, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Đơn thuốc kê kèm ({{ $prescription->details->count() }}):</span>
                                <span class="font-bold text-slate-900">{{ number_format($medsCost, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="pt-2.5 border-t border-slate-200 flex justify-between items-center">
                                <span class="font-bold uppercase text-slate-900">Tổng tạm tính:</span>
                                <span class="font-bold text-base text-slate-900">{{ number_format($estimatedTotal, 0, ',', '.') }} đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: 4 Tabs (Bệnh án, Sơ đồ răng, Đơn thuốc, Vật tư tiêu hao) (2/3) -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                        
                        <!-- Header Tabs Navigation -->
                        <div class="border-b border-slate-100 bg-slate-50/50">
                            <nav class="flex overflow-x-auto text-xs font-semibold" aria-label="Tabs">
                                <button onclick="switchTab('tab-record')" id="btn-record" class="tab-btn px-5 py-3.5 border-b-2 text-[#0D7A68] border-[#0D7A68] bg-white font-bold flex items-center gap-2 whitespace-nowrap">
                                    <span>📋</span> 1. Bệnh Án Điện Tử
                                </button>
                                <button onclick="switchTab('tab-odontogram')" id="btn-odontogram" class="tab-btn px-5 py-3.5 border-b-2 text-slate-600 border-transparent hover:text-[#0D7A68] hover:border-slate-300 flex items-center gap-2 whitespace-nowrap">
                                    <span>🦷</span> 2. Sơ Đồ Răng (Odontogram)
                                </button>
                                <button onclick="switchTab('tab-prescription')" id="btn-prescription" class="tab-btn px-5 py-3.5 border-b-2 text-slate-600 border-transparent hover:text-[#0D7A68] hover:border-slate-300 flex items-center gap-2 whitespace-nowrap">
                                    <span>💊</span> 3. Đơn Thuốc
                                    @if($prescription->details->count() > 0)
                                        <span class="bg-[#D1FAE5] text-[#065F46] text-[10px] px-2 py-0.5 rounded-full font-bold">({{ $prescription->details->count() }})</span>
                                    @endif
                                </button>
                                <button onclick="switchTab('tab-supplies')" id="btn-supplies" class="tab-btn px-5 py-3.5 border-b-2 text-slate-600 border-transparent hover:text-[#0D7A68] hover:border-slate-300 flex items-center gap-2 whitespace-nowrap">
                                    <span>📦</span> 4. Vật Tư Tiêu Hao
                                    @if($medicalRecord->materialUsages->count() > 0)
                                        <span class="bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded-full font-bold">({{ $medicalRecord->materialUsages->count() }})</span>
                                    @endif
                                </button>
                            </nav>
                        </div>

                        <div class="p-6">
                            <!-- TAB 1: BỆNH ÁN ĐIỆN TỬ -->
                            <div id="tab-record" class="tab-content block">
                                <form action="{{ route('doctor.medical-records.update', $medicalRecord->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Input ẩn lưu teeth_data -->
                                    <input type="hidden" name="teeth_data" id="hidden_teeth_data" value="{{ old('teeth_data', $medicalRecord->teeth_data ?? '{}') }}">

                                    <div class="space-y-4">
                                        <div>
                                            <label for="symptoms" class="block text-xs font-bold uppercase text-gray-700 mb-1">
                                                Lý do khám / Triệu chứng lâm sàng <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="symptoms" id="symptoms" rows="3" required placeholder="Ví dụ: Đau nhức buốt vùng răng hàm dưới bên trái khi ăn nóng lạnh..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
                                        </div>
                                        
                                        <div>
                                            <div class="flex justify-between items-center mb-1">
                                                <label for="diagnosis" class="block text-xs font-bold uppercase text-gray-700">
                                                    Chẩn đoán bệnh <span class="text-red-500">*</span>
                                                </label>
                                                <button type="button" onclick="syncTeethToDiagnosis()" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-1">
                                                    🔄 Lấy chẩn đoán từ Sơ đồ răng
                                                </button>
                                            </div>
                                            <textarea name="diagnosis" id="diagnosis" rows="2" required placeholder="Ví dụ: Răng 36 viêm tủy cấp, Răng 48 mọc lệch..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-semibold text-indigo-950">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="treatment_plan" class="block text-xs font-bold uppercase text-gray-700 mb-1">
                                                Kế hoạch điều trị / Thủ thuật thực hiện
                                            </label>
                                            <textarea name="treatment_plan" id="treatment_plan" rows="3" placeholder="Ví dụ: Gây tê tại chỗ, mở tủy răng 36, đặt thuốc diệt tủy, hẹn tái khám sau 3 ngày..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="note" class="block text-xs font-bold uppercase text-gray-700 mb-1">
                                                Ghi chú thêm & Lời dặn bệnh nhân
                                            </label>
                                            <textarea name="note" id="note" rows="2" placeholder="Ví dụ: Kiêng đồ quá nóng/lạnh, uống thuốc đúng giờ..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('note', $medicalRecord->note) }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-sm shadow-sm transition flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                            Lưu Bệnh Án & Sơ Đồ Răng
                                        </button>
                                    </div>
                                </form>

                                <!-- KHU VỰC CHỈ ĐỊNH DỊCH VỤ & THỦ THUẬT PHÁT SINH TRONG CA KHÁM -->
                                <div class="mt-8 pt-6 border-t-2 border-dashed border-indigo-100 space-y-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <h4 class="font-extrabold text-indigo-950 text-sm flex items-center gap-2">
                                                <span class="bg-indigo-100 text-indigo-700 p-1.5 rounded-lg">🦷</span>
                                                Chỉ Định Dịch Vụ & Thủ Thuật Thực Hiện Trong Ca Khám
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-0.5">Các dịch vụ/thủ thuật chỉ định thêm tại đây sẽ tự động cộng vào Hóa đơn thanh toán của bệnh nhân tại quầy Thu ngân.</p>
                                        </div>
                                        @if($appointment->service)
                                            <span class="inline-flex items-center gap-1.5 text-xs bg-indigo-50 text-indigo-800 border border-indigo-200 px-3 py-1.5 rounded-lg font-bold">
                                                📌 Dịch vụ đặt lịch: {{ $appointment->service->name }} ({{ number_format($appointment->service->price, 0, ',', '.') }} đ)
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Form thêm Dịch vụ / Thủ thuật phát sinh -->
                                    <form action="{{ route('doctor.medical-records.services.store', $medicalRecord->id) }}" method="POST" class="bg-indigo-50/60 p-4 rounded-xl border border-indigo-100 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                        @csrf
                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Chọn Dịch vụ / Thủ thuật chỉ định thêm <span class="text-red-500">*</span></label>
                                            <select name="service_id" required class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">-- Chọn dịch vụ / thủ thuật nha khoa --</option>
                                                @foreach($services ?? [] as $srv)
                                                    <option value="{{ $srv->id }}">
                                                        {{ $srv->name }} — {{ number_format($srv->price, 0, ',', '.') }} đ ({{ $srv->duration }} phút)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Số lượng / Số răng <span class="text-red-500">*</span></label>
                                            <input type="number" name="quantity" min="1" max="32" value="1" required class="w-full rounded-lg border-gray-300 text-xs text-center font-bold focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div class="md:col-span-3">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Vị trí răng / Ghi chú thủ thuật</label>
                                            <input type="text" name="note" placeholder="VD: Răng số 36, Răng 48 mọc ngầm..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <button type="submit" class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                + Chỉ Định Thêm
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Danh sách Dịch vụ / Thủ thuật đã chỉ định -->
                                    @if($medicalRecord->details && $medicalRecord->details->count() > 0)
                                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-3 py-2.5 text-left font-bold text-gray-600 uppercase">Tên Dịch vụ / Thủ thuật phát sinh</th>
                                                        <th class="px-3 py-2.5 text-left font-bold text-gray-600 uppercase">Vị trí răng / Ghi chú</th>
                                                        <th class="px-3 py-2.5 text-center font-bold text-gray-600 uppercase">SL</th>
                                                        <th class="px-3 py-2.5 text-right font-bold text-gray-600 uppercase">Đơn giá</th>
                                                        <th class="px-3 py-2.5 text-right font-bold text-gray-600 uppercase">Thành tiền</th>
                                                        <th class="px-3 py-2.5 text-right font-bold text-gray-600 uppercase">Xóa</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                    @foreach($medicalRecord->details as $srvDetail)
                                                        @php
                                                            $srvPrice = $srvDetail->service ? floatval($srvDetail->service->price) : 0;
                                                            $srvTotal = $srvPrice * max(1, intval($srvDetail->quantity));
                                                        @endphp
                                                        <tr>
                                                            <td class="px-3 py-2.5 font-bold text-indigo-900">{{ $srvDetail->service->name ?? 'Dịch vụ nha khoa' }}</td>
                                                            <td class="px-3 py-2.5 text-gray-600 italic">{{ $srvDetail->note ?: '---' }}</td>
                                                            <td class="px-3 py-2.5 text-center font-bold text-gray-900">{{ $srvDetail->quantity }}</td>
                                                            <td class="px-3 py-2.5 text-right text-gray-600">{{ number_format($srvPrice, 0, ',', '.') }} đ</td>
                                                            <td class="px-3 py-2.5 text-right font-extrabold text-emerald-700">{{ number_format($srvTotal, 0, ',', '.') }} đ</td>
                                                            <td class="px-3 py-2.5 text-right">
                                                                <form action="{{ route('doctor.medical-records.services.destroy', $srvDetail->id) }}" method="POST" onsubmit="return confirm('Xóa thủ thuật này khỏi ca khám?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-2 py-1 rounded">Xóa</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-xs text-gray-500">
                                            Chưa có thủ thuật phát sinh nào ngoài dịch vụ đăng ký ban đầu.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- TAB 2: SƠ ĐỒ RĂNG TƯƠNG TÁC (ODONTOGRAM) -->
                            <div id="tab-odontogram" class="tab-content hidden space-y-6">
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-indigo-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                    <div>
                                        <h4 class="font-bold text-indigo-900 text-sm flex items-center gap-1.5">
                                            🦷 Sơ Đồ Răng Người Lớn (Chuẩn FDI Quốc Tế - 32 Răng)
                                        </h4>
                                        <p class="text-xs text-indigo-700 mt-0.5">Click vào bất kỳ chiếc răng nào để chọn tình trạng và ghi chú bệnh lý.</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="syncTeethToDiagnosis()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-xs font-bold transition shadow-sm">
                                            Đồng bộ sang Chẩn đoán
                                        </button>
                                        <button type="button" onclick="saveTeethDirectly()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-xs font-bold transition shadow-sm">
                                            Lưu Sơ Đồ
                                        </button>
                                    </div>
                                </div>

                                <!-- Bảng chú giải màu trạng thái -->
                                <div class="flex flex-wrap gap-3 text-xs bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-emerald-500 inline-block border border-gray-300"></span> Khỏe mạnh</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-red-500 inline-block"></span> Sâu răng</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-gray-400 inline-block"></span> Mất răng</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-blue-500 inline-block"></span> Bọc sứ/Mão</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-amber-500 inline-block"></span> Viêm tủy</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-purple-500 inline-block"></span> Răng khôn lệch</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-teal-500 inline-block"></span> Cấy Implant</span>
                                </div>

                                <!-- KHUNG SƠ ĐỒ RĂNG -->
                                <div class="bg-slate-900 p-6 rounded-2xl text-white shadow-inner">
                                    <!-- Hàm trên (Upper Jaw) -->
                                    <div class="mb-6">
                                        <div class="text-center text-xs font-bold uppercase tracking-wider text-indigo-300 mb-3 border-b border-slate-700 pb-1">
                                            HÀM TRÊN (UPPER JAW)
                                        </div>
                                        <div class="flex flex-wrap justify-center gap-1.5 md:gap-2">
                                            <!-- Cung 1: 18 -> 11 -->
                                            @foreach(['18', '17', '16', '15', '14', '13', '12', '11'] as $num)
                                                <button type="button" onclick="openToothModal('{{ $num }}')" id="tooth-btn-{{ $num }}" class="tooth-item group relative flex flex-col items-center justify-between p-1.5 w-10 md:w-12 h-16 rounded-lg bg-slate-800 hover:bg-slate-700 border-2 border-slate-600 transition">
                                                    <span class="text-[10px] font-mono font-bold text-gray-300">{{ $num }}</span>
                                                    <div class="tooth-icon w-5 h-6 rounded-t-md bg-emerald-500 transition-colors"></div>
                                                    <span class="tooth-status-dot w-2 h-2 rounded-full bg-emerald-400"></span>
                                                </button>
                                            @endforeach
                                            <div class="w-1 border-r-2 border-dashed border-indigo-500/50 mx-1"></div>
                                            <!-- Cung 2: 21 -> 28 -->
                                            @foreach(['21', '22', '23', '24', '25', '26', '27', '28'] as $num)
                                                <button type="button" onclick="openToothModal('{{ $num }}')" id="tooth-btn-{{ $num }}" class="tooth-item group relative flex flex-col items-center justify-between p-1.5 w-10 md:w-12 h-16 rounded-lg bg-slate-800 hover:bg-slate-700 border-2 border-slate-600 transition">
                                                    <span class="text-[10px] font-mono font-bold text-gray-300">{{ $num }}</span>
                                                    <div class="tooth-icon w-5 h-6 rounded-t-md bg-emerald-500 transition-colors"></div>
                                                    <span class="tooth-status-dot w-2 h-2 rounded-full bg-emerald-400"></span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Hàm dưới (Lower Jaw) -->
                                    <div>
                                        <div class="text-center text-xs font-bold uppercase tracking-wider text-indigo-300 mb-3 border-b border-slate-700 pb-1">
                                            HÀM DƯỚI (LOWER JAW)
                                        </div>
                                        <div class="flex flex-wrap justify-center gap-1.5 md:gap-2">
                                            <!-- Cung 4: 48 -> 41 -->
                                            @foreach(['48', '47', '46', '45', '44', '43', '42', '41'] as $num)
                                                <button type="button" onclick="openToothModal('{{ $num }}')" id="tooth-btn-{{ $num }}" class="tooth-item group relative flex flex-col items-center justify-between p-1.5 w-10 md:w-12 h-16 rounded-lg bg-slate-800 hover:bg-slate-700 border-2 border-slate-600 transition">
                                                    <span class="tooth-status-dot w-2 h-2 rounded-full bg-emerald-400"></span>
                                                    <div class="tooth-icon w-5 h-6 rounded-b-md bg-emerald-500 transition-colors"></div>
                                                    <span class="text-[10px] font-mono font-bold text-gray-300">{{ $num }}</span>
                                                </button>
                                            @endforeach
                                            <div class="w-1 border-r-2 border-dashed border-indigo-500/50 mx-1"></div>
                                            <!-- Cung 3: 31 -> 38 -->
                                            @foreach(['31', '32', '33', '34', '35', '36', '37', '38'] as $num)
                                                <button type="button" onclick="openToothModal('{{ $num }}')" id="tooth-btn-{{ $num }}" class="tooth-item group relative flex flex-col items-center justify-between p-1.5 w-10 md:w-12 h-16 rounded-lg bg-slate-800 hover:bg-slate-700 border-2 border-slate-600 transition">
                                                    <span class="tooth-status-dot w-2 h-2 rounded-full bg-emerald-400"></span>
                                                    <div class="tooth-icon w-5 h-6 rounded-b-md bg-emerald-500 transition-colors"></div>
                                                    <span class="text-[10px] font-mono font-bold text-gray-300">{{ $num }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Danh sách răng có bệnh lý -->
                                <div>
                                    <h5 class="text-xs font-bold text-gray-700 uppercase mb-2">Các răng đã ghi nhận vấn đề:</h5>
                                    <div id="teeth-summary-list" class="space-y-1.5 text-xs">
                                        <p class="text-gray-400 italic">Chưa có răng nào được đánh dấu bệnh lý.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: ĐƠN THUỐC -->
                            <div id="tab-prescription" class="tab-content hidden space-y-6">
                                <form action="{{ route('doctor.prescriptions.update', $prescription->id) }}" method="POST" class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label for="follow_up_date" class="block text-xs font-bold text-gray-700 uppercase mb-1">Ngày hẹn tái khám</label>
                                            <input type="date" name="follow_up_date" id="follow_up_date" value="{{ old('follow_up_date', $prescription->follow_up_date ? \Carbon\Carbon::parse($prescription->follow_up_date)->format('Y-m-d') : '') }}" class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="pres_note" class="block text-xs font-bold text-gray-700 uppercase mb-1">Lời dặn của bác sĩ</label>
                                            <textarea name="note" id="pres_note" rows="2" placeholder="Ví dụ: Dùng thuốc theo toa 5 ngày, kiêng bia rượu..." class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('note', $prescription->note) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-1.5 bg-gray-700 hover:bg-gray-800 text-white text-xs font-bold rounded-lg transition">Lưu lời dặn</button>
                                    </div>
                                </form>

                                <!-- Danh sách thuốc đã kê -->
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm border-b pb-2 mb-3">Danh sách Thuốc trong đơn</h4>
                                    
                                    @if($prescription->details->count() > 0)
                                        @php $totalPrescriptionCost = 0; @endphp
                                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left font-bold text-gray-600 uppercase">Tên thuốc</th>
                                                        <th class="px-3 py-2 text-center font-bold text-gray-600 uppercase">SL</th>
                                                        <th class="px-3 py-2 text-right font-bold text-gray-600 uppercase">Đơn giá</th>
                                                        <th class="px-3 py-2 text-right font-bold text-gray-600 uppercase">Thành tiền</th>
                                                        <th class="px-3 py-2 text-left font-bold text-gray-600 uppercase">Sáng - Trưa - Chiều - Tối</th>
                                                        <th class="px-3 py-2 text-right font-bold text-gray-600 uppercase">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                    @foreach($prescription->details as $detail)
                                                        @php
                                                            $unitPrice = ($detail->medicine && $detail->medicine->price > 0) ? floatval($detail->medicine->price) : 15000;
                                                            $linePrice = $unitPrice * max(1, intval($detail->quantity));
                                                            $totalPrescriptionCost += $linePrice;
                                                        @endphp
                                                        <tr>
                                                            <td class="px-3 py-2.5 font-bold text-indigo-700">
                                                                {{ $detail->medicine_name }}
                                                                @if($detail->medicine_id)
                                                                    <span class="text-[10px] px-1.5 py-0.5 bg-green-100 text-green-700 rounded-md font-bold ml-1">Đã trừ kho</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2.5 text-center font-bold text-gray-900">{{ $detail->quantity }} {{ $detail->dosage }}</td>
                                                            <td class="px-3 py-2.5 text-right text-gray-600">{{ number_format($unitPrice, 0, ',', '.') }} đ</td>
                                                            <td class="px-3 py-2.5 text-right font-extrabold text-emerald-700">{{ number_format($linePrice, 0, ',', '.') }} đ</td>
                                                            <td class="px-3 py-2.5 text-gray-700 font-medium">
                                                                {{ $detail->usage_morning ?? '0' }} - {{ $detail->usage_noon ?? '0' }} - {{ $detail->usage_evening ?? '0' }} - {{ $detail->usage_night ?? '0' }}
                                                                @if($detail->instructions)
                                                                    <span class="text-[11px] font-normal italic block text-gray-500">({{ $detail->instructions }})</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2.5 text-right">
                                                                <form action="{{ route('doctor.prescriptions.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Xóa thuốc này và hoàn lại kho?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold bg-red-50 hover:bg-red-100 px-2 py-1 rounded">Xóa</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-emerald-50/70 border-t border-emerald-200">
                                                    <tr>
                                                        <td colspan="3" class="px-3 py-2.5 text-right font-extrabold uppercase text-emerald-800">💊 Tổng tiền thuốc kèm theo (Tự động chuyển sang Hóa đơn):</td>
                                                        <td class="px-3 py-2.5 text-right font-black text-sm text-emerald-700">{{ number_format($totalPrescriptionCost, 0, ',', '.') }} đ</td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-6 bg-gray-50 rounded-lg text-xs text-gray-400">
                                            Chưa có thuốc nào trong đơn này.
                                        </div>
                                    @endif
                                </div>

                                <!-- Form thêm thuốc mới -->
                                <div class="bg-indigo-50/70 p-4 rounded-xl border border-indigo-100">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                        <h4 class="font-bold text-indigo-900 text-sm flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Thêm Thuốc Mới Vào Đơn
                                        </h4>
                                        @if($appointment->patient->allergy_history)
                                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 border border-red-300 px-2.5 py-1 rounded-full text-xs font-extrabold">
                                                ⚠️ BN dị ứng: {{ $appointment->patient->allergy_history }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <form action="{{ route('doctor.prescriptions.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">

                                        <!-- Khung cảnh báo xung đột Dị ứng thuốc tự động -->
                                        <div id="allergy_warning_box" class="hidden mb-3 bg-red-100 border-2 border-red-500 rounded-xl p-3.5 text-red-900 shadow-sm">
                                            <div class="flex items-start gap-2.5">
                                                <span class="text-lg leading-none">🚨</span>
                                                <div class="flex-1 text-xs">
                                                    <p class="font-extrabold uppercase text-red-800">Cảnh báo Xung đột Dị ứng Thuốc!</p>
                                                    <p id="allergy_warning_text" class="mt-0.5 font-semibold text-red-700"></p>
                                                    <label class="mt-2 inline-flex items-center gap-2 cursor-pointer bg-white px-2.5 py-1.5 rounded-lg border border-red-300 font-bold text-red-800">
                                                        <input type="checkbox" name="force_allergy_override" id="force_allergy_override" value="1" class="rounded text-red-600 focus:ring-red-500">
                                                        <span>Xác nhận vượt cảnh báo dị ứng (Bác sĩ đã cân nhắc lâm sàng)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-3">
                                            <div class="md:col-span-6">
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Chọn từ kho (Tự động trừ kho)</label>
                                                <select name="medicine_id" id="medicine_id" class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500" onchange="fillMedicineName()">
                                                    <option value="">-- Chọn thuốc trong kho --</option>
                                                    @foreach($medicines as $med)
                                                        <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-unit="{{ $med->unit }}">
                                                            {{ $med->name }} - {{ number_format($med->price, 0, ',', '.') }} đ/{{ $med->unit }} (Tồn: {{ $med->stock_quantity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="md:col-span-6">
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Tên thuốc <span class="text-red-500">*</span></label>
                                                <input type="text" name="medicine_name" id="medicine_name" oninput="checkMedicineAllergy()" required placeholder="Tên thuốc..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-3">
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Số lượng <span class="text-red-500">*</span></label>
                                                <input type="number" name="quantity" min="1" value="1" required class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Đơn vị</label>
                                                <input type="text" name="dosage" id="dosage" placeholder="Viên..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            
                                            <div class="col-span-2 md:col-span-4 grid grid-cols-4 gap-2">
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 mb-1 text-center">Sáng</label>
                                                    <input type="text" name="usage_morning" placeholder="0" class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 mb-1 text-center">Trưa</label>
                                                    <input type="text" name="usage_noon" placeholder="0" class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 mb-1 text-center">Chiều</label>
                                                    <input type="text" name="usage_evening" placeholder="0" class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-700 mb-1 text-center">Tối</label>
                                                    <input type="text" name="usage_night" placeholder="0" class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Cách dùng</label>
                                            <input type="text" name="instructions" placeholder="Ví dụ: Uống sau khi ăn no..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                + Thêm Thuốc Vào Đơn
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- TAB 4: VẬT TƯ TIÊU HAO -->
                            <div id="tab-supplies" class="tab-content hidden space-y-6">
                                <div class="bg-emerald-50/70 p-4 rounded-xl border border-emerald-100">
                                    <h4 class="font-bold text-emerald-900 text-sm mb-3 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                        Chỉ Định Vật Tư Y Tế Tiêu Hoa (Tự Động Trừ Kho)
                                    </h4>

                                    <form action="{{ route('doctor.material-usage.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                        @csrf
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                        <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">

                                        <div class="md:col-span-5">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Chọn vật tư trong kho <span class="text-red-500">*</span></label>
                                            <select name="supply_id" required class="w-full rounded-lg border-gray-300 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                                <option value="">-- Chọn vật tư --</option>
                                                @foreach($supplies as $sup)
                                                    <option value="{{ $sup->id }}">
                                                        {{ $sup->name }} (Tồn: {{ $sup->stock_quantity }} {{ $sup->unit }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Số lượng <span class="text-red-500">*</span></label>
                                            <input type="number" name="quantity" min="1" value="1" required class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-emerald-500 focus:ring-emerald-500">
                                        </div>

                                        <div class="md:col-span-3">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Ghi chú tiêu hao</label>
                                            <input type="text" name="note" placeholder="Dùng trong thủ thuật..." class="w-full rounded-lg border-gray-300 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                        </div>

                                        <div class="md:col-span-2">
                                            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                                                + Ghi Nhận
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Danh sách vật tư đã dùng -->
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm border-b pb-2 mb-3">Vật tư đã tiêu hao trong ca khám này</h4>

                                    @if($medicalRecord->materialUsages && $medicalRecord->materialUsages->count() > 0)
                                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left font-bold text-gray-600 uppercase">Tên vật tư</th>
                                                        <th class="px-3 py-2 text-center font-bold text-gray-600 uppercase">Số lượng</th>
                                                        <th class="px-3 py-2 text-left font-bold text-gray-600 uppercase">Đơn vị</th>
                                                        <th class="px-3 py-2 text-left font-bold text-gray-600 uppercase">Ghi chú</th>
                                                        <th class="px-3 py-2 text-right font-bold text-gray-600 uppercase">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                    @foreach($medicalRecord->materialUsages as $usage)
                                                        <tr>
                                                            <td class="px-3 py-2.5 font-bold text-emerald-800">{{ $usage->supply->name ?? '---' }}</td>
                                                            <td class="px-3 py-2.5 text-center font-bold text-gray-900">{{ $usage->quantity }}</td>
                                                            <td class="px-3 py-2.5 text-gray-600">{{ $usage->supply->unit ?? 'Cái' }}</td>
                                                            <td class="px-3 py-2.5 text-gray-500 italic">{{ $usage->note ?: '---' }}</td>
                                                            <td class="px-3 py-2.5 text-right">
                                                                <form action="{{ route('doctor.material-usage.destroy', $usage->id) }}" method="POST" onsubmit="return confirm('Hủy ghi nhận và hoàn lại kho vật tư?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold bg-red-50 hover:bg-red-100 px-2 py-1 rounded">Hoàn kho</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-6 bg-gray-50 rounded-lg text-xs text-gray-400">
                                            Chưa ghi nhận vật tư tiêu hao nào cho ca này.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CHỌN TÌNH TRẠNG RĂNG -->
    <div id="toothModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-200">
            <div class="bg-indigo-600 px-6 py-4 text-white flex justify-between items-center">
                <h4 class="font-bold text-base flex items-center gap-2">
                    <span>🦷 Cập Nhật Tình Trạng Răng</span>
                    <span id="modalToothNumber" class="bg-white/20 px-2 py-0.5 rounded text-sm font-mono">11</span>
                </h4>
                <button type="button" onclick="closeToothModal()" class="text-white hover:text-indigo-200 text-xl font-bold">&times;</button>
            </div>

            <div class="p-6 space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-2">Tình trạng răng:</label>
                    <div class="grid grid-cols-2 gap-2" id="statusOptions">
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-emerald-50 transition border-emerald-300">
                            <input type="radio" name="tooth_status" value="healthy" checked class="text-emerald-600 focus:ring-emerald-500">
                            <span class="text-xs font-bold text-emerald-800">Khỏe mạnh</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-red-50 transition border-red-300">
                            <input type="radio" name="tooth_status" value="cavity" class="text-red-600 focus:ring-red-500">
                            <span class="text-xs font-bold text-red-800">Sâu răng (Trám)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-gray-100 transition border-gray-300">
                            <input type="radio" name="tooth_status" value="missing" class="text-gray-600 focus:ring-gray-500">
                            <span class="text-xs font-bold text-gray-800">Mất răng</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-blue-50 transition border-blue-300">
                            <input type="radio" name="tooth_status" value="crown" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-xs font-bold text-blue-800">Bọc sứ / Mão</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-amber-50 transition border-amber-300">
                            <input type="radio" name="tooth_status" value="pulp" class="text-amber-600 focus:ring-amber-500">
                            <span class="text-xs font-bold text-amber-800">Viêm tủy</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-purple-50 transition border-purple-300">
                            <input type="radio" name="tooth_status" value="wisdom" class="text-purple-600 focus:ring-purple-500">
                            <span class="text-xs font-bold text-purple-800">Răng khôn lệch</span>
                        </label>
                        <label class="col-span-2 flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-teal-50 transition border-teal-300">
                            <input type="radio" name="tooth_status" value="implant" class="text-teal-600 focus:ring-teal-500">
                            <span class="text-xs font-bold text-teal-800">Cấy ghép Implant</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Ghi chú riêng cho răng này:</label>
                    <input type="text" id="modalToothNote" placeholder="Ví dụ: Sâu mặt nhai độ 2, mẻ góc..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-3.5 flex justify-end gap-2 border-t border-gray-200">
                <button type="button" onclick="closeToothModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-xs font-bold transition">Hủy</button>
                <button type="button" onclick="applyToothChanges()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-sm">Xác Nhận</button>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn px-5 py-3.5 border-b-2 text-gray-600 border-transparent hover:text-indigo-600 hover:border-gray-300 flex items-center gap-2 whitespace-nowrap";
            });

            const activeTab = document.getElementById(tabId);
            if (activeTab) {
                activeTab.classList.remove('hidden');
                activeTab.classList.add('block');
            }

            const activeBtn = document.getElementById(tabId.replace('tab-', 'btn-'));
            if (activeBtn) {
                activeBtn.className = "tab-btn px-5 py-3.5 border-b-2 text-indigo-600 border-indigo-600 bg-white flex items-center gap-2 whitespace-nowrap";
            }
        }

        const patientAllergyRaw = @json($appointment->patient->allergy_history ?? '');

        function checkMedicineAllergy() {
            const nameInput = document.getElementById('medicine_name');
            const warningBox = document.getElementById('allergy_warning_box');
            const warningText = document.getElementById('allergy_warning_text');
            const overrideCheckbox = document.getElementById('force_allergy_override');
            if (!nameInput || !warningBox || !patientAllergyRaw) return;

            const medName = (nameInput.value || '').trim().toLowerCase();
            if (!medName) {
                warningBox.classList.add('hidden');
                if (overrideCheckbox) overrideCheckbox.required = false;
                return;
            }

            const tokens = patientAllergyRaw.toLowerCase().split(/[,;\/\-\n]+/).map(t => t.trim()).filter(t => t.length >= 3);
            let matched = null;
            for (const token of tokens) {
                if (medName.includes(token) || token.includes(medName)) {
                    matched = token;
                    break;
                }
            }

            if (matched) {
                warningText.textContent = `Thuốc "${nameInput.value}" trùng khớp với dị nguyên "${matched}" trong hồ sơ dị ứng của bệnh nhân (${patientAllergyRaw})!`;
                warningBox.classList.remove('hidden');
                if (overrideCheckbox) overrideCheckbox.required = true;
            } else {
                warningBox.classList.add('hidden');
                if (overrideCheckbox) {
                    overrideCheckbox.required = false;
                    overrideCheckbox.checked = false;
                }
            }
        }

        // Auto fill medicine name when select from stock
        function fillMedicineName() {
            var select = document.getElementById('medicine_id');
            var nameInput = document.getElementById('medicine_name');
            var dosageInput = document.getElementById('dosage');
            
            if(select.selectedIndex > 0) {
                var option = select.options[select.selectedIndex];
                nameInput.value = option.getAttribute('data-name');
                dosageInput.value = option.getAttribute('data-unit');
                nameInput.setAttribute('readonly', 'readonly');
                nameInput.classList.add('bg-gray-100');
            } else {
                nameInput.value = '';
                dosageInput.value = '';
                nameInput.removeAttribute('readonly');
                nameInput.classList.remove('bg-gray-100');
            }
            checkMedicineAllergy();
        }

        // Odontogram Data Management
        let teethData = {};
        let currentModalTooth = null;

        const statusMap = {
            healthy: { label: 'Khỏe mạnh', color: 'bg-emerald-500', dot: 'bg-emerald-400', border: 'border-emerald-500' },
            cavity:  { label: 'Sâu răng', color: 'bg-red-500', dot: 'bg-red-400', border: 'border-red-500' },
            missing: { label: 'Mất răng', color: 'bg-gray-400', dot: 'bg-gray-400', border: 'border-gray-400' },
            crown:   { label: 'Bọc sứ', color: 'bg-blue-500', dot: 'bg-blue-400', border: 'border-blue-500' },
            pulp:    { label: 'Viêm tủy', color: 'bg-amber-500', dot: 'bg-amber-400', border: 'border-amber-500' },
            wisdom:  { label: 'Răng khôn lệch', color: 'bg-purple-500', dot: 'bg-purple-400', border: 'border-purple-500' },
            implant: { label: 'Cấy Implant', color: 'bg-teal-500', dot: 'bg-teal-400', border: 'border-teal-500' }
        };

        // Initialize teeth data
        try {
            const raw = document.getElementById('hidden_teeth_data').value;
            if (raw) {
                teethData = JSON.parse(raw);
            }
        } catch(e) {
            teethData = {};
        }

        function renderTeethVisuals() {
            for (let num in teethData) {
                const item = teethData[num];
                const btn = document.getElementById('tooth-btn-' + num);
                if (btn && item && statusMap[item.status]) {
                    const cfg = statusMap[item.status];
                    const icon = btn.querySelector('.tooth-icon');
                    const dot = btn.querySelector('.tooth-status-dot');

                    if (icon) {
                        icon.className = 'tooth-icon w-5 h-6 transition-colors ' + cfg.color;
                    }
                    if (dot) {
                        dot.className = 'tooth-status-dot w-2 h-2 rounded-full ' + cfg.dot;
                    }
                    if (item.status !== 'healthy') {
                        btn.classList.add('ring-2', 'ring-indigo-400');
                    } else {
                        btn.classList.remove('ring-2', 'ring-indigo-400');
                    }
                }
            }
            renderTeethSummary();
        }

        function renderTeethSummary() {
            const container = document.getElementById('teeth-summary-list');
            if (!container) return;

            const problemTeeth = Object.keys(teethData).filter(num => teethData[num].status !== 'healthy');
            if (problemTeeth.length === 0) {
                container.innerHTML = '<p class="text-gray-400 italic">Chưa có răng nào được đánh dấu bệnh lý.</p>';
                return;
            }

            let html = '';
            problemTeeth.forEach(num => {
                const item = teethData[num];
                const cfg = statusMap[item.status] || statusMap.healthy;
                html += `
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-slate-800 text-white font-mono font-bold flex items-center justify-center text-[10px]">${num}</span>
                            <span class="font-bold text-gray-800">${cfg.label}</span>
                            ${item.note ? `<span class="text-gray-500 italic">(${item.note})</span>` : ''}
                        </div>
                        <button type="button" onclick="openToothModal('${num}')" class="text-indigo-600 hover:text-indigo-800 font-semibold text-[11px]">Sửa</button>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function openToothModal(num) {
            currentModalTooth = num;
            document.getElementById('modalToothNumber').textContent = num;

            const current = teethData[num] || { status: 'healthy', note: '' };
            const radios = document.getElementsByName('tooth_status');
            radios.forEach(r => {
                r.checked = (r.value === current.status);
            });
            document.getElementById('modalToothNote').value = current.note || '';

            document.getElementById('toothModal').classList.remove('hidden');
        }

        function closeToothModal() {
            document.getElementById('toothModal').classList.add('hidden');
            currentModalTooth = null;
        }

        function applyToothChanges() {
            if (!currentModalTooth) return;

            let selectedStatus = 'healthy';
            const radios = document.getElementsByName('tooth_status');
            radios.forEach(r => {
                if (r.checked) selectedStatus = r.value;
            });

            const note = document.getElementById('modalToothNote').value.trim();

            teethData[currentModalTooth] = {
                status: selectedStatus,
                note: note
            };

            document.getElementById('hidden_teeth_data').value = JSON.stringify(teethData);
            renderTeethVisuals();
            closeToothModal();
        }

        function syncTeethToDiagnosis() {
            const problemTeeth = Object.keys(teethData).filter(num => teethData[num].status !== 'healthy');
            if (problemTeeth.length === 0) {
                alert('Hiện chưa có răng nào được đánh dấu bệnh lý trong Sơ đồ răng.');
                return;
            }

            const diagnosisParts = problemTeeth.map(num => {
                const item = teethData[num];
                const label = statusMap[item.status]?.label || item.status;
                return `Răng ${num} (${label}${item.note ? ': ' + item.note : ''})`;
            });

            const currentDiagnosis = document.getElementById('diagnosis').value.trim();
            const newText = diagnosisParts.join(', ');

            if (currentDiagnosis) {
                if (confirm('Bạn có muốn nối thêm nội dung từ sơ đồ răng vào chẩn đoán hiện tại?')) {
                    document.getElementById('diagnosis').value = currentDiagnosis + '; ' + newText;
                }
            } else {
                document.getElementById('diagnosis').value = newText;
            }

            switchTab('tab-record');
            alert('Đã cập nhật chẩn đoán từ Sơ đồ răng!');
        }

        function saveTeethDirectly() {
            const form = document.querySelector('#tab-record form');
            if (form) {
                form.submit();
            }
        }

        // Run render on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderTeethVisuals();
        });
    </script>
</x-app-layout>
