@extends('layouts.public')

@section('content')
<!-- Hero Cẩm Nang Nha Khoa -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Góc Chuyên Gia Răng Hàm Mặt
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Kiến Thức <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Chăm Sóc Răng Miệng</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
            Tổng hợp kiến thức nha khoa chuẩn Y khoa được biên soạn và kiểm duyệt bởi đội ngũ Bác sĩ Nha Khoa Smile.
        </p>
    </div>
</section>

@php
    $articles = [
        [
            'id' => 1,
            'category' => 'Chăm sóc hằng ngày',
            'title' => 'Quy tắc chải răng Bass cải biên & Sử dụng chỉ nha khoa đúng cách',
            'read_time' => '5 phút đọc',
            'service_slug' => 'lay-cao-rang',
            'img' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Chải răng ngang làm mòn cổ răng tới 60%. Bác sĩ hướng dẫn đặt bàn chải nghiêng 45 độ về phía viền nướu và kết hợp máy tăm nước để sạch mảng bám kẽ răng.',
            'content' => 'Thói quen kéo bàn chải theo chiều ngang với lực mạnh là nguyên nhân chính dẫn đến tình trạng tụt nướu và khuyết cổ răng hình chêm gây ê buốt kéo dài. Phương pháp chải răng Bass cải biên được Hiệp hội Nha khoa Quốc tế khuyến nghị gồm 3 bước: (1) Đặt lông bàn chải nghiêng góc 45 độ ngay viền nướu; (2) Rung nhẹ tại chỗ 5-10 lần rồi hất nhẹ về phía mặt nhai; (3) Kết hợp chỉ nha khoa hoặc máy tăm nước làm sạch vùng kẽ răng trước khi đánh răng buổi tối.',
            'tips' => ['Đánh răng ít nhất 2 lần/ngày, mỗi lần 2 phút', 'Thay bàn chải lông mềm mỗi 3 tháng', 'Dùng chỉ nha khoa trước khi đánh răng buổi tối']
        ],
        [
            'id' => 2,
            'category' => 'Tiểu phẫu Răng khôn',
            'title' => '5 Dấu hiệu cảnh báo răng khôn (răng số 8) mọc lệch cần xử lý sớm',
            'read_time' => '6 phút đọc',
            'service_slug' => 'nho-rang-khon',
            'img' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Răng số 8 mọc ngầm đâm ngang vào răng số 7 là nguyên nhân hàng đầu gây sâu mặt xa răng số 7, viêm lợi trùm tái phát và tiêu xương ổ răng.',
            'content' => 'Răng khôn thường mọc ở độ tuổi 18-25 khi xương hàm đã cứng chắc và không còn đủ khoảng trống. Nếu gặp các triệu chứng như: đau nhức vùng góc hàm tái đi tái lại, sưng lợi trùm có dịch mủ, thức ăn nhồi nhét giữa răng số 7 và số 8, hoặc cứng hàm khó há miệng, bạn cần chụp phim X-quang ConeBeam CT 3D ngay. Công nghệ nhổ răng bằng sóng siêu âm Piezotome tại Nha Khoa Smile giúp tách dây chằng nhẹ nhàng, bảo tồn mô mềm và lành thương nhanh.',
            'tips' => ['Chụp phim X-quang Panorex/CT 3D kiểm tra hướng mọc', 'Nhổ răng bằng sóng siêu âm Piezotome giảm sưng đau', 'Chườm lạnh 24h đầu sau khi tiểu phẫu']
        ],
        [
            'id' => 3,
            'category' => 'Phục hình Implant',
            'title' => 'Tại sao mất răng lâu ngày dẫn đến tiêu xương hàm và lão hóa sớm?',
            'read_time' => '7 phút đọc',
            'service_slug' => 'implant-chuyen-sau',
            'img' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Khi mất chân răng, xương hàm không còn lực nhai kích thích sẽ tiêu dần từ 25-40% thể tích chỉ trong năm đầu tiên, khiến má hóp và các răng kế cận xô lệch.',
            'content' => 'Cầu răng sứ hay hàm giả tháo lắp chỉ khôi phục phần thân răng phía trên nướu mà không thay thế được chân răng đã mất, do đó quá trình tiêu xương hàm vẫn tiếp diễn ngầm bên dưới. Cấy ghép trụ Implant Titanium nguyên chất giúp tích hợp xương sinh học vững chắc, truyền lực nhai tự nhiên xuống xương hàm, ngăn chặn triệt để hiện tượng tiêu xương và giữ vững cấu trúc khuôn mặt.',
            'tips' => ['Cấy ghép trụ Implant Titanium thay thế chân răng đã mất', 'Bảo tồn răng kế cận, không cần mài răng như cầu răng sứ', 'Tuổi thọ trụ Implant lên đến trọn đời nếu vệ sinh tốt']
        ],
        [
            'id' => 4,
            'category' => 'Chỉnh nha - Niềng răng',
            'title' => 'Độ tuổi vàng để tầm soát và can thiệp chỉnh nha cho trẻ em & người lớn',
            'read_time' => '5 phút đọc',
            'service_slug' => 'nieng-rang',
            'img' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Giai đoạn từ 7 - 12 tuổi khi trẻ đang thay răng hỗn hợp là thời điểm lý tưởng để định hướng xương hàm, giúp rút ngắn thời gian niềng răng và hạn chế nhổ răng.',
            'content' => 'Việc khám tầm soát chỉnh nha sớm giúp Bác sĩ phát hiện kịp thời các thói quen xấu (thở miệng, đẩy lưỡi, mút tay) và sự bất hài hòa giữa xương hàm trên - hàm dưới. Đối với người trưởng thành, các khí cụ hiện đại như mắc cài tự buộc thông minh và khay niềng trong suốt Invisalign vẫn mang lại kết quả dịch chuyển răng chính xác, thẩm mỹ cao và ít đau nhức.',
            'tips' => ['Khám tầm soát chỉnh nha lần đầu từ 6 - 7 tuổi', 'Người trưởng thành vẫn niềng răng hiệu quả với mắc cài tự buộc hoặc Invisalign', 'Đeo hàm duy trì đúng chỉ định sau tháo niềng']
        ],
        [
            'id' => 5,
            'category' => 'Nha khoa phòng ngừa',
            'title' => 'Vôi răng hình thành như thế nào? Vì sao cần cạo vôi răng định kỳ 6 tháng?',
            'read_time' => '4 phút đọc',
            'service_slug' => 'lay-cao-rang',
            'img' => 'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Mảng bám thức ăn sau 48 giờ không được làm sạch sẽ vôi hóa bởi khoáng chất trong nước bọt tạo thành cao răng cứng chắc mà bàn chải thường không thể lấy đi.',
            'content' => 'Cao răng (vôi răng) là nơi trú ngụ của hàng triệu vi khuẩn gây viêm nướu, chảy máu chân răng khi đánh răng và hơi thở có mùi. Lấy cao răng bằng đầu rung siêu âm hiện đại chỉ tác động làm bong mảng vôi cứng mà hoàn toàn không làm mòn men răng như nhiều người lầm tưởng.',
            'tips' => ['Cạo vôi răng định kỳ 6 tháng/lần', 'Loại bỏ nguyên nhân gây chảy máu chân răng & hôi miệng', 'Phát hiện sớm các lỗ sâu răng mới chớm']
        ],
        [
            'id' => 6,
            'category' => 'Răng sứ thẩm mỹ',
            'title' => 'Phân biệt Dán sứ Veneer siêu mỏng và Bọc mão răng sứ toàn phần',
            'read_time' => '6 phút đọc',
            'service_slug' => 'rang-su-chuyen-sau',
            'img' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Mặt dán sứ Veneer chỉ dày 0.3 - 0.5mm phù hợp cho răng thưa nhẹ, nhiễm màu kháng sinh; trong khi bọc mão sứ giúp bảo vệ tối ưu răng đã điều trị tủy hoặc vỡ lớn.',
            'content' => 'Tùy vào tình trạng men răng và khớp cắn thực tế, Bác sĩ sẽ chỉ định phương pháp bảo tồn tối đa mô răng thật. Mặt dán sứ Veneer chỉ xử lý bề mặt ngoài siêu mỏng, không xâm lấn tủy răng; trong khi mão răng sứ toàn sứ (Cercon HT, Emax, Lava Plus) ôm trọn 360 độ giúp phục hồi chức năng ăn nhai cho răng bị mẻ lớn hoặc sau điều trị nội nha.',
            'tips' => ['Ưu tiên bảo tồn tủy răng gốc tối đa', 'Chọn phôi sứ chính hãng Emax, Cercon HT, Lava Plus', 'Tái khám kiểm tra khớp cắn định kỳ']
        ],
    ];
    $categories = ['Tất cả', 'Chăm sóc hằng ngày', 'Tiểu phẫu Răng khôn', 'Phục hình Implant', 'Chỉnh nha - Niềng răng', 'Nha khoa phòng ngừa', 'Răng sứ thẩm mỹ'];
@endphp

<!-- Bài viết chuyên môn + Bộ lọc + Modal đọc bài viết -->
<section class="py-16 bg-slate-50" x-data="{ activeCat: 'Tất cả', activeArticle: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Bộ lọc chuyên mục -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            @foreach($categories as $cat)
                <button type="button"
                    @click="activeCat = '{{ $cat }}'"
                    :class="activeCat === '{{ $cat }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-white text-slate-600 hover:bg-blue-50 hover:text-blue-600 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-extrabold transition">
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $art)
                <article x-show="activeCat === 'Tất cả' || activeCat === '{{ $art['category'] }}'"
                    x-transition
                    class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative h-52 overflow-hidden cursor-pointer" @click="activeArticle = {{ json_encode($art) }}">
                        <img src="{{ $art['img'] }}" alt="{{ $art['title'] }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-600 text-white shadow">
                            {{ $art['category'] }}
                        </span>
                        <span class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-900/80 text-white">
                            ⏱ {{ $art['read_time'] }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 @click="activeArticle = {{ json_encode($art) }}" class="text-lg font-black text-slate-900 hover:text-blue-600 cursor-pointer transition mb-2 leading-snug">
                                {{ $art['title'] }}
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-4">
                                {{ $art['excerpt'] }}
                            </p>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-1.5 mb-4">
                                <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">💡 Lời khuyên từ Bác sĩ:</p>
                                @foreach($art['tips'] as $tip)
                                    <div class="flex items-start gap-2 text-xs text-slate-600">
                                        <span class="text-emerald-600 font-bold">✓</span>
                                        <span>{{ $tip }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <button type="button" @click="activeArticle = {{ json_encode($art) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-extrabold transition">
                                📖 Đọc chi tiết bài viết
                            </button>
                            <a href="{{ route('public.service.detail', $art['service_slug']) }}" class="text-xs font-extrabold text-blue-600 hover:text-blue-700">
                                Xem dịch vụ →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Modal đọc chi tiết bài viết -->
        <div x-show="activeArticle !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-xs" @keydown.escape.window="activeArticle = null">
            <div @click.away="activeArticle = null" class="bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl border border-slate-200 max-h-[88vh] flex flex-col">
                <template x-if="activeArticle">
                    <div class="overflow-y-auto">
                        <div class="relative h-56">
                            <img :src="activeArticle.img" :alt="activeArticle.title" class="w-full h-full object-cover">
                            <button type="button" @click="activeArticle = null" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-900/75 hover:bg-slate-900 text-white font-bold flex items-center justify-center">✕</button>
                            <span class="absolute bottom-4 left-6 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-600 text-white" x-text="activeArticle.category"></span>
                        </div>
                        <div class="p-6 sm:p-8 space-y-4">
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug" x-text="activeArticle.title"></h3>
                            <p class="text-xs font-semibold text-slate-400">Biên soạn & Kiểm duyệt: Hội đồng Bác sĩ Chuyên khoa Nha Khoa Smile • <span x-text="activeArticle.read_time"></span></p>
                            <p class="text-sm text-slate-700 leading-relaxed font-medium" x-text="activeArticle.excerpt"></p>
                            <p class="text-sm text-slate-600 leading-relaxed" x-text="activeArticle.content"></p>

                            <div class="bg-blue-50/70 rounded-2xl p-4 border border-blue-100 space-y-1.5">
                                <p class="text-xs font-extrabold text-blue-900 uppercase tracking-wider mb-1">📌 Ghi nhớ quan trọng:</p>
                                <template x-for="tip in activeArticle.tips" :key="tip">
                                    <div class="flex items-start gap-2 text-xs text-blue-900">
                                        <span class="text-emerald-600 font-bold">✓</span>
                                        <span x-text="tip"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                                <button type="button" @click="activeArticle = null" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">Đóng cửa sổ</button>
                                <a href="{{ route('public.booking') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow">
                                    📅 Đặt lịch khám & Tư vấn trực tiếp →
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Câu hỏi thường gặp (FAQ) -->
        <div class="mt-16 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-sm">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Giải đáp nhanh</span>
                <h2 class="text-2xl font-black text-slate-900 mt-3">Câu Hỏi Thường Gặp Khi Đi Khám Nha Khoa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <h4 class="font-extrabold text-slate-900 text-sm mb-2">1. Tôi muốn khám ngay hôm nay có cần đặt lịch trên web không?</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Hệ thống đặt lịch trực tuyến nhận lịch hẹn từ <strong>ngày mai trở đi</strong> để phòng khám sắp xếp trước ghế máy. Nếu bạn cần khám ngay trong ngày hôm nay, vui lòng đến trực tiếp phòng khám (08:00 - 20:00) để Lễ tân tiếp đón ngay.
                    </p>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <h4 class="font-extrabold text-slate-900 text-sm mb-2">2. Chi phí thuốc uống sau khi nhổ răng/điều trị được tính thế nào?</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Sau khi khám, nếu Bác sĩ kê đơn thuốc, hệ thống sẽ tự động bóc tách <strong>Tiền dịch vụ khám</strong> và <strong>Tiền thuốc kèm theo</strong> hoàn toàn minh bạch trên hóa đơn thanh toán.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
