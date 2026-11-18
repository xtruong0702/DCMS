<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    🧾 Tạo Hóa Đơn Mới (Chọn Dịch Vụ & Thuốc)
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tích chọn dịch vụ khám và thuốc theo bảng giá, hệ thống tự động tính tổng tiền thanh toán</p>
            </div>
            <a href="{{ route('admin.invoices.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách hóa đơn
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-bold">
                    @foreach ($errors->all() as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.invoices.store') }}" method="POST">
                @csrf
                <div id="adminGeneratedItems"></div>
                <input type="hidden" name="discount" id="adminHiddenDiscount" value="0">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Thông tin Bệnh nhân & Lịch khám -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-indigo-700 mb-4">1. Thông Tin Bệnh Nhân & Trạng Thái</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Khách hàng / Bệnh nhân <span class="text-red-500">*</span></label>
                                    <select name="patient_id" id="patient_id" required class="w-full rounded-xl border-slate-300 text-xs font-semibold">
                                        <option value="">-- Chọn bệnh nhân --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->phone }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Lịch khám liên quan</label>
                                    <select name="appointment_id" id="appointment_id" class="w-full rounded-xl border-slate-300 text-xs font-semibold">
                                        <option value="">-- Không qua lịch hẹn --</option>
                                        @foreach($appointments as $app)
                                            <option value="{{ $app->id }}">#{{ $app->id }} ({{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m/Y') }}) - {{ $app->patient->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Trạng thái thanh toán <span class="text-red-500">*</span></label>
                                    <select name="status" required class="w-full rounded-xl border-slate-300 text-xs font-semibold">
                                        <option value="unpaid">Chưa thanh toán</option>
                                        <option value="paid">Đã thanh toán (Thu tiền ngay)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Chọn Dịch vụ khám -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-indigo-700 mb-4">2. Tích Chọn Dịch Vụ Khám (Giá Niêm Yết)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="adminServicesGrid">
                                @foreach($services as $idx => $srv)
                                    @php $checked = ($idx === 0); @endphp
                                    <div class="adm-card srv-card rounded-xl border p-3.5 transition cursor-pointer flex items-center justify-between gap-2 {{ $checked ? 'border-indigo-500 bg-indigo-50/70 ring-1 ring-indigo-500' : 'border-slate-200 bg-white' }}"
                                         data-name="Dịch vụ: {{ $srv->name }}"
                                         data-price="{{ round($srv->price) }}"
                                         onclick="toggleAdmCard(this)">
                                        <div class="flex items-start gap-2.5">
                                            <input type="checkbox" class="adm-cb mt-0.5 rounded border-slate-300 text-indigo-600 pointer-events-none" {{ $checked ? 'checked' : '' }}>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $srv->name }}</p>
                                                <p class="text-xs font-extrabold text-indigo-600 mt-0.5">{{ number_format($srv->price, 0, ',', '.') }} đ</p>
                                            </div>
                                        </div>
                                        <div class="adm-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 {{ $checked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeAdmQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">-</button>
                                            <input type="text" readonly value="1" class="adm-qty w-6 text-center text-xs font-extrabold border-0 p-0 bg-transparent">
                                            <button type="button" onclick="changeAdmQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Chọn Tiền thuốc -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 mb-4">3. Tích Chọn Tiền Thuốc Kèm Theo</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="adminMedicinesGrid">
                                @foreach($medicines as $med)
                                    <div class="adm-card med-card rounded-xl border border-slate-200 bg-white p-3.5 transition cursor-pointer flex items-center justify-between gap-2"
                                         data-name="Thuốc: {{ $med->name }} ({{ $med->unit ?? 'Đơn vị' }})"
                                         data-price="{{ round($med->price) }}"
                                         onclick="toggleAdmCard(this)">
                                        <div class="flex items-start gap-2.5">
                                            <input type="checkbox" class="adm-cb mt-0.5 rounded border-slate-300 text-emerald-600 pointer-events-none">
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $med->name }}</p>
                                                <p class="text-xs font-extrabold text-emerald-600 mt-0.5">{{ number_format($med->price, 0, ',', '.') }} đ</p>
                                            </div>
                                        </div>
                                        <div class="adm-qty-box flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1 py-0.5 opacity-40 pointer-events-none" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeAdmQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">-</button>
                                            <input type="text" readonly value="1" class="adm-qty w-6 text-center text-xs font-extrabold border-0 p-0 bg-transparent">
                                            <button type="button" onclick="changeAdmQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 text-xs font-bold">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Bảng tổng hợp tự động -->
                    <div class="lg:col-span-1 sticky top-24">
                        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-5 space-y-4">
                            <h3 class="text-sm font-extrabold uppercase text-indigo-700 border-b border-slate-100 pb-3">Tổng Hợp Thanh Toán</h3>
                            <div class="space-y-2.5 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tiền dịch vụ khám:</span>
                                    <strong id="admSrvTotal">0 đ</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tiền thuốc:</span>
                                    <strong class="text-emerald-700" id="admMedTotal">0 đ</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Thuế VAT ({{ $vatRate ?? 10 }}%):</span>
                                    <strong id="admVatTotal" data-rate="{{ $vatRate ?? 10 }}">0 đ</strong>
                                </div>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                                <p class="text-[11px] font-extrabold uppercase text-red-600">Số Tiền Cần Thanh Toán</p>
                                <p class="text-2xl font-black text-red-600 mt-1" id="admFinalTotal">0 đ</p>
                            </div>
                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs uppercase tracking-wider shadow-sm transition">
                                Lưu Hóa Đơn Tự Động
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAdmCard(card) {
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
            recalcAdm();
        }

        function changeAdmQty(btn, delta) {
            const card = btn.closest('.adm-card');
            const input = card.querySelector('.adm-qty');
            input.value = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
            recalcAdm();
        }

        function recalcAdm() {
            const container = document.getElementById('adminGeneratedItems');
            container.innerHTML = '';
            let srvTotal = 0, medTotal = 0, idx = 0;

            document.querySelectorAll('#adminServicesGrid .adm-card').forEach(card => {
                if (card.querySelector('.adm-cb').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.adm-qty').value, 10) || 1;
                    srvTotal += price * qty;
                    container.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${idx}][name]" value="${name}">
                        <input type="hidden" name="items[${idx}][price]" value="${price}">
                        <input type="hidden" name="items[${idx}][quantity]" value="${qty}">
                    `);
                    idx++;
                }
            });

            document.querySelectorAll('#adminMedicinesGrid .adm-card').forEach(card => {
                if (card.querySelector('.adm-cb').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.adm-qty').value, 10) || 1;
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
            const vatEl = document.getElementById('admVatTotal');
            const vatRate = parseFloat(vatEl.getAttribute('data-rate')) || 10;
            const vatAmount = Math.round(subtotal * (vatRate / 100));
            const finalAmount = subtotal + vatAmount;

            document.getElementById('admSrvTotal').textContent = new Intl.NumberFormat('vi-VN').format(srvTotal) + ' đ';
            document.getElementById('admMedTotal').textContent = new Intl.NumberFormat('vi-VN').format(medTotal) + ' đ';
            vatEl.textContent = new Intl.NumberFormat('vi-VN').format(vatAmount) + ' đ';
            document.getElementById('admFinalTotal').textContent = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' đ';
        }

        document.addEventListener('DOMContentLoaded', recalcAdm);
    </script>
</x-app-layout>
