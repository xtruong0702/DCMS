@extends('layouts.public')

@section('content')
<!-- Hero Banner Giới Thiệu -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20 lg:py-24">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-500 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-cyan-500 blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-5">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Hệ thống Nha Khoa Tiêu Chuẩn Quốc Tế
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-5 leading-tight">
            Về <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Nha Khoa Smile</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
            Hơn 15 năm đồng hành kiến tạo nụ cười khỏe đẹp, tự tin cho hơn 15.000 khách hàng với triết lý điều trị bảo tồn tối đa và trải nghiệm êm ái, minh bạch.
        </p>
    </div>
</section>

<!-- Câu chuyện & Tầm nhìn -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 relative">
                <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=85" alt="Phòng khám Nha Khoa Smile" class="w-full h-[420px] object-cover">
                </div>
                <div class="hidden sm:flex items-center gap-4 bg-white p-5 rounded-2xl shadow-xl border border-slate-100 absolute -bottom-6 -right-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-md">
                        15+
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-900 text-sm">Năm Kinh Nghiệm</p>
                        <p class="text-xs text-slate-500">Chuẩn vô trùng Bộ Y Tế & Châu Âu</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold uppercase tracking-wider">
                    Câu chuyện thương hiệu
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight">
                    Nơi Khoa Học Nha Khoa Hiện Đại Gặp Gỡ Sự Tận Tâm
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Được thành lập bởi đội ngũ Thạc sĩ, Bác sĩ Răng Hàm Mặt giàu kinh nghiệm, <strong>Nha Khoa Smile</strong> ra đời với sứ mệnh xóa bỏ nỗi sợ phòng nha truyền thống. Chúng tôi đầu tư đồng bộ vào hệ thống chẩn đoán hình ảnh 3D ConeBeam CT, máy quét dấu răng kỹ thuật số iTero 5D và phòng phẫu thuật vô trùng khép kín.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Tại Nha Khoa Smile, mỗi phác đồ điều trị đều được cá nhân hóa, báo giá minh bạch trọn gói trước khi thực hiện (cam kết không phát sinh chi phí ẩn) và lưu trữ hồ sơ bệnh án điện tử trọn đời.
                </p>

                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-100">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <div class="text-2xl sm:text-3xl font-black text-blue-600">15.000+</div>
                        <div class="text-xs font-semibold text-slate-500 mt-1">Ca điều trị thành công</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <div class="text-2xl sm:text-3xl font-black text-emerald-600">100%</div>
                        <div class="text-xs font-semibold text-slate-500 mt-1">Bác sĩ có chứng chỉ CCHN</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <div class="text-2xl sm:text-3xl font-black text-indigo-600">99.2%</div>
                        <div class="text-xs font-semibold text-slate-500 mt-1">Khách hàng hài lòng</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4 Giá trị cốt lõi -->
<section class="py-16 lg:py-20 bg-slate-50 border-y border-slate-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600 bg-blue-50 px-3.5 py-1.5 rounded-full">Giá trị cốt lõi</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-4">4 Cam Kết Vàng Tại Nha Khoa Smile</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-2">Tiêu chuẩn vận hành nghiêm ngặt nhằm bảo vệ tối đa sức khỏe răng miệng và quyền lợi khách hàng.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-2">Vô Trùng Tuyệt Đối</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Mỗi khách hàng sử dụng 1 bộ tay khoan và dụng cụ riêng biệt, hấp sấy tiệt trùng Autoclave chuẩn Class B.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-2">Công Nghệ Không Đau</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Ứng dụng sóng siêu âm Piezotome, gây tê kiểm soát áp lực và quy trình xâm lấn tối thiểu giúp êm ái suốt buổi khám.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-2">Chi Phí Minh Bạch</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Bảng giá niêm yết công khai. Hóa đơn tách biệt rõ ràng tiền dịch vụ khám và tiền thuốc kèm theo.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-2">Bảo Hành Điện Tử</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Vật liệu răng sứ, trụ Implant chính hãng Thuỵ Sĩ, Đức, Hàn Quốc đi kèm thẻ bảo hành chính hãng dài hạn.</p>
            </div>
        </div>
    </div>
</section>

<!-- Cơ sở vật chất & CTA -->
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 sm:p-12 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl sm:text-3xl font-black mb-3">Sẵn sàng trải nghiệm dịch vụ nha khoa chuẩn quốc tế?</h3>
                <p class="text-blue-100 text-sm sm:text-base">
                    Đặt lịch hẹn trước cho các ngày tiếp theo để được ưu tiên tiếp đón không cần chờ đợi, hoặc ghé trực tiếp phòng khám nếu bạn cần thăm khám ngay trong ngày hôm nay.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-4 shrink-0">
                <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white text-blue-700 font-extrabold text-sm shadow-lg hover:bg-blue-50 transition">
                    📅 Đặt Lịch Khám Ngay
                </a>
                <a href="{{ route('public.doctors') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-blue-700/60 border border-blue-400/40 text-white font-bold text-sm hover:bg-blue-700 transition">
                    Xem Đội Ngũ Bác Sĩ
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
