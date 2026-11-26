@extends('layouts.public')

@section('title', 'Về Nha Khoa Smile - Hệ Thống Chăm Sóc Răng Miệng Chuẩn Y Khoa')

@section('content')
<!-- Hero Giới Thiệu -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Câu Chuyện Thương Hiệu & Triết Lý Y Đức</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Về <span class="italic font-normal text-[#E6D5B8]">Nha Khoa Smile</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Hơn 10 năm đồng hành chăm sóc sức khỏe nụ cười cho hơn 10.000 khách hàng. Nơi y đức chuẩn mực hòa quyện cùng công nghệ số hóa tiên tiến DCMS.
        </p>
    </div>
</section>

<!-- Câu chuyện & Tầm nhìn -->
<section class="py-12 sm:py-16 bg-[#FBF9F5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 relative">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-[#EAE5DD]">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=85" alt="Không gian Nha Khoa Smile" class="w-full h-[380px] sm:h-[420px] object-cover">
                </div>
                <div class="hidden sm:flex items-center gap-4 bg-white p-5 rounded-2xl shadow-md border border-[#EAE5DD] absolute -bottom-5 -right-4">
                    <div class="w-12 h-12 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-xl border border-[#C5A880]/40">
                        10+
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-xs">Năm Kiến Tạo Nụ Cười</p>
                        <p class="text-[11px] text-slate-500 font-light">Tiêu chuẩn Y tế & Quốc tế</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Tâm Đức Y Khoa</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] leading-snug">
                    Bảo Tồn Răng Thật & Nụ Cười Hoàn Mỹ Tự Nhiên
                </h2>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Tại Nha Khoa Smile, chúng tôi tin rằng một hàm răng đẹp bền vững phải bắt nguồn từ nền tảng sinh học khỏe mạnh, khớp cắn chuẩn xác và bảo tồn tối đa răng thật nguyên bản.
                </p>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Mọi ca khám và điều trị tại Nha Khoa Smile đều được theo dõi chặt chẽ trên hệ thống bệnh án điện tử DCMS, sơ đồ 32 răng trực quan, cùng quy trình kiểm soát nhiễm khuẩn khắt khe theo quy chuẩn Bộ Y Tế.
                </p>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <div class="p-3.5 rounded-2xl bg-white border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-lg font-bold text-[#063B30]">100%</div>
                        <div class="text-[11px] text-slate-500 font-light mt-0.5">Vật liệu & Thuốc chính hãng</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-lg font-bold text-[#063B30]">1 Bác Sĩ : 1 Ghế</div>
                        <div class="text-[11px] text-slate-500 font-light mt-0.5">Thăm khám kỹ lưỡng, tận tâm</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Trụ Cột Vàng -->
        <div class="space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">3 Trụ Cột Cốt Lõi</span>
                <h3 class="font-serif-luxury text-2xl font-bold text-slate-900">Cam Kết Chất Lượng Điều Trị</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        🏥
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Không Gian Chuẩn Y Khoa</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Phòng khám khang trang, vô trùng tuyệt đối, sảnh tiếp đón tiện nghi và đội ngũ nhân viên chăm sóc tận tình.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        🔬
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Công Nghệ Kỹ Thuật Số DCMS</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Chụp phim 3D CT ConeBeam, quét mẫu hàm kỹ thuật số, hồ sơ bệnh án điện tử và thanh toán quét mã VietQR tự động.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        🛡️
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Bảo Hành Minh Bạch & Dài Lâu</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Cấp thẻ bảo hành chính hãng đối với răng sứ, trụ Implant và theo dõi chăm sóc răng miệng định kỳ hoàn toàn miễn phí.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
