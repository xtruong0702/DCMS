@extends('layouts.public')

@section('title', 'Về Smile Atelier - Không Gian Nha Khoa Boutique 5 Sao')

@section('content')
<!-- Hero Giới Thiệu -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Câu Chuyện Thương Hiệu & Triết Lý</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Về <span class="italic font-normal text-[#E6D5B8]">Smile Atelier</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Hơn 15 năm kiến tạo nụ cười hoàng gia cho hơn 12.000 khách hàng thượng lưu. Nơi khoa học y khoa đỉnh cao hòa quyện cùng mỹ cảm nghệ thuật tinh tế.
        </p>
    </div>
</section>

<!-- Câu chuyện & Tầm nhìn -->
<section class="py-12 sm:py-16 bg-[#FBF9F5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 relative">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-[#EAE5DD]">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=85" alt="Không gian Smile Atelier" class="w-full h-[380px] sm:h-[420px] object-cover">
                </div>
                <div class="hidden sm:flex items-center gap-4 bg-white p-5 rounded-2xl shadow-md border border-[#EAE5DD] absolute -bottom-5 -right-4">
                    <div class="w-12 h-12 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-xl border border-[#C5A880]/40">
                        15+
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-xs">Năm Kiến Tạo Nụ Cười</p>
                        <p class="text-[11px] text-slate-500 font-light">Tiêu chuẩn Thụy Sĩ & Quốc Tế</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Triết Lý Nghệ Nhân</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] leading-snug">
                    Nơi Quyền Uy Hội Tụ Cùng Mỹ Cảm Tinh Tế
                </h2>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Tại Smile Atelier, chúng tôi tin rằng một hàm răng đẹp không chỉ là chuẩn khớp cắn sinh học, mà còn là một tác phẩm nghệ thuật độc bản tôn vinh phong thái, vị thế và nhân tướng của từng chủ nhân.
                </p>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Khác biệt với các phòng khám truyền thống, mọi trải nghiệm tại Smile Atelier đều diễn ra tại Private Lounge riêng tư với sự đồng hành của Bác sĩ Trưởng khoa, liệu pháp âm nhạc sóng não giảm căng thẳng và quy trình vô trùng áp lực dương tuyệt đối.
                </p>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <div class="p-3.5 rounded-2xl bg-white border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-lg font-bold text-[#063B30]">100%</div>
                        <div class="text-[11px] text-slate-500 font-light mt-0.5">Vật liệu chính hãng Thụy Sĩ</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-lg font-bold text-[#063B30]">Private 1:1</div>
                        <div class="text-[11px] text-slate-500 font-light mt-0.5">Phòng tiếp đón riêng tư</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Trụ Cột Vàng -->
        <div class="space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">3 Trụ Cột Đẳng Cấp</span>
                <h3 class="font-serif-luxury text-2xl font-bold text-slate-900">Cam Kết Chất Lượng Vượt Bậc</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        🏛️
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Không Gian Boutique 5 Sao</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Thiết kế nội thất phong cách châu Âu trang nhã, phòng VIP riêng biệt, sảnh đón tiếp thưởng trà và xe riêng đón tận nơi.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        🔬
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Công Nghệ Kỹ Thuật Số Đa Tầng</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Hệ thống CT ConeBeam 3D, máy quét khớp cắn iTero 5D, phần mềm ClinCheck mô phỏng nụ cười tương lai chuẩn nhân tướng.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-lg font-bold">
                        👑
                    </div>
                    <h4 class="font-serif-luxury text-base font-bold text-slate-900">Bảo Hành Toàn Cầu Trọn Đời</h4>
                    <p class="text-xs text-slate-500 font-light leading-relaxed">
                        Thẻ bảo hành điện tử chính hãng kích hoạt trên hệ thống quốc tế cho trụ Implant Straumann và răng sứ thẩm mỹ Emax.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
