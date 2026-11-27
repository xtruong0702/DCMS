@extends('layouts.public')

@section('title', 'Về Nha Khoa Smile - Phòng Khám Răng Hàm Mặt Chuẩn Y Khoa')

@section('content')
<div class="bg-[#effcf9]">

    <!-- 1. HERO GIỚI THIỆU (CENTERED STITCH LAYOUT) -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#effcf9] via-white to-[#effcf9] pt-12 pb-12 sm:pt-16 sm:pb-14">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[560px] h-[260px] bg-[#d4af37]/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-[#0f3e36] text-[11px] font-bold uppercase tracking-widest shadow-sm border border-[#d4af37]/30">
                <span class="text-[#d4af37]">✦</span>
                <span>Triết Lý Điều Trị & Y Đức</span>
            </div>

            <h1 class="font-heading-clinic !text-3xl sm:!text-4xl lg:!text-5xl font-extrabold tracking-tight text-[#0f3e36]">
                Về <span class="text-clinic-gradient">Nha Khoa Smile</span>
            </h1>

            <p class="text-slate-600 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                Hơn 15 năm đồng hành chăm sóc sức khỏe răng miệng cho hơn 50.000 lượt bệnh nhân. Kết hợp y đức chuẩn mực cùng công nghệ nha khoa kỹ thuật số DCMS.
            </p>
        </div>
    </section>

    <!-- 2. CÂU CHUYỆN & TÂM ĐỨC Y KHOA (2-COLUMN STORY + FLOATING BADGE) -->
    <section class="py-10 sm:py-14 bg-[#effcf9]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <!-- Cột ảnh phòng khám + Thẻ nổi 15+ góc dưới trái -->
                <div class="lg:col-span-6 relative reveal-item">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl ring-1 ring-[#d4af37]/25 img-zoom-container bg-white">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=85" alt="Không gian Nha Khoa Smile" class="w-full h-[340px] sm:h-[400px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"></div>

                        <!-- Floating 15+ Years Badge inside bottom-left (Matching Stitch Screen) -->
                        <div class="absolute bottom-4 left-4 right-4 sm:right-auto bg-[#0b1f1b]/90 backdrop-blur-md px-4 py-3 rounded-2xl border border-[#d4af37]/35 shadow-xl flex items-center gap-3.5">
                            <div class="font-heading-clinic text-2xl font-extrabold text-[#f3e5ab] tabular-nums leading-none">15+</div>
                            <div class="border-l border-white/15 pl-3">
                                <p class="font-bold text-white text-xs leading-tight">Năm Chăm Sóc Nụ Cười</p>
                                <p class="text-[10px] text-[#b0c4be] mt-0.5">Tiêu chuẩn Bộ Y Tế & Quốc tế</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột nội dung Tâm Đức Y Khoa -->
                <div class="lg:col-span-6 space-y-5 reveal-item">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#0f3e36] text-[10px] font-bold uppercase tracking-widest border border-[#d4af37]/25 shadow-sm">
                        <span class="text-[#d4af37]">✦</span>
                        <span>Tâm Đức Y Khoa</span>
                    </div>

                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36] leading-snug">
                        Bảo Tồn Răng Thật & <span class="text-clinic-gradient">Điều Trị Chuẩn Xác</span>
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Tại Nha Khoa Smile, chúng tôi tin rằng một hàm răng khỏe đẹp bền vững phải bắt nguồn từ nền tảng sinh học chắc khỏe, khớp cắn chuẩn xác và ưu tiên <strong class="text-slate-900">bảo tồn tối đa răng thật nguyên bản</strong>.
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Mọi ca khám và điều trị đều được theo dõi chặt chẽ trên hệ thống bệnh án điện tử DCMS với sơ đồ 32 răng chuẩn FDI, cùng quy trình kiểm soát nhiễm khuẩn khắt khe theo quy chuẩn Bộ Y Tế.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div class="clinic-card rounded-2xl p-4 flex items-start gap-3">
                            <span class="w-9 h-9 rounded-xl bg-[#effcf9] text-[#d4af37] flex items-center justify-center text-base shrink-0 border border-[#d4af37]/25">🛡️</span>
                            <div>
                                <div class="font-heading-clinic text-base font-extrabold text-[#0f3e36] tabular-nums">100%</div>
                                <div class="text-xs font-bold text-slate-800">Vật Liệu & Thuốc Chính Hãng</div>
                                <p class="text-[11px] text-slate-500 mt-0.5">Xuất xứ Đức, Thụy Sĩ, Mỹ kiểm tra mã QR.</p>
                            </div>
                        </div>
                        <div class="clinic-card rounded-2xl p-4 flex items-start gap-3">
                            <span class="w-9 h-9 rounded-xl bg-[#effcf9] text-[#d4af37] flex items-center justify-center text-base shrink-0 border border-[#d4af37]/25">👨‍⚕️</span>
                            <div>
                                <div class="font-heading-clinic text-base font-extrabold text-[#0f3e36]">1 BS : 1 Ghế</div>
                                <div class="text-xs font-bold text-slate-800">Thăm Khám Kỹ Lưỡng, Vô Trùng</div>
                                <p class="text-[11px] text-slate-500 mt-0.5">Phòng điều trị riêng biệt, đảm bảo riêng tư.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. 3 TRỤ CỘT CỐT LÕI: CAM KẾT CHẤT LƯỢNG ĐIỀU TRỊ -->
            <div class="space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2 reveal-item">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#0f3e36] text-[10px] font-bold uppercase tracking-widest border border-[#d4af37]/25 shadow-sm">
                        <span class="text-[#d4af37]">✦</span>
                        <span>3 Trụ Cột Cốt Lõi</span>
                    </div>
                    <h3 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">
                        Cam Kết <span class="text-clinic-gradient">Chất Lượng Điều Trị</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600">Những nguyên tắc kiên định định hình uy tín của Nha Khoa Smile suốt hơn một thập kỷ qua.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([
                        ['icon' => '🏥', 'title' => 'Phòng Khám Vô Trùng 1 Chiều', 'desc' => 'Không gian khang trang, sạch sẽ, tiệt trùng dụng cụ bằng nồi hấp Class B chuẩn châu Âu giúp loại bỏ hoàn toàn nguy cơ lây nhiễm chéo.', 'foot' => 'Tiêu chuẩn kiểm soát nhiễm khuẩn'],
                        ['icon' => '🔬', 'title' => 'Công Nghệ Kỹ Thuật Số DCMS', 'desc' => 'Chụp phim 3D CT ConeBeam, quét mẫu hàm kỹ thuật số, lưu trữ bệnh án điện tử 32 răng FDI và thanh toán mã VietQR minh bạch.', 'foot' => 'Đồng bộ hồ sơ thời gian thực'],
                        ['icon' => '🛡️', 'title' => 'Bảo Hành Minh Bạch & Dài Lâu', 'desc' => 'Cấp thẻ bảo hành chính hãng đối với răng sứ, trụ Implant và theo dõi lịch tái khám chăm sóc răng miệng định kỳ miễn phí.', 'foot' => 'Cam kết trách nhiệm trọn đời'],
                    ] as $pillar)
                        <div class="clinic-card rounded-2xl p-6 flex flex-col justify-between gap-5 reveal-item">
                            <div class="space-y-3">
                                <div class="icon-pop w-11 h-11 rounded-xl bg-[#effcf9] text-[#0f3e36] flex items-center justify-center text-xl border border-[#d4af37]/25">
                                    {{ $pillar['icon'] }}
                                </div>
                                <h4 class="font-heading-clinic !text-base font-bold text-[#0f3e36]">{{ $pillar['title'] }}</h4>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $pillar['desc'] }}</p>
                            </div>
                            <div class="pt-3 border-t border-slate-100/70 flex items-center justify-between text-[11px] font-semibold text-[#0f3e36]/80">
                                <span>{{ $pillar['foot'] }}</span>
                                <span>&rsaquo;</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. TRANG THIẾT BỊ HIỆN ĐẠI: HỆ THỐNG CÔNG NGHỆ CHẨN ĐOÁN 3D -->
            <div class="space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2 reveal-item">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#0f3e36] text-[10px] font-bold uppercase tracking-widest border border-[#d4af37]/25 shadow-sm">
                        <span class="text-[#d4af37]">✦</span>
                        <span>Trang Thiết Bị Hiện Đại</span>
                    </div>
                    <h3 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">
                        Hệ Thống Công Nghệ <span class="text-clinic-gradient">Chẩn Đoán 3D</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600">Đầu tư đồng bộ 100% máy móc nhập khẩu từ Đức, Thụy Sĩ và Hoa Kỳ giúp chẩn đoán chính xác từng micromet.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach([
                        ['icon' => '🩻', 'title' => 'CT ConeBeam 3D', 'desc' => 'Tái tạo cấu trúc xương hàm, dây thần kinh 3 chiều rõ nét với liều tia thấp an toàn tuyệt đối.', 'foot' => 'Chẩn đoán 3D vi thể'],
                        ['icon' => '🖥️', 'title' => 'Scan Răng iTero 5D', 'desc' => 'Lấy dấu răng kỹ thuật số chỉ trong 60 giây, xem trước kết quả nụ cười mà không gây khó chịu.', 'foot' => 'Công nghệ lấy dấu 5D'],
                        ['icon' => '🫧', 'title' => 'Autoclave Class B', 'desc' => 'Tiệt trùng dụng cụ khép kín tiêu chuẩn bệnh viện Châu Âu, mỗi bệnh nhân 1 bộ tay khoan riêng.', 'foot' => 'Vô trùng tuyệt đối'],
                        ['icon' => '⚡', 'title' => 'Siêu Âm Piezotome', 'desc' => 'Công nghệ rung siêu âm chọn lọc giúp nhổ răng khôn không chạm mô mềm, không sưng đau.', 'foot' => 'Tiểu phẫu không đau'],
                    ] as $tech)
                        <div class="clinic-card rounded-2xl p-5 flex flex-col justify-between gap-4 reveal-scale">
                            <div class="space-y-2.5">
                                <div class="icon-pop w-10 h-10 rounded-xl bg-[#effcf9] text-[#0f3e36] flex items-center justify-center text-lg border border-[#d4af37]/25">
                                    {{ $tech['icon'] }}
                                </div>
                                <h4 class="font-heading-clinic !text-sm font-bold text-[#0f3e36]">{{ $tech['title'] }}</h4>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $tech['desc'] }}</p>
                            </div>
                            <div class="pt-2.5 border-t border-slate-100/70 text-[11px] font-semibold text-[#d4af37]">
                                {{ $tech['foot'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 5. CHẶNG ĐƯỜNG TỰ HÀO: HÀNH TRÌNH KIẾN TẠO NỤ CƯỜI VIỆT -->
            <div class="space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2 reveal-item">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#0f3e36] text-[10px] font-bold uppercase tracking-widest border border-[#d4af37]/25 shadow-sm">
                        <span class="text-[#d4af37]">✦</span>
                        <span>Chặng Đường Tự Hào</span>
                    </div>
                    <h3 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">
                        Hành Trình <span class="text-clinic-gradient">Kiến Tạo Nụ Cười Việt</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600">Những cột mốc khẳng định sự phát triển không ngừng về kỹ thuật chuyên môn và hạ tầng.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach([
                        ['year' => '2010', 'title' => 'Thành Lập Phòng Khám', 'desc' => 'Khởi đầu với đội ngũ bác sĩ tốt nghiệp ĐH Y Hà Nội cùng 4 ghế nha khoa tiêu chuẩn.'],
                        ['year' => '2016', 'title' => 'Chuyển Giao Thụy Sĩ', 'desc' => 'Trở thành đối tác chiến lược cấy ghép Implant Straumann và sứ thẩm mỹ Emax Đức.'],
                        ['year' => '2021', 'title' => 'Số Hóa Toàn Diện DCMS', 'desc' => 'Triển khai bệnh án điện tử, sơ đồ 32 răng FDI và tra cứu hóa đơn VietQR tự động.'],
                        ['year' => 'Hiện Tại', 'title' => '15.000+ Nụ Cười Hoàn Mỹ', 'desc' => 'Không gian phòng khám hiện đại chuẩn Y khoa tại 204 Trần Duy Hưng, Cầu Giấy, Hà Nội.'],
                    ] as $idx => $mile)
                        <div class="clinic-card rounded-2xl p-6 space-y-2 reveal-scale reveal-delay-{{ ($idx % 4) + 1 }}">
                            <div class="font-heading-clinic text-2xl font-extrabold text-[#d4af37] tabular-nums">{{ $mile['year'] }}</div>
                            <div class="text-sm font-bold text-[#0f3e36]">{{ $mile['title'] }}</div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $mile['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 6. CTA CARD CUỐI TRANG (MATCHING STITCH SCREEN) -->
            <div class="clinic-card rounded-3xl p-7 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 reveal-item">
                <div class="space-y-2 text-center md:text-left max-w-xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-[10px] font-bold uppercase tracking-widest">
                        <span>★</span>
                        <span>Ưu Tiên Tiếp Đón Đặt Hẹn Online</span>
                    </span>
                    <h3 class="font-heading-clinic !text-2xl font-bold text-[#0f3e36]">Trải Nghiệm Thăm Khám Chuẩn Y Khoa Ngay Hôm Nay</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Đặt lịch trước để được tư vấn 1:1 cùng Bác sĩ Chuyên khoa và chụp phim chẩn đoán chi tiết mà không phải chờ đợi.
                    </p>
                </div>
                <a href="{{ route('public.booking') }}" class="btn-press gold-btn-shimmer px-7 py-3.5 rounded-xl text-xs uppercase tracking-wider shrink-0 shadow-lg flex items-center gap-2">
                    <span>📅</span>
                    <span>Đặt Lịch Khám Ngay</span>
                </a>
            </div>

        </div>
    </section>
</div>
@endsection
