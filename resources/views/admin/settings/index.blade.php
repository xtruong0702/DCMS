<x-app-layout>
    @php
        $storedAddress = trim((string) ($settings['clinic_address'] ?? ''));
        $clinicAddressValue = $storedAddress !== ''
            ? $storedAddress
            : ($clinicSettings['clinic_address'] ?? '204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội');
    @endphp
    <x-slot name="header">
        <div class="flex flex-col gap-1.5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Cấu hình phòng khám</h2>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Thiết lập hệ thống
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Thông tin hiển thị trên hồ sơ, hóa đơn và thanh toán VietQR.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            @if(session('success'))
                <div role="status" class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-2.5 text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div role="alert" class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-sm space-y-1">
                    <p class="font-bold">Một số thông tin cần được kiểm tra:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf

                    <!-- Phần 1: Thông tin phòng khám -->
                    <section class="p-5 sm:p-7 border-b border-slate-100">
                        <div class="flex items-start gap-3 mb-5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-teal-50 text-sm font-bold text-teal-800">1</span>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Thông tin phòng khám</h3>
                                <p class="mt-1 text-xs text-slate-500">Dùng trên hóa đơn, bệnh án và thông tin liên hệ.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                            <div>
                                <label for="clinic_name" class="block text-xs font-semibold text-slate-700 mb-1.5">Tên phòng khám</label>
                                <input id="clinic_name" type="text" name="clinic_name" value="{{ old('clinic_name', $settings['clinic_name'] ?? 'Nha Khoa Smile') }}" autocomplete="organization" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                            </div>
                            <div>
                                <label for="clinic_hotline" class="block text-xs font-semibold text-slate-700 mb-1.5">Hotline hỗ trợ</label>
                                <input id="clinic_hotline" type="tel" name="clinic_hotline" value="{{ old('clinic_hotline', $settings['clinic_hotline'] ?? ($clinicSettings['clinic_hotline'] ?? '0775 761 388')) }}" autocomplete="tel" inputmode="tel" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                            </div>
                            <div class="md:col-span-2">
                                <label for="clinic_address" class="block text-xs font-semibold text-slate-700 mb-1.5">Địa chỉ phòng khám</label>
                                <input id="clinic_address" type="text" name="clinic_address" value="{{ old('clinic_address', $clinicAddressValue) }}" autocomplete="street-address" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                                <p class="mt-1.5 text-[11px] text-slate-500">Địa chỉ đang được dùng trên website: {{ $clinicSettings['clinic_address'] }}.</p>
                            </div>
                            <div>
                                <label for="clinic_email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email liên hệ</label>
                                <input id="clinic_email" type="email" name="clinic_email" value="{{ old('clinic_email', $settings['clinic_email'] ?? ($clinicSettings['clinic_email'] ?? 'contact@nhakhoasmile.vn')) }}" autocomplete="email" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                            </div>
                            <div>
                                <label for="clinic_website" class="block text-xs font-semibold text-slate-700 mb-1.5">Website</label>
                                <input id="clinic_website" type="url" name="clinic_website" value="{{ old('clinic_website', $settings['clinic_website'] ?? 'https://nhakhoasmile.vn') }}" autocomplete="url" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                            </div>
                        </div>
                    </section>

                    <!-- Phần 2: Cấu hình Thanh toán & VietQR -->
                    <section class="p-5 sm:p-7">
                        <div class="flex items-start gap-3 mb-5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-teal-50 text-sm font-bold text-teal-800">2</span>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Thuế và thanh toán VietQR</h3>
                                <p class="mt-1 text-xs text-slate-500">VAT áp dụng cho hóa đơn mới. Tài khoản dưới đây được dùng để tạo mã nhận tiền.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                            <div>
                                <label for="vat_percentage" class="block text-xs font-semibold text-slate-700 mb-1.5">VAT mặc định</label>
                                <div class="relative">
                                    <input id="vat_percentage" type="number" step="0.1" min="0" max="100" name="vat_percentage" value="{{ old('vat_percentage', (isset($settings['vat_percentage']) && $settings['vat_percentage'] !== '' && is_numeric($settings['vat_percentage'])) ? $settings['vat_percentage'] : '10') }}" class="w-full rounded-lg border-slate-300 pr-10 text-sm focus:border-teal-700 focus:ring-teal-700">
                                    <span class="absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">%</span>
                                </div>
                            </div>
                            <div>
                                <label for="currency_unit" class="block text-xs font-semibold text-slate-700 mb-1.5">Đơn vị tiền tệ</label>
                                <input id="currency_unit" type="text" name="currency_unit" value="{{ old('currency_unit', $settings['currency_unit'] ?? 'VNĐ') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                            </div>
                            <div>
                                <label for="bank_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Ngân hàng nhận tiền</label>
                                <select id="bank_id" name="bank_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-700 focus:ring-teal-700">
                                    <option value="MB" {{ ($settings['bank_id'] ?? 'MB') == 'MB' ? 'selected' : '' }}>MBBank - Ngân hàng Quân Đội (MB)</option>
                                    <option value="TCB" {{ ($settings['bank_id'] ?? '') == 'TCB' ? 'selected' : '' }}>Techcombank - Kỹ Thương VN (TCB)</option>
                                    <option value="VCB" {{ ($settings['bank_id'] ?? '') == 'VCB' ? 'selected' : '' }}>Vietcombank - Ngoại Thương VN (VCB)</option>
                                    <option value="ICB" {{ ($settings['bank_id'] ?? '') == 'ICB' ? 'selected' : '' }}>VietinBank - Công Thương VN (CTG)</option>
                                    <option value="BIDV" {{ ($settings['bank_id'] ?? '') == 'BIDV' ? 'selected' : '' }}>BIDV - Đầu tư & Phát triển VN</option>
                                    <option value="ACB" {{ ($settings['bank_id'] ?? '') == 'ACB' ? 'selected' : '' }}>ACB - Á Châu</option>
                                    <option value="TPB" {{ ($settings['bank_id'] ?? '') == 'TPB' ? 'selected' : '' }}>TPBank - Tiên Phong</option>
                                    <option value="VPB" {{ ($settings['bank_id'] ?? '') == 'VPB' ? 'selected' : '' }}>VPBank - Việt Nam Thịnh Vượng</option>
                                </select>
                            </div>
                            <div>
                                <label for="bank_account_no" class="block text-xs font-semibold text-slate-700 mb-1.5">Số tài khoản nhận tiền</label>
                                <input id="bank_account_no" type="text" name="bank_account_no" value="{{ old('bank_account_no', !empty($settings['bank_account_no']) ? $settings['bank_account_no'] : '1626262696969') }}" placeholder="Nhập số tài khoản" autocomplete="off" inputmode="numeric" class="w-full rounded-lg border-slate-300 font-mono text-sm font-semibold focus:border-teal-700 focus:ring-teal-700">
                            </div>
                            <div class="md:col-span-2">
                                <label for="bank_account_name" class="block text-xs font-semibold text-slate-700 mb-1.5">Tên chủ tài khoản</label>
                                <input id="bank_account_name" type="text" name="bank_account_name" value="{{ old('bank_account_name', !empty($settings['bank_account_name']) ? $settings['bank_account_name'] : 'PHAM XUAN TRUONG') }}" placeholder="Ví dụ: PHAM XUAN TRUONG" autocomplete="name" class="w-full rounded-lg border-slate-300 text-sm uppercase focus:border-teal-700 focus:ring-teal-700">
                                <p class="mt-1.5 text-[11px] text-slate-500">Nhập tên không dấu theo thông tin ngân hàng để nội dung VietQR chính xác.</p>
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                        <p class="text-[11px] text-slate-500">Các thay đổi có hiệu lực sau khi lưu.</p>
                        <button type="submit" style="background-color: #0D7A68; color: #ffffff;" class="inline-flex items-center justify-center gap-2 rounded-lg px-5 py-2.5 text-sm font-semibold shadow-sm transition hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-teal-700 focus:ring-offset-2">
                            <span aria-hidden="true">✓</span>Lưu cấu hình
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
