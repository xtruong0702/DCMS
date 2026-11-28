<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #{{ $invoice->invoice_code }} - {{ $clinicSettings['clinic_name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,600;0,700;1,600&family=Inter:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 13px; color: #000; }
            @page { margin: 12mm; size: auto; }
        }
        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, .invoice-title {
            font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
            font-weight: 700;
        }
        .font-mono, td.text-right, .tabular-nums, .price {
            font-family: 'Inter', monospace !important;
            font-variant-numeric: tabular-nums !important;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8">
    @php
        $rawBankId = $settings['bank_id'] ?? ($clinicSettings['bank_id'] ?? 'MB');
        $rawAccNo = $settings['bank_account_no'] ?? ($clinicSettings['bank_account_no'] ?? '1626262696969');
        $rawAccName = $settings['bank_account_name'] ?? ($clinicSettings['bank_account_name'] ?? 'PHAM XUAN TRUONG');

        $bankId = !empty($rawBankId) ? strtoupper(trim($rawBankId)) : 'MB';
        $accountNo = !empty($rawAccNo) ? trim($rawAccNo) : '1626262696969';
        $accountName = !empty($rawAccName) ? trim($rawAccName) : 'PHAM XUAN TRUONG';
        $bankLabels = ['MB' => 'MBBank (MB)', 'TCB' => 'Techcombank (TCB)', 'VCB' => 'Vietcombank (VCB)', 'ICB' => 'VietinBank (CTG)', 'BIDV' => 'BIDV', 'ACB' => 'ACB', 'TPB' => 'TPBank (TPB)', 'VPB' => 'VPBank (VPB)'];
        $bankDisplayName = $bankLabels[$bankId] ?? $bankId;

        $paidAmount = (float) $invoice->payments->where('status', 'completed')->sum('amount');
        $remainingAmount = max(0, (float) $invoice->final_amount - $paidAmount);
        $qrAmount = $remainingAmount > 0 ? round($remainingAmount) : round($invoice->final_amount);

        $transferContent = 'THANH TOAN ' . $invoice->invoice_code;
        $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount=" . $qrAmount . "&addInfo=" . urlencode($transferContent) . "&accountName=" . urlencode($accountName);
    @endphp

    <!-- Thanh nút thao tác (ẩn khi in) -->
    <div class="max-w-3xl mx-auto mb-6 flex justify-between items-center no-print bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <a href="{{ route('receptionist.invoices.show', $invoice) }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center gap-1">
            &larr; Quay lại chi tiết hóa đơn
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold flex items-center gap-2 shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                In Hóa Đơn (Ctrl + P)
            </button>
        </div>
    </div>

    <!-- Khổ in Hóa đơn -->
    <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-indigo-600 pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-black text-indigo-800 uppercase tracking-tight">{{ $clinicSettings['clinic_name'] }}</h1>
                <p class="text-xs text-gray-600 mt-1">{{ $clinicSettings['clinic_address'] }}</p>
                <p class="text-xs text-gray-600">Hotline: <span class="font-bold text-gray-800">{{ $clinicSettings['clinic_hotline'] }}</span></p>
                <p class="text-xs text-gray-600">Email: {{ $clinicSettings['clinic_email'] }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold uppercase tracking-wider text-gray-900">HÓA ĐƠN DỊCH VỤ</h2>
                <p class="text-sm font-mono font-bold text-indigo-700 mt-1">#{{ $invoice->invoice_code }}</p>
                <p class="text-xs text-gray-500">Ngày in: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Khách hàng -->
        <div class="grid grid-cols-2 gap-4 text-xs mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
            <div>
                <p><span class="text-gray-500">Khách hàng:</span> <span class="font-bold text-sm text-gray-900 uppercase">{{ $invoice->patient->name ?? 'Khách vãng lai' }}</span></p>
                <p class="mt-1"><span class="text-gray-500">Mã bệnh nhân:</span> <span class="font-mono font-semibold">{{ $invoice->patient->patient_code ?? '---' }}</span></p>
                <p class="mt-1"><span class="text-gray-500">Điện thoại:</span> <span class="font-semibold">{{ $invoice->patient->phone ?? '---' }}</span></p>
                <p class="mt-1"><span class="text-gray-500">Địa chỉ:</span> {{ $invoice->patient->address ?? '---' }}</p>
            </div>
            <div class="text-right">
                <p><span class="text-gray-500">Ngày lập phiếu:</span> <span class="font-semibold">{{ $invoice->created_at->format('d/m/Y H:i') }}</span></p>
                @if($invoice->appointment)
                    <p class="mt-1"><span class="text-gray-500">Bác sĩ khám:</span> <span class="font-bold text-gray-800">{{ $invoice->appointment->doctor->user->name ?? '---' }}</span></p>
                @endif
                <p class="mt-2">
                    <span class="text-gray-500">Trạng thái:</span>
                    @if($invoice->status === 'paid')
                        <span class="font-bold text-green-700 uppercase border border-green-500 bg-green-50 px-2 py-0.5 rounded">Đã thanh toán</span>
                    @else
                        <span class="font-bold text-amber-700 uppercase border border-amber-500 bg-amber-50 px-2 py-0.5 rounded">Chưa thanh toán</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Bảng dịch vụ -->
        <table class="w-full text-left text-xs mb-6 border-collapse">
            <thead>
                <tr class="border-y-2 border-gray-800 bg-gray-100 text-gray-800 font-bold uppercase">
                    <th class="py-2.5 px-3 text-center w-12">STT</th>
                    <th class="py-2.5 px-3">Dịch vụ / Sản phẩm</th>
                    <th class="py-2.5 px-3 text-center w-16">SL</th>
                    <th class="py-2.5 px-3 text-right w-28">Đơn giá</th>
                    <th class="py-2.5 px-3 text-right w-32">Thành tiền</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($invoice->details as $idx => $detail)
                    <tr>
                        <td class="py-2 px-3 text-center text-gray-500">{{ $idx + 1 }}</td>
                        <td class="py-2 px-3 font-semibold text-gray-900">{{ $detail->item_name }}</td>
                        <td class="py-2 px-3 text-center font-bold">{{ $detail->quantity }}</td>
                        <td class="py-2 px-3 text-right text-gray-700">{{ number_format($detail->unit_price, 0, ',', '.') }} đ</td>
                        <td class="py-2 px-3 text-right font-bold text-gray-900">{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Chưa có chi tiết dịch vụ.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Khối Tổng tiền & VietQR -->
        @php
            $printPrescription = $invoice->appointment?->medicalRecord?->prescription;
        @endphp
        @if($printPrescription && $printPrescription->details && $printPrescription->details->count() > 0)
            <div class="mb-6 p-4 rounded-lg border border-gray-300 bg-gray-50/70 text-xs">
                <div class="font-bold text-gray-900 uppercase mb-2">💊 Chi Tiết Đơn Thuốc & Hướng Dẫn Sử Dụng (BS. {{ $invoice->appointment->doctor->user->name ?? 'Chuyên khoa' }})</div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-300 text-gray-600">
                            <th class="py-1 pr-2">Tên thuốc</th>
                            <th class="py-1 px-2 text-center">SL</th>
                            <th class="py-1 px-2">Liều dùng</th>
                            <th class="py-1 pl-2">Cách uống</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($printPrescription->details as $pItem)
                            <tr>
                                <td class="py-1.5 pr-2 font-bold text-gray-900">{{ $pItem->medicine_name }}</td>
                                <td class="py-1.5 px-2 text-center font-bold">{{ $pItem->quantity }}</td>
                                <td class="py-1.5 px-2">{{ $pItem->dosage ?: '---' }}</td>
                                <td class="py-1.5 pl-2">{{ $pItem->instructions ?: '---' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(!empty($printPrescription->notes))
                    <p class="mt-2 pt-1.5 border-t border-gray-200 text-gray-700"><strong>Lời dặn của Bác sĩ:</strong> {{ $printPrescription->notes }}</p>
                @endif
            </div>
        @endif
        <div class="flex justify-between items-start pt-2 border-t-2 border-gray-800 gap-6">
            <!-- VietQR (nếu chưa thanh toán hoặc để khách tra cứu) -->
            <div class="w-1/2 flex items-center gap-3">
                <div class="p-1.5 border border-gray-300 rounded-lg inline-block bg-white shadow-sm">
                    <img src="{{ $vietQrUrl }}" alt="VietQR" class="w-28 h-28 object-contain">
                </div>
                <div class="text-[11px] space-y-0.5 text-gray-600">
                    <p class="font-bold text-gray-800 uppercase">Quét VietQR Thanh Toán</p>
                    <p>Ngân hàng: <span class="font-bold text-gray-900">{{ $bankDisplayName }}</span></p>
                    <p>STK: <span class="font-mono font-bold text-indigo-700">{{ $accountNo }}</span></p>
                    <p>Chủ TK: <span class="font-bold text-gray-800 uppercase">{{ $accountName }}</span></p>
                    <p>Nội dung: <span class="font-mono font-bold text-indigo-700">{{ $transferContent }}</span></p>
                </div>
            </div>

            @php
                $medicineSubtotal = $invoice->details->filter(fn($d) => str_starts_with(mb_strtolower($d->item_name), 'thuốc') || str_contains(mb_strtolower($d->item_name), 'gói thuốc'))->sum('total_price');
                $serviceSubtotal = max(0, $invoice->total_amount - $medicineSubtotal);
            @endphp
            <!-- Tổng kết tiền -->
            <div class="w-1/2 text-xs space-y-1.5">
                <div class="flex justify-between text-gray-600">
                    <span>Tiền dịch vụ khám:</span>
                    <span class="font-semibold">{{ number_format($serviceSubtotal, 0, ',', '.') }} đ</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Tiền thuốc kèm theo:</span>
                    <span class="font-semibold">{{ number_format($medicineSubtotal, 0, ',', '.') }} đ</span>
                </div>
                <div class="flex justify-between text-gray-600 pt-1 border-t border-dashed border-gray-200">
                    <span>Tổng tạm tính:</span>
                    <span class="font-bold">{{ number_format($invoice->total_amount, 0, ',', '.') }} đ</span>
                </div>
                @if($invoice->discount > 0)
                <div class="flex justify-between text-green-700">
                    <span>Chiết khấu / Giảm giá:</span>
                    <span class="font-semibold">- {{ number_format($invoice->discount, 0, ',', '.') }} đ</span>
                </div>
                @endif
                <div class="flex justify-between text-gray-600">
                    <span>Thuế VAT ({{ (!empty($settings['vat_percentage']) && floatval($settings['vat_percentage']) > 0) ? $settings['vat_percentage'] : 10 }}%):</span>
                    <span class="font-semibold">+ {{ number_format($invoice->vat_amount, 0, ',', '.') }} đ</span>
                </div>
                <div class="flex justify-between text-sm font-black text-gray-900 pt-2 border-t border-gray-300">
                    <span class="uppercase">TỔNG THANH TOÁN:</span>
                    <span class="text-base text-red-600">{{ number_format($invoice->final_amount, 0, ',', '.') }} VNĐ</span>
                </div>
                @if($invoice->status === 'paid')
                    <div class="text-right text-[11px] text-green-700 font-bold mt-1">
                        ✓ Đã thanh toán đầy đủ
                    </div>
                @endif
            </div>
        </div>

        <!-- Chữ ký -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs mt-12 pt-6 border-t border-gray-100">
            <div>
                <p class="font-bold text-gray-800 uppercase">Khách hàng / Bệnh nhân</p>
                <p class="text-[10px] text-gray-400 italic">(Ký và ghi rõ họ tên)</p>
                <div class="h-20"></div>
                <p class="font-semibold text-gray-800">{{ $invoice->patient->name ?? '' }}</p>
            </div>
            <div>
                <p class="font-bold text-gray-800 uppercase">Người lập phiếu</p>
                <p class="text-[10px] text-gray-400 italic">(Ký và ghi rõ họ tên)</p>
                <div class="h-20"></div>
                <p class="font-semibold text-gray-800">{{ auth()->user()->name ?? 'Lễ tân' }}</p>
            </div>
        </div>

        <div class="mt-8 text-center text-[10px] text-gray-400 border-t border-gray-100 pt-3">
            Cảm ơn Quý khách đã tin tưởng và sử dụng dịch vụ tại {{ $clinicSettings['clinic_name'] }}!
        </div>
    </div>
</body>
</html>
