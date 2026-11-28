<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    ✏️ Cập Nhật Hóa Đơn - #{{ $invoice->invoice_code }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">Chọn lại dịch vụ khám & thuốc hoặc cập nhật trạng thái thanh toán</p>
            </div>
            <a href="{{ route('admin.invoices.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Quay lại danh sách
            </a>
        </div>
    </x-slot>

    @php
        $matchedDetailIds = [];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')
                <div id="adminEditGeneratedItems"></div>
                <input type="hidden" name="discount" value="{{ round($invoice->discount ?? 0) }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Khách hàng / Bệnh nhân</label>
                                <input type="text" disabled value="{{ $invoice->patient->name ?? '' }}" class="w-full bg-slate-100 rounded-xl border-slate-300 text-xs font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Trạng thái thanh toán <span class="text-red-500">*</span></label>
                                <select name="status" required class="w-full rounded-xl border-slate-300 text-xs font-bold">
                                    <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                    <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Đã hủy bỏ</option>
                                </select>
                            </div>
                        </div>

                        <!-- Chọn Dịch vụ khám -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-indigo-700 mb-4">1. Tích Chọn Dịch Vụ Khám</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="editServicesGrid">
                                @foreach($services as $srv)
                                    @php
                                        $matchedSrv = $invoice->details->first(function ($dt) use ($srv, $matchedDetailIds) {
                                            if (in_array($dt->id, $matchedDetailIds)) return false;
                                            $dtName = mb_strtolower(trim($dt->item_name));
                                            $sName = mb_strtolower(trim($srv->name));
                                            return $dtName === $sName 
                                                || $dtName === 'dịch vụ: ' . $sName
                                                || $dtName === 'dịch vụ/thủ thuật: ' . $sName
                                                || str_contains($dtName, $sName);
                                        });
                                        $checked = !is_null($matchedSrv);
                                        $q = $matchedSrv ? $matchedSrv->quantity : 1;
                                        if ($matchedSrv) {
                                            $matchedDetailIds[] = $matchedSrv->id;
                                        }
                                    @endphp
                                    <div class="adm-card srv-card rounded-xl border p-3.5 transition cursor-pointer flex items-center justify-between gap-2 {{ $checked ? 'border-indigo-500 bg-indigo-50/70 ring-1 ring-indigo-500' : 'border-slate-200 bg-white' }}"
                                         data-service-id="{{ $srv->id }}"
                                         data-name="Dịch vụ: {{ $srv->name }}"
                                         data-price="{{ round($srv->price) }}"
                                         onclick="toggleEditCard(this)">
                                        <div class="flex items-start gap-2.5">
                                            <input type="checkbox" class="adm-cb mt-0.5 rounded border-slate-300 text-indigo-600 pointer-events-none" {{ $checked ? 'checked' : '' }}>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $srv->name }}</p>
                                                <p class="text-xs font-extrabold text-indigo-600 mt-0.5">{{ number_format($srv->price, 0, ',', '.') }} đ</p>
                                            </div>
                                        </div>
                                        <div class="adm-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 {{ $checked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeEditQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">-</button>
                                            <input type="text" readonly value="{{ $checked ? $q : 1 }}" class="adm-qty w-6 text-center text-xs font-extrabold border-0 p-0 bg-transparent">
                                            <button type="button" onclick="changeEditQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Chọn Tiền thuốc -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 mb-4">2. Tích Chọn Tiền Thuốc</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="editMedicinesGrid">
                                @foreach($medicines as $med)
                                    @php
                                        $matchedMed = $invoice->details->first(function ($dt) use ($med, $matchedDetailIds) {
                                            if (in_array($dt->id, $matchedDetailIds)) return false;
                                            $dtName = mb_strtolower(trim($dt->item_name));
                                            $mName = mb_strtolower(trim($med->name));
                                            return str_contains($dtName, $mName);
                                        });
                                        $mChecked = !is_null($matchedMed);
                                        $mq = $matchedMed ? $matchedMed->quantity : 1;
                                        if ($matchedMed) {
                                            $matchedDetailIds[] = $matchedMed->id;
                                        }
                                    @endphp
                                    <div class="adm-card med-card rounded-xl border p-3.5 transition cursor-pointer flex items-center justify-between gap-2 {{ $mChecked ? 'border-emerald-500 bg-emerald-50/70 ring-1 ring-emerald-500' : 'border-slate-200 bg-white' }}"
                                         data-medicine-id="{{ $med->id }}"
                                         data-name="Thuốc: {{ $med->name }} ({{ $med->unit ?? 'Đơn vị' }})"
                                         data-price="{{ round($med->price) }}"
                                         onclick="toggleEditCard(this)">
                                        <div class="flex items-start gap-2.5">
                                            <input type="checkbox" class="adm-cb mt-0.5 rounded border-slate-300 text-emerald-600 pointer-events-none" {{ $mChecked ? 'checked' : '' }}>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $med->name }}</p>
                                                <p class="text-xs font-extrabold text-emerald-600 mt-0.5">{{ number_format($med->price, 0, ',', '.') }} đ</p>
                                            </div>
                                        </div>
                                        <div class="adm-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 {{ $mChecked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeEditQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">-</button>
                                            <input type="text" readonly value="{{ $mChecked ? $mq : 1 }}" class="adm-qty w-6 text-center text-xs font-extrabold border-0 p-0 bg-transparent">
                                            <button type="button" onclick="changeEditQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- 3. Các mục Bác sĩ đã chỉ định trong hóa đơn -->
                        @php
                            $unmatchedAdminDetails = $invoice->details->whereNotIn('id', $matchedDetailIds);
                        @endphp
                        @if($unmatchedAdminDetails->count() > 0)
                            <div class="bg-white rounded-2xl shadow-xs border border-amber-200 p-6">
                                <h3 class="text-xs font-extrabold uppercase tracking-wider text-amber-800 mb-4 flex items-center gap-2">
                                    <span>📋</span>
                                    <span>3. Các Khoản Theo Chỉ Định Của Bác Sĩ (Đang có trong hóa đơn)</span>
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="editCustomGrid">
                                    @foreach($unmatchedAdminDetails as $udt)
                                        @php
                                            $isMed = str_starts_with(mb_strtolower($udt->item_name), 'thuốc') || str_contains(mb_strtolower($udt->item_name), 'gói thuốc');
                                        @endphp
                                        <div class="adm-card {{ $isMed ? 'med-card' : 'srv-card' }} rounded-xl border border-[#0D7A68] bg-[#0D7A68]/5 ring-1 ring-[#0D7A68] p-3.5 transition cursor-pointer flex items-center justify-between gap-2"
                                             data-name="{{ $udt->item_name }}"
                                             data-price="{{ round($udt->unit_price) }}"
                                             data-existing-detail-id="{{ $udt->id }}"
                                             data-medicine-id="{{ $udt->medicine_id }}"
                                             data-service-id="{{ $udt->service_id }}"
                                             onclick="toggleEditCard(this)">
                                            <div class="flex items-start gap-2.5">
                                                <input type="checkbox" class="adm-cb mt-0.5 rounded border-slate-300 text-[#0D7A68] pointer-events-none" checked>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800">{{ $udt->item_name }}</p>
                                                    <p class="text-xs font-extrabold text-[#0D7A68] mt-0.5">
                                                        {{ number_format($udt->unit_price, 0, ',', '.') }} đ
                                                        <span class="text-[10px] font-bold text-slate-500">(Theo đơn Bác sĩ)</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="adm-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5" onclick="event.stopPropagation()">
                                                <button type="button" onclick="changeEditQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">-</button>
                                                <input type="text" readonly value="{{ $udt->quantity }}" class="adm-qty w-6 text-center text-xs font-extrabold border-0 p-0 bg-transparent">
                                                <button type="button" onclick="changeEditQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">+</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-1 sticky top-24">
                        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-5 space-y-4">
                            <h3 class="text-sm font-extrabold uppercase text-indigo-700 border-b border-slate-100 pb-3">Tổng Hợp Thanh Toán</h3>
                            <div class="space-y-2.5 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tiền dịch vụ khám:</span>
                                    <strong id="editSrvTotal">0 đ</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tiền thuốc:</span>
                                    <strong class="text-emerald-700" id="editMedTotal">0 đ</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Thuế VAT ({{ $vatRate ?? 10 }}%):</span>
                                    <strong id="editVatTotal" data-rate="{{ $vatRate ?? 10 }}">0 đ</strong>
                                </div>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                                <p class="text-[11px] font-extrabold uppercase text-red-600">Số Tiền Cần Thanh Toán</p>
                                <p class="text-2xl font-black text-red-600 mt-1" id="editFinalTotal">0 đ</p>
                            </div>
                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs uppercase tracking-wider shadow-sm transition">
                                Cập Nhật Hóa Đơn
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEditCard(card) {
            const cb = card.querySelector('.adm-cb');
            cb.checked = !cb.checked;
            const qtyBox = card.querySelector('.adm-qty-box');
            const isMed = card.classList.contains('med-card');
            const borderCls = isMed ? 'border-emerald-500' : 'border-indigo-500';
            const bgCls = isMed ? 'bg-emerald-50/70' : 'bg-indigo-50/70';
            const ringCls = isMed ? 'ring-emerald-500' : 'ring-indigo-500';

            if (cb.checked) {
                card.classList.remove('border-slate-200', 'bg-white');
                card.classList.add(borderCls, bgCls, 'ring-1', ringCls);
                qtyBox.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                card.classList.remove(borderCls, bgCls, 'ring-1', ringCls);
                card.classList.add('border-slate-200', 'bg-white');
                qtyBox.classList.add('opacity-40', 'pointer-events-none');
                card.querySelector('.adm-qty').value = 1;
            }
            recalcEditAdm();
        }

        function changeEditQty(btn, delta) {
            const card = btn.closest('.adm-card');
            const input = card.querySelector('.adm-qty');
            input.value = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
            recalcEditAdm();
        }

        function recalcEditAdm() {
            const container = document.getElementById('adminEditGeneratedItems');
            container.innerHTML = '';
            let srvTotal = 0, medTotal = 0, idx = 0;

            document.querySelectorAll('.adm-card').forEach(card => {
                if (card.querySelector('.adm-cb').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const serviceId = card.getAttribute('data-service-id') || '';
                    const medicineId = card.getAttribute('data-medicine-id') || '';
                    const existingDetailId = card.getAttribute('data-existing-detail-id') || '';
                    const qty = parseInt(card.querySelector('.adm-qty').value, 10) || 1;
                    if (card.classList.contains('med-card')) {
                        medTotal += price * qty;
                    } else {
                        srvTotal += price * qty;
                    }
                    container.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${idx}][service_id]" value="${serviceId}">
                        <input type="hidden" name="items[${idx}][medicine_id]" value="${medicineId}">
                        <input type="hidden" name="items[${idx}][existing_detail_id]" value="${existingDetailId}">
                        <input type="hidden" name="items[${idx}][quantity]" value="${qty}">
                    `);
                    idx++;
                }
            });

            const subtotal = srvTotal + medTotal;
            const vatEl = document.getElementById('editVatTotal');
            const vatRate = parseFloat(vatEl.getAttribute('data-rate')) || 10;
            const vatAmount = Math.round(subtotal * (vatRate / 100));
            const finalAmount = subtotal + vatAmount;

            document.getElementById('editSrvTotal').textContent = new Intl.NumberFormat('vi-VN').format(srvTotal) + ' đ';
            document.getElementById('editMedTotal').textContent = new Intl.NumberFormat('vi-VN').format(medTotal) + ' đ';
            vatEl.textContent = new Intl.NumberFormat('vi-VN').format(vatAmount) + ' đ';
            document.getElementById('editFinalTotal').textContent = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' đ';
        }

        document.addEventListener('DOMContentLoaded', recalcEditAdm);
    </script>
</x-app-layout>
