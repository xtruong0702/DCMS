<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">⚙️ Cấu Hình Hệ Thống & Thanh Toán VietQR</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Thiết lập thông tin phòng khám, thuế VAT và tài khoản ngân hàng nhận tiền qua mã VietQR</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
                    @csrf

                    <!-- Phần 1: Thông tin phòng khám -->
                    <div>
                        <h3 class="text-sm font-extrabold uppercase text-indigo-700 border-b border-gray-100 pb-3 mb-5">
                            🏥 1. Thông Tin Phòng Khám (Hiển thị trên Hóa đơn & Bệnh án)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Tên phòng khám</label>
                                <input type="text" name="clinic_name" value="{{ $settings['clinic_name'] ?? 'Nha Khoa Smile' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số Hotline hỗ trợ</label>
                                <input type="text" name="clinic_hotline" value="{{ $settings['clinic_hotline'] ?? '1900 1234' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Địa chỉ phòng khám</label>
                                <input type="text" name="clinic_address" value="{{ $settings['clinic_address'] ?? '123 Nguyễn Văn Cừ, Quận 5, TP.HCM' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Email liên hệ</label>
                                <input type="email" name="clinic_email" value="{{ $settings['clinic_email'] ?? 'contact@nhakhoasmile.vn' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Website</label>
                                <input type="text" name="clinic_website" value="{{ $settings['clinic_website'] ?? 'https://nhakhoasmile.vn' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Phần 2: Cấu hình Thanh toán & VietQR -->
                    <div>
                        <h3 class="text-sm font-extrabold uppercase text-indigo-700 border-b border-gray-100 pb-3 mb-5">
                            💳 2. Cấu Hình Tài Chính & Mã VietQR Tự Động
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Thuế VAT mặc định (%)</label>
                                <input type="number" step="0.1" name="vat_percentage" value="{{ (!empty($settings['vat_percentage']) && floatval($settings['vat_percentage']) > 0) ? $settings['vat_percentage'] : '10' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Đơn vị tiền tệ</label>
                                <input type="text" name="currency_unit" value="{{ $settings['currency_unit'] ?? 'VNĐ' }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Ngân hàng thụ hưởng (VietQR NAPAS)</label>
                                <select name="bank_id" class="w-full rounded-xl border-gray-300 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="TCB" {{ ($settings['bank_id'] ?? 'TCB') == 'TCB' ? 'selected' : '' }}>Techcombank - Kỹ Thương VN (TCB)</option>
                                    <option value="MB" {{ ($settings['bank_id'] ?? '') == 'MB' ? 'selected' : '' }}>MBBank - Ngân hàng Quân Đội (MB)</option>
                                    <option value="VCB" {{ ($settings['bank_id'] ?? '') == 'VCB' ? 'selected' : '' }}>Vietcombank - Ngoại Thương VN (VCB)</option>
                                    <option value="ICB" {{ ($settings['bank_id'] ?? '') == 'ICB' ? 'selected' : '' }}>VietinBank - Công Thương VN (CTG)</option>
                                    <option value="BIDV" {{ ($settings['bank_id'] ?? '') == 'BIDV' ? 'selected' : '' }}>BIDV - Đầu tư & Phát triển VN</option>
                                    <option value="ACB" {{ ($settings['bank_id'] ?? '') == 'ACB' ? 'selected' : '' }}>ACB - Á Châu</option>
                                    <option value="TPB" {{ ($settings['bank_id'] ?? '') == 'TPB' ? 'selected' : '' }}>TPBank - Tiên Phong</option>
                                    <option value="VPB" {{ ($settings['bank_id'] ?? '') == 'VPB' ? 'selected' : '' }}>VPBank - Việt Nam Thịnh Vượng</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Số tài khoản nhận tiền</label>
                                <input type="text" name="bank_account_no" value="{{ (!empty($settings['bank_account_no']) && $settings['bank_account_no'] !== '0789169711') ? $settings['bank_account_no'] : '6362566666' }}" placeholder="Ví dụ: 6362566666" class="w-full rounded-xl border-gray-300 text-sm font-mono font-bold focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Tên chủ tài khoản (In hoa không dấu)</label>
                                <input type="text" name="bank_account_name" value="{{ (!empty($settings['bank_account_name']) && $settings['bank_account_name'] !== 'NHA KHOA SMILE') ? $settings['bank_account_name'] : 'PHAM XUAN TRUONG' }}" placeholder="Ví dụ: PHAM XUAN TRUONG" class="w-full rounded-xl border-gray-300 text-sm font-bold uppercase focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition">
                            💾 Lưu Cấu Hình Hệ Thống
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
