@extends('layouts.public')

@section('title', 'Nha Khoa Smile - Phòng Khám Răng Hàm Mặt Chuẩn Y Khoa')

@section('content')
<div class="bg-[#effcf9]">

    <!-- 1. HERO SECTION (2-COL WIDE DESKTOP LAYOUT MATCHING STITCH + 3D TOOTH STAGE) -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#effcf9] via-white to-[#effcf9] pt-10 pb-14 lg:pt-14 lg:pb-16">
        <!-- Soft Ambient Aura -->
        <div class="absolute top-0 right-10 w-[460px] h-[460px] bg-teal-200/20 rounded-full blur-[130px] pointer-events-none orb-drift-slow"></div>
        <div class="absolute bottom-0 left-10 w-[380px] h-[380px] bg-[#d4af37]/10 rounded-full blur-[120px] pointer-events-none orb-drift-reverse"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">

                <!-- Cột trái (7 cột): Thông điệp phòng khám, Rating, 2 CTA ngang & 4 Chỉ số -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Eyebrow Pill -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-[#0f3e36] text-[11px] font-bold uppercase tracking-widest shadow-sm border border-[#d4af37]/25">
                        <span class="pulse-dot pulse-dot-emerald"></span>
                        <span>Phòng Khám Răng Hàm Mặt Chuẩn Bộ Y Tế</span>
                    </div>

                    <!-- Main Headline & Subtitle -->
                    <div class="space-y-3">
                        <h1 class="font-heading-clinic !text-3xl sm:!text-4xl lg:!text-5xl font-extrabold text-[#0f3e36] !leading-[1.16] tracking-tight">
                            Chăm Sóc Nụ Cười Khỏe Đẹp <br>
                            <span class="text-clinic-gradient">Chuẩn Y Khoa Hiện Đại</span>
                        </h1>
                        <p class="text-sm text-slate-600 leading-relaxed max-w-xl">
                            Hệ thống phòng khám Răng Hàm Mặt ứng dụng công nghệ chụp phim 3D CT ConeBeam, bệnh án điện tử DCMS và quy trình vô trùng chuẩn Bộ Y Tế — điều trị nhẹ nhàng, an toàn và minh bạch chi phí.
                        </p>
                    </div>

                    <!-- Inline Rating Pill -->
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white shadow-sm border border-[#d4af37]/25 gold-pulse">
                        <span class="text-[#d4af37] text-xs tracking-tighter">★★★★★</span>
                        <span class="text-xs font-bold text-[#0f3e36] tabular-nums">4.98 / 5.0</span>
                        <span class="text-slate-300">|</span>
                        <span class="text-xs text-slate-500 font-medium">15.000+ Khách hàng tin tưởng</span>
                    </div>

                    <!-- 2 Side-by-side CTA Buttons (Matching Stitch Desktop) -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-1">
                        <a href="{{ route('public.booking') }}" class="btn-press gold-btn-shimmer px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg">
                            <span>📅</span>
                            <span>Đặt Lịch Khám Ngay</span>
                        </a>
                        <a href="tel:0775761388" class="btn-press px-6 py-3.5 bg-white hover:bg-teal-50/70 text-[#0f3e36] font-bold rounded-xl border border-[#d4af37]/30 transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider shadow-sm tabular-nums">
                            <span>📞</span>
                            <span>Tư Vấn Bác Sĩ: 0775 761 388</span>
                        </a>
                    </div>

                    <!-- Clinical Opening Info Line -->
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-500 pt-1">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-[#d4af37]">🏥</span>
                            <span>Mở cửa 08:00 – 20:00 (Thứ 2 – Chủ Nhật)</span>
                        </span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[#0f3e36] font-semibold hover:underline">
                            <span>📍 204 Trần Duy Hưng, Cầu Giấy, Hà Nội</span>
                        </a>
                    </div>

                    <!-- 4 Compact Metrics Row (Matching Stitch Desktop) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="clinic-card rounded-2xl p-4 text-center reveal-scale reveal-delay-1">
                            <div class="font-heading-clinic text-xl sm:text-2xl font-extrabold text-[#0f3e36] tabular-nums" data-count-to="15" data-count-suffix="+">15+</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Năm kinh nghiệm</div>
                        </div>
                        <div class="clinic-card rounded-2xl p-4 text-center reveal-scale reveal-delay-2">
                            <div class="font-heading-clinic text-xl sm:text-2xl font-extrabold text-[#0f3e36] tabular-nums" data-count-to="15000" data-count-suffix="+">15.000+</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Khách hàng điều trị</div>
                        </div>
                        <div class="clinic-card rounded-2xl p-4 text-center reveal-scale reveal-delay-3">
                            <div class="font-heading-clinic text-xl sm:text-2xl font-extrabold text-[#0f3e36] tabular-nums" data-count-to="100" data-count-suffix="%">100%</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Bác sĩ ĐH Y Dược</div>
                        </div>
                        <div class="clinic-card rounded-2xl p-4 text-center reveal-scale reveal-delay-4">
                            <div class="font-heading-clinic text-xl sm:text-2xl font-extrabold text-[#0f3e36]">Trọn Đời</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Bảo hành điện tử</div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải (5 cột): Thanh Trượt So Sánh Trước – Sau Điều Trị (Interactive Before/After Slider) -->
                <div class="lg:col-span-5" x-data="{ pos: 50 }">
                    <div class="stage-3d-dental rounded-3xl p-4 sm:p-5 flex flex-col justify-between gap-3 shadow-2xl shadow-[#0f3e36]/25 ring-1 ring-[#d4af37]/35 select-none">

                        <!-- Top Bar -->
                        <div class="flex items-center justify-between gap-2 relative z-10">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-[#d4af37]">KẾT QUẢ LÂM SÀNG THỰC TẾ</div>
                                <div class="text-xs sm:text-sm font-bold text-[#f9f6ee]">So Sánh Trước &amp; Sau Điều Trị</div>
                            </div>
                            <div class="flex items-center gap-1 bg-black/40 backdrop-blur-md p-1 rounded-full border border-[#d4af37]/25">
                                <button type="button" @click="pos = 90"
                                    :class="pos >= 75 ? 'bg-[#d4af37] text-[#081412]' : 'text-[#b0c4be] hover:text-white'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition">Trước</button>
                                <button type="button" @click="pos = 50"
                                    :class="pos > 25 && pos < 75 ? 'bg-[#d4af37] text-[#081412]' : 'text-[#b0c4be] hover:text-white'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition">50/50</button>
                                <button type="button" @click="pos = 10"
                                    :class="pos <= 25 ? 'bg-[#d4af37] text-[#081412]' : 'text-[#b0c4be] hover:text-white'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition">Sau</button>
                            </div>
                        </div>

                        <!-- Interactive Before / After Comparison Viewport -->
                        <div class="relative w-full rounded-2xl overflow-hidden border border-[#d4af37]/30 bg-[#071412]" style="aspect-ratio: 4 / 3; min-height: 290px;">
                            <!-- Ảnh SAU điều trị (nền full) -->
                            <img
                                src="{{ asset('images/before-after/veneer-after.jpg') }}"
                                alt="Sau khi dán sứ Veneer Emax tại Nha Khoa Smile"
                                draggable="false"
                                style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; pointer-events: none;"
                            >

                            <!-- Ảnh TRƯỚC điều trị (cắt theo vị trí thanh trượt) -->
                            <img
                                src="{{ asset('images/before-after/veneer-before.jpg') }}"
                                alt="Trước khi dán sứ Veneer Emax tại Nha Khoa Smile"
                                draggable="false"
                                :style="`position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; pointer-events: none; clip-path: inset(0 ${100 - pos}% 0 0);`"
                            >

                            <!-- Nhãn Trước / Sau -->
                            <span
                                x-show="pos > 18"
                                style="position: absolute; top: 12px; left: 12px; z-index: 10; pointer-events: none;"
                                class="px-2.5 py-1 rounded-full bg-black/65 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-200 border border-white/15"
                            >
                                Trước điều trị
                            </span>
                            <span
                                x-show="pos < 82"
                                style="position: absolute; top: 12px; right: 12px; z-index: 10; pointer-events: none;"
                                class="px-2.5 py-1 rounded-full bg-[#0D7A68]/90 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-[#f3e5ab] border border-[#d4af37]/45"
                            >
                                ✓ Sau Veneer Emax
                            </span>

                            <!-- Đường chia dọc & Núm kéo vàng Gold -->
                            <div
                                :style="`position: absolute; top: 0; bottom: 0; left: ${pos}%; z-index: 10; width: 2px; background: #d4af37; box-shadow: 0 0 14px rgba(212,175,55,0.9); pointer-events: none;`"
                            >
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; height: 40px; border-radius: 9999px; background: rgba(9, 61, 53, 0.95); border: 2px solid #f3e5ab; color: #f3e5ab; box-shadow: 0 8px 20px rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M8 9l-3 3 3 3m8-6l3 3-3 3"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Range Input trong suốt phủ toàn khung để kéo mượt trên cả chuột & cảm ứng -->
                            <input
                                type="range"
                                min="0"
                                max="100"
                                step="0.5"
                                x-model.number="pos"
                                aria-label="Kéo để so sánh trước và sau điều trị"
                                style="position: absolute; inset: 0; z-index: 20; width: 100%; height: 100%; opacity: 0; cursor: ew-resize; margin: 0;"
                            >
                        </div>

                        <!-- Bottom Info Bar -->
                        <div class="flex items-center justify-between gap-2 relative z-10 pt-2 border-t border-white/10">
                            <span class="text-[11px] text-[#b0c4be] flex items-center gap-1.5">
                                <span class="text-[#d4af37] font-bold">↔</span>
                                <span>Kéo thanh trượt để so sánh</span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-lg bg-[#d4af37]/20 text-[#f3e5ab] text-[10px] font-bold uppercase tracking-wider border border-[#d4af37]/30">
                                Sứ Emax 0.2mm • 2 Buổi
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. DANH MỤC DỊCH VỤ NHA KHOA (LƯỚI 3x2 = 6 THẺ CHUẨN MẪU DESKTOP) -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 reveal-item">
                <div class="space-y-1">
                    <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">DỊCH VỤ CHUYÊN KHOA</span>
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Danh Mục Dịch Vụ Nha Khoa</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Điều trị toàn diện từ nha khoa tổng quát đến phục hình thẩm mỹ và cấy ghép chuyên sâu.</p>
                </div>
                <a href="{{ route('public.services') }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0f3e36] hover:opacity-80 shrink-0 group">
                    <span>Xem tất cả bảng giá</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            @php
                $clinicServices = [
                    [
                        'cat' => 'PHỤC HÌNH THẨM MỸ',
                        'tag' => 'Bảo hành chính hãng',
                        'title' => 'Dán Sứ Veneer & Bọc Răng Sứ',
                        'desc' => 'Khắc phục răng ố vàng, sứt mẻ, thưa kẽ bằng sứ Emax/Cercon siêu mỏng, bảo tồn răng thật tối đa và ăn nhai bền chắc.',
                        'priceLabel' => 'Giá niêm yết từ:',
                        'price' => '4.000.000 đ / răng',
                        'param' => 'veneer',
                        'primary' => true,
                    ],
                    [
                        'cat' => 'PHỤC HỒI RĂNG MẤT',
                        'tag' => 'Thụy Sĩ • Hoa Kỳ',
                        'title' => 'Cấy Ghép Implant Straumann',
                        'desc' => 'Thay thế răng mất 1:1 bằng trụ Titanium sinh học tích hợp xương nhanh, ngăn tiêu xương hàm và khôi phục sức nhai như răng thật.',
                        'priceLabel' => 'Trọn gói trụ & mão:',
                        'price' => '25.000.000 đ / trụ',
                        'param' => 'implant',
                        'primary' => true,
                    ],
                    [
                        'cat' => 'CHỈNH NHA CHUYÊN SÂU',
                        'tag' => 'Trả góp 0%',
                        'title' => 'Niềng Răng Mắc Cài & Invisalign',
                        'desc' => 'Sắp đều răng khấp khểnh, hô, móm và điều chỉnh khớp cắn chuẩn sinh học bằng mắc cài tự buộc hoặc khay trong suốt Invisalign.',
                        'priceLabel' => 'Trọn gói phác đồ:',
                        'price' => '32.000.000 đ / gói',
                        'param' => 'invisalign',
                        'primary' => true,
                    ],
                    [
                        'cat' => 'THẨM MỸ NỤ CƯỜI',
                        'tag' => 'Chỉ 45 phút',
                        'title' => 'Tẩy Trắng Răng Laser Whitening',
                        'desc' => 'Làm sáng răng bật 3–5 tone ngay trong 1 lần hẹn bằng ánh sáng lạnh sinh học dịu nhẹ, an toàn cho men răng và không ê buốt.',
                        'priceLabel' => 'Chi phí trọn gói:',
                        'price' => '2.000.000 đ / ca',
                        'param' => 'whitening',
                        'primary' => true,
                    ],
                    [
                        'cat' => 'TIỂU PHẪU PIEZOTOME',
                        'tag' => 'Ít xâm lấn',
                        'title' => 'Nhổ Răng Khôn Không Đau',
                        'desc' => 'Ứng dụng máy siêu âm Piezotome nhẹ nhàng bóc tách chân răng mọc lệch, mọc ngầm, hạn chế sưng đau và lành thương nhanh.',
                        'priceLabel' => 'Chi phí từ:',
                        'price' => '490.000 đ / răng',
                        'param' => 'wisdom',
                        'primary' => false,
                    ],
                    [
                        'cat' => 'NHA KHOA TỔNG QUÁT',
                        'tag' => 'Định kỳ 6 tháng',
                        'title' => 'Khám Tổng Quát, Cạo Vôi & CT 3D',
                        'desc' => 'Kiểm tra sức khỏe răng miệng, cạo vôi răng siêu âm, trám răng sâu, điều trị tủy và chụp phim 3D CT ConeBeam phát hiện bệnh lý sớm.',
                        'priceLabel' => 'Khám & tư vấn:',
                        'price' => 'Miễn phí khám',
                        'param' => 'general',
                        'primary' => false,
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($clinicServices as $idx => $item)
                    <div class="clinic-card service-card rounded-2xl p-6 flex flex-col justify-between gap-5 reveal-item">
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#0f3e36]/75">{{ $item['cat'] }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#effcf9] text-[#0f3e36] shrink-0">{{ $item['tag'] }}</span>
                            </div>
                            <h3 class="font-heading-clinic !text-lg font-bold text-[#0f3e36] leading-snug">{{ $item['title'] }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $item['desc'] }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100/70 flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[10px] text-slate-500 block">{{ $item['priceLabel'] }}</span>
                                <div class="font-heading-clinic text-sm sm:text-base font-bold text-[#0f3e36] tabular-nums">{{ $item['price'] }}</div>
                            </div>
                            <a href="{{ route('public.booking', ['service' => $item['param']]) }}"
                               class="btn-press {{ $item['primary'] ? 'btn-clinic-primary' : 'bg-[#effcf9] hover:bg-[#0f3e36] text-[#0f3e36] hover:text-white border border-[#d4af37]/30' }} px-4 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider shrink-0 transition">
                                Đặt Lịch
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. QUY TRÌNH KHÁM CHỮA BỆNH 4 BƯỚC (4 CỘT NGANG CHUẨN MẪU DESKTOP) -->
    <section class="py-16 lg:py-20 bg-[#effcf9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2 reveal-item">
                <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">QUY TRÌNH CHUẨN BỘ Y TẾ</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Quy Trình Khám Chữa Bệnh 4 Bước</h2>
                <p class="text-xs sm:text-sm text-slate-600">Rõ ràng, minh bạch và vô trùng tuyệt đối từ lúc tiếp đón đến khi hoàn tất điều trị.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="clinic-card rounded-2xl p-6 space-y-3 reveal-scale reveal-delay-1">
                    <div class="step-badge-teal icon-pop w-9 h-9 rounded-full bg-[#0f3e36] text-white font-bold text-xs flex items-center justify-center shadow-sm">1</div>
                    <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">Tiếp Đón & Thăm Khám</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Lễ tân tiếp đón, lập hồ sơ bệnh án điện tử DCMS và Bác sĩ trực tiếp kiểm tra tổng quát tình trạng răng miệng.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-6 space-y-3 reveal-scale reveal-delay-2">
                    <div class="step-badge-teal icon-pop w-9 h-9 rounded-full bg-[#0f3e36] text-white font-bold text-xs flex items-center justify-center shadow-sm">2</div>
                    <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">Chụp Phim 3D & Lập Phác Đồ</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Chụp phim CT ConeBeam 3D, ghi nhận sơ đồ 32 răng FDI, giải thích chi tiết phác đồ và báo giá trước khi thực hiện.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-6 space-y-3 reveal-scale reveal-delay-3">
                    <div class="step-badge-teal icon-pop w-9 h-9 rounded-full bg-[#0f3e36] text-white font-bold text-xs flex items-center justify-center shadow-sm">3</div>
                    <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">Điều Trị Vô Trùng An Toàn</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Thực hiện tại phòng thủ thuật vô trùng 1 chiều, gây tê nhẹ nhàng không đau với trang thiết bị nhập khẩu châu Âu.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-6 space-y-3 reveal-scale reveal-delay-4">
                    <div class="step-badge-gold icon-pop w-9 h-9 rounded-full bg-[#e6be53] text-[#0f3e36] font-bold text-xs flex items-center justify-center shadow-sm">4</div>
                    <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">Bảo Hành & Tái Khám Định Kỳ</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Thanh toán minh bạch qua VietQR, cấp phiếu bảo hành điện tử chính hãng và tự động nhắc lịch tái khám định kỳ.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3.5. KHÔNG GIAN PHÒNG KHÁM & TRANG THIẾT BỊ CHUẨN 5 SAO -->
    <section class="py-16 lg:py-20 bg-white border-b border-slate-100/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 reveal-item">
                <div class="space-y-1">
                    <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">CƠ SỞ VẬT CHẤT CHUẨN QUỐC TẾ</span>
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Không Gian &amp; Công Nghệ Nha Khoa 5 Sao</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Trải nghiệm thăm khám riêng tư, vô trùng tuyệt đối chuẩn Bộ Y Tế tại 204 Trần Duy Hưng, Hà Nội.</p>
                </div>
                <a href="{{ route('public.about') }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0f3e36] hover:opacity-80 shrink-0 group">
                    <span>Khám phá Nha Khoa Smile</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="clinic-card rounded-2xl overflow-hidden img-zoom-container reveal-item">
                    <div class="relative overflow-hidden bg-slate-100" style="height: 230px;">
                        <img src="{{ asset('images/clinic/clinic-vip-room.jpg') }}" alt="Phòng điều trị VIP Nha Khoa Smile" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#d4af37] text-[#081412] uppercase tracking-wider mb-1">1 BS : 1 Ghế Riêng Biệt</span>
                            <h3 class="font-heading-clinic !text-base font-bold text-white">Phòng Điều Trị VIP Vô Trùng</h3>
                        </div>
                    </div>
                </div>

                <div class="clinic-card rounded-2xl overflow-hidden img-zoom-container reveal-item">
                    <div class="relative overflow-hidden bg-slate-100" style="height: 230px;">
                        <img src="{{ asset('images/clinic/clinic-ct-3d.jpg') }}" alt="Phòng chụp phim CT ConeBeam 3D" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#0f3e36]/90 text-[#f3e5ab] border border-[#d4af37]/30 uppercase tracking-wider mb-1">Chẩn Đoán Số Hóa DCMS</span>
                            <h3 class="font-heading-clinic !text-base font-bold text-white">Hệ Thống Chụp CT 3D &amp; Scan iTero</h3>
                        </div>
                    </div>
                </div>

                <div class="clinic-card rounded-2xl overflow-hidden img-zoom-container reveal-item">
                    <div class="relative overflow-hidden bg-slate-100" style="height: 230px;">
                        <img src="{{ asset('images/clinic/clinic-lounge.jpg') }}" alt="Sảnh tiếp đón khách hàng Nha Khoa Smile" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#0f3e36]/90 text-[#f3e5ab] border border-[#d4af37]/30 uppercase tracking-wider mb-1">Tiêu Chuẩn Thụy Sĩ</span>
                            <h3 class="font-heading-clinic !text-base font-bold text-white">Sảnh Đón Tiếp &amp; Chăm Sóc Chu Đáo</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. ĐỘI NGŨ BÁC SĨ CHUYÊN KHOA (4 CỘT NGANG CHUẨN MẪU DESKTOP) -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 reveal-item">
                <div class="space-y-1">
                    <span class="block text-[11px] font-bold uppercase tracking-[0.18em] text-[#0f3e36] opacity-75">ĐỘI NGŨ Y BÁC SĨ</span>
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Đội Ngũ Bác Sĩ Chuyên Khoa</h2>
                    <p class="text-xs sm:text-sm text-slate-600">100% tốt nghiệp Đại học Y Dược chính quy, tận tâm với sức khỏe răng miệng của từng bệnh nhân.</p>
                </div>
                <a href="{{ route('public.doctors') }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0f3e36] hover:opacity-80 shrink-0 group">
                    <span>Xem hồ sơ chi tiết bác sĩ</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($doctors as $idx => $doc)
                    @php
                        $rawName = trim($doc->user->name ?? 'Bác sĩ Chuyên khoa');
                        $docName = preg_match('/^(BS|TS|ThS|PGS|GS)\b/iu', $rawName) ? $rawName : 'BS. ' . $rawName;
                        $docSpec = $doc->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                        $docDesc = $doc->description ?: 'Chuyên gia điều trị răng hàm mặt chuẩn y khoa, ưu tiên bảo tồn răng thật và tư vấn tận tâm.';
                        $docExp = 10 + (($idx % 4) * 2);
                    @endphp
                    <div class="clinic-card doctor-card rounded-2xl overflow-hidden flex flex-col justify-between img-zoom-container reveal-item">
                        <div>
                            <div class="relative h-56 overflow-hidden bg-slate-100">
                                <img src="{{ $doc->avatar_url }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                <div class="absolute bottom-2.5 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#0f3e36]/90 backdrop-blur-md text-[#f3e5ab] tabular-nums">
                                        {{ $docExp }}+ năm kinh nghiệm
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 space-y-2">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-[#0f3e36]/75 truncate">{{ $docSpec }}</div>
                                <h3 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">{{ $docName }}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $docDesc }}</p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-2">
                            <a href="{{ route('public.booking', ['doctor_id' => $doc->id]) }}" class="btn-press block w-full py-2 px-3 rounded-xl bg-[#effcf9] hover:bg-[#0f3e36] text-[#0f3e36] hover:text-white text-[11px] font-bold uppercase tracking-wider text-center border border-[#d4af37]/25 transition">
                                Đặt Lịch Khám &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. FORM ĐẶT LỊCH KHÁM NHANH TRỰC TIẾP TRÊN TRANG CHỦ (MATCHING STITCH DESKTOP) -->
    <section class="py-16 lg:py-20 bg-[#effcf9]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 reveal-item">
            <div class="clinic-card rounded-3xl p-6 sm:p-10 space-y-6">
                <div class="text-center space-y-2">
                    <div class="w-11 h-11 rounded-2xl bg-[#effcf9] text-[#0f3e36] mx-auto flex items-center justify-center text-lg border border-[#d4af37]/30">
                        📅
                    </div>
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Đăng Ký Đặt Lịch Khám</h2>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed">
                        Để lại thông tin bên dưới để Lễ tân xác nhận khung giờ khám và sắp xếp Bác sĩ chuyên khoa phù hợp cho bạn.
                    </p>
                </div>

                <form action="{{ route('public.booking.store') }}" method="POST" class="space-y-4">
                    @csrf

                    @if(session('success'))
                        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-500/20 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                            <span>✓</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-500/20 text-rose-700 text-xs space-y-1">
                            <p class="font-bold">Vui lòng kiểm tra lại thông tin đặt lịch:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Họ và tên <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}"
                                placeholder="Ví dụ: Nguyễn Minh Anh"
                                class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Số điện thoại liên hệ <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" required value="{{ old('phone') }}"
                                placeholder="Ví dụ: 0912 345 678"
                                class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs tabular-nums">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Dịch vụ quan tâm
                            </label>
                            <select name="service_id" class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs">
                                <option value="">-- Khám tổng quát & Tư vấn --</option>
                                @foreach($allServices ?? $featuredServices ?? [] as $srv)
                                    <option value="{{ $srv->id }}">{{ $srv->name }} ({{ number_format($srv->price, 0, ',', '.') }} đ)</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Thời gian dự kiến <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local" name="appointment_time" required
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T08:00') }}"
                                value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00') }}"
                                class="input-clinic w-full rounded-xl px-3.5 py-2.5 text-xs tabular-nums">
                        </div>
                    </div>

                    <button type="submit" class="btn-press gold-btn-shimmer w-full py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider shadow-lg">
                        ✦ Xác Nhận Đặt Lịch Khám ✦
                    </button>
                </form>

                <!-- Địa chỉ & Bản đồ chỉ đường gọn đẹp -->
                <div class="pt-4 border-t border-slate-100/70 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <span>📍</span>
                        <span>204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội</span>
                    </span>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i" target="_blank" rel="noopener noreferrer" class="font-bold text-[#0f3e36] hover:underline shrink-0">
                        🗺️ Mở chỉ đường Google Maps &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
