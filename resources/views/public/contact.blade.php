@extends('layouts.public')

@section('title', 'Liên Hệ & Địa Chỉ Phòng Khám - ' . $clinicSettings['clinic_name'])

@section('content')
<!-- Hero Liên Hệ -->
<section class="relative overflow-hidden bg-gradient-to-b from-teal-50/80 via-white to-slate-50 py-14 sm:py-16 border-b border-slate-200/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-teal-500/15 text-teal-800 text-xs font-semibold shadow-sm">
            <span class="pulse-dot pulse-dot-emerald"></span>
            <span>Tiếp Nhận & Chăm Sóc Bệnh Nhân</span>
        </div>
        <h1 class="font-heading-clinic !text-3xl sm:!text-4xl font-extrabold tracking-tight text-slate-900">
            Liên Hệ <span class="text-clinic-gradient">{{ $clinicSettings['clinic_name'] }}</span>
        </h1>
        <p class="text-slate-600 text-sm max-w-xl mx-auto leading-relaxed">
            Đội ngũ Lễ tân và Bác sĩ tư vấn luôn sẵn sàng hỗ trợ giải đáp mọi thắc mắc về tình trạng răng miệng, bảng giá và lịch hẹn khám.
        </p>
    </div>
</section>

<section class="py-12 sm:py-16 bg-slate-50" x-data="{ msgText: '{{ old('message', '') }}' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Cột thông tin liên hệ (5 cột) -->
            <div class="lg:col-span-5 space-y-5">
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/40 shadow-sm space-y-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Thông Tin Phòng Khám</span>
                        <h2 class="font-heading-clinic !text-xl font-bold text-slate-900 mt-0.5">{{ $clinicSettings['clinic_name'] }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Không gian khám chữa bệnh chuẩn Y khoa hiện đại.</p>
                    </div>

                    <div class="space-y-3 text-xs">
                        <a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($clinicSettings['clinic_address']) }}" target="_blank" rel="noopener noreferrer" class="p-4 rounded-xl bg-slate-50 border border-slate-200/40 hover:border-teal-400 transition flex items-start gap-3.5 group">
                            <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 text-base border border-teal-500/10">📍</div>
                            <div>
                                <div class="text-[11px] uppercase font-semibold text-slate-500">Địa chỉ phòng khám</div>
                                <div class="font-bold text-slate-900 mt-0.5 group-hover:text-teal-700 transition">{{ $clinicSettings['clinic_address'] }}</div>
                                <div class="text-[11px] text-teal-700 font-semibold mt-1">🗺️ Xem chỉ đường trên Google Maps &rarr;</div>
                            </div>
                        </a>

                        <a href="tel:{{ $clinicHotlineTel }}" class="p-4 rounded-xl bg-teal-50/70 border border-teal-500/15 hover:border-teal-400 transition flex items-start gap-3.5 group">
                            <div class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0 text-base">📞</div>
                            <div>
                                <div class="text-[11px] uppercase font-semibold text-teal-700">Hotline Tư Vấn & Cấp Cứu 24/7</div>
                                <div class="font-heading-clinic text-base font-extrabold text-teal-900 group-hover:underline mt-0.5 tabular-nums">{{ $clinicSettings['clinic_hotline'] }}</div>
                                <div class="text-[11px] text-slate-600 mt-0.5">Tư vấn chuyên môn & điều phối lịch khám</div>
                            </div>
                        </a>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/40 flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 text-base border border-sky-500/10">⏰</div>
                            <div>
                                <div class="text-[11px] uppercase font-semibold text-slate-500">Thời gian làm việc</div>
                                <div class="font-bold text-slate-900 mt-0.5 tabular-nums">08:00 – 20:00 (Thứ 2 – Chủ Nhật)</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Làm việc xuyên trưa, cả Thứ 7 & Chủ Nhật</div>
                            </div>
                        </div>
                        <a href="{{ $clinicSettings['clinic_website'] }}" target="_blank" rel="noopener noreferrer" class="block px-4 pb-1 text-xs font-semibold text-teal-800 hover:underline">{{ $clinicSettings['clinic_website'] }}</a>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/40 flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 text-base border border-emerald-500/10">✉️</div>
                            <div>
                                <div class="text-[11px] uppercase font-semibold text-slate-500">Hòm thư điện tử</div>
                                <div class="font-bold text-slate-900 mt-0.5">{{ $clinicSettings['clinic_email'] }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Tiếp nhận phản hồi và yêu cầu hồ sơ bệnh án</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form gửi yêu cầu tư vấn (7 cột) -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/40 shadow-sm space-y-5">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Tư Vấn Miễn Phí</span>
                    <h3 class="font-heading-clinic !text-xl font-bold text-slate-900 mt-0.5">Gửi Yêu Cầu Tư Vấn Trực Tuyến</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Bác sĩ chuyên khoa sẽ liên hệ phản hồi trong thời gian sớm nhất.</p>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-500/15 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('public.contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Họ và tên <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                placeholder="Họ và tên của bạn..."
                                class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Số điện thoại <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                placeholder="Số điện thoại liên hệ..."
                                class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5 tabular-nums">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Địa chỉ Email (Tùy chọn)
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Địa chỉ email để nhận tư vấn..."
                            class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nội dung cần tư vấn hoặc tình trạng răng miệng <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="message" rows="4" required
                            placeholder="Mô tả triệu chứng răng miệng, dịch vụ quan tâm hoặc câu hỏi dành cho Bác sĩ..."
                            class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5 resize-none">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-press btn-shimmer btn-clinic-primary w-full py-3.5 px-6 rounded-xl text-sm">
                        <span>Gửi Yêu Cầu Tư Vấn</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Bản Đồ Google Maps & Chỉ Dẫn Đường Đi -->
        <div class="mt-10 clinic-card rounded-3xl p-5 sm:p-7 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Bản Đồ & Chỉ Dẫn Đường Đi</span>
                    <h3 class="font-heading-clinic !text-xl font-bold text-slate-900 mt-0.5">{{ $clinicSettings['clinic_address'] }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Mặt đường lớn Trần Duy Hưng, thuận tiện di chuyển và có chỗ đỗ ô tô, xe máy.</p>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($clinicSettings['clinic_address']) }}" target="_blank" rel="noopener noreferrer" class="btn-press btn-clinic-primary px-5 py-2.5 rounded-xl text-xs inline-flex items-center justify-center gap-2 shrink-0">
                    <span>🗺️</span>
                    <span>Mở Chỉ Đường Google Maps</span>
                </a>
            </div>
            <div class="rounded-2xl overflow-hidden shadow-md ring-1 ring-slate-900/5 h-72 sm:h-96 bg-slate-100">
                <iframe
                    title="Bản đồ {{ $clinicSettings['clinic_name'] }} - {{ $clinicSettings['clinic_address'] }}"
                    src="https://maps.google.com/maps?q={{ urlencode($clinicSettings['clinic_address']) }}&t=&z=16&ie=UTF8&iwloc=&output=embed"
                    class="w-full h-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <!-- Tiện Ích Đón Tiếp & Hướng Dẫn Di Chuyển -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="clinic-card rounded-2xl p-5 space-y-2">
                <div class="icon-pop w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg">🚗</div>
                <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Bãi Đỗ Ô Tô & Xe Máy Miễn Phí</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Khu vực đỗ xe rộng rãi ngay trước cửa phòng khám tại {{ $clinicSettings['clinic_address'] }}, có nhân viên bảo vệ hỗ trợ.</p>
            </div>
            <div class="clinic-card rounded-2xl p-5 space-y-2">
                <div class="icon-pop w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-lg">🧭</div>
                <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Vị Trí Trung Tâm Cầu Giấy</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Nằm trên trục đường lớn Trần Duy Hưng, cách Vincom Trần Duy Hưng & ngã tư Hoàng Đạo Thúy chỉ vài phút di chuyển.</p>
            </div>
            <div class="clinic-card rounded-2xl p-5 space-y-2">
                <div class="icon-pop w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg">☕</div>
                <h4 class="font-heading-clinic !text-base font-bold text-slate-900">Sảnh Chờ Riêng Tư & Trà Thảo Mộc</h4>
                <p class="text-xs text-slate-600 leading-relaxed">Phòng chờ thoáng mát, phục vụ trà thảo mộc miễn phí và hỗ trợ sắp xếp phòng khám ưu tiên cho khách đặt hẹn trước.</p>
            </div>
        </div>
    </div>
</section>
@endsection
