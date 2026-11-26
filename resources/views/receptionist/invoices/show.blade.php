<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Chi tiết hóa đơn <span class="font-mono text-[#0D7A68]">#{{ $invoice->invoice_code }}</span>
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        {{ $invoice->created_at->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Thông tin chi phí điều trị, đơn thuốc và thanh toán VietQR</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('receptionist.invoices.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                    &larr; Danh sách hóa đơn
                </a>
                <a href="{{ route('receptionist.invoices.print', $invoice) }}" target="_blank" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs flex items-center gap-1.5 transition">
                    <span>🖨️ In Hóa Đơn</span>
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $rawBankId = $settings['bank_id'] ?? '';
        $rawAccNo = $settings['bank_account_no'] ?? '';
        $rawAccName = $settings['bank_account_name'] ?? '';

        $bankId = (!empty($rawBankId) && $rawAccNo !== '0789169711') ? $rawBankId : 'TCB';
        $accountNo = (!empty($rawAccNo) && $rawAccNo !== '0789169711') ? $rawAccNo : '6362566666';
        $accountName = (!empty($rawAccName) && $rawAccName !== 'NHA KHOA SMILE') ? $rawAccName : 'PHAM XUAN TRUONG';
        $bankDisplayName = $bankId === 'TCB' ? 'Techcombank (TCB)' : $bankId;

        $transferContent = 'THANH TOAN ' . $invoice->invoice_code;
        $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount=" . round($invoice->final_amount) . "&addInfo=" . urlencode($transferContent) . "&accountName=" . urlencode($accountName);
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold" role="alert">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cột trái: Hóa đơn & Bảng chi tiết (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 md:p-8">
                        <!-- Thông tin phòng khám & tiêu đề -->
                        <div class="flex flex-col sm:flex-row justify-between items-start border-b border-slate-100 pb-6 gap-4">
                            <div>
                                <h3 class="text-xl font-black text-[#0D7A68] uppercase tracking-tight">{{ $settings['clinic_name'] ?? 'Nha Khoa Smile' }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ $settings['clinic_address'] ?? '123 Nguyễn Văn Cừ, Quận 5, TP.HCM' }}</p>
                                <p class="text-xs text-slate-500">Hotline: <span class="font-semibold text-slate-700">{{ $settings['clinic_hotline'] ?? '1900 1234' }}</span></p>
                            </div>
                            <div class="sm:text-right">
                                <span class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Hóa đơn điện tử</span>
                                <p class="text-lg font-bold text-slate-900 font-mono">{{ $invoice->invoice_code }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Ngày lập: {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                                <div class="mt-2">
                                    @if($invoice->status === 'paid')
                                        <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                            ✓ ĐÃ THANH TOÁN
                                        </span>
                                    @elseif($invoice->status === 'cancelled')
                                        <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1">
                                            ✕ ĐÃ HỦY BỎ
                                        </span>
                                    @else
                                        <span class="bg-[#FEF3C7] text-[#92400E] font-bold text-[11px] px-2.5 py-0.5 rounded-md inline-flex items-center gap-1 animate-pulse">
                                            ⏳ CHƯA THANH TOÁN
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin khách hàng & Bác sĩ điều trị -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6 py-4 bg-slate-50/70 rounded-xl px-4 border border-slate-100">
                            <div>
                                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Thông tin Bệnh nhân</h4>
                                <p class="font-bold text-sm text-slate-900">{{ $invoice->patient->name ?? 'Vãng lai' }}</p>
                                <p class="text-xs text-slate-500 mt-1">Mã BN: <span class="font-mono font-semibold">{{ $invoice->patient->patient_code ?? '---' }}</span></p>
                                <p class="text-xs text-slate-500">SĐT: {{ $invoice->patient->phone ?? '---' }}</p>
                                <p class="text-xs text-slate-500 truncate">Địa chỉ: {{ $invoice->patient->address ?? '---' }}</p>
                            </div>
                            <div>
                                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Thông tin Khám bệnh</h4>
                                @if($invoice->appointment)
                                    <p class="text-xs text-slate-700">Mã lịch hẹn: <span class="font-mono font-semibold">#{{ $invoice->appointment->id }}</span></p>
                                    <p class="text-xs text-slate-700 mt-1">Bác sĩ khám: <span class="font-semibold text-[#0D7A68]">{{ $invoice->appointment->doctor->user->name ?? '---' }}</span></p>
                                    <p class="text-xs text-slate-500 mt-1">Thời gian: {{ \Carbon\Carbon::parse($invoice->appointment->appointment_time)->format('d/m/Y H:i') }}</p>
                                @else
                                    <p class="text-xs text-slate-400 italic">Hóa đơn phát sinh trực tiếp tại quầy</p>
                                @endif
                            </div>
                        </div>

                        <!-- Bảng chi tiết dịch vụ & thuốc -->
                        <div class="overflow-x-auto border border-slate-200/90 rounded-xl mb-6">
                            <table class="min-w-full divide-y divide-slate-100 text-xs">
                                <thead class="bg-slate-50/70">
                                    <tr>
                                        <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider w-12">STT</th>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dịch vụ / Sản phẩm</th>
                                        <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Số lượng</th>
                                        <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Đơn giá</th>
                                        <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse($invoice->details as $idx => $detail)
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="px-4 py-3 text-slate-400 text-center font-medium">{{ $idx + 1 }}</td>
                                            <td class="px-4 py-3 font-medium text-slate-900">{{ $detail->item_name }}</td>
                                            <td class="px-4 py-3 text-slate-700 text-center font-bold">{{ $detail->quantity }}</td>
                                            <td class="px-4 py-3 text-slate-500 text-right">{{ number_format($detail->unit_price, 0, ',', '.') }} đ</td>
                                            <td class="px-4 py-3 font-bold text-slate-900 text-right">{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-6 text-center text-slate-400 text-xs">Hóa đơn chưa có danh mục chi tiết nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @php
                            $medicineSubtotal = $invoice->details->filter(fn($d) => str_starts_with(mb_strtolower($d->item_name), 'thuốc') || str_contains(mb_strtolower($d->item_name), 'gói thuốc'))->sum('total_price');
                            $serviceSubtotal = max(0, $invoice->total_amount - $medicineSubtotal);
                            $docPrescription = $invoice->appointment?->medicalRecord?->prescription;
                        @endphp

                        <!-- Đơn thuốc Bác sĩ đã kê -->
                        @if($docPrescription && $docPrescription->details && $docPrescription->details->count() > 0)
                            <div class="mb-6 bg-emerald-50/40 border border-emerald-200/80 rounded-2xl p-4 sm:p-5">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 mb-3 border-b border-emerald-200/60">
                                    <div>
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-900 flex items-center gap-1.5">
                                            <span>💊</span> Đơn thuốc Bác sĩ đã kê ({{ $docPrescription->details->count() }} loại)
                                        </h4>
                                        <p class="text-[11px] text-emerald-700 mt-0.5">
                                            Bác sĩ kê đơn: <strong>BS. {{ $invoice->appointment->doctor->user->name ?? 'Chuyên khoa' }}</strong>
                                        </p>
                                    </div>
                                    <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-2.5 py-0.5 rounded-md self-start sm:self-auto">
                                        ✓ Đã đồng bộ sang hóa đơn
                                    </span>
                                </div>
                                <div class="overflow-x-auto bg-white rounded-xl border border-emerald-200/60">
                                    <table class="min-w-full divide-y divide-emerald-100 text-xs">
                                        <thead class="bg-emerald-50/50 text-emerald-900">
                                            <tr>
                                                <th class="px-3 py-2 text-left font-bold uppercase">Tên thuốc</th>
                                                <th class="px-3 py-2 text-center font-bold uppercase">Số lượng</th>
                                                <th class="px-3 py-2 text-left font-bold uppercase">Liều dùng</th>
                                                <th class="px-3 py-2 text-left font-bold uppercase">Cách uống</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($docPrescription->details as $pItem)
                                                <tr>
                                                    <td class="px-3 py-2.5 font-bold text-slate-900">{{ $pItem->medicine_name }}</td>
                                                    <td class="px-3 py-2.5 text-center font-bold text-emerald-700">{{ $pItem->quantity }}</td>
                                                    <td class="px-3 py-2.5 font-medium text-slate-700">{{ $pItem->dosage ?: 'Theo chỉ định' }}</td>
                                                    <td class="px-3 py-2.5 text-slate-500">{{ $pItem->instructions ?: 'Uống sau ăn' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(!empty($docPrescription->notes))
                                    <p class="text-xs text-emerald-900 mt-2.5 bg-white/80 px-3 py-2 rounded-xl border border-emerald-200/50">
                                        <strong>📌 Lời dặn của Bác sĩ:</strong> {{ $docPrescription->notes }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <!-- Tổng tiền & Chiết khấu -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pt-4 border-t border-slate-100">
                            <div class="text-xs text-slate-400 max-w-xs">
                                <p class="italic">* Giá trên đã bao gồm VAT và các chi phí liên quan theo thỏa thuận.</p>
                            </div>
                            <div class="w-full sm:w-80 space-y-2">
                                <div class="flex justify-between text-xs text-slate-600">
                                    <span>Tiền dịch vụ khám:</span>
                                    <span class="font-semibold text-slate-900">{{ number_format($serviceSubtotal, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="flex justify-between text-xs text-slate-600">
                                    <span>Tiền thuốc kèm theo:</span>
                                    <span class="font-semibold text-slate-900">{{ number_format($medicineSubtotal, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="flex justify-between text-xs text-slate-600 pt-1.5 border-t border-dashed border-slate-200">
                                    <span>Tạm tính (Dịch vụ + Thuốc):</span>
                                    <span class="font-bold text-slate-800">{{ number_format($invoice->total_amount, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="flex justify-between text-xs text-emerald-700">
                                    <span>Chiết khấu / Giảm giá:</span>
                                    <span class="font-semibold">- {{ number_format($invoice->discount, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="flex justify-between text-xs text-slate-600">
                                    <span>Thuế VAT ({{ (!empty($settings['vat_percentage']) && floatval($settings['vat_percentage']) > 0) ? $settings['vat_percentage'] : 10 }}%):</span>
                                    <span class="font-semibold">+ {{ number_format($invoice->vat_amount, 0, ',', '.') }} đ</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold text-slate-900 pt-3 border-t-2 border-slate-900">
                                    <span class="uppercase">Cần Thanh Toán:</span>
                                    <span class="text-xl font-bold text-slate-900">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                                </div>
                            </div>
                        </div>

                        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled' && isset($services) && isset($medicines))
                            @php
                                $existingItemNames = $invoice->details->pluck('quantity', 'item_name')->toArray();
                                $vatRateShow = (!empty($settings['vat_percentage']) && floatval($settings['vat_percentage']) > 0) ? floatval($settings['vat_percentage']) : 10;
                            @endphp
                            <!-- Khối Chọn Dịch vụ khám & Chọn Tiền thuốc -->
                            <div class="mt-8 pt-6 border-t border-slate-200" x-data="{ openSelector: true }">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                            <span>🦷 Điều chỉnh Dịch vụ & 💊 Thuốc kê thêm</span>
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Tích chọn dịch vụ khám và thuốc sử dụng, hệ thống tự động tính số tiền cần thanh toán</p>
                                    </div>
                                    <button type="button" @click="openSelector = !openSelector" class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition">
                                        <span x-text="openSelector ? 'Thu gọn ▲' : 'Mở bảng chọn ▼'"></span>
                                    </button>
                                </div>

                                <form action="{{ route('receptionist.invoices.update', $invoice) }}" method="POST" x-show="openSelector" class="space-y-5 bg-slate-50/70 p-5 rounded-2xl border border-slate-200/90">
                                    @csrf
                                    @method('PUT')
                                    <div id="showGeneratedItemsContainer"></div>
                                    <input type="hidden" name="discount" id="showHiddenDiscount" value="{{ round($invoice->discount ?? 0) }}">

                                    <!-- 1. Chọn Dịch vụ khám -->
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-2.5">1. Tích chọn Dịch vụ khám:</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5" id="showServicesGrid">
                                            @foreach($services as $srv)
                                                @php
                                                    $srvKey1 = 'Dịch vụ: ' . $srv->name;
                                                    $srvKey2 = $srv->name;
                                                    $matchedQty = $existingItemNames[$srvKey1] ?? ($existingItemNames[$srvKey2] ?? 0);
                                                    $isChecked = $matchedQty > 0;
                                                @endphp
                                                <div class="show-item-card service-type rounded-xl border p-3 transition cursor-pointer flex items-center justify-between gap-2 {{ $isChecked ? 'border-[#0D7A68] bg-[#0D7A68]/5 ring-1 ring-[#0D7A68]' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                                                     data-name="Dịch vụ: {{ $srv->name }}"
                                                     data-price="{{ round($srv->price) }}"
                                                     onclick="toggleShowCard(this)">
                                                    <div class="flex items-start gap-2.5 min-w-0">
                                                        <input type="checkbox" class="show-cb mt-0.5 rounded border-slate-300 text-[#0D7A68] pointer-events-none" {{ $isChecked ? 'checked' : '' }}>
                                                        <div class="min-w-0">
                                                            <p class="text-xs font-bold text-slate-800 leading-snug">{{ $srv->name }}</p>
                                                            <p class="text-xs font-bold text-[#0D7A68] mt-0.5">{{ number_format($srv->price, 0, ',', '.') }} đ</p>
                                                        </div>
                                                    </div>
                                                    <div class="show-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 shrink-0 {{ $isChecked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                                        <button type="button" onclick="changeShowQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">-</button>
                                                        <input type="text" readonly value="{{ $isChecked ? $matchedQty : 1 }}" class="show-qty w-6 text-center text-xs font-bold border-0 p-0 bg-transparent focus:ring-0">
                                                        <button type="button" onclick="changeShowQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">+</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- 2. Chọn Tiền thuốc -->
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-2.5">2. Tích chọn Tiền thuốc kèm theo:</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5" id="showMedicinesGrid">
                                            @php $renderedMedNames = []; @endphp
                                            @foreach($medicines as $med)
                                                @php
                                                    $medKey1 = 'Thuốc: ' . $med->name . ' (' . ($med->unit ?? 'Đơn vị') . ')';
                                                    $medKey2 = 'Thuốc: ' . $med->name;
                                                    $renderedMedNames[] = $medKey1;
                                                    $renderedMedNames[] = $medKey2;
                                                    $matchedMedQty = $existingItemNames[$medKey1] ?? ($existingItemNames[$medKey2] ?? 0);
                                                    $isMedChecked = $matchedMedQty > 0;
                                                @endphp
                                                <div class="show-item-card medicine-type rounded-xl border p-3 transition cursor-pointer flex items-center justify-between gap-2 {{ $isMedChecked ? 'border-[#0D7A68] bg-[#0D7A68]/5 ring-1 ring-[#0D7A68]' : 'border-slate-200 bg-white hover:border-slate-300' }}"
                                                     data-name="Thuốc: {{ $med->name }} ({{ $med->unit ?? 'Đơn vị' }})"
                                                     data-price="{{ round($med->price) }}"
                                                     onclick="toggleShowCard(this)">
                                                    <div class="flex items-start gap-2.5 min-w-0">
                                                        <input type="checkbox" class="show-cb mt-0.5 rounded border-slate-300 text-[#0D7A68] pointer-events-none" {{ $isMedChecked ? 'checked' : '' }}>
                                                        <div class="min-w-0">
                                                            <p class="text-xs font-bold text-slate-800 leading-snug">{{ $med->name }}</p>
                                                            <p class="text-xs font-bold text-[#0D7A68] mt-0.5">{{ number_format($med->price, 0, ',', '.') }} đ <span class="text-[10px] font-normal text-slate-400">/ {{ $med->unit ?? 'Đơn vị' }}</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="show-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 shrink-0 {{ $isMedChecked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                                        <button type="button" onclick="changeShowQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">-</button>
                                                        <input type="text" readonly value="{{ $isMedChecked ? $matchedMedQty : 1 }}" class="show-qty w-6 text-center text-xs font-bold border-0 p-0 bg-transparent focus:ring-0">
                                                        <button type="button" onclick="changeShowQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">+</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- Các thuốc Bác sĩ kê ngoài danh mục sẵn có --}}
                                            @foreach($invoice->details as $dt)
                                                @if((str_starts_with(mb_strtolower($dt->item_name), 'thuốc') || str_contains(mb_strtolower($dt->item_name), 'gói thuốc')) && !in_array($dt->item_name, $renderedMedNames))
                                                    <div class="show-item-card medicine-type rounded-xl border border-[#0D7A68] bg-[#0D7A68]/5 ring-1 ring-[#0D7A68] p-3 transition cursor-pointer flex items-center justify-between gap-2"
                                                         data-name="{{ $dt->item_name }}"
                                                         data-price="{{ round($dt->unit_price) }}"
                                                         onclick="toggleShowCard(this)">
                                                        <div class="flex items-start gap-2.5 min-w-0">
                                                            <input type="checkbox" class="show-cb mt-0.5 rounded border-slate-300 text-[#0D7A68] pointer-events-none" checked>
                                                            <div class="min-w-0">
                                                                <p class="text-xs font-bold text-slate-800 leading-snug">{{ $dt->item_name }}</p>
                                                                <p class="text-xs font-bold text-[#0D7A68] mt-0.5">{{ number_format($dt->unit_price, 0, ',', '.') }} đ <span class="text-[10px] font-bold text-slate-500">(Theo đơn BS kê)</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="show-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 shrink-0" onclick="event.stopPropagation()">
                                                            <button type="button" onclick="changeShowQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">-</button>
                                                            <input type="text" readonly value="{{ $dt->quantity }}" class="show-qty w-6 text-center text-xs font-bold border-0 p-0 bg-transparent focus:ring-0">
                                                            <button type="button" onclick="changeShowQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold">+</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Thanh hiển thị tổng tiền tự động & nút Cập nhật -->
                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
                                        <div class="flex flex-wrap items-center gap-4 text-xs">
                                            <div>Tiền DV: <strong class="text-slate-900" id="showSrvTotal">0 đ</strong></div>
                                            <div>Tiền thuốc: <strong class="text-slate-900" id="showMedTotal">0 đ</strong></div>
                                            <div>VAT ({{ $vatRateShow }}%): <strong class="text-slate-700" id="showVatTotal" data-rate="{{ $vatRateShow }}">0 đ</strong></div>
                                            <div class="text-xs">Cần thanh toán: <strong class="text-base font-bold text-slate-900" id="showFinalPreview">0 đ</strong></div>
                                        </div>
                                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold uppercase tracking-wide shadow-xs transition shrink-0">
                                            💾 Áp dụng Dịch vụ & Thuốc đã chọn
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- Lịch sử thanh toán -->
                        @if($invoice->payments && $invoice->payments->count() > 0)
                            <div class="mt-8 pt-6 border-t border-slate-100">
                                <h4 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Lịch sử thanh toán đã ghi nhận
                                </h4>
                                <div class="space-y-2">
                                    @foreach($invoice->payments as $pmt)
                                        <div class="flex justify-between items-center text-xs bg-emerald-50/50 p-3 rounded-xl border border-emerald-200/60 text-emerald-950">
                                            <div>
                                                <span class="font-bold uppercase">{{ $pmt->payment_method }}</span>
                                                <span class="text-[11px] text-slate-400 ml-2">({{ $pmt->created_at->format('d/m/Y H:i') }})</span>
                                            </div>
                                            <span class="font-bold text-sm text-emerald-700">+ {{ number_format($pmt->amount, 0, ',', '.') }} đ</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cột phải: VietQR Code & Thao tác Thu tiền (1/3) -->
                <div class="space-y-6">
                    <!-- Khối VietQR -->
                    <div class="bg-gradient-to-br from-[#095246] via-[#0D7A68] to-[#0A4B40] rounded-2xl shadow-sm p-6 text-white text-center border border-teal-800">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-semibold uppercase tracking-wider mb-3">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            Quét Mã VietQR Chuyển Khoản
                        </div>

                        <div class="bg-white p-3 rounded-2xl shadow-sm inline-block mx-auto my-2 max-w-[240px]">
                            <img src="{{ $vietQrUrl }}" alt="VietQR Nha Khoa Smile" class="w-full h-auto rounded-xl">
                        </div>

                        <p class="text-xs text-teal-100 mt-2">Tự động nhận diện thanh toán qua VietQR</p>

                        <!-- Chi tiết thông tin chuyển khoản -->
                        <div class="mt-4 bg-white/10 backdrop-blur rounded-xl p-3 text-left space-y-2 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-teal-100">Ngân hàng:</span>
                                <span class="font-bold text-white uppercase">{{ $bankDisplayName }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-teal-100">Số tài khoản:</span>
                                <div class="flex items-center gap-1">
                                    <span class="font-mono font-bold text-amber-300 text-sm" id="stkText">{{ $accountNo }}</span>
                                    <button onclick="copyToClipboard('{{ $accountNo }}', 'Đã sao chép số tài khoản!')" class="p-1 hover:bg-white/20 rounded" title="Sao chép STK">
                                        📋
                                    </button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-teal-100">Chủ tài khoản:</span>
                                <span class="font-bold text-white uppercase truncate max-w-[140px]">{{ $accountName }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-teal-100">Số tiền:</span>
                                <span class="font-bold text-amber-300">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="flex justify-between items-center pt-1 border-t border-white/20">
                                <span class="text-teal-100">Nội dung CK:</span>
                                <div class="flex items-center gap-1">
                                    <span class="font-mono font-bold text-emerald-300">{{ $transferContent }}</span>
                                    <button onclick="copyToClipboard('{{ $transferContent }}', 'Đã sao chép nội dung CK!')" class="p-1 hover:bg-white/20 rounded" title="Sao chép nội dung">
                                        📋
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                            <div class="mt-3 flex items-center justify-between text-xs px-1">
                                <span class="inline-flex items-center gap-1.5 text-teal-100">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    Lắng nghe Webhook tự động
                                </span>
                                <button type="button" onclick="simulateReceptionistPayment('{{ $invoice->invoice_code }}')" class="text-amber-300 hover:text-white underline font-bold transition">
                                    ⚡ Test Webhook QR
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Thao tác Thu tiền / Cập nhật thanh toán -->
                    @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                            <h4 class="font-bold text-slate-900 mb-4 text-sm flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                                Xác nhận thu tiền
                            </h4>

                            <form action="{{ route('receptionist.invoices.pay', $invoice) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Phương thức thanh toán <span class="text-red-500">*</span></label>
                                    <select name="payment_method" class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                                        <option value="Chuyển khoản (VietQR)">Chuyển khoản (VietQR / Internet Banking)</option>
                                        <option value="Tiền mặt">Tiền mặt (Cash)</option>
                                        <option value="Thẻ POS">Quẹt thẻ ngân hàng (POS)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Số tiền cần thanh toán</label>
                                    <input type="hidden" name="amount" value="{{ round($invoice->final_amount) }}">
                                    <div class="w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-600 uppercase">Tổng thu:</span>
                                        <span class="text-lg font-bold text-slate-900">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                                    </div>
                                </div>

                                <button type="submit" class="w-full py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center justify-center gap-2">
                                    <span>✓ Xác Nhận Đã Thanh Toán</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text, message) {
            navigator.clipboard.writeText(text).then(function() {
                alert(message);
            }).catch(function() {
                prompt("Sao chép thủ công:", text);
            });
        }

        function toggleShowCard(card) {
            const cb = card.querySelector('.show-cb');
            cb.checked = !cb.checked;
            const qtyBox = card.querySelector('.show-qty-box');

            if (cb.checked) {
                card.classList.remove('border-slate-200', 'bg-white');
                card.classList.add('border-[#0D7A68]', 'bg-[#0D7A68]/5', 'ring-1', 'ring-[#0D7A68]');
                qtyBox.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                card.classList.remove('border-[#0D7A68]', 'bg-[#0D7A68]/5', 'ring-1', 'ring-[#0D7A68]');
                card.classList.add('border-slate-200', 'bg-white');
                qtyBox.classList.add('opacity-40', 'pointer-events-none');
                card.querySelector('.show-qty').value = 1;
            }
            recalcShowSelector();
        }

        function changeShowQty(btn, delta) {
            const card = btn.closest('.show-item-card');
            const input = card.querySelector('.show-qty');
            let v = parseInt(input.value, 10) || 1;
            input.value = Math.max(1, v + delta);
            recalcShowSelector();
        }

        function recalcShowSelector() {
            const container = document.getElementById('showGeneratedItemsContainer');
            if (!container) return;
            container.innerHTML = '';
            let srvTotal = 0;
            let medTotal = 0;
            let idx = 0;

            document.querySelectorAll('#showServicesGrid .show-item-card').forEach(card => {
                if (card.querySelector('.show-cb').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.show-qty').value, 10) || 1;
                    srvTotal += price * qty;
                    container.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${idx}][name]" value="${name}">
                        <input type="hidden" name="items[${idx}][price]" value="${price}">
                        <input type="hidden" name="items[${idx}][quantity]" value="${qty}">
                    `);
                    idx++;
                }
            });

            document.querySelectorAll('#showMedicinesGrid .show-item-card').forEach(card => {
                if (card.querySelector('.show-cb').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.show-qty').value, 10) || 1;
                    medTotal += price * qty;
                    container.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${idx}][name]" value="${name}">
                        <input type="hidden" name="items[${idx}][price]" value="${price}">
                        <input type="hidden" name="items[${idx}][quantity]" value="${qty}">
                    `);
                    idx++;
                }
            });

            const subtotal = srvTotal + medTotal;
            const discount = parseFloat(document.getElementById('showHiddenDiscount')?.value) || 0;
            const afterDiscount = Math.max(0, subtotal - discount);
            const vatEl = document.getElementById('showVatTotal');
            const vatRate = vatEl ? (parseFloat(vatEl.getAttribute('data-rate')) || 10) : 10;
            const vatAmount = Math.round(afterDiscount * (vatRate / 100));
            const finalAmount = afterDiscount + vatAmount;

            document.getElementById('showSrvTotal').textContent = new Intl.NumberFormat('vi-VN').format(srvTotal) + ' đ';
            document.getElementById('showMedTotal').textContent = new Intl.NumberFormat('vi-VN').format(medTotal) + ' đ';
            if (vatEl) vatEl.textContent = new Intl.NumberFormat('vi-VN').format(vatAmount) + ' đ';
            document.getElementById('showFinalPreview').textContent = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' đ';
        }

        document.addEventListener('DOMContentLoaded', recalcShowSelector);

        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
        // Tự động kiểm tra hóa đơn đã thanh toán qua Webhook chưa
        setInterval(async function () {
            try {
                const res = await fetch('/api/invoices/{{ $invoice->invoice_code }}/status');
                const data = await res.json();
                if (data.is_paid) {
                    window.location.reload();
                }
            } catch (e) {}
        }, 4000);

        async function simulateReceptionistPayment(code) {
            if (!confirm('Bạn có muốn mô phỏng Webhook Ngân hàng gửi giao dịch thanh toán thành công cho hóa đơn #' + code + '?')) return;
            try {
                const res = await fetch('/api/payment/simulate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ invoice_code: code })
                });
                const data = await res.json();
                if (data.success) {
                    alert('Webhook xác nhận thành công! Hóa đơn đã tự động chuyển sang ĐÃ THANH TOÁN.');
                    window.location.reload();
                } else {
                    alert(data.message || 'Mô phỏng thất bại.');
                }
            } catch (err) {
                alert('Lỗi kết nối API: ' + err.message);
            }
        }
        @endif
    </script>
</x-app-layout>
