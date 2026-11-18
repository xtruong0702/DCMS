<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    🧾 Lập Hóa Đơn Tự Động (Chọn Dịch Vụ & Thuốc)
                </h2>
                <p class="text-xs text-slate-500 mt-1">Chỉ cần tích chọn dịch vụ khám và thuốc theo bảng giá niêm yết, hệ thống tự động tính tổng tiền & sinh mã VietQR</p>
            </div>
            <a href="{{ route('receptionist.invoices.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl text-xs font-bold transition">
                &larr; Danh sách hóa đơn
            </a>
        </div>
    </x-slot>

    @php
        // Chuẩn bị dữ liệu JSON của các ca khám để khi chọn Ca khám sẽ tự động tích Dịch vụ & Thuốc đã kê
        $appointmentMap = [];
        foreach ($appointments as $app) {
            $srvIds = [];
            if ($app->service_id) {
                $srvIds[] = $app->service_id;
            }
            if ($app->medicalRecord && $app->medicalRecord->details) {
                foreach ($app->medicalRecord->details as $dt) {
                    if ($dt->service_id && !in_array($dt->service_id, $srvIds)) {
                        $srvIds[] = $dt->service_id;
                    }
                }
            }
            $medItems = [];
            if ($app->medicalRecord && $app->medicalRecord->prescription && $app->medicalRecord->prescription->details) {
                foreach ($app->medicalRecord->prescription->details as $pDetail) {
                    if ($pDetail->medicine_id) {
                        $medItems[$pDetail->medicine_id] = max(1, intval($pDetail->quantity));
                    }
                }
            }
            $appointmentMap[$app->id] = [
                'patient_id' => $app->patient_id,
                'service_ids' => $srvIds,
                'medicines' => $medItems,
            ];
        }

        $defaultServiceId = ($appointment && $appointment->service_id) ? $appointment->service_id : ($services->first()->id ?? null);
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-bold">
                    @foreach ($errors->all() as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('receptionist.invoices.store') }}" method="POST" id="autoInvoiceForm">
                @csrf
                <!-- Container chứa các input ẩn được sinh tự động khi tích chọn Dịch vụ / Thuốc -->
                <div id="generatedItemsContainer"></div>
                <input type="hidden" name="discount" id="hiddenDiscountInput" value="0">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <!-- CỘT TRÁI (2/3): CHỌN CA KHÁM, CHỌN DỊCH VỤ KHÁM, CHỌN THUỐC -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Bước 1: Chọn Ca khám & Bệnh nhân -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">1</span>
                                Chọn Ca Khám Hoặc Bệnh Nhân
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Chọn nhanh theo Ca khám (Tự động lấy DV & Đơn thuốc)</label>
                                    <select name="appointment_id" id="appointment_id" onchange="onAppointmentChange(this.value)" class="w-full rounded-xl border-slate-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Khám trực tiếp / Chọn thủ công bên dưới --</option>
                                        @foreach($appointments as $app)
                                            <option value="{{ $app->id }}" {{ (old('appointment_id', $appointment->id ?? '') == $app->id) ? 'selected' : '' }}>
                                                #{{ $app->id }} ({{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m/Y H:i') }}) - {{ $app->patient->name ?? '' }} ({{ $app->service->name ?? 'Khám chung' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Khách hàng / Bệnh nhân <span class="text-red-500">*</span></label>
                                    <select name="patient_id" id="patient_id" required class="w-full rounded-xl border-slate-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Chọn bệnh nhân --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ (old('patient_id', $appointment->patient_id ?? '') == $patient->id) ? 'selected' : '' }}>
                                                {{ $patient->patient_code }} - {{ $patient->name }} ({{ $patient->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bước 2: Tích chọn Dịch vụ khám -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                                <h3 class="text-xs font-extrabold uppercase tracking-wider text-indigo-700 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs">2</span>
                                    Chọn Dịch Vụ Khám & Điều Trị (Giá niêm yết)
                                </h3>
                                <span class="text-[11px] font-semibold text-slate-500">Nhấn vào dịch vụ để chọn / bỏ chọn</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="servicesGrid">
                                @foreach($services as $srv)
                                    @php $isChecked = ($defaultServiceId == $srv->id); @endphp
                                    <div class="service-card rounded-xl border p-3.5 transition cursor-pointer flex items-center justify-between gap-3 {{ $isChecked ? 'border-indigo-500 bg-indigo-50/60 ring-1 ring-indigo-500' : 'border-slate-200 hover:border-indigo-300 bg-white' }}"
                                         data-id="{{ $srv->id }}"
                                         data-name="Dịch vụ: {{ $srv->name }}"
                                         data-price="{{ round($srv->price) }}"
                                         onclick="toggleCardSelection(this, event)">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" class="item-checkbox mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 pointer-events-none" {{ $isChecked ? 'checked' : '' }}>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-800 leading-snug">{{ $srv->name }}</p>
                                                <p class="text-xs font-extrabold text-indigo-600 mt-1">{{ number_format($srv->price, 0, ',', '.') }} đ</p>
                                            </div>
                                        </div>
                                        <!-- Bộ chọn số lượng (Răng / Lần) -->
                                        <div class="qty-controls flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1.5 py-1 shrink-0 {{ $isChecked ? '' : 'opacity-40 pointer-events-none' }}" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeCardQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center">-</button>
                                            <input type="text" readonly value="1" class="card-qty w-7 text-center text-xs font-extrabold text-slate-800 border-0 p-0 bg-transparent focus:ring-0">
                                            <button type="button" onclick="changeCardQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bước 3: Tích chọn Tiền thuốc / Đơn thuốc -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                                <h3 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">3</span>
                                    Chọn Tiền Thuốc & Đơn Thuốc Kèm Theo
                                </h3>
                                <span class="text-[11px] font-semibold text-slate-500">Tự động cộng tiền thuốc vào hóa đơn</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="medicinesGrid">
                                @foreach($medicines as $med)
                                    <div class="medicine-card rounded-xl border border-slate-200 hover:border-emerald-300 bg-white p-3.5 transition cursor-pointer flex items-center justify-between gap-3"
                                         data-id="{{ $med->id }}"
                                         data-name="Thuốc: {{ $med->name }} ({{ $med->unit ?? 'Đơn vị' }})"
                                         data-price="{{ round($med->price) }}"
                                         onclick="toggleCardSelection(this, event)">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" class="item-checkbox mt-0.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 pointer-events-none">
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-800 leading-snug">{{ $med->name }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-xs font-extrabold text-emerald-600">{{ number_format($med->price, 0, ',', '.') }} đ</span>
                                                    <span class="text-[10px] font-semibold text-slate-400">/ {{ $med->unit ?? 'Đơn vị' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Bộ chọn số lượng thuốc -->
                                        <div class="qty-controls flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-1.5 py-1 shrink-0 opacity-40 pointer-events-none" onclick="event.stopPropagation()">
                                            <button type="button" onclick="changeCardQty(this, -1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center">-</button>
                                            <input type="text" readonly value="1" class="card-qty w-7 text-center text-xs font-extrabold text-slate-800 border-0 p-0 bg-transparent focus:ring-0">
                                            <button type="button" onclick="changeCardQty(this, 1)" class="w-5 h-5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bước 4: Chọn mức Ưu đãi / Chiết khấu -->
                        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-3 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xs">4</span>
                                Chọn Mức Ưu Đãi / Giảm Giá (Nếu có)
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="discountRateGroup">
                                <button type="button" onclick="setDiscountPercent(0, this)" class="discount-btn px-3 py-2.5 rounded-xl border border-indigo-500 bg-indigo-50 text-indigo-700 text-xs font-extrabold transition">
                                    Không giảm (0%)
                                </button>
                                <button type="button" onclick="setDiscountPercent(5, this)" class="discount-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:border-indigo-300 text-xs font-bold transition">
                                    Khách thân thiết (-5%)
                                </button>
                                <button type="button" onclick="setDiscountPercent(10, this)" class="discount-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:border-indigo-300 text-xs font-bold transition">
                                    Thẻ thành viên (-10%)
                                </button>
                                <button type="button" onclick="setDiscountPercent(20, this)" class="discount-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:border-indigo-300 text-xs font-bold transition">
                                    Hỗ trợ BHYT (-20%)
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CỘT PHẢI (1/3): BẢNG TỔNG HỢP SỐ TIỀN CẦN THANH TOÁN TỰ ĐỘNG -->
                    <div class="lg:col-span-1 sticky top-24">
                        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-5 py-4 text-white">
                                <h3 class="text-sm font-extrabold uppercase tracking-wider">📌 Tổng Hợp Thanh Toán</h3>
                                <p class="text-[11px] text-indigo-100 mt-0.5">Tự động tính theo dịch vụ & thuốc đã chọn</p>
                            </div>

                            <div class="p-5 space-y-4">
                                <!-- Danh sách các mục đã chọn -->
                                <div>
                                    <p class="text-[11px] font-extrabold uppercase text-slate-400 tracking-wider mb-2">Danh mục đã chọn (<span id="selectedCountBadge">0</span>)</p>
                                    <div id="selectedItemsSummary" class="space-y-2 max-h-60 overflow-y-auto pr-1 text-xs divide-y divide-slate-100">
                                        <p class="text-slate-400 italic py-2">Chưa chọn dịch vụ hoặc thuốc nào.</p>
                                    </div>
                                </div>

                                <!-- Chi tiết cộng tiền -->
                                <div class="border-t border-slate-200 pt-4 space-y-2.5 text-xs">
                                    <div class="flex justify-between items-center text-slate-600">
                                        <span>🦷 Tiền dịch vụ khám:</span>
                                        <span class="font-bold text-slate-900" id="serviceSubtotalDisplay">0 đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-600">
                                        <span>💊 Tiền thuốc kèm theo:</span>
                                        <span class="font-bold text-emerald-700" id="medicineSubtotalDisplay">0 đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-600 pt-2 border-t border-dashed border-slate-200">
                                        <span class="font-semibold">Tạm tính:</span>
                                        <span class="font-extrabold text-slate-900" id="subtotalDisplay">0 đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-emerald-600">
                                        <span>Ưu đãi giảm giá (<span id="discountPercentLabel">0</span>%):</span>
                                        <span class="font-bold" id="discountDisplay">- 0 đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-600">
                                        <span>Thuế VAT ({{ $vatRate ?? 10 }}%):</span>
                                        <span class="font-bold text-slate-800" id="vatDisplay" data-rate="{{ $vatRate ?? 10 }}">+ 0 đ</span>
                                    </div>
                                </div>

                                <!-- Số tiền cần thanh toán nổi bật -->
                                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-center">
                                    <p class="text-[11px] font-extrabold uppercase tracking-wider text-red-600">Số Tiền Cần Thanh Toán</p>
                                    <p class="text-2xl font-black text-red-600 mt-1" id="finalTotalDisplay">0 đ</p>
                                    <p class="text-[10px] text-red-500 mt-0.5">(Đã bao gồm 10% thuế VAT)</p>
                                </div>

                                <button type="submit" id="submitInvoiceBtn" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center justify-center gap-2">
                                    <span>Tạo Hóa Đơn & Sinh Mã VietQR</span>
                                    <span>&rarr;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const appointmentDataMap = @json($appointmentMap);
        let currentDiscountPercent = 0;

        function toggleCardSelection(card, event) {
            const checkbox = card.querySelector('.item-checkbox');
            checkbox.checked = !checkbox.checked;
            syncCardVisual(card);
            recalcInvoice();
        }

        function syncCardVisual(card) {
            const checkbox = card.querySelector('.item-checkbox');
            const qtyControls = card.querySelector('.qty-controls');
            const isMedicine = card.classList.contains('medicine-card');
            const activeBorder = isMedicine ? 'border-emerald-500' : 'border-indigo-500';
            const activeBg = isMedicine ? 'bg-emerald-50/60' : 'bg-indigo-50/60';
            const activeRing = isMedicine ? 'ring-emerald-500' : 'ring-indigo-500';

            if (checkbox.checked) {
                card.classList.remove('border-slate-200', 'bg-white');
                card.classList.add(activeBorder, activeBg, 'ring-1', activeRing);
                qtyControls.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                card.classList.remove(activeBorder, activeBg, 'ring-1', activeRing);
                card.classList.add('border-slate-200', 'bg-white');
                qtyControls.classList.add('opacity-40', 'pointer-events-none');
                card.querySelector('.card-qty').value = 1;
            }
        }

        function changeCardQty(btn, delta) {
            const card = btn.closest('.service-card, .medicine-card');
            const input = card.querySelector('.card-qty');
            let val = parseInt(input.value, 10) || 1;
            val = Math.max(1, val + delta);
            input.value = val;
            recalcInvoice();
        }

        function setDiscountPercent(percent, btn) {
            currentDiscountPercent = percent;
            document.getElementById('discountPercentLabel').textContent = percent;
            document.querySelectorAll('#discountRateGroup .discount-btn').forEach(b => {
                b.className = 'discount-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:border-indigo-300 text-xs font-bold transition';
            });
            btn.className = 'discount-btn px-3 py-2.5 rounded-xl border border-indigo-500 bg-indigo-50 text-indigo-700 text-xs font-extrabold transition';
            recalcInvoice();
        }

        function onAppointmentChange(appId) {
            if (!appId || !appointmentDataMap[appId]) return;
            const info = appointmentDataMap[appId];

            if (info.patient_id) {
                document.getElementById('patient_id').value = info.patient_id;
            }

            // Reset & tích chọn các dịch vụ của ca khám
            document.querySelectorAll('#servicesGrid .service-card').forEach(card => {
                const srvId = parseInt(card.getAttribute('data-id'), 10);
                const cb = card.querySelector('.item-checkbox');
                cb.checked = info.service_ids && info.service_ids.includes(srvId);
                syncCardVisual(card);
            });

            // Reset & tích chọn các thuốc kê đơn của ca khám
            document.querySelectorAll('#medicinesGrid .medicine-card').forEach(card => {
                const medId = card.getAttribute('data-id');
                const cb = card.querySelector('.item-checkbox');
                if (info.medicines && info.medicines[medId]) {
                    cb.checked = true;
                    syncCardVisual(card);
                    card.querySelector('.card-qty').value = info.medicines[medId];
                } else {
                    cb.checked = false;
                    syncCardVisual(card);
                }
            });

            recalcInvoice();
        }

        function recalcInvoice() {
            let serviceSubtotal = 0;
            let medicineSubtotal = 0;
            let itemIdx = 0;
            const hiddenContainer = document.getElementById('generatedItemsContainer');
            const summaryList = document.getElementById('selectedItemsSummary');
            hiddenContainer.innerHTML = '';
            let summaryHtml = '';

            // 1. Duyệt các dịch vụ đã tích
            document.querySelectorAll('#servicesGrid .service-card').forEach(card => {
                if (card.querySelector('.item-checkbox').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.card-qty').value, 10) || 1;
                    const lineTotal = price * qty;
                    serviceSubtotal += lineTotal;

                    hiddenContainer.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${itemIdx}][name]" value="${name}">
                        <input type="hidden" name="items[${itemIdx}][price]" value="${price}">
                        <input type="hidden" name="items[${itemIdx}][quantity]" value="${qty}">
                    `);
                    summaryHtml += `
                        <div class="py-2 flex justify-between items-start gap-2">
                            <div>
                                <p class="font-bold text-slate-800">${name}</p>
                                <p class="text-[11px] text-slate-400">SL: ${qty} x ${new Intl.NumberFormat('vi-VN').format(price)} đ</p>
                            </div>
                            <span class="font-extrabold text-slate-900 whitespace-nowrap">${new Intl.NumberFormat('vi-VN').format(lineTotal)} đ</span>
                        </div>
                    `;
                    itemIdx++;
                }
            });

            // 2. Duyệt các thuốc đã tích
            document.querySelectorAll('#medicinesGrid .medicine-card').forEach(card => {
                if (card.querySelector('.item-checkbox').checked) {
                    const name = card.getAttribute('data-name');
                    const price = parseFloat(card.getAttribute('data-price')) || 0;
                    const qty = parseInt(card.querySelector('.card-qty').value, 10) || 1;
                    const lineTotal = price * qty;
                    medicineSubtotal += lineTotal;

                    hiddenContainer.insertAdjacentHTML('beforeend', `
                        <input type="hidden" name="items[${itemIdx}][name]" value="${name}">
                        <input type="hidden" name="items[${itemIdx}][price]" value="${price}">
                        <input type="hidden" name="items[${itemIdx}][quantity]" value="${qty}">
                    `);
                    summaryHtml += `
                        <div class="py-2 flex justify-between items-start gap-2">
                            <div>
                                <p class="font-bold text-emerald-800">${name}</p>
                                <p class="text-[11px] text-slate-400">SL: ${qty} x ${new Intl.NumberFormat('vi-VN').format(price)} đ</p>
                            </div>
                            <span class="font-extrabold text-emerald-700 whitespace-nowrap">${new Intl.NumberFormat('vi-VN').format(lineTotal)} đ</span>
                        </div>
                    `;
                    itemIdx++;
                }
            });

            document.getElementById('selectedCountBadge').textContent = itemIdx;
            summaryList.innerHTML = summaryHtml || '<p class="text-slate-400 italic py-2">Chưa chọn dịch vụ hoặc thuốc nào.</p>';

            const subtotal = serviceSubtotal + medicineSubtotal;
            const discountAmount = Math.round(subtotal * (currentDiscountPercent / 100));
            document.getElementById('hiddenDiscountInput').value = discountAmount;

            const afterDiscount = Math.max(0, subtotal - discountAmount);
            const vatEl = document.getElementById('vatDisplay');
            const vatRate = vatEl ? (parseFloat(vatEl.getAttribute('data-rate')) || 10) : 10;
            const vatAmount = Math.round(afterDiscount * (vatRate / 100));
            const finalTotal = afterDiscount + vatAmount;

            document.getElementById('serviceSubtotalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(serviceSubtotal) + ' đ';
            document.getElementById('medicineSubtotalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(medicineSubtotal) + ' đ';
            document.getElementById('subtotalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(subtotal) + ' đ';
            document.getElementById('discountDisplay').textContent = '- ' + new Intl.NumberFormat('vi-VN').format(discountAmount) + ' đ';
            if (vatEl) {
                vatEl.textContent = '+ ' + new Intl.NumberFormat('vi-VN').format(vatAmount) + ' đ';
            }
            document.getElementById('finalTotalDisplay').textContent = new Intl.NumberFormat('vi-VN').format(finalTotal) + ' đ';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const initialAppId = document.getElementById('appointment_id').value;
            if (initialAppId) {
                onAppointmentChange(initialAppId);
            } else {
                recalcInvoice();
            }
        });
    </script>
</x-app-layout>
