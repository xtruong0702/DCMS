@extends('layouts.public')

@section('title', 'Bộ Sưu Tập Dịch Vụ Mũi Nhọn & Bảng Giá Niêm Yết - Smile Atelier')

@section('content')
<!-- Hero Dịch Vụ & Bảng Giá -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Signature Collection & Bảng Giá Niêm Yết</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Nghệ Thuật Nha Khoa & <span class="italic font-normal text-[#E6D5B8]">Bảng Giá Thượng Lưu</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            100% minh bạch chi phí, sử dụng vật liệu chính hãng Thụy Sĩ, Đức, Hoa Kỳ với thẻ bảo hành điện tử toàn cầu và cam kết đồng hành trọn đời.
        </p>
    </div>
</section>

<!-- Các chuyên khoa mũi nhọn -->
<section class="py-12 sm:py-16 bg-[#FBF9F5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-[#EAE5DD] pb-4 gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Tuyển Chọn Kỹ Thuật Đỉnh Cao</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421] mt-1">Dịch Vụ Nghệ Nhân Chuyên Sâu</h2>
            </div>
            <p class="text-xs text-slate-500 font-light">Mỗi dịch vụ được kiến tạo bởi Bác sĩ Trưởng khoa chuyên biệt</p>
        </div>

        @php
            $catalog = [
                ['slug' => 'rang-su-chuyen-sau', 'title' => 'Dán Sứ Veneer Emax Siêu Mỏng', 'tag' => 'Thụy Sĩ • Bán chạy nhất', 'desc' => 'Khôi phục men răng, form răng tự nhiên, không mài nhỏ, bảo tồn răng gốc 100%, bảo hành trọn đời.', 'icon' => '✨', 'price' => '104.500.000 đ / 16 răng'],
                ['slug' => 'implant-chuyen-sau', 'title' => 'Cấy Ghép Implant Straumann', 'tag' => 'Thụy Sĩ • Tiêu chuẩn vàng', 'desc' => 'Trụ kim cương sinh học số 1 thế giới, tích hợp xương tức thì chỉ sau 3-4 tuần, bảo hành toàn cầu.', 'icon' => '🦷', 'price' => '32.180.000 đ / trụ'],
                ['slug' => 'nieng-rang', 'title' => 'Niềng Răng Invisalign Diamond', 'tag' => 'Hoa Kỳ • SmartTrack', 'desc' => 'Khay niềng vô hình chính hãng Hoa Kỳ, nụ cười chuẩn tỷ lệ vàng khuôn mặt mô phỏng bằng ClinCheck 3D.', 'icon' => '💎', 'price' => '104.000.000 đ trọn gói'],
                ['slug' => 'tay-trang-rang', 'title' => 'Tẩy Trắng Răng Laser Whitening', 'tag' => 'Ánh sáng lạnh • -40%', 'desc' => 'Bật 3-5 tone răng trắng sáng tự nhiên chỉ sau 45 phút, không ê buốt, an toàn tuyệt đối.', 'icon' => '🌟', 'price' => '2.000.000 đ / ca'],
                ['slug' => 'nho-rang-khon', 'title' => 'Nhổ Răng Khôn Sóng Siêu Âm', 'tag' => 'Piezotome • 0 Đau', 'desc' => 'Ứng dụng máy siêu âm Piezotome bóc tách nhẹ nhàng, mau lành thương, không sưng mặt.', 'icon' => '🛡️', 'price' => '990.000 đ / răng'],
                ['slug' => 'dieu-tri-tuy', 'title' => 'Điều Trị Tủy Vi Phẫu Áp Lực', 'tag' => 'Nội nha không đau', 'desc' => 'Làm sạch ống tủy bằng máy vi phẫu sóng âm, triệt tiêu vi khuẩn và bảo tồn chân răng thật.', 'icon' => '🔬', 'price' => '1.500.000 đ / răng'],
                ['slug' => 'lay-cao-rang', 'title' => 'Chăm Sóc Nha Chu & Trà Thảo Mộc', 'tag' => 'Spa răng miệng', 'desc' => 'Làm sạch mảng bám dưới nướu bằng sóng siêu âm êm ái, massage nướu và dưỡng men răng thảo dược.', 'icon' => '🫧', 'price' => '350.000 đ / lần'],
                ['slug' => 'tram-rang', 'title' => 'Trám Răng Tái Tạo Men Sứ', 'tag' => 'Composite Nano', 'desc' => 'Phục hồi lỗ sâu, kẽ hở bằng vật liệu nano trùng khớp 100% với màu sắc men răng tự nhiên.', 'icon' => '🩹', 'price' => '500.000 đ / răng'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($catalog as $item)
                <div class="bg-white rounded-3xl p-5 border border-[#EAE5DD] shadow-xs hover:border-[#063B30] hover:shadow-md transition flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-[#EBF4F0] text-xl flex items-center justify-center text-[#063B30]">
                                {{ $item['icon'] }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#FDF8EE] text-[#9A7B4F] border border-[#E9DCBF]">
                                {{ $item['tag'] }}
                            </span>
                        </div>
                        <h3 class="font-serif-luxury text-base font-bold text-slate-900 leading-snug">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            {{ $item['desc'] }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Đơn giá niêm yết:</span>
                            <span class="font-serif-luxury text-xs font-bold text-[#063B30]">{{ $item['price'] }}</span>
                        </div>
                        <a href="{{ route('public.booking') }}" class="px-3 py-1.5 bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] rounded-xl text-xs font-bold transition">
                            Đặt Lịch
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bảng giá niêm yết từ cơ sở dữ liệu -->
        <div class="pt-6">
            <div class="text-center max-w-xl mx-auto mb-8 space-y-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Minh Bạch Tuyệt Đối</span>
                <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#1A2421]">Bảng Giá Dịch Vụ Hệ Thống</h2>
                <p class="text-xs text-slate-500 font-light">Đồng bộ tự động với hệ thống hóa đơn điện tử & thanh toán VietQR.</p>
            </div>

            <div class="bg-white rounded-3xl border border-[#EAE5DD] shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-[#063B30] text-[#E6D5B8] text-[11px] uppercase tracking-wider">
                                <th class="py-3.5 px-5 font-bold">Dịch vụ nha khoa</th>
                                <th class="py-3.5 px-5 font-bold">Mô tả quy trình</th>
                                <th class="py-3.5 px-5 font-bold text-center">Thời gian</th>
                                <th class="py-3.5 px-5 font-bold text-right">Đơn giá niêm yết</th>
                                <th class="py-3.5 px-5 font-bold text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($services as $service)
                                <tr class="hover:bg-[#EBF4F0]/50 transition">
                                    <td class="py-3.5 px-5 font-bold text-slate-900">
                                        💎 {{ $service->name }}
                                    </td>
                                    <td class="py-3.5 px-5 text-slate-600 font-light">
                                        {{ $service->description ?: 'Quy trình vô trùng áp lực dương chuẩn Thụy Sĩ.' }}
                                    </td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-medium">
                                            ⏱ {{ $service->duration ?? 30 }} phút
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right font-serif-luxury text-sm font-bold text-[#063B30] whitespace-nowrap">
                                        {{ number_format($service->price, 0, ',', '.') }} đ
                                    </td>
                                    <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                        <a href="{{ route('public.booking', ['service_id' => $service->id]) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] text-xs font-bold transition shadow-2xs">
                                            Đặt lịch ngay
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 text-xs">
                                        Danh mục dịch vụ đang được cập nhật. Vui lòng liên hệ Hotline 1900 6868 để được tư vấn trực tiếp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-[#FBF9F5] px-6 py-3.5 border-t border-[#EAE5DD] flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
                    <div>
                        💡 <strong>Lưu ý:</strong> Bảng giá đã bao gồm tư vấn chuyên khoa tại Private Lounge. Thuế VAT 10% áp dụng theo quy định hiện hành.
                    </div>
                    <a href="tel:19006868" class="font-bold text-[#063B30] hover:underline">Cần tư vấn báo giá chi tiết? Gọi Hotline 1900 6868 &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
