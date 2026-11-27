@extends('layouts.public')

@section('title', ($pageTitle ?? 'Dịch Vụ Nha Khoa') . ' - Nha Khoa Smile')

@section('content')
<div class="bg-[#effcf9]">

    <!-- 1. HERO BANNER CHI TIẾT DỊCH VỤ (CENTERED STITCH LAYOUT) -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#effcf9] via-white to-[#effcf9] pt-12 pb-14 lg:pt-16 lg:pb-16">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[560px] h-[280px] bg-[#d4af37]/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-5">
            <!-- Eyebrow Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-[#0f3e36] text-[11px] font-bold uppercase tracking-widest shadow-sm border border-[#d4af37]/30">
                <span class="pulse-dot pulse-dot-emerald"></span>
                <span>{{ $badge ?? 'CHUYÊN KHOA NHA KHOA CHUẨN Y KHOA' }}</span>
            </div>

            <!-- Main Title -->
            <h1 class="font-heading-clinic !text-3xl sm:!text-4xl lg:!text-5xl font-extrabold text-[#0f3e36] !leading-[1.18] tracking-tight uppercase">
                {{ $heroTitle }} <br class="hidden sm:inline">
                <span class="text-clinic-gradient">{{ $heroHighlight }}</span>
            </h1>

            <!-- Intro Description -->
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
                {{ $heroDesc }}
            </p>

            <!-- 3 Trust Highlights Row (Matching Stitch Screen) -->
            <div class="pt-5 mt-4 border-t border-slate-200/40 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto">
                @foreach($highlights as $hl)
                    <div class="flex items-center justify-center gap-2.5 text-left">
                        <span class="w-8 h-8 rounded-xl bg-white text-[#0f3e36] flex items-center justify-center text-sm shadow-sm border border-[#d4af37]/25 shrink-0">
                            {{ $hl['icon'] }}
                        </span>
                        <div>
                            <div class="text-xs font-bold text-[#0f3e36]">{{ $hl['title'] }}</div>
                            <div class="text-[11px] text-slate-500">{{ $hl['sub'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 2. ĐÁNH GIÁ ƯU & NHƯỢC ĐIỂM (2-COLUMN COMPARISON CARDS) -->
    <section class="py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">{{ $prosConsTitle ?? 'Đánh Giá Ưu & Nhược Điểm Y Khoa' }}</h2>
                <p class="text-xs sm:text-sm text-slate-500">{{ $prosConsSub ?? 'Thông tin minh bạch giúp bệnh nhân hiểu rõ trước khi quyết định điều trị.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ưu điểm -->
                <div class="clinic-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between gap-5 reveal-item">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100/70">
                            <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base font-bold shrink-0">✓</span>
                            <div>
                                <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36] uppercase">Ưu Điểm Vượt Trội</h3>
                                <p class="text-[11px] text-slate-500">Hiệu quả lâm sàng và giá trị lâu dài</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs text-slate-600 leading-relaxed">
                            @foreach($pros as $pro)
                                <li class="flex items-start gap-2.5">
                                    <span class="text-emerald-600 font-bold mt-0.5 shrink-0">✓</span>
                                    <span><strong class="text-slate-900">{{ $pro['title'] }}:</strong> {{ $pro['desc'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100/70 flex items-center justify-between text-[11px] text-slate-500">
                        <span>Đánh giá bởi Hội đồng chuyên môn</span>
                        <span class="font-bold text-[#0f3e36]">Chuẩn Bộ Y Tế</span>
                    </div>
                </div>

                <!-- Nhược điểm & Lưu ý -->
                <div class="clinic-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between gap-5 reveal-item">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100/70">
                            <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-base font-bold shrink-0">!</span>
                            <div>
                                <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36] uppercase">Nhược Điểm & Lưu Ý Y Khoa</h3>
                                <p class="text-[11px] text-slate-500">Những điều cần cân nhắc và tuân thủ</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-xs text-slate-600 leading-relaxed">
                            @foreach($cons as $con)
                                <li class="flex items-start gap-2.5">
                                    <span class="text-amber-600 font-bold mt-0.5 shrink-0">•</span>
                                    <span><strong class="text-slate-900">{{ $con['title'] }}:</strong> {{ $con['desc'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pt-3 border-t border-slate-100/70 text-[11px] text-slate-500">
                        Bác sĩ sẽ thăm khám và chụp phim 3D để tư vấn chỉ định phù hợp nhất.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. AI NÊN THỰC HIỆN DỊCH VỤ NÀY? (4-COLUMN ICON GRID) -->
    <section class="py-14 bg-[#effcf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">{{ $whoTitle }}</h2>
                <p class="text-xs sm:text-sm text-slate-600">{{ $whoSub ?? 'Các trường hợp lâm sàng thường được Bác sĩ chỉ định thực hiện.' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($whoCards as $idx => $card)
                    <div class="clinic-card rounded-2xl p-6 text-center space-y-3 reveal-scale reveal-delay-{{ ($idx % 4) + 1 }}">
                        <div class="icon-pop w-11 h-11 rounded-xl bg-[#effcf9] text-[#0f3e36] mx-auto flex items-center justify-center text-xl border border-[#d4af37]/25">
                            {{ $card['icon'] }}
                        </div>
                        <h3 class="font-heading-clinic !text-sm font-bold text-[#0f3e36]">{{ $card['title'] }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $card['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. TIÊU CHÍ LỰA CHỌN PHÙ HỢP (5-COLUMN NUMBERED CARDS 01-05) -->
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">{{ $criteriaTitle }}</h2>
                <p class="text-xs sm:text-sm text-slate-500">5 tiêu chí chuyên môn giúp bạn chọn đúng giải pháp an toàn và bền đẹp lâu dài.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($criteria as $idx => $item)
                    <div class="clinic-card rounded-2xl p-5 flex flex-col justify-between gap-4 reveal-item">
                        <div class="space-y-2">
                            <div class="font-heading-clinic text-xl font-extrabold text-[#d4af37] tabular-nums">0{{ $idx + 1 }}</div>
                            <h3 class="font-heading-clinic !text-sm font-bold text-[#0f3e36]">{{ $item['title'] }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                        <div class="pt-2.5 border-t border-slate-100/70 text-[10px] font-bold uppercase tracking-wider text-[#0f3e36]/75">
                            {{ $item['tag'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. QUY TRÌNH 6 BƯỚC CHUẨN Y KHOA (3x2 GRID MATCHING STITCH) -->
    <section class="py-14 bg-[#effcf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">{{ $processTitle }}</h2>
                <p class="text-xs sm:text-sm text-slate-600">Tuân thủ nghiêm ngặt quy trình kiểm soát nhiễm khuẩn và an toàn lâm sàng Bộ Y Tế.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($steps as $idx => $step)
                    <div class="clinic-card rounded-2xl p-6 space-y-2.5 relative reveal-item">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">{{ $step['title'] }}</h3>
                            <span class="font-heading-clinic text-2xl font-extrabold text-[#d4af37]/45 tabular-nums leading-none shrink-0">0{{ $idx + 1 }}</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. BẢNG GIÁ NIÊM YẾT CHI TIẾT (MATCHING STITCH TABLE) -->
    <section class="py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">MINH BẠCH CHI PHÍ ĐIỀU TRỊ</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">{{ $priceTitle }}</h2>
                <p class="text-xs sm:text-sm text-slate-500">Chi phí niêm yết công khai, không phát sinh chi phí ẩn và hỗ trợ thanh toán VietQR.</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/40 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs table-spotlight">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-[11px] uppercase tracking-wider border-b border-slate-200/40">
                                <th class="py-3.5 px-4 font-bold text-center w-14">STT</th>
                                <th class="py-3.5 px-4 font-bold">Dịch vụ / Vật liệu</th>
                                <th class="py-3.5 px-4 font-bold">Xuất xứ & Đặc tính</th>
                                <th class="py-3.5 px-4 font-bold text-center">Bảo hành</th>
                                <th class="py-3.5 px-4 font-bold text-right">Chi phí niêm yết</th>
                                <th class="py-3.5 px-4 font-bold text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/60">
                            @foreach($priceRows as $idx => $row)
                                <tr class="hover:bg-teal-50/40 transition">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-500 tabular-nums">{{ $idx + 1 }}</td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        <span>{{ $row['name'] }}</span>
                                        @if(!empty($row['badge']))
                                            <span class="ml-1.5 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800">{{ $row['badge'] }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $row['desc'] }}</td>
                                    <td class="py-3.5 px-4 text-center font-semibold text-slate-700 whitespace-nowrap">{{ $row['warranty'] }}</td>
                                    <td class="py-3.5 px-4 text-right font-heading-clinic font-extrabold text-[#0f3e36] whitespace-nowrap tabular-nums">{{ $row['price'] }}</td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <a href="#service-booking-form" class="btn-press {{ !empty($row['featured']) ? 'gold-btn-shimmer' : 'btn-clinic-primary' }} inline-flex items-center px-3.5 py-1.5 rounded-lg text-[11px] font-bold">
                                            Chọn
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. VÌ SAO CHỌN NHA KHOA SMILE? (5-COLUMN TRUST STRIP) -->
    <section class="py-14 bg-[#effcf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-1.5 reveal-item">
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] uppercase">Vì Sao Chọn Nha Khoa Smile?</h2>
                <p class="text-xs sm:text-sm text-slate-600">Cam kết chất lượng điều trị, vô trùng tuyệt đối và đồng hành cùng sức khỏe răng miệng của bạn.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach([
                    ['icon' => '👨‍⚕️', 'title' => 'Bác Sĩ Chuyên Khoa', 'desc' => '100% tốt nghiệp ĐH Y Dược, giàu kinh nghiệm lâm sàng.'],
                    ['icon' => '🩻', 'title' => 'Chẩn Đoán CT 3D', 'desc' => 'Phim 3D ConeBeam & scan dấu hàm kỹ thuật số chính xác.'],
                    ['icon' => '🫧', 'title' => 'Vô Trùng Class B', 'desc' => 'Phòng thủ thuật vô trùng 1 chiều chuẩn Bộ Y Tế.'],
                    ['icon' => '🛡️', 'title' => 'Vật Liệu Chính Hãng', 'desc' => 'Nhập khẩu Đức, Thụy Sĩ, Hoa Kỳ có thẻ bảo hành điện tử.'],
                    ['icon' => '🧾', 'title' => 'Minh Bạch VietQR', 'desc' => 'Báo giá trước điều trị, lưu bệnh án & hóa đơn trên DCMS.'],
                ] as $why)
                    <div class="clinic-card rounded-2xl p-5 text-center space-y-2 reveal-item">
                        <div class="icon-pop w-10 h-10 rounded-xl bg-[#effcf9] text-[#0f3e36] mx-auto flex items-center justify-center text-lg border border-[#d4af37]/25">{{ $why['icon'] }}</div>
                        <h3 class="font-heading-clinic !text-xs sm:!text-sm font-bold text-[#0f3e36]">{{ $why['title'] }}</h3>
                        <p class="text-[11px] text-slate-600 leading-relaxed">{{ $why['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 8. FORM ĐĂNG KÝ TƯ VẤN & ĐẶT LỊCH MIỄN PHÍ (CENTERED CARD MATCHING STITCH) -->
    <section id="service-booking-form" class="py-14 pb-18 bg-[#effcf9]">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 reveal-item">
            <div class="clinic-card rounded-3xl p-6 sm:p-10 space-y-6">
                <div class="text-center space-y-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-[10px] font-bold uppercase tracking-widest">
                        Tư Vấn Trực Tiếp Cùng Bác Sĩ
                    </span>
                    <h2 class="font-heading-clinic !text-2xl font-bold text-[#0f3e36] uppercase">Đăng Ký Tư Vấn & Đặt Lịch Khám</h2>
                    <p class="text-xs text-slate-600">Điền thông tin bên dưới để nhận lịch hẹn ưu tiên và báo giá chi tiết từ Nha Khoa Smile.</p>
                </div>

                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-500/20 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                        <span>✓</span><span>{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-500/20 text-rose-700 text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('public.booking.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Nhập họ và tên của bạn..." class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Số điện thoại <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="Nhập số điện thoại liên hệ..." class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs tabular-nums">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Dịch vụ quan tâm</label>
                        <select name="service_id" class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs">
                            <option value="">-- {{ $pageTitle ?? 'Khám tổng quát & Tư vấn' }} --</option>
                            @foreach($services ?? [] as $srv)
                                <option value="{{ $srv->id }}" @selected(isset($targetService) && $targetService && $targetService->id == $srv->id)>
                                    {{ $srv->name }} ({{ number_format($srv->price, 0, ',', '.') }} đ)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Chọn Bác sĩ (Tùy chọn)</label>
                        <select name="doctor_id" class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs">
                            <option value="">-- Phòng khám sắp xếp Bác sĩ chuyên khoa phù hợp --</option>
                            @foreach($doctors ?? [] as $doc)
                                @php
                                    $rName = trim($doc->user->name ?? ('Bác sĩ #' . $doc->id));
                                    $dName = preg_match('/^(BS|TS|ThS|PGS|GS)\b/iu', $rName) ? $rName : 'BS. ' . $rName;
                                @endphp
                                <option value="{{ $doc->id }}">{{ $dName }} — {{ $doc->specialty ?: 'Chuyên khoa Răng Hàm Mặt' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Thời gian dự kiến <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="appointment_time" required
                            min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T08:00') }}"
                            value="{{ old('appointment_time', \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00')) }}"
                            class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs tabular-nums">
                    </div>

                    <button type="submit" class="btn-press gold-btn-shimmer w-full py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-lg">
                        Gửi Đăng Ký Tư Vấn & Đặt Lịch
                    </button>
                </form>

                <div class="pt-3 border-t border-slate-100/70 text-center text-[11px] text-slate-500">
                    📍 204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội • 📞 Hotline: <a href="tel:0775761388" class="font-bold text-[#0f3e36] hover:underline tabular-nums">0775 761 388</a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
