<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    🧾 Chi Tiết Hóa Đơn - <span class="text-indigo-600 font-mono">#{{ $invoice->invoice_code }}</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Ngày lập: {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                @if($invoice->status !== 'cancelled')
                    <form action="{{ route('admin.invoices.refund', $invoice) }}" method="POST" onsubmit="return confirm('Xác nhận hủy / hoàn trả hóa đơn #{{ $invoice->invoice_code }}?');">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-bold transition">
                            ↩️ Hoàn trả / Hủy HĐ
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.invoices.edit', $invoice) }}" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold transition">
                    ✏️ Cập nhật hóa đơn
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    🖨️ In Hóa Đơn
                </button>
                <a href="{{ route('admin.invoices.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    &larr; Danh sách
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-semibold">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-8" id="printable-area">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start border-b border-gray-200 pb-6 mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-black text-indigo-700 uppercase tracking-tight">Nha Khoa Smile</h2>
                        <p class="text-xs text-slate-500 mt-1">Hệ thống Quản lý Phòng khám Nha khoa DCMS</p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs uppercase font-bold text-slate-400">Hóa đơn thanh toán</span>
                        <p class="text-lg font-extrabold font-mono text-slate-900">#{{ $invoice->invoice_code }}</p>
                        <div class="mt-2">
                            @if($invoice->status == 'paid')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">✓ ĐÃ THANH TOÁN</span>
                            @elseif($invoice->status == 'cancelled')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">✕ ĐÃ HỦY BỎ</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">⏳ CHƯA THANH TOÁN</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-gray-100 mb-6 text-xs">
                    <div>
                        <span class="font-bold uppercase text-slate-400 block mb-1">Khách hàng / Bệnh nhân</span>
                        <p class="font-extrabold text-sm text-slate-900">{{ $invoice->patient->name ?? '---' }}</p>
                        <p class="text-slate-600 mt-0.5">Mã BN: <span class="font-mono font-bold">{{ $invoice->patient->patient_code ?? '---' }}</span> • SĐT: {{ $invoice->patient->phone ?? '---' }}</p>
                    </div>
                    <div>
                        <span class="font-bold uppercase text-slate-400 block mb-1">Thông tin lịch khám</span>
                        @if($invoice->appointment)
                            <p class="text-slate-700 font-semibold">Lịch hẹn #{{ $invoice->appointment->id }}</p>
                            <p class="text-slate-500 mt-0.5">Giờ khám: {{ \Carbon\Carbon::parse($invoice->appointment->appointment_time)->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="text-slate-400 italic">Hóa đơn lập trực tiếp</p>
                        @endif
                    </div>
                </div>

                <!-- Bảng chi tiết dịch vụ -->
                @if($invoice->details && $invoice->details->count() > 0)
                    <div class="overflow-x-auto border border-gray-200 rounded-xl mb-6">
                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 uppercase w-12">STT</th>
                                    <th class="px-4 py-3 text-left font-bold text-slate-600 uppercase">Dịch vụ / Sản phẩm</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 uppercase w-20">SL</th>
                                    <th class="px-4 py-3 text-right font-bold text-slate-600 uppercase w-32">Đơn giá</th>
                                    <th class="px-4 py-3 text-right font-bold text-slate-600 uppercase w-36">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($invoice->details as $idx => $detail)
                                    <tr>
                                        <td class="px-4 py-3 text-center text-slate-500">{{ $idx + 1 }}</td>
                                        <td class="px-4 py-3 font-bold text-slate-900">{{ $detail->item_name }}</td>
                                        <td class="px-4 py-3 text-center font-bold">{{ $detail->quantity }}</td>
                                        <td class="px-4 py-3 text-right text-slate-600">{{ number_format($detail->unit_price, 0, ',', '.') }} đ</td>
                                        <td class="px-4 py-3 text-right font-bold text-slate-900">{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @php
                    $medicineSubtotal = $invoice->details->filter(fn($d) => str_starts_with(mb_strtolower($d->item_name), 'thuốc') || str_contains(mb_strtolower($d->item_name), 'gói thuốc'))->sum('total_price');
                    $serviceSubtotal = max(0, $invoice->total_amount - $medicineSubtotal);
                    $adminPrescription = $invoice->appointment?->medicalRecord?->prescription;
                @endphp

                <!-- Chi tiết Đơn thuốc Bác sĩ đã kê (nếu có) -->
                @if($adminPrescription && $adminPrescription->details && $adminPrescription->details->count() > 0)
                    <div class="mb-6 bg-emerald-50/70 border border-emerald-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2.5 pb-2 border-b border-emerald-200/80">
                            <h4 class="text-xs font-extrabold uppercase text-emerald-800">
                                💊 Đơn Thuốc Bác Sĩ Đã Kê (BS. {{ $invoice->appointment->doctor->user->name ?? 'Chuyên khoa' }})
                            </h4>
                            <span class="text-[11px] font-bold text-emerald-700">{{ $adminPrescription->details->count() }} loại thuốc</span>
                        </div>
                        <div class="overflow-x-auto bg-white rounded-lg border border-emerald-200/70">
                            <table class="min-w-full divide-y divide-emerald-100 text-xs">
                                <thead class="bg-emerald-100/50 text-emerald-900">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-bold uppercase">Tên thuốc</th>
                                        <th class="px-3 py-2 text-center font-bold uppercase">Số lượng</th>
                                        <th class="px-3 py-2 text-left font-bold uppercase">Liều dùng</th>
                                        <th class="px-3 py-2 text-left font-bold uppercase">Hướng dẫn uống</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($adminPrescription->details as $pItem)
                                        <tr>
                                            <td class="px-3 py-2 font-extrabold text-slate-900">{{ $pItem->medicine_name }}</td>
                                            <td class="px-3 py-2 text-center font-black text-emerald-700">{{ $pItem->quantity }}</td>
                                            <td class="px-3 py-2 font-semibold text-slate-700">{{ $pItem->dosage ?: '---' }}</td>
                                            <td class="px-3 py-2 text-slate-600">{{ $pItem->instructions ?: '---' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(!empty($adminPrescription->notes))
                            <p class="text-xs text-emerald-900 mt-2"><strong>Lời dặn của Bác sĩ:</strong> {{ $adminPrescription->notes }}</p>
                        @endif
                    </div>
                @endif

                <!-- Tổng kết số tiền -->
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <div class="w-full sm:w-80 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>🦷 Tiền dịch vụ khám:</span>
                            <span class="font-semibold text-indigo-700">{{ number_format($serviceSubtotal, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>💊 Tiền thuốc kèm theo:</span>
                            <span class="font-semibold text-emerald-700">{{ number_format($medicineSubtotal, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex justify-between text-slate-600 pt-1.5 border-t border-dashed border-gray-200">
                            <span>Tổng tạm tính:</span>
                            <span class="font-bold">{{ number_format($invoice->total_amount, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex justify-between text-emerald-600">
                            <span>Chiết khấu / Giảm giá:</span>
                            <span class="font-semibold">- {{ number_format($invoice->discount, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Thuế VAT:</span>
                            <span class="font-semibold">+ {{ number_format($invoice->vat_amount, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t-2 border-slate-800">
                            <span class="font-extrabold uppercase text-slate-900">Tổng thanh toán:</span>
                            <span class="font-black text-2xl text-red-600">{{ number_format($invoice->final_amount, 0, ',', '.') }} đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
