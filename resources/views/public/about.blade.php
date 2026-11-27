@extends('layouts.public')

@section('title', 'Về Nha Khoa Smile - Phòng Khám Răng Hàm Mặt Chuẩn Y Khoa')

@section('content')
<!-- Hero Giới Thiệu -->
<section class="relative overflow-hidden bg-gradient-to-b from-teal-50/80 via-white to-slate-50 py-14 sm:py-16 border-b border-slate-200/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-teal-500/15 text-teal-800 text-xs font-semibold shadow-sm">
            <span class="pulse-dot pulse-dot-emerald"></span>
            <span>Triết Lý Điều Trị & Y Đức</span>
        </div>
        <h1 class="font-heading-clinic !text-3xl sm:!text-4xl font-extrabold tracking-tight text-slate-900">
            Về <span class="text-clinic-gradient">Nha Khoa Smile</span>
        </h1>
        <p class="text-slate-600 text-sm max-w-xl mx-auto leading-relaxed">
            Hơn 15 năm đồng hành chăm sóc sức khỏe răng miệng cho hơn 50.000 lượt bệnh nhân. Kết hợp y đức chuẩn mực cùng công nghệ nha khoa kỹ thuật số DCMS.
        </p>
    </div>
</section>

<!-- Câu chuyện & Tầm nhìn -->
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 relative">
                <div class="rounded-3xl overflow-hidden shadow-xl ring-1 ring-slate-900/5 img-zoom-container bg-white">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=85" alt="Không gian Nha Khoa Smile" class="w-full h-[360px] sm:h-[400px] object-cover">
                </div>
                <div class="hidden sm:flex items-center gap-4 bg-white p-4 rounded-2xl shadow-xl border border-slate-200/40 absolute -bottom-5 -right-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-600 text-white flex items-center justify-center font-heading-clinic font-extrabold text-lg tabular-nums">
                        15+
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-xs">Năm Chăm Sóc Nụ Cười</p>
                        <p class="text-[11px] text-slate-500">Tiêu chuẩn Bộ Y Tế & Quốc tế</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-4">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-500/10">Tâm Đức Y Khoa</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-slate-900 leading-snug">
                    Bảo Tồn Răng Thật & Điều Trị Chuẩn Xác
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Tại Nha Khoa Smile, chúng tôi tin rằng một hàm răng khỏe đẹp bền vững phải bắt nguồn từ nền tảng sinh học chắc khỏe, khớp cắn chuẩn xác và ưu tiên bảo tồn tối đa răng thật nguyên bản.
                </p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Mọi ca khám và điều trị đều được theo dõi chặt chẽ trên hệ thống bệnh án điện tử DCMS với sơ đồ 32 răng chuẩn FDI, cùng quy trình kiểm soát nhiễm khuẩn khắt khe theo quy chuẩn Bộ Y Tế.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/40 shadow-sm">
                        <div class="font-heading-clinic text-xl font-extrabold text-teal-700 tabular-nums">100%</div>
                        <div class="text-xs text-slate-600 mt-0.5">Vật liệu & Thuốc chính hãng</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/40 shadow-sm">
                        <div class="font-heading-clinic text-xl font-extrabold text-teal-700">1 BS : 1 Ghế</div>
                        <div class="text-xs text-slate-600 mt-0.5">Thăm khám kỹ lưỡng, vô trùng</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Trụ Cột Cốt Lõi -->
        <div class="space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-500/10">3 Trụ Cột Cốt Lõi</span>
                <h3 class="font-heading-clinic !text-2xl font-bold text-slate-900 pt-1">Cam Kết Chất Lượng Điều Trị</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="clinic-card rounded-2xl p-6 space-y-3">
                    <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl border border-teal-500/10">🏥</div>
                    <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Phòng Khám Vô Trùng 1 Chiều</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Không gian khang trang, sạch sẽ, tiệt trùng dụng cụ bằng nồi hấp Class B chuẩn châu Âu giúp loại bỏ hoàn toàn nguy cơ lây nhiễm chéo.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-6 space-y-3">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-xl border border-sky-500/10">🔬</div>
                    <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Công Nghệ Kỹ Thuật Số DCMS</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Chụp phim 3D CT ConeBeam, quét mẫu hàm kỹ thuật số, lưu trữ bệnh án điện tử và thanh toán mã VietQR tự động minh bạch.
                    </p>
                </div>

                <div class="clinic-card rounded-2xl p-6 space-y-3">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl border border-emerald-500/10">🛡️</div>
                    <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Bảo Hành Minh Bạch & Dài Lâu</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Cấp thẻ bảo hành chính hãng đối với răng sứ, trụ Implant và theo dõi lịch tái khám chăm sóc răng miệng định kỳ miễn phí.
                    </p>
                </div>
            </div>
        </div>

        <!-- Hệ Thống Công Nghệ & Thiết Bị Chuẩn Châu Âu -->
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto space-y-1.5">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-500/10">Trang Thiết Bị Hiện Đại</span>
                <h3 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-slate-900 pt-1">Hệ Thống Công Nghệ Chẩn Đoán 3D</h3>
                <p class="text-xs sm:text-sm text-slate-600">Đầu tư đồng bộ 100% máy móc nhập khẩu từ Đức, Thụy Sĩ và Hoa Kỳ giúp chẩn đoán chính xác từng micromet.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="clinic-card rounded-2xl p-5 space-y-2.5">
                    <div class="icon-pop w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg">🩻</div>
                    <h4 class="font-heading-clinic !text-sm font-bold text-slate-900">CT ConeBeam 3D</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Tái tạo cấu trúc xương hàm, dây thần kinh 3 chiều rõ nét với liều tia thấp an toàn tuyệt đối.</p>
                </div>
                <div class="clinic-card rounded-2xl p-5 space-y-2.5">
                    <div class="icon-pop w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-lg">🖥️</div>
                    <h4 class="font-heading-clinic !text-sm font-bold text-slate-900">Scan Răng iTero 5D</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Lấy dấu răng kỹ thuật số chỉ trong 60 giây, xem trước kết quả nụ cười mà không gây khó chịu.</p>
                </div>
                <div class="clinic-card rounded-2xl p-5 space-y-2.5">
                    <div class="icon-pop w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg">🫧</div>
                    <h4 class="font-heading-clinic !text-sm font-bold text-slate-900">Autoclave Class B</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Tiệt trùng dụng cụ khép kín tiêu chuẩn bệnh viện Châu Âu, mỗi bệnh nhân 1 bộ tay khoan riêng.</p>
                </div>
                <div class="clinic-card rounded-2xl p-5 space-y-2.5">
                    <div class="icon-pop w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg">⚡</div>
                    <h4 class="font-heading-clinic !text-sm font-bold text-slate-900">Siêu Âm Piezotome</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Công nghệ rung siêu âm chọn lọc giúp nhổ răng khôn không chạm mô mềm, không sưng đau.</p>
                </div>
            </div>
        </div>

        <!-- Hành Trình Phát Triển -->
        <div class="clinic-card rounded-3xl p-6 sm:p-8 space-y-6">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Chặng Đường Tự Hào</span>
                <h3 class="font-heading-clinic !text-2xl font-bold text-slate-900">Hành Trình Kiến Tạo Nụ Cười Việt</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                    <div class="font-heading-clinic text-xl font-bold text-teal-700 tabular-nums">2010</div>
                    <div class="text-xs font-bold text-slate-900">Thành Lập Phòng Khám</div>
                    <p class="text-xs text-slate-600 leading-relaxed">Khởi đầu với đội ngũ bác sĩ tốt nghiệp ĐH Y Hà Nội cùng 4 ghế nha khoa tiêu chuẩn.</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                    <div class="font-heading-clinic text-xl font-bold text-teal-700 tabular-nums">2016</div>
                    <div class="text-xs font-bold text-slate-900">Chuyển Giao Công Nghệ Thụy Sĩ</div>
                    <p class="text-xs text-slate-600 leading-relaxed">Trở thành đối tác chiến lược cấy ghép Implant Straumann và sứ thẩm mỹ Emax Đức.</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                    <div class="font-heading-clinic text-xl font-bold text-teal-700 tabular-nums">2021</div>
                    <div class="text-xs font-bold text-slate-900">Số Hóa Toàn Diện DCMS</div>
                    <p class="text-xs text-slate-600 leading-relaxed">Triển khai bệnh án điện tử, sơ đồ 32 răng FDI và tra cứu hóa đơn VietQR tự động.</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                    <div class="font-heading-clinic text-xl font-bold text-teal-700 tabular-nums">Hiện Tại</div>
                    <div class="text-xs font-bold text-slate-900">15.000+ Nụ Cười Hoàn Mỹ</div>
                    <p class="text-xs text-slate-600 leading-relaxed">Không gian Dental Spa 5 sao tại 204 Trần Duy Hưng, Cầu Giấy, Hà Nội.</p>
                </div>
            </div>
        </div>

        <!-- CTA Cuối Trang Giới Thiệu -->
        <div class="reviews-showcase-card bg-[#0f3e36] text-white rounded-3xl p-7 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-1.5 text-center md:text-left">
                <h3 class="font-heading-clinic !text-2xl font-bold !text-white">Trải Nghiệm Thăm Khám Chuẩn 5 Sao Ngay Hôm Nay</h3>
                <p class="text-xs sm:text-sm text-[#d9ebe7]">Đặt lịch trước để được tư vấn 1:1 cùng Bác sĩ Chuyên khoa và chụp phim chẩn đoán chi tiết.</p>
            </div>
            <a href="{{ route('public.booking') }}" class="btn-press gold-btn-shimmer px-6 py-3 rounded-xl text-xs sm:text-sm shrink-0 shadow-lg">
                📅 Đặt Lịch Khám Ngay
            </a>
        </div>
    </div>
</section>
@endsection
