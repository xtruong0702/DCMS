@extends('layouts.public')

@section('title', 'Smile Atelier - Tác Phẩm Nụ Cười • Nét Đẹp Vượt Thời Gian')

@section('content')
<div class="space-y-16 lg:space-y-24 pb-16">

    <!-- 1. HERO SECTION (100% MATCHING REFERENCE DESIGN) -->
    <section class="pt-6 sm:pt-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">
            
            <!-- Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#EBF4F0] border border-[#D1E6DE] text-[#063B30] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
                <span class="text-[#A37F4E]">✦</span>
                <span>Tiêu Chuẩn Nha Khoa Thẩm Mỹ Hoàng Gia</span>
            </div>

            <!-- Main Title & Subtitle -->
            <div class="space-y-3">
                <h1 class="font-serif-luxury text-3xl sm:text-5xl lg:text-6xl font-bold text-[#1A2421] leading-[1.15] tracking-tight">
                    Tác Phẩm Nụ Cười • <br class="hidden sm:inline">
                    <span class="italic font-normal text-[#063B30]">Nét Đẹp Vượt Thời Gian</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl font-light">
                    Không gian nha khoa mang phong cách boutique 5 sao. Nơi quyền uy hội tụ cùng bàn tay nghệ nhân và công nghệ nụ cười chuẩn tỷ lệ vàng.
                </p>
            </div>

            <!-- Social Proof Pill -->
            <div class="inline-flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-[#EAE5DD] shadow-2xs">
                <div class="w-8 h-8 rounded-xl bg-[#FDF8EE] text-[#A37F4E] flex items-center justify-center font-bold text-xs border border-[#E9DCBF]">
                    ★
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>4.99</span>
                        <span class="text-[#A37F4E] tracking-tighter">★★★★★</span>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">Hơn 12.000 khách hàng thượng lưu tin chọn</div>
                </div>
            </div>

            <!-- Hero Showcase Image -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg border border-[#EAE5DD]">
                <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=1200" alt="Smile Atelier Boutique Lounge" class="w-full h-[280px] sm:h-[420px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#063B30]/85 via-black/20 to-transparent"></div>
                <div class="absolute bottom-5 left-5 right-5 text-white">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-black/40 backdrop-blur-md text-[10px] font-medium text-[#E6D5B8] mb-1 border border-white/10">
                        <span>🏛️</span>
                        <span>Kiến trúc boutique sang trọng giữa lòng thành phố</span>
                    </div>
                    <p class="font-serif-luxury text-lg sm:text-2xl font-bold tracking-tight">Absolute Smile - Nét Nghệ Thuật</p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-2.5 pt-1">
                <a href="{{ route('public.booking') }}" class="w-full py-3.5 px-6 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold rounded-2xl shadow-sm transition flex items-center justify-center gap-2 border border-[#C5A880]/30 text-sm">
                    <svg class="w-4 h-4 text-[#E6D5B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Đặt Lịch Hẹn Khám Ưu Tiên</span>
                </a>
                <a href="tel:19006868" class="w-full py-3 px-6 bg-white hover:bg-[#FDFBF7] text-[#063B30] font-bold rounded-2xl border border-[#C5A880]/50 transition flex items-center justify-center gap-2 text-xs shadow-2xs">
                    <svg class="w-4 h-4 text-[#A37F4E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>Tư Vấn Trực Tiếp 1:1 Với Nghệ Nhân</span>
                </a>
            </div>

            <!-- VIP Highlights Card (Special Features & Stats Grid) -->
            <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-bold text-sm shadow-xs border border-[#C5A880]/40">
                        👑
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#A37F4E]">Đặc Quyền Thượng Lưu</div>
                        <div class="text-xs font-bold text-slate-900">Private Lounge & Trà Đón Tiếp 1:1</div>
                    </div>
                </div>

                <!-- 4 Metrics Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3.5 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-2xl font-bold text-[#063B30]">15+</div>
                        <div class="text-[11px] text-slate-500 font-medium mt-0.5">Năm kiến tạo nụ cười</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-2xl font-bold text-[#063B30]">12,000+</div>
                        <div class="text-[11px] text-slate-500 font-medium mt-0.5">Nụ cười hoàng gia</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-2xl font-bold text-[#063B30]">100%</div>
                        <div class="text-[11px] text-slate-500 font-medium mt-0.5">Vật liệu Thụy Sĩ</div>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-serif-luxury text-2xl font-bold text-[#063B30]">Trọn Đời</div>
                        <div class="text-[11px] text-slate-500 font-medium mt-0.5">Bảo hành tuyệt đối</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SECTION: BỘ SƯU TẬP DỊCH VỤ MŨI NHỌN (SIGNATURE COLLECTION) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">
        <div class="flex items-end justify-between border-b border-[#EAE5DD] pb-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Signature Collection</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] mt-1">Bộ Sưu Tập Dịch Vụ Mũi Nhọn</h2>
                <p class="text-xs text-slate-500 mt-1">Tuyển chọn các dịch vụ kỹ thuật đỉnh cao bởi các chuyên gia nghệ nhân hàng đầu.</p>
            </div>
            <a href="{{ route('public.services') }}" class="text-xs font-bold text-[#063B30] hover:underline flex items-center gap-1 shrink-0">
                <span>Xem tất cả</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="space-y-4">
            <!-- Service 1: Dán Sứ Veneer Emax -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#EAE5DD] shadow-xs space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nghệ thuật thẩm mỹ nụ cười</div>
                        <h3 class="font-serif-luxury text-lg sm:text-xl font-bold text-slate-900 mt-0.5">Dán Sứ Veneer Emax Siêu Mỏng</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FDF8EE] text-[#9A7B4F] border border-[#E9DCBF] shrink-0">
                        Bán chạy nhất (30%)
                    </span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Khôi phục men răng, form răng tự nhiên, không mài nhỏ, bảo tồn răng gốc 100%, bảo hành trọn đời.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-[11px] text-slate-400">Giá ưu đãi trọn gói:</span>
                        <div class="font-serif-luxury text-xl font-bold text-[#063B30]">104.500.000 đ <span class="text-xs font-sans-luxury text-slate-400 font-normal">/ 16 răng</span></div>
                    </div>
                    <a href="{{ route('public.booking', ['service' => 'veneer']) }}" class="py-2.5 px-5 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs rounded-xl shadow-xs transition text-center">
                        Trải Nghiệm Ngay
                    </a>
                </div>
            </div>

            <!-- Service 2: Cấy Ghép Implant Straumann -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#EAE5DD] shadow-xs space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Phục hình mất răng vĩnh viễn</div>
                        <h3 class="font-serif-luxury text-lg sm:text-xl font-bold text-slate-900 mt-0.5">Cấy Ghép Implant Straumann</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#EBF4F0] text-[#063B30] border border-[#D1E6DE] shrink-0">
                        Thụy Sĩ
                    </span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Trụ kim cương sinh học số 1 thế giới, tích hợp xương tức thì chỉ sau 3-4 tuần, bảo hành toàn cầu.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-[11px] text-slate-400">Giá trọn gói niêm yết:</span>
                        <div class="font-serif-luxury text-xl font-bold text-[#063B30]">32.180.000 đ <span class="text-xs font-sans-luxury text-slate-400 font-normal">/ 1 trụ</span></div>
                    </div>
                    <a href="{{ route('public.booking', ['service' => 'implant']) }}" class="py-2.5 px-5 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs rounded-xl shadow-xs transition text-center">
                        Trải Nghiệm Ngay
                    </a>
                </div>
            </div>

            <!-- Service 3: Tẩy Trắng Laser Whitening -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#EAE5DD] shadow-xs space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ánh sáng lạnh an toàn</div>
                        <h3 class="font-serif-luxury text-lg sm:text-xl font-bold text-slate-900 mt-0.5">Tẩy Trắng Răng Laser Whitening</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FFFBEB] text-[#B45309] border border-[#FDE68A] shrink-0">
                        Ưu đãi 40%
                    </span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Bước sóng ánh sáng lạnh hoạt hóa gel nano sinh học, bật 3-5 tone không ê buốt, giữ màu trắng sáng 2-3 năm.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-[11px] text-slate-400">Giá ưu đãi đặc biệt:</span>
                        <div class="font-serif-luxury text-xl font-bold text-[#063B30]">2.000.000 đ <span class="text-xs font-sans-luxury text-slate-400 font-normal">/ liệu trình</span></div>
                    </div>
                    <a href="{{ route('public.booking', ['service' => 'whitening']) }}" class="py-2.5 px-5 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs rounded-xl shadow-xs transition text-center">
                        Trải Nghiệm Ngay
                    </a>
                </div>
            </div>

            <!-- Service 4: Niềng Răng Invisalign Diamond -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#EAE5DD] shadow-xs space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Chỉnh nha vô hình Hoa Kỳ</div>
                        <h3 class="font-serif-luxury text-lg sm:text-xl font-bold text-slate-900 mt-0.5">Niềng Răng Invisalign Diamond</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#EBF4F0] text-[#063B30] border border-[#D1E6DE] shrink-0">
                        Đặc quyền mùa cưới
                    </span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-light">
                    Khay niềng trong suốt SmartTrack chính hãng Hoa Kỳ, xem trước nụ cười tương lai bằng phần mềm ClinCheck 3D.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-[11px] text-slate-400">Trọn gói điều trị:</span>
                        <div class="font-serif-luxury text-xl font-bold text-[#063B30]">104.000.000 đ <span class="text-xs font-sans-luxury text-slate-400 font-normal">/ trọn gói</span></div>
                    </div>
                    <a href="{{ route('public.booking', ['service' => 'invisalign']) }}" class="py-2.5 px-5 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs rounded-xl shadow-xs transition text-center">
                        Trải Nghiệm Ngay
                    </a>
                </div>
            </div>

            <!-- 2 Mini Quick Services -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                <div class="bg-white rounded-2xl p-4 border border-[#EAE5DD] flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-400">Sóng Siêu Âm 0 Đau</div>
                        <div class="text-xs font-bold text-slate-900 mt-0.5">Nhổ Răng Khôn Piezotome</div>
                        <div class="font-serif-luxury font-bold text-sm text-[#063B30] mt-1">990.000 đ</div>
                    </div>
                    <a href="{{ route('public.booking') }}" class="px-3 py-1.5 bg-[#EBF4F0] hover:bg-[#063B30] text-[#063B30] hover:text-white rounded-xl text-xs font-bold transition">
                        Đặt Lịch
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-4 border border-[#EAE5DD] flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-400">Chuẩn Đoán Đa Tầng</div>
                        <div class="text-xs font-bold text-slate-900 mt-0.5">Khám 3D Chuyên Sâu</div>
                        <div class="font-serif-luxury font-bold text-sm text-[#063B30] mt-1">350.000 đ</div>
                    </div>
                    <a href="{{ route('public.booking') }}" class="px-3 py-1.5 bg-[#EBF4F0] hover:bg-[#063B30] text-[#063B30] hover:text-white rounded-xl text-xs font-bold transition">
                        Đặt Lịch
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SECTION: HÀNH TRÌNH 4 BƯỚC THƯ THÁI (LUXURY EXPERIENCE) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">
        <div class="border-b border-[#EAE5DD] pb-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Luxury Experience</span>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] mt-1">Hành Trình 4 Bước Thư Thái</h2>
            <p class="text-xs text-slate-500 mt-1">Tại Smile Atelier, mỗi ca điều trị là một hành trình tĩnh tâm, giải tỏa âu lo và nâng niu trọn vẹn.</p>
        </div>

        <div class="space-y-3.5">
            <!-- Step 1 -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#EAE5DD] flex items-start gap-4">
                <div class="w-8 h-8 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-sm shrink-0">
                    1
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-xs sm:text-sm text-slate-900">Thưởng Trà & Khảo Sát Nụ Cười (1-1)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-light">
                        Trò chuyện cùng Bác sĩ tại phòng chờ riêng biệt. Thưởng thức trà thảo mộc thượng hạng và lắng nghe tư vấn tỉ lệ nụ cười.
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#EAE5DD] flex items-start gap-4">
                <div class="w-8 h-8 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-sm shrink-0">
                    2
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-xs sm:text-sm text-slate-900">Quét 3D CT ConeBeam & Thiết Kế Nụ Cười</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-light">
                        Ghi nhận cấu trúc xương hàm và mô mềm đa tầng, mô phỏng nụ cười chuẩn tỷ lệ vàng hài hòa nhân tướng học.
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#EAE5DD] flex items-start gap-4">
                <div class="w-8 h-8 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-sm shrink-0">
                    3
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-xs sm:text-sm text-slate-900">Trị Liệu Êm Ái Với Âm Nhạc Sóng Não</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-light">
                        Phòng vô trùng áp lực dương tuyệt đối. Thư giãn cùng tai nghe chống ồn khử căng thẳng và liệu pháp ánh sáng dịu nhẹ.
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#EAE5DD] flex items-start gap-4">
                <div class="w-8 h-8 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-serif-luxury font-bold text-sm shrink-0">
                    4
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-xs sm:text-sm text-slate-900">Hậu Mãi Thượng Hạng & Trà VIP Club</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-light">
                        Nghỉ dưỡng sau trị liệu tại sảnh VIP lounge, trao thẻ bảo hành điện tử chính hãng toàn cầu và xe riêng đưa về tận nơi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SECTION: HỘI ĐỒNG BÁC SĨ NGHỆ NHÂN (MASTER DOCTORS) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">
        <div class="border-b border-[#EAE5DD] pb-4">
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Master Doctors</span>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] mt-1">Hội Đồng Bác Sĩ Nghệ Nhân</h2>
            <p class="text-xs text-slate-500 mt-1">Đội ngũ chuyên gia tu nghiệp Harvard & Geneva, hơn 15 năm kinh nghiệm kiến tạo nụ cười hoàn mỹ.</p>
        </div>

        <div class="space-y-6">
            <!-- Doctor 1: TS. BS. Lê Hoàng Nam -->
            <div class="bg-white rounded-3xl overflow-hidden border border-[#EAE5DD] shadow-xs">
                <div class="relative h-64 sm:h-80 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=85" alt="TS. BS. Lê Hoàng Nam" class="w-full h-full object-cover object-top">
                    <div class="absolute bottom-3 left-3 bg-[#063B30]/90 backdrop-blur-md px-3 py-1 rounded-xl text-[10px] font-bold text-[#E6D5B8] uppercase tracking-wider border border-[#C5A880]/30">
                        Nha Khoa Thẩm Mỹ & Phẫu Thuật
                    </div>
                </div>
                <div class="p-5 sm:p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#A37F4E]">Chuyên Gia Chuyên Khoa</span>
                        <span class="text-xs text-slate-400 font-medium">18+ Năm Kinh Nghiệm</span>
                    </div>
                    <div>
                        <h3 class="font-serif-luxury text-xl font-bold text-slate-900">TS. BS. Lê Hoàng Nam</h3>
                        <p class="text-xs text-slate-600 mt-1 font-light leading-relaxed">
                            Chuyên gia phẫu thuật Implant & phục hình răng sứ thẩm mỹ. Cựu giảng viên ĐH Y Dược, tu nghiệp Implant chuyên sâu tại Harvard & Geneva. Hơn 3.000 ca thành công.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Trực tiếp điều trị tại Private Lounge</span>
                        </div>
                        <a href="{{ route('public.booking', ['doctor' => 'nam']) }}" class="text-xs font-bold text-[#063B30] hover:underline">
                            Đặt lịch khám riêng &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Doctor 2: ThS. BS. Mai Phương Uyên -->
            <div class="bg-white rounded-3xl overflow-hidden border border-[#EAE5DD] shadow-xs">
                <div class="relative h-64 sm:h-80 overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=800&q=85" alt="ThS. BS. Mai Phương Uyên" class="w-full h-full object-cover object-top">
                    <div class="absolute bottom-3 left-3 bg-[#063B30]/90 backdrop-blur-md px-3 py-1 rounded-xl text-[10px] font-bold text-[#E6D5B8] uppercase tracking-wider border border-[#C5A880]/30">
                        Invisalign Diamond Provider
                    </div>
                </div>
                <div class="p-5 sm:p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#A37F4E]">Trưởng Khoa Chỉnh Nha</span>
                        <span class="text-xs text-slate-400 font-medium">12+ Năm Kinh Nghiệm</span>
                    </div>
                    <div>
                        <h3 class="font-serif-luxury text-xl font-bold text-slate-900">ThS. BS. Mai Phương Uyên</h3>
                        <p class="text-xs text-slate-600 mt-1 font-light leading-relaxed">
                            Bác sĩ chuyên gia nẹp vô hình Invisalign Diamond. Đào tạo chỉnh nha chuyên sâu tại Pháp, sở hữu chứng chỉ thẩm mỹ nụ cười chuẩn nhân trắc học.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Trực tiếp điều trị tại Private Lounge</span>
                        </div>
                        <a href="{{ route('public.booking', ['doctor' => 'uyen']) }}" class="text-xs font-bold text-[#063B30] hover:underline">
                            Đặt lịch khám riêng &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SECTION: CẢM NHẬN TỪ TRÁI TIM (CLIENT TESTIMONIALS - DEEP EMERALD) -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-[#063B30] text-white rounded-3xl p-6 sm:p-10 border border-[#C5A880]/30 shadow-xl space-y-6">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#E6D5B8]">Client Testimonials</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mt-1">Cảm Nhận Từ Trái Tim</h2>
            </div>

            <div class="space-y-6">
                <!-- Testimonial 1 -->
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                    <p class="font-serif-luxury text-sm sm:text-base italic text-slate-100 leading-relaxed font-light">
                        "Không gian nha khoa mang phong cách boutique 5 sao tuyệt mỹ. Bác sĩ Nam điều trị răng sứ mà tôi hoàn toàn không hề có cảm giác ê buốt hay căng thẳng nào. Nụ cười mới tự nhiên giúp tôi tự tin tuyệt đối trên thương trường."
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <div class="w-10 h-10 rounded-full bg-[#E6D5B8] text-[#063B30] font-bold flex items-center justify-center text-xs">
                            TH
                        </div>
                        <div>
                            <div class="font-bold text-xs text-white">Bà Trần Thu Hằng</div>
                            <div class="text-[10px] text-slate-300">Á Hậu Doanh Nhân • Chủ Tịch Tập Đoàn Thời Trang</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                    <p class="font-serif-luxury text-sm sm:text-base italic text-slate-100 leading-relaxed font-light">
                        "Cấy 2 trụ Implant Straumann chỉ mất 25 phút trong không gian êm ái như spa. Thưởng thức tách trà thảo mộc tại Private Lounge sau khi hoàn thành là một trải nghiệm thực sự đẳng cấp."
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <div class="w-10 h-10 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-xs border border-white/20">
                            VT
                        </div>
                        <div>
                            <div class="font-bold text-xs text-white">Ông Vũ Doãn Thành</div>
                            <div class="text-[10px] text-slate-300">Nhà Sáng Lập Chuỗi Nhà Hàng Cao Cấp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. SECTION: SMILE ATELIER VIP CONCIERGE -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#EAE5DD] shadow-xs text-center space-y-5">
            <div class="w-10 h-1 bg-[#A37F4E] mx-auto rounded-full"></div>
            <div class="space-y-1">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Đặc Quyền Dành Riêng Cho Thượng Khách</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421]">Smile Atelier VIP Concierge</h2>
                <p class="text-xs text-slate-500 max-w-lg mx-auto font-light leading-relaxed">
                    Hỗ trợ đặt xe riêng đưa đón tận nơi, chuẩn bị trà đón tiếp theo sở thích và sắp xếp phòng khám VIP riêng tư hoàn toàn.
                </p>
            </div>

            <!-- Hotline Box -->
            <a href="tel:19006868" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] hover:border-[#063B30] transition group shadow-2xs">
                <div class="w-8 h-8 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-bold text-xs">
                    📞
                </div>
                <div class="text-left">
                    <div class="text-[10px] uppercase font-bold text-slate-400">Hotline Thượng Khách 24/7</div>
                    <div class="font-serif-luxury text-xl font-bold text-[#063B30] group-hover:underline">1900 6868</div>
                </div>
            </a>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                <a href="{{ route('public.contact') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center justify-center gap-1.5">
                    <span>🗺️</span>
                    <span>Chỉ Đường Đi</span>
                </a>
                <a href="{{ route('public.booking') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#063B30] text-[#FDFBF7] text-xs font-bold hover:bg-[#042A22] transition flex items-center justify-center gap-1.5 shadow-sm">
                    <span>👑</span>
                    <span>Đặt Phòng VIP Riêng</span>
                </a>
            </div>

            <div class="text-[11px] text-slate-400 pt-2 flex items-center justify-center gap-1.5">
                <span>📍</span>
                <span>123 Nguyễn Văn Cừ, Quận 5, TP.HCM • Chỗ đỗ xe ô tô riêng cho thượng khách</span>
            </div>
        </div>
    </section>

</div>
@endsection
