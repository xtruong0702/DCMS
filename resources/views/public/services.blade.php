@extends('layouts.public')

@section('title', 'Dịch Vụ & Bảng Giá Niêm Yết - Nha Khoa Smile')

@section('content')
<!-- Hero Dịch Vụ & Bảng Giá (Medical Clinic) -->
<section class="relative overflow-hidden bg-gradient-to-b from-teal-50/80 via-white to-slate-50 py-14 sm:py-16 border-b border-slate-200/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-teal-500/15 text-teal-800 text-xs font-semibold shadow-sm">
            <span class="pulse-dot pulse-dot-emerald"></span>
            <span>Bảng Giá Niêm Yết Công Khai</span>
        </div>
        <h1 class="font-heading-clinic !text-3xl sm:!text-4xl font-extrabold tracking-tight text-slate-900">
            Dịch Vụ Nha Khoa & <span class="text-clinic-gradient">Bảng Giá Minh Bạch</span>
        </h1>
        <p class="text-slate-600 text-sm max-w-xl mx-auto leading-relaxed">
            100% minh bạch chi phí khám chữa bệnh, sử dụng vật liệu nha khoa chính hãng, chế độ bảo hành rõ ràng và thanh toán VietQR tự động.
        </p>
    </div>
</section>

<!-- Các chuyên khoa mũi nhọn -->
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-slate-200/40 pb-4 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Danh Mục Chuyên Khoa</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-slate-900 mt-1">Dịch Vụ Chuyên Khoa Nha Khoa Smile</h2>
            </div>
            <p class="text-xs text-slate-500">Mỗi ca điều trị đều được Bác sĩ Chuyên khoa trực tiếp thăm khám</p>
        </div>

        @php
            $catalog = [
                ['slug' => 'rang-su-chuyen-sau', 'title' => 'Dán Sứ Veneer Emax Siêu Mỏng', 'tag' => 'Thụy Sĩ • Phổ biến', 'desc' => 'Khôi phục men răng, form răng tự nhiên, không mài nhỏ, bảo tồn răng gốc 100%, bảo hành điện tử.', 'icon' => '✨', 'price' => '104.500.000 đ / 16 răng'],
                ['slug' => 'implant-chuyen-sau', 'title' => 'Cấy Ghép Implant Straumann', 'tag' => 'Thụy Sĩ • Tiêu chuẩn vàng', 'desc' => 'Trụ Titanium sinh học số 1 thế giới, tích hợp xương nhanh sau 3-4 tuần, ăn nhai như răng thật.', 'icon' => '🦷', 'price' => '32.180.000 đ / trụ'],
                ['slug' => 'nieng-rang', 'title' => 'Niềng Răng Invisalign Diamond', 'tag' => 'Hoa Kỳ • SmartTrack', 'desc' => 'Khay niềng trong suốt chính hãng Hoa Kỳ, mô phỏng dịch chuyển răng 3D bằng ClinCheck.', 'icon' => '💎', 'price' => '104.000.000 đ trọn gói'],
                ['slug' => 'tay-trang-rang', 'title' => 'Tẩy Trắng Răng Laser Whitening', 'tag' => 'Ánh sáng lạnh • 45 phút', 'desc' => 'Bật 3-5 tone răng trắng sáng tự nhiên, không ê buốt, bảo vệ men răng an toàn tuyệt đối.', 'icon' => '🌟', 'price' => '2.000.000 đ / ca'],
                ['slug' => 'nho-rang-khon', 'title' => 'Nhổ Răng Khôn Sóng Siêu Âm', 'tag' => 'Piezotome • Không đau', 'desc' => 'Ứng dụng máy siêu âm Piezotome bóc tách nhẹ nhàng, ít xâm lấn, mau lành thương.', 'icon' => '🛡️', 'price' => '990.000 đ / răng'],
                ['slug' => 'dieu-tri-tuy', 'title' => 'Điều Trị Tủy Vi Phẫu', 'tag' => 'Nội nha không đau', 'desc' => 'Làm sạch ống tủy bằng máy vi phẫu sóng âm, triệt tiêu vi khuẩn và bảo tồn chân răng thật.', 'icon' => '🔬', 'price' => '1.500.000 đ / răng'],
                ['slug' => 'lay-cao-rang', 'title' => 'Cạo Vôi Răng & Chăm Sóc Nha Chu', 'tag' => 'Tổng quát định kỳ', 'desc' => 'Làm sạch mảng bám dưới nướu bằng sóng siêu âm êm ái, đánh bóng răng ngăn ngừa viêm nướu.', 'icon' => '🫧', 'price' => '350.000 đ / lần'],
                ['slug' => 'tram-rang', 'title' => 'Trám Răng Thẩm Mỹ Composite', 'tag' => 'Composite Nano', 'desc' => 'Phục hồi lỗ sâu, răng mẻ bằng vật liệu nano trùng khớp màu sắc men răng tự nhiên.', 'icon' => '🩹', 'price' => '500.000 đ / răng'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($catalog as $item)
                <div class="clinic-card rounded-2xl p-5 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="w-10 h-10 rounded-xl bg-teal-50 text-xl flex items-center justify-center border border-teal-500/10">
                                {{ $item['icon'] }}
                            </span>
                            <span class="text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-teal-800 border border-slate-200/40">
                                {{ $item['tag'] }}
                            </span>
                        </div>
                        <h3 class="font-heading-clinic !text-base font-bold text-slate-900 leading-snug">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $item['desc'] }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100/70 flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[10px] text-slate-500 block">Đơn giá niêm yết:</span>
                            <span class="font-heading-clinic text-xs font-bold text-teal-800 tabular-nums">{{ $item['price'] }}</span>
                        </div>
                        <a href="{{ route('public.booking') }}" class="btn-press btn-clinic-primary px-3 py-1.5 rounded-lg text-xs shrink-0">
                            Đặt Lịch
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bảng giá niêm yết từ cơ sở dữ liệu (Có lọc chuyên khoa & tìm kiếm tức thì) -->
        <div class="pt-4" x-data="{
            q: '',
            cat: 'all',
            matches(name, desc) {
                const text = (name + ' ' + desc).toLowerCase();
                const qOk = !this.q.trim() || text.includes(this.q.trim().toLowerCase());
                if (!qOk) return false;
                if (this.cat === 'all') return true;
                if (this.cat === 'su') return /sứ|veneer|cercon|lava|bọc răng/.test(text);
                if (this.cat === 'implant') return /implant|cấy ghép|trồng răng/.test(text);
                if (this.cat === 'nieng') return /niềng|invisalign|chỉnh nha|mắc cài/.test(text);
                if (this.cat === 'trang') return /tẩy trắng|laser|whitening/.test(text);
                if (this.cat === 'tongquat') return /khám|cạo vôi|nhổ|trám|tủy|nha chu/.test(text);
                return true;
            }
        }">
            <div class="text-center max-w-xl mx-auto mb-6 space-y-2">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-500/10">Minh Bạch Chi Phí</span>
                <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-slate-900">Bảng Giá Dịch Vụ Hệ Thống</h2>
                <p class="text-xs sm:text-sm text-slate-500">Đồng bộ trực tiếp với hệ thống hóa đơn điện tử & thanh toán VietQR tại phòng khám.</p>
            </div>

            <!-- Thanh Lọc Chuyên Khoa & Ô Tìm Kiếm Nhanh -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-5">
                <div class="flex flex-wrap items-center gap-1.5">
                    @foreach([
                        'all' => 'Tất cả',
                        'su' => 'Răng sứ & Veneer',
                        'implant' => 'Implant',
                        'nieng' => 'Niềng răng',
                        'trang' => 'Tẩy trắng',
                        'tongquat' => 'Tổng quát',
                    ] as $key => $label)
                        <button type="button" @click="cat = '{{ $key }}'"
                            :class="cat === '{{ $key }}' ? 'btn-clinic-primary shadow-sm' : 'bg-white text-slate-600 hover:bg-teal-50 hover:text-teal-800'"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <div class="relative w-full md:w-72">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none text-xs">🔍</span>
                    <input type="text" x-model="q" placeholder="Tìm nhanh dịch vụ (VD: Implant, cạo vôi...)"
                        class="input-clinic w-full pl-8 pr-3.5 py-2 rounded-xl text-xs">
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/40 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs table-spotlight">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-[11px] uppercase tracking-wider border-b border-slate-200/40">
                                <th class="py-3.5 px-5 font-bold">Dịch vụ nha khoa</th>
                                <th class="py-3.5 px-5 font-bold">Mô tả quy trình</th>
                                <th class="py-3.5 px-5 font-bold text-center">Thời gian</th>
                                <th class="py-3.5 px-5 font-bold text-right">Đơn giá niêm yết</th>
                                <th class="py-3.5 px-5 font-bold text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/60">
                            @forelse($services as $service)
                                <tr x-show="matches(@js($service->name), @js($service->description ?? ''))" class="hover:bg-teal-50/40 transition">
                                    <td class="py-3.5 px-5 font-semibold text-slate-900">
                                        {{ $service->name }}
                                    </td>
                                    <td class="py-3.5 px-5 text-slate-600">
                                        {{ $service->description ?: 'Quy trình điều trị chuẩn vô trùng Bộ Y Tế.' }}
                                    </td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium tabular-nums">
                                            ⏱ {{ $service->duration ?? 30 }} phút
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-heading-clinic text-sm font-bold text-teal-800 whitespace-nowrap tabular-nums">
                                        {{ number_format($service->price, 0, ',', '.') }} đ
                                    </td>
                                    <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                        <a href="{{ route('public.booking', ['service_id' => $service->id]) }}" class="btn-press btn-clinic-primary inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs">
                                            Đặt lịch
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500 text-xs">
                                        Danh mục dịch vụ đang được cập nhật. Vui lòng liên hệ Hotline 0775 761 388 để được tư vấn trực tiếp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-teal-50/60 px-6 py-3.5 border-t border-slate-200/40 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-600">
                    <div>
                        💡 <strong>Lưu ý:</strong> Bảng giá đã bao gồm thăm khám và tư vấn trực tiếp cùng Bác sĩ Chuyên khoa.
                    </div>
                    <a href="tel:0775761388" class="font-bold text-teal-700 hover:underline tabular-nums">Cần tư vấn chi tiết? Gọi Hotline 0775 761 388 &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Chính sách bảo hành & Ưu đãi thanh toán -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4">
            <div class="clinic-card rounded-2xl p-6 space-y-2.5">
                <div class="icon-pop w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg">🛡️</div>
                <h3 class="font-heading-clinic !text-base font-bold text-slate-900">Bảo Hành Điện Tử Chính Hãng</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Toàn bộ răng sứ Emax, trụ Implant Straumann đều có mã QR kiểm tra xuất xứ và bảo hành điện tử trọn đời.</p>
            </div>
            <div class="clinic-card rounded-2xl p-6 space-y-2.5">
                <div class="icon-pop w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-lg">💳</div>
                <h3 class="font-heading-clinic !text-base font-bold text-slate-900">Hỗ Trợ Trả Góp 0% Lãi Suất</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Hỗ trợ thanh toán linh hoạt qua VietQR, thẻ tín dụng 25+ ngân hàng với kỳ hạn 6–12 tháng 0% lãi suất.</p>
            </div>
            <div class="clinic-card rounded-2xl p-6 space-y-2.5">
                <div class="icon-pop w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg">📋</div>
                <h3 class="font-heading-clinic !text-base font-bold text-slate-900">Cam Kết Không Phát Sinh Chi Phí</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Bác sĩ lập phác đồ và báo giá trọn gói trên hệ thống DCMS trước khi thực hiện điều trị.</p>
            </div>
        </div>

        <!-- Câu hỏi thường gặp (FAQ Accordion) -->
        <div class="clinic-card rounded-3xl p-6 sm:p-8 space-y-5" x-data="{ openFaq: 1 }">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Giải Đáp Thắc Mắc</span>
                <h3 class="font-heading-clinic !text-2xl font-bold text-slate-900 mt-1">Câu Hỏi Thường Gặp Về Dịch Vụ & Chi Phí</h3>
            </div>
            <div class="divide-y divide-slate-100/60">
                <div class="py-3.5">
                    <button type="button" @click="openFaq = openFaq === 1 ? null : 1" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-slate-900">
                        <span>1. Chi phí niêm yết đã bao gồm chụp phim 3D và khám bác sĩ chưa?</span>
                        <span class="text-teal-700 text-base ml-2" x-text="openFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 1" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2">
                        Khi quý khách thực hiện các dịch vụ điều trị như Implant, Niềng răng Invisalign hoặc Dán sứ Veneer tại Nha Khoa Smile, chi phí thăm khám và chụp phim 3D CT ConeBeam lập phác đồ sẽ được hỗ trợ hoàn toàn miễn phí.
                    </p>
                </div>
                <div class="py-3.5">
                    <button type="button" @click="openFaq = openFaq === 2 ? null : 2" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-slate-900">
                        <span>2. Làm răng sứ Veneer có cần mài nhỏ răng thật không?</span>
                        <span class="text-teal-700 text-base ml-2" x-text="openFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 2" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2">
                        Mặt dán sứ Veneer Emax siêu mỏng chỉ 0.2mm giúp bảo tồn tối đa men răng thật (hầu như không mài hoặc chỉ xử lý nhám bề mặt rất mỏng), không chạm tủy và không gây ê buốt.
                    </p>
                </div>
                <div class="py-3.5">
                    <button type="button" @click="openFaq = openFaq === 3 ? null : 3" class="w-full flex items-center justify-between text-left text-xs sm:text-sm font-bold text-slate-900">
                        <span>3. Tôi có thể thanh toán và xem lại hóa đơn trực tuyến không?</span>
                        <span class="text-teal-700 text-base ml-2" x-text="openFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <p x-show="openFaq === 3" x-cloak class="text-xs text-slate-600 leading-relaxed mt-2">
                        Hoàn toàn được. Sau mỗi buổi khám, hóa đơn điện tử kèm mã VietQR được lưu tự động trên hệ thống DCMS. Quý khách có thể tra cứu bất cứ lúc nào bằng số điện thoại tại mục Tra Cứu Lịch Hẹn.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
