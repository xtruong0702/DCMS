@extends('layouts.public')

@section('title', 'Nha Khoa Smile - Hệ Thống Chăm Sóc Răng Miệng Chuẩn Quốc Tế')

@section('content')
<!-- 1. HERO SECTION -->
<section class="relative bg-gradient-to-b from-slate-50 via-blue-50/40 to-white pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
    <!-- Subtle Background Glows -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <!-- Left Column (7/12) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-200/80 text-indigo-700 font-extrabold text-xs uppercase tracking-wider shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                    Hệ Thống Nha Khoa Số Hóa Toàn Diện (DCMS)
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-[1.12] tracking-tight">
                    Kiến Tạo <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500">Nụ Cười Hoàn Mỹ</span> & Chuẩn Y Khoa.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                    Trải nghiệm dịch vụ nha khoa hiện đại với hồ sơ bệnh án điện tử, sơ đồ răng 32 răng chuẩn quốc tế FDI, đội ngũ bác sĩ chuyên khoa giàu kinh nghiệm và thanh toán VietQR minh bạch.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3.5 pt-2">
                    <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-2.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-7 py-4 rounded-2xl font-extrabold text-sm uppercase tracking-wider shadow-lg shadow-indigo-500/25 transform hover:-translate-y-0.5 transition-all">
                        <span>📅 Đặt Lịch Khám Trước</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('public.services') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200/90 px-5 py-4 rounded-2xl font-extrabold text-sm shadow-xs transition-all">
                        <span>📋 Xem Bảng Giá</span>
                    </a>
                    <a href="{{ route('public.lookup') }}" class="inline-flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/80 px-5 py-4 rounded-2xl font-extrabold text-sm transition-all">
                        <span>🔍 Tra Cứu Lịch Hẹn</span>
                    </a>
                </div>

                <!-- Walk-in vs Advance Booking Notice Box -->
                <div class="bg-white/90 backdrop-blur border border-blue-200/80 rounded-2xl p-4 shadow-xs flex items-start gap-3.5 max-w-2xl">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 font-bold text-base">
                        💡
                    </div>
                    <div class="text-xs text-slate-600 leading-relaxed">
                        <p class="font-extrabold text-slate-800">Hướng dẫn khám trong ngày & Đặt lịch hẹn trước:</p>
                        <p class="mt-0.5">
                            • <strong>Khám ngay trong ngày:</strong> Quý khách không cần đặt lịch online, vui lòng đến trực tiếp phòng khám (<span class="font-bold text-indigo-700">08:00 – 20:00</span>) để Lễ tân tiếp đón ngay.<br>
                            • <strong>Đặt lịch trực tuyến:</strong> Áp dụng cho các lịch hẹn <strong>từ ngày mai trở đi</strong>, bác sĩ sẽ xác nhận và hệ thống tự động nhắc hẹn khi đến giờ.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column (5/12): Visual Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=1000" alt="Nha Khoa Smile" class="w-full h-[420px] sm:h-[460px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <span class="px-2.5 py-1 rounded-lg bg-emerald-500/90 text-[10px] font-extrabold uppercase tracking-wider">Phòng khám tiêu chuẩn Quốc tế</span>
                        <p class="text-lg font-extrabold mt-1.5">Trang thiết bị vô trùng chuẩn Bộ Y Tế</p>
                        <p class="text-xs text-slate-200">123 Nguyễn Văn Cừ, Quận 5, TP.HCM • Hotline: 1900 1234</p>
                    </div>
                </div>

                <!-- Floating Badge Top Left -->
                <a href="#reviews" class="hidden sm:flex absolute -top-5 -left-6 bg-white hover:bg-amber-50/40 rounded-2xl p-4 shadow-xl border border-slate-100 items-center gap-3.5 transition transform hover:-translate-y-0.5">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-black text-xl">
                        ★
                    </div>
                    <div>
                        <div class="text-sm font-black text-slate-900">4.9 / 5.0 (2.500+ đánh giá)</div>
                        <div class="text-xs font-semibold text-indigo-600">Xem phản hồi khách hàng &rarr;</div>
                    </div>
                </a>

                <!-- Floating Badge Bottom Right -->
                <a href="{{ route('public.lookup') }}" class="hidden sm:flex absolute -bottom-5 -right-4 bg-white hover:bg-indigo-50/40 rounded-2xl p-4 shadow-xl border border-slate-100 items-center gap-3.5 transition transform hover:-translate-y-0.5">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-lg">
                        🦷
                    </div>
                    <div>
                        <div class="text-sm font-black text-slate-900">Bệnh Án & VietQR Tự Động</div>
                        <div class="text-xs font-semibold text-indigo-600">Tra cứu hóa đơn bằng SĐT &rarr;</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 2. STATS STRIP -->
<section class="relative z-20 -mt-8 mb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200/80 p-6 sm:p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                <a href="{{ route('public.about') }}" class="pt-2 sm:pt-0 block group hover:bg-slate-50/70 rounded-xl p-2 transition">
                    <div class="text-3xl sm:text-4xl font-black text-indigo-600 group-hover:scale-105 transition-transform">15+</div>
                    <div class="text-xs font-extrabold text-slate-500 group-hover:text-indigo-600 uppercase tracking-wider mt-1">Năm Kinh Nghiệm &rarr;</div>
                </a>
                <a href="#reviews" class="pt-2 sm:pt-0 block group hover:bg-slate-50/70 rounded-xl p-2 transition">
                    <div class="text-3xl sm:text-4xl font-black text-blue-600 group-hover:scale-105 transition-transform">10.000+</div>
                    <div class="text-xs font-extrabold text-slate-500 group-hover:text-blue-600 uppercase tracking-wider mt-1">Ca Điều Trị Thành Công &rarr;</div>
                </a>
                <a href="{{ route('public.doctors') }}" class="pt-2 sm:pt-0 block group hover:bg-slate-50/70 rounded-xl p-2 transition">
                    <div class="text-3xl sm:text-4xl font-black text-cyan-600 group-hover:scale-105 transition-transform">20+</div>
                    <div class="text-xs font-extrabold text-slate-500 group-hover:text-cyan-600 uppercase tracking-wider mt-1">Bác Sĩ Chuyên Khoa &rarr;</div>
                </a>
                <a href="{{ route('public.services') }}" class="pt-2 sm:pt-0 block group hover:bg-slate-50/70 rounded-xl p-2 transition">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600 group-hover:scale-105 transition-transform">100%</div>
                    <div class="text-xs font-extrabold text-slate-500 group-hover:text-emerald-600 uppercase tracking-wider mt-1">Giá Niêm Yết Minh Bạch &rarr;</div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 3. FEATURED SERVICES & PRICE LIST -->
<section id="services" class="py-16 lg:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Dịch Vụ & Bảng Giá Niêm Yết</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-1">Dịch Vụ Nha Khoa Mũi Nhọn</h2>
            </div>
            <a href="{{ route('public.services') }}" class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2.5 rounded-xl border border-indigo-200/80 transition self-start md:self-auto">
                <span>Xem toàn bộ bảng giá dịch vụ</span>
                <span>&rarr;</span>
            </a>
        </div>

        @php
            $serviceVisuals = [
                ['icon' => '🦷', 'slug' => 'lay-cao-rang', 'badge' => 'Chăm sóc định kỳ', 'desc' => 'Thăm khám tổng quát 32 răng, tư vấn phác đồ điều trị và lấy cao răng siêu âm êm ái.'],
                ['icon' => '✨', 'slug' => 'tay-trang-rang', 'badge' => 'Thẩm mỹ nụ cười', 'desc' => 'Công nghệ Laser Whitening giúp răng trắng sáng bật tông an toàn, không ê buốt.'],
                ['icon' => '🛡️', 'slug' => 'tram-rang', 'badge' => 'Phục hồi răng', 'desc' => 'Trám răng thẩm mỹ Composite chuẩn màu răng thật, điều trị sâu răng và mẻ răng.'],
                ['icon' => '🩺', 'slug' => 'nho-rang-khon', 'badge' => 'Tiểu phẫu an toàn', 'desc' => 'Nhổ răng khôn mọc lệch, mọc ngầm bằng máy siêu âm Piezotome lành thương nhanh.'],
                ['icon' => '👑', 'slug' => 'rang-su-chuyen-sau', 'badge' => 'Bọc sứ cao cấp', 'desc' => 'Thiết kế nụ cười răng sứ toàn sứ chính hãng Đức, Mỹ với độ bền và thẩm mỹ tự nhiên.'],
                ['icon' => '🔩', 'slug' => 'implant-chuyen-sau', 'badge' => 'Phục hình vĩnh viễn', 'desc' => 'Trồng răng Implant kỹ thuật số phục hồi chân răng độc lập, ăn nhai bền vững trọn đời.'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredServices as $idx => $service)
                @php
                    $vis = $serviceVisuals[$idx % count($serviceVisuals)];
                @endphp
                <div class="bg-white rounded-2xl p-6 shadow-xs hover:shadow-lg transition-all duration-200 border border-slate-200/90 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                {{ $vis['icon'] }}
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-600">
                                {{ $vis['badge'] }}
                            </span>
                        </div>

                        <a href="{{ route('public.service.detail', $vis['slug']) }}" class="block">
                            <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                {{ $service->name }}
                            </h3>
                        </a>

                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            {{ $service->description ?: $vis['desc'] }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-400 block">Giá niêm yết</span>
                            <span class="text-base font-black text-indigo-600">{{ number_format($service->price, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('public.service.detail', $vis['slug']) }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Chi tiết
                            </a>
                            <a href="{{ route('public.booking', ['service_id' => $service->id]) }}" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-2xs transition">
                                Đặt lịch &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-slate-500 text-sm">
                    Đang cập nhật danh mục dịch vụ...
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 4. SMART 4-STEP WORKFLOW SECTION -->
<section class="py-16 lg:py-20 bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Quy Trình Khép Kín</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-1">4 Bước Khám Chữa Bệnh Thông Minh</h2>
            <p class="text-sm text-slate-600 mt-2">Đồng bộ từ khâu đặt lịch hẹn, bác sĩ xác nhận, lập bệnh án điện tử đến thanh toán mã QR tự động.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('public.booking') }}" class="bg-slate-50 hover:bg-blue-50/50 rounded-2xl p-6 border border-slate-200/80 hover:border-blue-300 relative transition group flex flex-col justify-between">
                <div>
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-600 text-white font-black text-sm mb-4 shadow-sm">01</span>
                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition">Đặt Lịch Hoặc Đến Trực Tiếp</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Đặt lịch online trước từ ngày mai trở đi, hoặc đến trực tiếp phòng khám nếu cần khám ngay trong ngày.
                    </p>
                </div>
                <span class="text-xs font-extrabold text-blue-600 mt-4 inline-flex items-center gap-1">Đặt lịch hẹn ngay &rarr;</span>
            </a>

            <a href="{{ route('public.lookup') }}" class="bg-slate-50 hover:bg-indigo-50/50 rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-300 relative transition group flex flex-col justify-between">
                <div>
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 text-white font-black text-sm mb-4 shadow-sm">02</span>
                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-indigo-600 transition">Bác Sĩ Xác Nhận & Nhắc Hẹn</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Bác sĩ xác nhận lịch hẹn trên hệ thống; tự động gửi cảnh báo nhắc hẹn khi đến giờ hoặc quá giờ hẹn.
                    </p>
                </div>
                <span class="text-xs font-extrabold text-indigo-600 mt-4 inline-flex items-center gap-1">Tra cứu trạng thái lịch &rarr;</span>
            </a>

            <a href="{{ route('public.doctors') }}" class="bg-slate-50 hover:bg-cyan-50/50 rounded-2xl p-6 border border-slate-200/80 hover:border-cyan-300 relative transition group flex flex-col justify-between">
                <div>
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-cyan-600 text-white font-black text-sm mb-4 shadow-sm">03</span>
                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-cyan-700 transition">Khám & Sơ Đồ Răng Điện Tử</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Thăm khám trên Sơ đồ răng 32 răng chuẩn FDI, lưu trữ bệnh án và kê đơn thuốc điện tử minh bạch.
                    </p>
                </div>
                <span class="text-xs font-extrabold text-cyan-700 mt-4 inline-flex items-center gap-1">Xem đội ngũ Bác sĩ &rarr;</span>
            </a>

            <a href="{{ route('public.lookup') }}" class="bg-slate-50 hover:bg-emerald-50/50 rounded-2xl p-6 border border-slate-200/80 hover:border-emerald-300 relative transition group flex flex-col justify-between">
                <div>
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-600 text-white font-black text-sm mb-4 shadow-sm">04</span>
                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition">Thanh Toán VietQR Tự Động</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Hóa đơn tự động tổng hợp tiền dịch vụ khám, tiền thuốc kèm theo và thuế VAT 10% kèm mã quét VietQR.
                    </p>
                </div>
                <span class="text-xs font-extrabold text-emerald-700 mt-4 inline-flex items-center gap-1">Tra cứu hóa đơn &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- 5. OUR DOCTORS SECTION -->
<section class="py-16 lg:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Đội Ngũ Chuyên Gia</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-1">Bác Sĩ Chuyên Khoa Răng Hàm Mặt</h2>
            </div>
            <a href="{{ route('public.doctors') }}" class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-indigo-600 hover:text-indigo-800 bg-white px-4 py-2.5 rounded-xl border border-slate-200 transition self-start md:self-auto">
                <span>Xem toàn bộ đội ngũ Bác sĩ</span>
                <span>&rarr;</span>
            </a>
        </div>

        @php
            $doctorPortraits = [
                'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=600',
            ];
            $fallbackDoctors = [
                ['name' => 'BS.CKII Trần Văn A', 'specialty' => 'Nha khoa Thẩm mỹ & Phục hình Sứ', 'exp' => '12 năm kinh nghiệm', 'img' => $doctorPortraits[0]],
                ['name' => 'ThS.BS Nguyễn Thị Minh Anh', 'specialty' => 'Chuyên gia Chỉnh nha Invisalign', 'exp' => '10 năm kinh nghiệm', 'img' => $doctorPortraits[1]],
                ['name' => 'BS.CKI Lê Hoàng Nam', 'specialty' => 'Cấy ghép Implant & Tiểu phẫu', 'exp' => '15 năm kinh nghiệm', 'img' => $doctorPortraits[2]],
                ['name' => 'BS. Phạm Thanh Thảo', 'specialty' => 'Nha khoa Tổng quát & Nội nha', 'exp' => '8 năm kinh nghiệm', 'img' => $doctorPortraits[3]],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($fallbackDoctors as $idx => $fbDoc)
                @php
                    $dbDoc = isset($doctors[$idx]) ? $doctors[$idx] : null;
                    $docName = ($dbDoc && $dbDoc->user) ? $dbDoc->user->name : $fbDoc['name'];
                    $docSpec = ($dbDoc && $dbDoc->specialty) ? (is_object($dbDoc->specialty) ? $dbDoc->specialty->name : $dbDoc->specialty) : $fbDoc['specialty'];
                    $docExp = ($dbDoc && $dbDoc->experience_years) ? ($dbDoc->experience_years . ' năm kinh nghiệm') : $fbDoc['exp'];
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-lg border border-slate-200/90 transition group flex flex-col">
                    <div class="relative h-64 overflow-hidden bg-slate-100">
                        <img src="{{ $fbDoc['img'] }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-white/90 backdrop-blur text-indigo-700 shadow-2xs">
                            {{ $docExp }}
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900">{{ $docName }}</h3>
                            <p class="text-xs font-bold text-indigo-600 mt-1">{{ $docSpec }}</p>
                            <p class="text-[11px] text-slate-500 mt-2">Tốt nghiệp Đại học Y Dược • Chứng chỉ hành nghề Răng Hàm Mặt Quốc gia.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <a href="{{ route('public.booking', $dbDoc ? ['doctor_id' => $dbDoc->id] : []) }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-extrabold transition">
                                <span>Đặt lịch với Bác sĩ</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 6. CUSTOMER REVIEWS -->
<section id="reviews" class="py-16 lg:py-20 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-cyan-400 uppercase tracking-widest">Khách Hàng Chia Sẻ</span>
            <h2 class="text-3xl sm:text-4xl font-black mt-1">Hơn 10.000 Khách Hàng Tin Tưởng</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-800/80 p-6 rounded-2xl border border-slate-700/80 flex flex-col justify-between">
                <div>
                    <div class="text-amber-400 text-sm tracking-widest mb-3">★★★★★</div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic">
                        "Nhổ răng khôn bằng máy siêu âm rất êm, hầu như không sưng đau. Đặc biệt thích phần hóa đơn hiển thị rõ tiền dịch vụ, tiền thuốc và quét mã VietQR cực nhanh."
                    </p>
                </div>
                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-slate-700/70">
                    <div class="w-9 h-9 rounded-full bg-indigo-600 text-white font-extrabold text-xs flex items-center justify-center">HN</div>
                    <div>
                        <h4 class="text-xs font-extrabold text-white">Anh Hoàng Nam</h4>
                        <span class="text-[11px] text-slate-400">Dịch vụ Nhổ răng khôn Piezotome</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/80 p-6 rounded-2xl border border-indigo-500/40 flex flex-col justify-between">
                <div>
                    <div class="text-amber-400 text-sm tracking-widest mb-3">★★★★★</div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic">
                        "Đặt lịch khám online từ hôm trước, bác sĩ xác nhận ngay và khi đến giờ hẹn có thông báo nhắc rất chuyên nghiệp. Hồ sơ bệnh án và đơn thuốc tra cứu trực tuyến rất tiện."
                    </p>
                </div>
                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-slate-700/70">
                    <div class="w-9 h-9 rounded-full bg-cyan-600 text-white font-extrabold text-xs flex items-center justify-center">LC</div>
                    <div>
                        <h4 class="text-xs font-extrabold text-white">Chị Linh Chi</h4>
                        <span class="text-[11px] text-slate-400">Dịch vụ Niềng răng & Chăm sóc định kỳ</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/80 p-6 rounded-2xl border border-slate-700/80 flex flex-col justify-between">
                <div>
                    <div class="text-amber-400 text-sm tracking-widest mb-3">★★★★★</div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic">
                        "Phòng khám sạch đẹp, vô trùng kỹ lưỡng. Bác sĩ giải thích trực tiếp trên sơ đồ răng điện tử nên mình hiểu rất rõ tình trạng từng chiếc răng trước khi làm."
                    </p>
                </div>
                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-slate-700/70">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center">MT</div>
                    <div>
                        <h4 class="text-xs font-extrabold text-white">Anh Minh Tuấn</h4>
                        <span class="text-[11px] text-slate-400">Dịch vụ Trồng răng Implant</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. BOTTOM CTA BANNER -->
<section class="py-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-black mb-3">Sẵn Sàng Chăm Sóc Nụ Cười Của Bạn?</h2>
        <p class="text-sm sm:text-base text-blue-100 mb-8 max-w-2xl mx-auto">
            Đặt lịch hẹn trước cho các ngày tiếp theo hoặc đến trực tiếp phòng khám nếu bạn muốn thăm khám ngay trong ngày hôm nay.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('public.booking') }}" class="px-8 py-4 bg-white text-indigo-700 hover:bg-slate-50 rounded-2xl font-extrabold text-sm uppercase tracking-wider shadow-lg transition">
                📅 Đặt Lịch Khám Online Ngay
            </a>
            <a href="tel:19001234" class="px-8 py-4 bg-indigo-900/40 hover:bg-indigo-900/60 border border-white/30 text-white rounded-2xl font-extrabold text-sm uppercase tracking-wider transition">
                📞 Gọi Hotline: 1900 1234
            </a>
        </div>
    </div>
</section>
@endsection
