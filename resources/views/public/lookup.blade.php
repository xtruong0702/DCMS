@extends('layouts.public')

@section('title', 'Tra Cứu Lịch Hẹn, Bệnh Án & Hóa Đơn Điện Tử - Nha Khoa Smile')

@section('content')
<div class="bg-[#effcf9]">

    <!-- 1. HERO BANNER TRA CỨU (CENTERED STITCH LAYOUT) -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#effcf9] via-white to-[#effcf9] pt-12 pb-10 sm:pt-16 sm:pb-12">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[560px] h-[260px] bg-[#d4af37]/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-[#0f3e36] text-[11px] font-bold uppercase tracking-widest shadow-sm border border-[#d4af37]/30">
                <span class="text-[#d4af37]">✦</span>
                <span>Cổng Tra Cứu Y Tế Chuẩn DCMS & Bảo Mật</span>
                <span class="text-[#d4af37]">✦</span>
            </div>

            <h1 class="font-heading-clinic !text-3xl sm:!text-4xl lg:!text-5xl font-extrabold tracking-tight text-[#0f3e36] !leading-[1.18]">
                Tra Cứu Lịch Hẹn, Bệnh Án & <br class="hidden sm:inline">
                <span class="text-clinic-gradient">Hóa Đơn Điện Tử</span>
            </h1>

            <p class="text-slate-600 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                Tra cứu nhanh tức thì — Xem lịch hẹn sắp tới, trạng thái tiếp đón của Bác sĩ và hóa đơn thanh toán VietQR trên hệ thống DCMS.
            </p>
        </div>
    </section>

    <!-- 2. KHỐI TRA CỨU 2 CỘT: FORM TRA CỨU + THẺ Y TẾ ĐIỆN TỬ DCMS -->
    <section class="py-8 sm:py-10 bg-[#effcf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

                <!-- Cột Trái (7 cột): Form Tra Cứu SĐT -->
                <div class="lg:col-span-7 clinic-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between gap-5">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#0f3e36]">Tra Cứu Hồ Sơ Bệnh Nhân</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Bảo mật hồ sơ y tế
                            </span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 dark-inner-tile text-xs text-slate-600 leading-relaxed flex items-start gap-2.5">
                            <span class="text-[#d4af37] mt-0.5 shrink-0">ℹ️</span>
                            <span>Hệ thống kiểm tra trực tiếp theo số điện thoại đã đăng ký trên bệnh án điện tử DCMS mà không cần nhập mật khẩu.</span>
                        </div>

                        <form action="{{ route('public.lookup') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                    Số điện thoại đã đăng ký <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ $phone }}" required
                                    placeholder="Nhập số điện thoại (VD: 0986667788)..."
                                    class="input-clinic w-full rounded-xl px-4 py-3 text-sm tabular-nums">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                    Mã hồ sơ bệnh nhân (Tùy chọn)
                                </label>
                                <input type="text" name="patient_code" value="{{ request('patient_code') }}"
                                    placeholder="Ví dụ: BN2026... (có thể bỏ trống)"
                                    class="input-clinic w-full rounded-xl px-4 py-2.5 text-xs font-mono">
                            </div>

                            <button type="submit" class="btn-press gold-btn-shimmer w-full py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-lg flex items-center justify-center gap-2">
                                <span>🔍</span>
                                <span>Tra Cứu Lịch Hẹn & Hồ Sơ Ngay</span>
                            </button>
                        </form>
                    </div>

                    <div class="pt-4 border-t border-slate-100/70 flex flex-wrap items-center justify-between gap-2 text-[11px] text-slate-500">
                        <span class="inline-flex items-center gap-1.5">📱 Tra cứu nhanh bằng SĐT</span>
                        <span class="inline-flex items-center gap-1.5">🛡️ Dữ liệu mã hóa chuẩn y tế</span>
                    </div>
                </div>

                <!-- Cột Phải (5 cột): Thẻ Y Tế Điện Tử DCMS + Lịch Hẹn Gần Nhất -->
                <div class="lg:col-span-5 clinic-card rounded-3xl p-5 sm:p-6 flex flex-col justify-between gap-5">
                    @php
                        $nextApt = ($patient && isset($appointments)) ? $appointments->first() : null;
                    @endphp

                    <!-- Thẻ Medical Pass (Emerald & Gold) -->
                    <div class="rounded-2xl p-5 bg-gradient-to-br from-[#0f3e36] via-[#0c2e28] to-[#081412] text-white relative overflow-hidden shadow-xl border border-[#d4af37]/35 space-y-5">
                        <div class="absolute -top-10 -right-10 w-36 h-36 bg-[#d4af37]/15 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-[#d4af37]/20 border border-[#d4af37]/50 text-[#f3e5ab] flex items-center justify-center text-xs font-bold">+</span>
                                <div>
                                    <div class="text-[11px] font-bold tracking-wider uppercase text-white leading-none">NHA KHOA SMILE</div>
                                    <div class="text-[9px] text-[#f3e5ab] uppercase tracking-widest mt-0.5">DCMS Medical Pass</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#d4af37]/20 border border-[#d4af37]/40 text-[#f3e5ab] text-[10px] font-bold">
                                {{ $patient ? 'ĐÃ XÁC THỰC' : 'HỒ SƠ ĐIỆN TỬ' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-9 h-7 rounded-md bg-gradient-to-br from-[#f3e5ab] to-[#b89028] opacity-90 shadow-sm"></div>
                            <div class="w-10 h-10 rounded-lg bg-white/95 text-[#081412] flex items-center justify-center text-[9px] font-mono font-bold shadow-sm">
                                QR
                            </div>
                        </div>

                        <div class="flex items-end justify-between relative z-10 pt-1">
                            <div>
                                <div class="text-[10px] text-[#b0c4be] font-mono">MÃ HỒ SƠ: {{ $patient ? $patient->patient_code : 'BN-DCMS-2026' }}</div>
                                <div class="font-heading-clinic text-base font-bold text-[#f9f6ee] uppercase mt-0.5">
                                    {{ $patient ? $patient->name : 'HỒ SƠ BỆNH NHÂN' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[9px] text-[#b0c4be] uppercase">SĐT Đăng Ký</div>
                                <div class="text-xs font-bold text-[#f3e5ab] tabular-nums">{{ $patient ? $patient->phone : '0775 761 388' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin lịch hẹn sắp tới & 2 nút tiện ích -->
                    <div class="space-y-3">
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-[#d4af37]/20 text-[#8a6a17] dark:text-[#f3e5ab] text-[10px] font-bold uppercase">
                                    {{ $nextApt ? 'LỊCH HẸN GẦN NHẤT' : 'GIỜ LÀM VIỆC PHÒNG KHÁM' }}
                                </span>
                                <span class="text-[10px] text-emerald-600 font-semibold">● Đang hoạt động</span>
                            </div>
                            @if($nextApt)
                                <div class="text-xs font-bold text-[#0f3e36] tabular-nums pt-0.5">
                                    ⏰ {{ \Carbon\Carbon::parse($nextApt->appointment_time)->format('H:i — d/m/Y') }}
                                </div>
                                <div class="text-[11px] text-slate-600">
                                    Dịch vụ: <strong>{{ $nextApt->service->name ?? 'Khám tổng quát' }}</strong> •
                                    BS: <strong>{{ $nextApt->doctor ? $nextApt->doctor->user->name : 'Phòng khám phân bổ' }}</strong>
                                </div>
                            @else
                                <div class="text-xs font-bold text-[#0f3e36] tabular-nums pt-0.5">
                                    08:00 – 20:00 (Thứ 2 – Chủ Nhật)
                                </div>
                                <div class="text-[11px] text-slate-600">
                                    204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <a href="https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i" target="_blank" rel="noopener noreferrer"
                               class="btn-press py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold text-center transition">
                                🗺️ Chỉ Đường Maps
                            </a>
                            <a href="{{ route('public.booking') }}"
                               class="btn-press btn-clinic-primary py-2.5 px-3 rounded-xl text-xs font-bold text-center">
                                📅 Đặt Lịch Mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. KẾT QUẢ TRA CỨU CHI TIẾT (HIỂN THỊ KHI ĐÃ NHẬP SĐT) -->
            @if($phone !== '')
                @if(!$patient)
                    <div class="clinic-card rounded-3xl p-8 text-center border border-rose-500/20 max-w-2xl mx-auto space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto">⚠️</div>
                        <h3 class="font-heading-clinic !text-xl font-bold text-slate-900">Không tìm thấy hồ sơ với SĐT "{{ $phone }}"</h3>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Vui lòng kiểm tra lại số điện thoại hoặc liên hệ Hotline <strong class="text-teal-800 tabular-nums">0775 761 388</strong> để được Lễ tân hỗ trợ tra cứu trực tiếp.
                        </p>
                        <div class="pt-1">
                            <a href="{{ route('public.booking') }}" class="btn-press gold-btn-shimmer inline-flex items-center gap-1.5 px-6 py-2.5 rounded-xl text-xs uppercase tracking-wider">
                                📅 Đặt Lịch Hẹn Mới
                            </a>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        <!-- Thanh Tổng Quan Bệnh Nhân + 3 Thẻ Tóm Tắt (Matching Stitch Middle Bar) -->
                        <div class="clinic-card rounded-3xl p-6 space-y-5">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100/70">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-2xl bg-[#0f3e36] text-[#f3e5ab] font-bold text-base flex items-center justify-center shadow-sm shrink-0">
                                        {{ mb_strtoupper(mb_substr($patient->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h2 class="font-heading-clinic !text-lg font-bold text-slate-900">Bệnh nhân: {{ $patient->name }}</h2>
                                            <span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[10px] font-bold font-mono">{{ $patient->patient_code }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5 tabular-nums">
                                            SĐT: <strong class="text-slate-800">{{ $patient->phone }}</strong> •
                                            Cơ sở: 204 Trần Duy Hưng, Cầu Giấy, Hà Nội
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('patient.login') }}" class="btn-press px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                        🔐 Cổng Bệnh Nhân
                                    </a>
                                    <a href="{{ route('public.booking') }}" class="btn-press btn-clinic-primary px-4 py-2 rounded-xl text-xs font-bold">
                                        + Đặt lịch mới
                                    </a>
                                </div>
                            </div>

                            <!-- 3 Thẻ Tóm Tắt Nhanh -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-teal-700">📅 Lịch Hẹn Khám</div>
                                    <div class="font-heading-clinic text-lg font-bold text-slate-900 tabular-nums">{{ $appointments->count() }} lịch hẹn</div>
                                    <p class="text-[11px] text-slate-500">Theo dõi giờ khám và trạng thái xác nhận của Bác sĩ bên dưới.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-teal-700">🧾 Hóa Đơn & VietQR</div>
                                    <div class="font-heading-clinic text-lg font-bold text-slate-900 tabular-nums">{{ $invoices->count() }} hóa đơn</div>
                                    <p class="text-[11px] text-slate-500">Hóa đơn điện tử minh bạch kèm mã VietQR thanh toán tức thì.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-teal-700">🛡️ Bảo Mật Y Tế</div>
                                    <div class="font-heading-clinic text-lg font-bold text-slate-900">Chuẩn DCMS</div>
                                    <p class="text-[11px] text-slate-500">Hồ sơ bệnh án chỉ do Bác sĩ & Lễ tân cập nhật chính xác.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách Lịch hẹn chi tiết -->
                        <div class="clinic-card rounded-3xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100/70 bg-slate-50/70 flex items-center justify-between">
                                <h3 class="font-heading-clinic !text-base font-bold text-slate-900">📅 Danh Sách Lịch Hẹn ({{ $appointments->count() }})</h3>
                            </div>
                            <div class="divide-y divide-slate-100/60">
                                @forelse($appointments as $apt)
                                    <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-teal-50/30 transition">
                                        <div class="space-y-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-sm font-bold text-teal-800 tabular-nums">
                                                    ⏰ {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i - d/m/Y') }}
                                                </span>
                                                @if($apt->isOverdue())
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700">⚠️ Quá giờ hẹn</span>
                                                @elseif($apt->isDueNow())
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 animate-pulse">🔔 Đến giờ khám</span>
                                                @endif
                                            </div>
                                            <p class="text-xs font-semibold text-slate-900">
                                                Dịch vụ: <span class="text-teal-700">{{ $apt->service->name ?? 'Khám tổng quát & Tư vấn' }}</span>
                                            </p>
                                            <p class="text-xs text-slate-600">
                                                👨‍⚕️ Bác sĩ phụ trách: <strong class="text-slate-900">{{ $apt->doctor ? $apt->doctor->user->name : 'Phòng khám phân bổ' }}</strong>
                                            </p>
                                        </div>
                                        <div>
                                            @if($apt->status == 'confirmed')
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">✓ Bác sĩ đã xác nhận</span>
                                            @elseif($apt->status == 'completed')
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">✓ Đã hoàn tất khám</span>
                                            @elseif($apt->status == 'pending')
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800">Đang chờ xác nhận</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">{{ $apt->status }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-xs text-slate-500">Bạn chưa có lịch hẹn nào sắp tới.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Danh sách Hóa đơn chi tiết -->
                        <div class="clinic-card rounded-3xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100/70 bg-slate-50/70 flex items-center justify-between">
                                <h3 class="font-heading-clinic !text-base font-bold text-slate-900">🧾 Hóa Đơn & Thanh Toán VietQR ({{ $invoices->count() }})</h3>
                            </div>
                            <div class="divide-y divide-slate-100/60">
                                @forelse($invoices as $inv)
                                    <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-teal-50/30 transition">
                                        <div>
                                            <div class="font-mono font-bold text-xs text-slate-900">#{{ $inv->invoice_code }}</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5 tabular-nums">Ngày lập: {{ $inv->created_at->format('d/m/Y H:i') }}</div>
                                            <div class="font-heading-clinic text-base font-extrabold text-teal-800 mt-1 tabular-nums">
                                                {{ number_format($inv->final_amount, 0, ',', '.') }} đ
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($inv->status == 'paid')
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">✓ Đã thanh toán</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800">Chưa thanh toán</span>
                                            @endif
                                            <a href="{{ route('patient.invoices.show', $inv->id) }}" class="btn-press btn-clinic-primary px-3.5 py-1.5 rounded-lg text-xs">
                                                Chi tiết & VietQR
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-xs text-slate-500">Chưa có hóa đơn nào phát sinh.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- 4. TIỆN ÍCH HỆ THỐNG BỆNH ÁN ĐIỆN TỬ DCMS (4 CỘT NGANG MATCHING STITCH) -->
    <section class="py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">HỒ SƠ Y TẾ SỐ HÓA TOÀN DIỆN</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">
                    Tiện Ích Của Hệ Thống <span class="text-clinic-gradient">Bệnh Án Điện Tử DCMS</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">Toàn bộ lịch hẹn, sơ đồ 32 răng FDI và hóa đơn đều được đồng bộ tự động, giúp bạn theo dõi dễ dàng mọi lúc.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    ['icon' => '📅', 'title' => 'Trạng Thái Lịch Hẹn Live', 'desc' => 'Cập nhật tức thì khi Bác sĩ xác nhận lịch, nhắc giờ khám trước và thông báo phòng điều trị.', 'foot' => 'Đồng bộ thời gian thực'],
                    ['icon' => '🦷', 'title' => 'Sơ Đồ 32 Răng Chuẩn FDI', 'desc' => 'Đăng nhập Cổng Bệnh Nhân để xem chi tiết tình trạng từng răng, lịch sử điều trị và đơn thuốc.', 'foot' => 'Chuẩn quốc tế FDI'],
                    ['icon' => '🧾', 'title' => 'Hóa Đơn & Quét Mã VietQR', 'desc' => 'Minh bạch từng dịch vụ và chi phí, hỗ trợ quét mã VietQR thanh toán tức thì không dùng tiền mặt.', 'foot' => 'Thanh toán 24/7'],
                    ['icon' => '🛡️', 'title' => 'Bảo Hành & Phôi Sứ Chính Hãng', 'desc' => 'Lưu trữ thông tin bảo hành điện tử đối với răng sứ và trụ Implant chính hãng nhập khẩu.', 'foot' => 'Bảo hành điện tử'],
                ] as $feat)
                    <div class="clinic-card rounded-2xl p-6 flex flex-col justify-between gap-4 reveal-item">
                        <div class="space-y-3">
                            <div class="icon-pop w-10 h-10 rounded-xl bg-[#effcf9] text-[#0f3e36] flex items-center justify-center text-lg border border-[#d4af37]/25">{{ $feat['icon'] }}</div>
                            <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">{{ $feat['title'] }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $feat['desc'] }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100/70 text-[11px] font-semibold text-[#0f3e36]/80 flex items-center justify-between">
                            <span>{{ $feat['foot'] }}</span>
                            <span>&rsaquo;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. CÂU HỎI THƯỜNG GẶP VỀ TRA CỨU BỆNH ÁN (ACCORDION MATCHING STITCH) -->
    <section class="py-14 bg-[#effcf9]" x-data="{ openFaq: 1 }">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 reveal-item">
            <div class="text-center space-y-1">
                <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">HỎI ĐÁP NHANH</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Câu Hỏi Thường Gặp Về Tra Cứu Bệnh Án</h2>
            </div>

            <div class="space-y-3">
                <div class="clinic-card rounded-2xl p-5">
                    <button type="button" @click="openFaq = openFaq === 1 ? null : 1" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-[#0f3e36]">
                        <span>Làm thế nào để tra cứu nếu tôi đã đổi số điện thoại?</span>
                        <span class="text-[#d4af37] text-base ml-2" x-text="openFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 1" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2.5 pt-2.5 border-t border-slate-100/70">
                        Nếu bạn thay đổi số điện thoại so với lúc đăng ký hồ sơ ban đầu, vui lòng liên hệ Hotline <strong class="tabular-nums text-[#0f3e36]">0775 761 388</strong> hoặc đến quầy Lễ tân tại 204 Trần Duy Hưng để được xác minh và cập nhật số mới vào hệ thống DCMS.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-5">
                    <button type="button" @click="openFaq = openFaq === 2 ? null : 2" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-[#0f3e36]">
                        <span>Tôi có thể xem lại đơn thuốc và sơ đồ răng đã khám không?</span>
                        <span class="text-[#d4af37] text-base ml-2" x-text="openFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 2" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2.5 pt-2.5 border-t border-slate-100/70">
                        Có. Để bảo mật thông tin bệnh án chuyên sâu (sơ đồ 32 răng FDI, chẩn đoán chi tiết và đơn thuốc), bạn chỉ cần đăng nhập vào mục <strong>Cổng Bệnh Nhân</strong> bằng đúng số điện thoại đã đăng ký.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-5">
                    <button type="button" @click="openFaq = openFaq === 3 ? null : 3" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-[#0f3e36]">
                        <span>Hóa đơn điện tử tại Nha Khoa Smile có hỗ trợ thanh toán VietQR không?</span>
                        <span class="text-[#d4af37] text-base ml-2" x-text="openFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 3" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2.5 pt-2.5 border-t border-slate-100/70">
                        Mọi hóa đơn khám chữa bệnh đều tự động sinh mã VietQR chính xác số tiền và nội dung chuyển khoản, giúp bạn thanh toán nhanh gọn hoặc tải bản in bất cứ lúc nào.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. BOTTOM CTA CARD (MATCHING STITCH) -->
    <section class="py-12 pb-16 bg-[#effcf9]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal-item">
            <div class="clinic-card rounded-3xl p-8 sm:p-10 text-center space-y-5">
                <div class="w-11 h-11 rounded-full bg-[#effcf9] text-[#d4af37] mx-auto flex items-center justify-center text-xl font-bold border border-[#d4af37]/35">+</div>
                <div class="space-y-2 max-w-xl mx-auto">
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Chưa Có Lịch Hẹn Tại Nha Khoa Smile?</h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Đặt hẹn online ngay hôm nay để được chủ động chọn Bác sĩ chuyên khoa, không cần chờ đợi tại quầy Lễ tân và nhận tư vấn phác đồ miễn phí.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                    <a href="{{ route('public.booking') }}" class="btn-press gold-btn-shimmer w-full sm:w-auto px-6 py-3 rounded-xl text-xs uppercase tracking-wider shadow-lg">
                        📅 Đặt Lịch Khám Online Ngay
                    </a>
                    <a href="tel:0775761388" class="btn-press w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold tabular-nums transition">
                        📞 Hotline Tư Vấn: 0775 761 388
                    </a>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 pt-2 text-[11px] text-slate-500 font-medium">
                    <span class="inline-flex items-center gap-1"><span class="text-emerald-600">✓</span> Không phải xếp hàng chờ đợi</span>
                    <span class="inline-flex items-center gap-1"><span class="text-emerald-600">✓</span> Chủ động chọn Bác sĩ theo yêu cầu</span>
                    <span class="inline-flex items-center gap-1"><span class="text-emerald-600">✓</span> Phòng khám vô trùng chuẩn Class B</span>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
