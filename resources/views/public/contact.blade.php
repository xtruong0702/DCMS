@extends('layouts.public')

@section('title', 'Smile Atelier VIP Concierge & Liên Hệ')

@section('content')
<!-- Hero Liên Hệ -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>24/7 VIP Concierge Services</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Smile Atelier <span class="italic font-normal text-[#E6D5B8]">VIP Concierge</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Đội ngũ Concierge chuyên biệt hỗ trợ thượng khách sắp xếp xe đưa đón, chuẩn bị phòng khám riêng và giải đáp chi tiết về dịch vụ 24/7.
        </p>
    </div>
</section>

<section class="py-12 sm:py-16 bg-[#FBF9F5]" x-data="{ msgText: '{{ old('message', '') }}' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Cột thông tin liên hệ (5 cột) -->
            <div class="lg:col-span-5 space-y-5">
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#EAE5DD] shadow-xs space-y-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Kênh Tiếp Đón Thượng Khách</span>
                        <h2 class="font-serif-luxury text-xl font-bold text-slate-900 mt-0.5">Smile Atelier Boutique</h2>
                        <p class="text-xs text-slate-500 font-light mt-0.5">Không gian nha khoa 5 sao tiêu chuẩn quốc tế.</p>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center shrink-0 text-sm">
                                📍
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-slate-400">Địa chỉ Boutique Lounge</div>
                                <div class="font-bold text-slate-900 mt-0.5">123 Đường Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 font-light">Chỗ đỗ xe ô tô riêng cho thượng khách</div>
                            </div>
                        </div>

                        <a href="tel:19006868" class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] hover:border-[#063B30] transition flex items-start gap-3.5 group">
                            <div class="w-9 h-9 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center shrink-0 text-sm">
                                📞
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-slate-400">Hotline Thượng Khách 24/7</div>
                                <div class="font-serif-luxury text-base font-bold text-[#063B30] group-hover:underline mt-0.5">1900 6868</div>
                                <div class="text-[11px] text-slate-500 font-light mt-0.5">Tư vấn trực tiếp cùng Concierge</div>
                            </div>
                        </a>

                        <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center shrink-0 text-sm">
                                ⏰
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-slate-400">Thời gian tiếp đón</div>
                                <div class="font-bold text-slate-900 mt-0.5">08:00 – 20:00 (Thứ 2 – Chủ Nhật)</div>
                                <div class="text-[11px] text-slate-500 font-light mt-0.5">Hỗ trợ ngoài giờ theo lịch hẹn trước</div>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center shrink-0 text-sm">
                                🚗
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-slate-400">Đặc quyền xe riêng</div>
                                <div class="font-bold text-slate-900 mt-0.5">Xe đưa đón nội thành miễn phí</div>
                                <div class="text-[11px] text-slate-500 font-light mt-0.5">Áp dụng cho ca phẫu thuật Implant & Dán sứ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form gửi yêu cầu tư vấn VIP (7 cột) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#EAE5DD] shadow-xs space-y-5">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Tư Vấn Riêng Tư</span>
                    <h3 class="font-serif-luxury text-xl font-bold text-slate-900 mt-0.5">Gửi Yêu Cầu Đến Ban Giám Đốc Chuyên Môn</h3>
                    <p class="text-xs text-slate-500 font-light mt-0.5">Thông tin của quý khách được bảo mật tuyệt đối 100%.</p>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('public.contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Quý danh <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                placeholder="Họ và tên quý khách..."
                                class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Số điện thoại <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                placeholder="Số điện thoại của quý khách..."
                                class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Địa chỉ Email (Tùy chọn)
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Địa chỉ email để nhận phác đồ điều trị..."
                            class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nội dung cần hỗ trợ hoặc tình trạng răng miệng <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="message" rows="4" required
                            placeholder="Mô tả mong muốn cải thiện nụ cười, tình trạng răng hiện tại hoặc câu hỏi dành cho Bác sĩ..."
                            class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium resize-none">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs uppercase tracking-wider shadow-sm transition flex items-center justify-center gap-2 border border-[#C5A880]/30">
                        <span>Gửi Yêu Cầu Đến Concierge</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
