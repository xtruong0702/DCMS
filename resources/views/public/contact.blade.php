@extends('layouts.public')

@section('content')
<!-- Hero Liên Hệ -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Hỗ trợ tận tâm 08:00 - 20:00 (Thứ 2 - Chủ Nhật)
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Liên Hệ <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Nha Khoa Smile</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
            Đội ngũ Bác sĩ và Tư vấn viên luôn sẵn sàng lắng nghe, giải đáp mọi thắc mắc về tình trạng răng miệng và chi phí điều trị của bạn.
        </p>
    </div>
</section>

<section class="py-16 bg-slate-50" x-data="{ msgText: '{{ old('message', '') }}' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Cột thông tin liên hệ -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600">Thông tin chính thức</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">Phòng Khám Nha Khoa Smile</h2>
                        <p class="text-sm text-slate-500 mt-1">Hệ thống quản lý phòng khám nha khoa điện tử hiện đại.</p>
                    </div>

                    <div class="space-y-4">
                        <a href="#ban-do" class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-blue-50/50 border border-slate-100 hover:border-blue-200 transition">
                            <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-lg">📍</div>
                            <div>
                                <div class="text-xs font-bold uppercase text-slate-400">Địa chỉ phòng khám (Bấm xem bản đồ)</div>
                                <div class="text-sm font-extrabold text-slate-900 mt-0.5">123 Đường Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh</div>
                            </div>
                        </a>

                        <a href="tel:19001234" class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/50 border border-slate-100 hover:border-emerald-200 transition">
                            <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 text-lg">📞</div>
                            <div>
                                <div class="text-xs font-bold uppercase text-slate-400">Tổng đài tư vấn (Bấm để gọi ngay)</div>
                                <div class="text-base font-black text-emerald-600 mt-0.5">1900 1234 <span class="text-xs font-semibold text-slate-500">(Nhánh 1: Tư vấn)</span></div>
                            </div>
                        </a>

                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-lg">⏰</div>
                            <div>
                                <div class="text-xs font-bold uppercase text-slate-400">Giờ mở cửa đón khách</div>
                                <div class="text-sm font-extrabold text-slate-900 mt-0.5">08:00 – 20:00 (Từ Thứ 2 đến Chủ Nhật)</div>
                                <div class="text-xs text-slate-500 mt-0.5">Làm việc xuyên trưa, kể cả ngày Thứ 7 & Chủ Nhật</div>
                            </div>
                        </div>

                        <a href="mailto:cskh@nhakhoasmile.vn" class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-amber-50/50 border border-slate-100 hover:border-amber-200 transition">
                            <div class="w-11 h-11 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 text-lg">✉️</div>
                            <div>
                                <div class="text-xs font-bold uppercase text-slate-400">Hộp thư điện tử (Bấm gửi Email)</div>
                                <div class="text-sm font-extrabold text-slate-900 mt-0.5">cskh@nhakhoasmile.vn</div>
                            </div>
                        </a>
                    </div>

                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200/80 text-xs text-blue-900 leading-relaxed">
                        💡 <strong>Khám ngay trong ngày:</strong> Quý khách cần khám gấp hoặc xử lý đau răng trong ngày hôm nay có thể đến trực tiếp địa chỉ trên trong khung giờ <strong>08:00 - 20:00</strong> mà không cần đặt lịch trước.
                    </div>
                </div>
            </div>

            <!-- Cột Form gửi tin nhắn -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Gửi Câu Hỏi Tư Vấn Trực Tuyến</h2>
                    <p class="text-sm text-slate-500 mb-6">
                        Điền thông tin bên dưới hoặc bấm chọn nhanh chủ đề bạn đang quan tâm, Bác sĩ tư vấn sẽ liên hệ giải đáp trong vòng 15 phút.
                    </p>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">✓</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                            <p class="font-extrabold mb-1">Vui lòng kiểm tra lại thông tin:</p>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('public.contact.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                    Họ và tên của bạn <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                    placeholder="Ví dụ: Nguyễn Văn An"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4">
                            </div>

                            <div>
                                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                    Số điện thoại liên hệ <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    placeholder="Ví dụ: 0901 234 567"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4">
                            </div>
                        </div>

                        <!-- Chủ đề chọn nhanh -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Chọn nhanh chủ đề cần tư vấn:
                            </label>
                            <div class="flex flex-wrap gap-2 mb-3">
                                @php
                                    $quickTopics = [
                                        'Tư vấn chi phí Trồng răng Implant',
                                        'Bọc răng sứ thẩm mỹ bảo tồn răng',
                                        'Tư vấn lộ trình Niềng răng chỉnh nha',
                                        'Nhổ răng khôn không đau bằng máy siêu âm',
                                        'Đau nhức răng cấp tính cần khám sớm',
                                    ];
                                @endphp
                                @foreach($quickTopics as $topic)
                                    <button type="button"
                                        @click="msgText = '{{ $topic }} - Xin tư vấn chi tiết giúp tôi.'"
                                        class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 border border-slate-200 hover:border-blue-300 text-xs font-bold transition">
                                        + {{ $topic }}
                                    </button>
                                @endforeach
                            </div>

                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Nội dung cần tư vấn <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="message" rows="5" required x-model="msgText"
                                placeholder="Mô tả triệu chứng răng miệng hoặc dịch vụ bạn đang quan tâm..."
                                class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4"></textarea>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500">
                                🔒 Thông tin cá nhân của quý khách được bảo mật tuyệt đối.
                            </p>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-sm shadow-lg shadow-blue-600/25 transition">
                                Gửi Tin Nhắn Tư Vấn
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bản đồ chỉ đường -->
        <div id="ban-do" class="mt-12 bg-white rounded-3xl p-4 sm:p-6 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 px-2">
                <div>
                    <h3 class="text-lg font-black text-slate-900">🗺️ Bản Đồ Chỉ Đường Đến Nha Khoa Smile</h3>
                    <p class="text-xs text-slate-500">123 Đường Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh (Có chỗ đậu ô tô & xe máy rộng rãi)</p>
                </div>
                <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold transition self-start sm:self-auto">
                    📅 Đặt lịch hẹn trước
                </a>
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-200 h-72 sm:h-80 bg-slate-100">
                <iframe
                    title="Bản đồ Nha Khoa Smile"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=106.6780%2C10.7540%2C106.6880%2C10.7620&amp;layer=mapnik"
                    class="w-full h-full border-0"
                    loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
