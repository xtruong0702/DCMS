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

                <!-- Cột phải (5 cột): Khung Mô Hình Răng 3D Tương Tác (Three.js) -->
                <div class="lg:col-span-5" x-data="{ mode3d: 'veneer' }">
                    <div class="stage-3d-dental rounded-3xl p-5 sm:p-6 h-[360px] sm:h-[430px] flex flex-col justify-between shadow-2xl shadow-[#0f3e36]/20 ring-1 ring-[#d4af37]/30 select-none">

                        <!-- Top Bar inside 3D Showcase -->
                        <div class="flex items-center justify-between relative z-10 pointer-events-auto">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-[#d4af37]">CHẨN ĐOÁN SỐ HÓA</div>
                                <div class="text-xs font-bold text-[#f9f6ee]">Mô Hình Răng 3D DCMS</div>
                            </div>
                            <div class="flex items-center gap-1 bg-black/35 backdrop-blur-md p-1 rounded-full border border-[#d4af37]/25">
                                <button type="button" @click="mode3d = 'veneer'; window.dispatchEvent(new CustomEvent('dental3d:mode', { detail: 'veneer' }))"
                                    :class="mode3d === 'veneer' ? 'bg-[#d4af37] text-[#081412]' : 'text-[#b0c4be] hover:text-white'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition">Răng Sứ</button>
                                <button type="button" @click="mode3d = 'diamond'; window.dispatchEvent(new CustomEvent('dental3d:mode', { detail: 'diamond' }))"
                                    :class="mode3d === 'diamond' ? 'bg-[#d4af37] text-[#081412]' : 'text-[#b0c4be] hover:text-white'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold transition">Phục Hình</button>
                            </div>
                        </div>

                        <!-- Three.js Interactive Canvas -->
                        <div id="dental-3d-container" class="absolute inset-0 z-[2] cursor-grab active:cursor-grabbing"></div>

                        <!-- Bottom Info Bar -->
                        <div class="flex items-center justify-between gap-2 relative z-10 pt-3 border-t border-white/10 pointer-events-none">
                            <span class="text-[11px] text-[#b0c4be] flex items-center gap-1.5">
                                <span class="text-[#d4af37]">↻</span>
                                <span>Chạm & kéo để xoay 360°</span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-lg bg-[#d4af37]/20 text-[#f3e5ab] text-[10px] font-bold uppercase tracking-wider border border-[#d4af37]/30"
                                x-text="mode3d === 'veneer' ? 'Sứ Emax 0.2mm' : 'Chuẩn Khớp Cắn'">
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

            @php
                $homeDoctorImages = [
                    'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=85',
                    'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=600&q=85',
                    'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=85',
                    'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=85',
                ];
            @endphp

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
                                <img src="{{ $homeDoctorImages[$idx % count($homeDoctorImages)] }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('dental-3d-container');
        if (!container || typeof THREE === 'undefined') return;

        try {
            const width = container.clientWidth || 400;
            const height = container.clientHeight || 380;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(42, width / height, 0.1, 100);
            camera.position.set(0, 0.12, 5.1);

            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            scene.add(new THREE.AmbientLight(0xffffff, 0.95));
            const keyLight = new THREE.DirectionalLight(0xfff7d6, 2.2);
            keyLight.position.set(4, 5, 5);
            scene.add(keyLight);

            const rimLight = new THREE.PointLight(0x5eead4, 2.0, 18);
            rimLight.position.set(-4, -2, 3);
            scene.add(rimLight);

            const goldLight = new THREE.PointLight(0xd4af37, 2.0, 16);
            goldLight.position.set(3, -3, 2);
            scene.add(goldLight);

            const gemGroup = new THREE.Group();
            scene.add(gemGroup);

            const veneerMat = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                emissive: 0x0f3e36,
                emissiveIntensity: 0.08,
                metalness: 0.05,
                roughness: 0.08,
                clearcoat: 1.0,
                clearcoatRoughness: 0.04,
                reflectivity: 1.0,
            });
            const goldToothMat = new THREE.MeshPhysicalMaterial({
                color: 0xf3e5ab,
                emissive: 0xb89028,
                emissiveIntensity: 0.16,
                metalness: 0.85,
                roughness: 0.14,
                clearcoat: 1.0,
                clearcoatRoughness: 0.06,
            });

            const toothShape = new THREE.Shape();
            toothShape.moveTo(0, 0.82);
            toothShape.bezierCurveTo(0.28, 1.04, 0.78, 1.02, 0.88, 0.56);
            toothShape.bezierCurveTo(0.95, 0.22, 0.78, -0.06, 0.72, -0.32);
            toothShape.bezierCurveTo(0.66, -0.68, 0.56, -1.12, 0.36, -1.16);
            toothShape.bezierCurveTo(0.18, -1.18, 0.14, -0.72, 0.06, -0.52);
            toothShape.bezierCurveTo(0.02, -0.44, -0.02, -0.44, -0.06, -0.52);
            toothShape.bezierCurveTo(-0.14, -0.72, -0.18, -1.18, -0.36, -1.16);
            toothShape.bezierCurveTo(-0.56, -1.12, -0.66, -0.68, -0.72, -0.32);
            toothShape.bezierCurveTo(-0.78, -0.06, -0.95, 0.22, -0.88, 0.56);
            toothShape.bezierCurveTo(-0.78, 1.02, -0.28, 1.04, 0, 0.82);

            const toothGeo = new THREE.ExtrudeGeometry(toothShape, {
                depth: 0.34,
                bevelEnabled: true,
                bevelSegments: 16,
                steps: 2,
                bevelSize: 0.24,
                bevelThickness: 0.30,
                curveSegments: 36,
            });
            toothGeo.center();

            const toothMesh = new THREE.Mesh(toothGeo, veneerMat);
            toothMesh.scale.set(0.95, 0.95, 0.95);
            gemGroup.add(toothMesh);

            window.addEventListener('dental3d:mode', (e) => {
                toothMesh.material = e.detail === 'diamond' ? goldToothMat : veneerMat;
            });

            const goldRingMat = new THREE.MeshStandardMaterial({
                color: 0xd4af37,
                emissive: 0xb89028,
                emissiveIntensity: 0.25,
                metalness: 0.92,
                roughness: 0.18,
            });
            const ring1 = new THREE.Mesh(new THREE.TorusGeometry(1.75, 0.028, 16, 100), goldRingMat);
            ring1.rotation.x = Math.PI / 2.6;
            ring1.rotation.y = 0.25;
            gemGroup.add(ring1);

            const ring2 = new THREE.Mesh(new THREE.TorusGeometry(2.05, 0.015, 12, 100), goldRingMat);
            ring2.rotation.x = -Math.PI / 3.2;
            ring2.rotation.z = 0.4;
            gemGroup.add(ring2);

            const particleCount = 65;
            const positions = new Float32Array(particleCount * 3);
            for (let i = 0; i < particleCount; i++) {
                const r = 1.9 + Math.random() * 1.8;
                const theta = Math.random() * Math.PI * 2;
                const phi = Math.acos(2 * Math.random() - 1);
                positions[i * 3] = r * Math.sin(phi) * Math.cos(theta);
                positions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
                positions[i * 3 + 2] = r * Math.cos(phi);
            }
            const particleGeo = new THREE.BufferGeometry();
            particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            const particles = new THREE.Points(particleGeo, new THREE.PointsMaterial({
                color: 0xf3e5ab,
                size: 0.055,
                transparent: true,
                opacity: 0.85,
            }));
            scene.add(particles);

            let isDragging = false, prevX = 0, prevY = 0, targetRotX = 0.18, targetRotY = 0;
            const onDown = (x, y) => { isDragging = true; prevX = x; prevY = y; };
            const onMove = (x, y) => {
                if (!isDragging) return;
                targetRotY += (x - prevX) * 0.012;
                targetRotX = Math.max(-1.1, Math.min(1.1, targetRotX + (y - prevY) * 0.012));
                prevX = x; prevY = y;
            };
            const onUp = () => { isDragging = false; };

            const canvas = renderer.domElement;
            canvas.addEventListener('mousedown', (e) => onDown(e.clientX, e.clientY));
            window.addEventListener('mousemove', (e) => onMove(e.clientX, e.clientY));
            window.addEventListener('mouseup', onUp);
            canvas.addEventListener('touchstart', (e) => { if (e.touches[0]) onDown(e.touches[0].clientX, e.touches[0].clientY); }, { passive: true });
            canvas.addEventListener('touchmove', (e) => { if (e.touches[0]) onMove(e.touches[0].clientX, e.touches[0].clientY); }, { passive: true });
            window.addEventListener('touchend', onUp);

            window.addEventListener('resize', () => {
                const w = container.clientWidth || 400;
                const h = container.clientHeight || 380;
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
                renderer.setSize(w, h);
            });

            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let clock = 0;
            const animate = () => {
                requestAnimationFrame(animate);
                if (!reducedMotion) {
                    clock += 0.014;
                    if (!isDragging) targetRotY += 0.0055;
                    gemGroup.position.y = Math.sin(clock * 1.4) * 0.1;
                    ring1.rotation.z += 0.006;
                    ring2.rotation.y -= 0.004;
                    particles.rotation.y += 0.0018;
                }
                gemGroup.rotation.y += (targetRotY - gemGroup.rotation.y) * 0.08;
                gemGroup.rotation.x += (targetRotX - gemGroup.rotation.x) * 0.08;
                renderer.render(scene, camera);
            };
            animate();
        } catch (err) {}
    });
</script>
@endpush
