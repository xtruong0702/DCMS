@extends('layouts.patient')

@section('title', 'Chi tiết hóa đơn #' . $invoice->invoice_code)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('patient.invoices') }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-[#0D7A68] transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Quay lại danh sách hóa đơn
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            In hóa đơn
        </button>
    </div>

    @php
        $rawBankId = $settings['bank_id'] ?? '';
        $rawAccNo = $settings['bank_account_no'] ?? '';
        $rawAccName = $settings['bank_account_name'] ?? '';

        $bankId = !empty($rawBankId) ? strtoupper(trim($rawBankId)) : 'MB';
        $accountNo = !empty($rawAccNo) ? trim($rawAccNo) : '1626262696969';
        $accountName = !empty($rawAccName) ? trim($rawAccName) : 'PHAM XUAN TRUONG';
        $bankLabels = ['MB' => 'MBBank (MB)', 'TCB' => 'Techcombank (TCB)', 'VCB' => 'Vietcombank (VCB)', 'ACB' => 'ACB'];
        $bankDisplayName = $bankLabels[$bankId] ?? $bankId;

        $transferContent = 'THANH TOAN ' . $invoice->invoice_code;
        $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount=" . round($invoice->final_amount) . "&addInfo=" . urlencode($transferContent) . "&accountName=" . urlencode($accountName);
    @endphp

    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#0D7A68] via-[#0B6858] to-[#08483d] p-6 md:p-8 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon fill="currentColor" points="0,100 100,0 100,100"/></svg>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between gap-6 relative z-10 text-white">
                <div class="flex items-start gap-3.5">
                    <div class="w-12 h-12 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-md border border-white/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-xl tracking-tight uppercase mb-0.5">{{ $settings['clinic_name'] ?? 'Nha Khoa Smile' }}</h2>
                        <p class="text-teal-100 text-xs font-medium">{{ $settings['clinic_address'] ?? '123 Nguyễn Văn Cừ, Quận 5, TP.HCM' }}</p>
                        <p class="text-teal-100 text-xs font-medium">Hotline: {{ $settings['clinic_hotline'] ?? '0775 761 388' }}</p>
                    </div>
                </div>
                <div class="md:text-right flex flex-col justify-end">
                    <h3 class="text-2xl font-black text-white tracking-wider uppercase mb-0.5">HÓA ĐƠN ĐIỆN TỬ</h3>
                    <p class="text-xs text-teal-100 font-medium">Ngày lập: {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-xs text-teal-100 font-mono font-bold">Mã số: #{{ $invoice->invoice_code }}</p>
                </div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="bg-gray-50/50 p-6 md:px-12 md:py-6 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Khách hàng / Bệnh nhân</h4>
                    <p class="font-black text-xl text-slate-800 uppercase">{{ $invoice->patient->name }}</p>
                    <p class="text-slate-600 font-medium text-sm">Mã BN: {{ $invoice->patient->patient_code }} | SĐT: {{ $invoice->patient->phone }}</p>
                </div>
                <div class="md:text-right flex flex-col justify-center">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Trạng thái thanh toán</h4>
                    @if($invoice->status == 'paid')
                        <div class="inline-flex items-center md:justify-end">
                            <div class="bg-green-100 text-green-700 px-4 py-1.5 rounded-xl font-bold border border-green-200 shadow-sm flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                ĐÃ THANH TOÁN
                            </div>
                        </div>
                    @elseif($invoice->status == 'cancelled')
                        <div class="inline-flex items-center md:justify-end">
                            <div class="bg-red-100 text-red-700 px-4 py-1.5 rounded-xl font-bold border border-red-200 shadow-sm">
                                ĐÃ HỦY BỎ
                            </div>
                        </div>
                    @else
                        <div class="inline-flex items-center md:justify-end">
                            <div class="bg-amber-100 text-amber-800 px-4 py-1.5 rounded-xl font-bold border border-amber-200 shadow-sm animate-pulse">
                                CHƯA THANH TOÁN
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 md:p-12">
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-slate-200 text-slate-800">
                            <th class="py-3 px-2 font-black uppercase tracking-wider text-xs">STT</th>
                            <th class="py-3 px-2 font-black uppercase tracking-wider text-xs">Dịch vụ / Sản phẩm</th>
                            <th class="py-3 px-2 font-black uppercase tracking-wider text-xs text-center">SL</th>
                            <th class="py-3 px-2 font-black uppercase tracking-wider text-xs text-right">Đơn giá</th>
                            <th class="py-3 px-2 font-black uppercase tracking-wider text-xs text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoice->details as $index => $detail)
                        <tr class="group hover:bg-slate-50/50">
                            <td class="py-3 px-2 text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-2 font-bold text-slate-800">{{ $detail->item_name }}</td>
                            <td class="py-3 px-2 text-center text-slate-600 font-bold">{{ $detail->quantity }}</td>
                            <td class="py-3 px-2 text-right text-slate-600 font-medium">{{ number_format($detail->unit_price, 0, ',', '.') }} đ</td>
                            <td class="py-3 px-2 text-right font-black text-slate-800">{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 font-medium bg-gray-50 rounded-xl">Chi tiết hóa đơn đang trống.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start gap-8 pt-4 border-t border-gray-100">
                <div class="w-full md:w-1/2 space-y-4">
                    @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                        <!-- Khối quét VietQR trực tuyến cho Bệnh nhân -->
                        <div class="bg-gradient-to-br from-[#0D7A68] via-[#0B6858] to-[#08483d] p-5 rounded-2xl text-white shadow-md flex flex-col sm:flex-row items-center gap-5">
                            <div class="bg-white p-2 rounded-xl shrink-0">
                                <img src="{{ $vietQrUrl }}" alt="VietQR" class="w-32 h-32 object-contain">
                            </div>
                            <div class="space-y-1 text-xs w-full">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="bg-amber-400 text-slate-900 font-extrabold px-2 py-0.5 rounded text-[10px] uppercase">Quét QR Thanh Toán</span>
                                    <span class="inline-flex items-center gap-1.5 text-[11px] text-teal-200 font-semibold bg-teal-950/40 px-2 py-0.5 rounded-full border border-teal-500/30">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        Tự động nhận diện
                                    </span>
                                </div>
                                <p class="text-teal-100 mt-1">Ngân hàng: <span class="font-bold text-white">{{ $bankDisplayName }}</span></p>
                                <p class="text-teal-100">Số TK: <span class="font-mono font-bold text-amber-300 text-sm">{{ $accountNo }}</span></p>
                                <p class="text-teal-100">Chủ TK: <span class="font-bold text-white uppercase">{{ $accountName }}</span></p>
                                <p class="text-teal-100">Nội dung: <span class="font-mono font-bold text-emerald-300">{{ $transferContent }}</span></p>
                                <p class="text-[11px] text-teal-200 italic pt-1">Mở app Ngân hàng quét QR. Hệ thống sẽ tự động chuyển trạng thái khi tiền vào TK.</p>
                            </div>
                        </div>

                        <!-- Nút kiểm tra trạng thái thanh toán -->
                        <div class="flex flex-wrap items-center gap-2 pt-2">
                            <button id="btn-check-payment" type="button" class="text-xs font-bold text-[#0D7A68] bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-xl px-3.5 py-2 flex items-center gap-1.5 transition shadow-2xs">
                                <svg class="w-4 h-4 text-[#0D7A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Tôi đã chuyển khoản xong
                            </button>
                        </div>
                    @elseif($invoice->status === 'paid')
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200 p-5 rounded-2xl flex items-start gap-4 shadow-2xs">
                            <div class="w-12 h-12 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-base font-black text-emerald-900">Thanh toán thành công, cảm ơn quý khách!</h4>
                                <p class="text-xs text-emerald-800 leading-relaxed">
                                    Hóa đơn <strong class="font-mono">#{{ $invoice->invoice_code }}</strong> ({{ number_format($invoice->final_amount, 0, ',', '.') }} đ) đã được ghi nhận hoàn tất lúc {{ $invoice->updated_at->format('H:i d/m/Y') }}. Cảm ơn quý khách đã tin tưởng {{ $settings['clinic_name'] ?? 'Nha Khoa Smile' }}.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl text-rose-800 text-xs font-medium">
                            Hóa đơn này đã bị hủy bỏ. Mọi thắc mắc vui lòng liên hệ Hotline {{ $settings['clinic_hotline'] ?? '0775 761 388' }}.
                        </div>
                    @endif
                </div>
                
                @php
                    $medicineSubtotal = $invoice->details->filter(fn($d) => str_starts_with(mb_strtolower($d->item_name), 'thuốc') || str_contains(mb_strtolower($d->item_name), 'gói thuốc'))->sum('total_price');
                    $serviceSubtotal = max(0, $invoice->total_amount - $medicineSubtotal);
                @endphp
                <div class="w-full md:w-80 space-y-3">
                    <div class="flex justify-between text-slate-600 font-medium text-sm">
                        <span>🦷 Tiền dịch vụ khám:</span>
                        <span class="font-bold text-slate-800">{{ number_format($serviceSubtotal, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="flex justify-between text-slate-600 font-medium text-sm">
                        <span>💊 Tiền thuốc kèm theo:</span>
                        <span class="font-bold text-emerald-700">{{ number_format($medicineSubtotal, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="flex justify-between text-slate-600 font-medium text-sm pt-2 border-t border-dashed border-slate-200">
                        <span>Tạm tính:</span>
                        <span class="font-bold">{{ number_format($invoice->total_amount, 0, ',', '.') }} đ</span>
                    </div>
                    <div class="flex justify-between text-slate-600 font-medium text-sm">
                        <span>Thuế VAT ({{ (isset($settings['vat_percentage']) && $settings['vat_percentage'] !== '' && is_numeric($settings['vat_percentage'])) ? $settings['vat_percentage'] : 10 }}%):</span>
                        <span>+{{ number_format($invoice->vat_amount, 0, ',', '.') }} đ</span>
                    </div>
                    @if($invoice->discount > 0)
                    <div class="flex justify-between text-green-600 font-medium text-sm">
                        <span>Giảm giá:</span>
                        <span>-{{ number_format($invoice->discount, 0, ',', '.') }} đ</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center border-t-2 border-slate-200 pt-4 mt-4">
                        <span class="font-black text-base text-slate-800 uppercase">Thành tiền:</span>
                        <span class="font-black text-2xl text-[#0D7A68] tracking-tight">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
<!-- Modal Thông báo Thanh toán thành công -->
<div id="payment-success-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl text-center transform transition-all">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-xl font-black text-slate-800 mb-1">Thanh toán Thành công!</h3>
        <p class="text-sm text-slate-500 mb-6">Hệ thống đã nhận diện biến động số dư từ ngân hàng. Đang cập nhật hóa đơn...</p>
        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
            <div class="bg-emerald-500 h-1.5 rounded-full animate-pulse w-full"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const invoiceCode = '{{ $invoice->invoice_code }}';
        let isChecking = false;

        async function checkInvoiceStatus(manual = false) {
            if (isChecking) return;
            isChecking = true;
            try {
                const res = await fetch(`/api/invoices/${invoiceCode}/status`);
                const data = await res.json();
                if (data.is_paid) {
                    showSuccessModal();
                    setTimeout(() => window.location.reload(), 1500);
                } else if (manual) {
                    alert('Hệ thống đang chờ giao dịch chuyển khoản cho hóa đơn #' + invoiceCode + ' từ Ngân hàng. Vui lòng thử lại sau vài giây!');
                }
            } catch (err) {
                console.error('Lỗi kiểm tra hóa đơn:', err);
            } finally {
                isChecking = false;
            }
        }

        // Tự động kiểm tra polling mỗi 3 giây
        const timer = setInterval(() => checkInvoiceStatus(false), 3000);

        // Nút kiểm tra thủ công
        const btnCheck = document.getElementById('btn-check-payment');
        if (btnCheck) {
            btnCheck.addEventListener('click', () => checkInvoiceStatus(true));
        }

        function showSuccessModal() {
            clearInterval(timer);
            const modal = document.getElementById('payment-success-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
    });
</script>
@endif
@endsection