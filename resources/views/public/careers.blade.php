@extends('layouts.public')

@section('title', 'Cơ Hội Nghề Nghiệp Tại Smile Atelier')

@section('content')
<!-- Hero Tuyển Dụng -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Gia Nhập Smile Atelier Talent</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Cơ Hội Nghề Nghiệp & <span class="italic font-normal text-[#E6D5B8]">Phát Triển Đỉnh Cao</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Môi trường làm việc phong cách boutique 5 sao chuẩn quốc tế, trang thiết bị Thụy Sĩ tối tân cùng chế độ đãi ngộ và lộ trình đào tạo chuyên môn liên tục.
        </p>
    </div>
</section>

<!-- Phúc lợi & Vị trí tuyển dụng -->
<section class="py-12 sm:py-16 bg-[#FBF9F5]" x-data="{ applyJob: null }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white p-6 rounded-3xl border border-[#EAE5DD] shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center font-bold text-lg">💰</div>
                <h3 class="font-serif-luxury text-base font-bold text-slate-900">Thu Nhập & Đãi Ngộ Thượng Hạng</h3>
                <p class="text-xs text-slate-500 font-light leading-relaxed">Lương cạnh tranh + hoa hồng ca điều trị rõ ràng + thưởng tháng 13 và chế độ du lịch quốc tế.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-[#EAE5DD] shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center font-bold text-lg">🎓</div>
                <h3 class="font-serif-luxury text-base font-bold text-slate-900">Tu Nghiệp & Đào Tạo CME</h3>
                <p class="text-xs text-slate-500 font-light leading-relaxed">Tài trợ 100% học phí tham gia các khóa tu nghiệp Implant Straumann Thụy Sĩ và Invisalign Diamond.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-[#EAE5DD] shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center font-bold text-lg">💎</div>
                <h3 class="font-serif-luxury text-base font-bold text-slate-900">Không Gian Làm Việc 5 Sao</h3>
                <p class="text-xs text-slate-500 font-light leading-relaxed">Private Lounge sang trọng, quy trình điều trị 1:1 thư thái, văn hóa tôn trọng và gắn kết.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#EAE5DD] shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Đang Mở Tuyển Dụng</span>
                    <h2 class="font-serif-luxury text-xl font-bold text-slate-900 mt-0.5">Các Vị Trí Đang Mở Đơn</h2>
                </div>
                <span class="px-3 py-1 rounded-full bg-[#EBF4F0] text-[#063B30] text-[11px] font-bold">
                    3 vị trí ưu tiên
                </span>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">Bác Sĩ Răng Hàm Mặt Chuyên Sâu Implant / Sứ</h4>
                        <p class="text-xs text-slate-500 font-light mt-0.5">Toàn thời gian • Kinh nghiệm từ 5 năm • Thu nhập: 40 - 80 triệu++</p>
                    </div>
                    <a href="mailto:talent@smileatelier.vn" class="px-4 py-2 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] rounded-xl text-xs font-bold transition text-center">
                        Nộp Hồ Sơ
                    </a>
                </div>

                <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">Điều Dưỡng Nha Khoa 5 Sao (Dental Nurse)</h4>
                        <p class="text-xs text-slate-500 font-light mt-0.5">Toàn thời gian • Tốt nghiệp Điều dưỡng • Thu nhập: 12 - 18 triệu</p>
                    </div>
                    <a href="mailto:talent@smileatelier.vn" class="px-4 py-2 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] rounded-xl text-xs font-bold transition text-center">
                        Nộp Hồ Sơ
                    </a>
                </div>

                <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">Chuyên Viên VIP Concierge & Tiếp Đón Thượng Khách</h4>
                        <p class="text-xs text-slate-500 font-light mt-0.5">Ngoại hình thanh lịch, tiếng Anh giao tiếp tốt • Thu nhập: 15 - 25 triệu</p>
                    </div>
                    <a href="mailto:talent@smileatelier.vn" class="px-4 py-2 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] rounded-xl text-xs font-bold transition text-center">
                        Nộp Hồ Sơ
                    </a>
                </div>
            </div>

            <div class="pt-2 text-center text-xs text-slate-400">
                Gửi CV và Portfolio lâm sàng trực tiếp về: <a href="mailto:talent@smileatelier.vn" class="font-bold text-[#063B30] hover:underline">talent@smileatelier.vn</a> hoặc Hotline Tuyển Dụng: <strong>1900 6868</strong>
            </div>
        </div>
    </div>
</section>
@endsection
