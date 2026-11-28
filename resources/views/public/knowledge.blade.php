@extends('layouts.public')

@section('title', 'Kiến Thức & Cẩm Nang Nha Khoa - ' . $clinicSettings['clinic_name'])

@section('content')
<!-- Hero Cẩm Nang Nha Khoa -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Góc Chuyên Gia {{ $clinicSettings['clinic_name'] }}</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Kiến Thức <span class="italic font-normal text-[#E6D5B8]">Chăm Sóc Răng Miệng</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Tổng hợp cẩm nang chăm sóc răng miệng và phương pháp thẩm mỹ nụ cười chuẩn Y khoa, được biên soạn bởi Đội ngũ Bác sĩ {{ $clinicSettings['clinic_name'] }}.
        </p>
    </div>
</section>

@php
    $articles = [
        [
            'id' => 1,
            'category' => 'Thẩm mỹ nụ cười',
            'title' => 'Dán Sứ Veneer Emax: Tỷ Lệ Vàng Giúp Nụ Cười Đẹp Tự Nhiên Không Mài Răng',
            'read_time' => '5 phút đọc',
            'service_slug' => 'rang-su-chuyen-sau',
            'img' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Công nghệ siêu mỏng 0.2mm giúp bảo tồn tối đa 100% men răng thật, màu sắc trong bóng tự nhiên và độ bền chịu lực gấp 4 lần răng sinh học.',
            'content' => 'Khác với phương pháp bọc răng sứ truyền thống cần mài nhỏ mô răng, dán sứ Veneer Emax thủy tinh Thụy Sĩ áp dụng kỹ thuật vi phẫu dán mặt ngoài với độ dày siêu mỏng chỉ 0.2 - 0.3mm. Răng gốc được bảo tồn nguyên vẹn tủy và men răng, không gây ê buốt và mang lại độ trong mờ tự nhiên chuẩn mỹ thuật.',
            'tips' => ['Bảo tồn men răng gốc 100%', 'Độ bền sinh học trọn đời', 'Form răng cá nhân hóa theo đường cười']
        ],
        [
            'id' => 2,
            'category' => 'Cấy Ghép Implant',
            'title' => 'Implant Straumann Thụy Sĩ: Đỉnh Cao Phục Hình Răng Mất Vĩnh Viễn',
            'read_time' => '6 phút đọc',
            'service_slug' => 'implant-chuyen-sau',
            'img' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Trụ kim cương sinh học Straumann với bề mặt SLActive rút ngắn thời gian tích hợp xương từ 3 tháng xuống chỉ còn 3-4 tuần, ăn nhai như răng thật.',
            'content' => 'Straumann là dòng trụ Implant số 1 thế giới đến từ Thụy Sĩ. Nhờ hợp kim Roxolid siêu bền và công nghệ xử lý bề mặt kháng nước SLActive, trụ kích thích tế bào tạo xương bám nhanh chóng ngay cả trên cơ địa xương hàm xốp hoặc lớn tuổi.',
            'tips' => ['Tích hợp xương cấp tốc trong 3-4 tuần', 'Bảo hành điện tử toàn cầu trọn đời', 'Phòng phẫu thuật vô trùng áp lực dương']
        ],
        [
            'id' => 3,
            'category' => 'Chỉnh nha vô hình',
            'title' => 'Niềng Răng Invisalign Diamond: Bí Quyết Nụ Cười Tỏa Sáng Mà Không Ai Nhận Ra',
            'read_time' => '7 phút đọc',
            'service_slug' => 'nieng-rang',
            'img' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Khay niềng SmartTrack trong suốt độc quyền ôm sát thân răng, tháo lắp linh hoạt khi ăn uống và xem trước kết quả bằng phần mềm 3D ClinCheck.',
            'content' => 'Invisalign là giải pháp chỉnh nha đỉnh cao dành cho doanh nhân, người của công chúng và khách hàng đòi hỏi sự tinh tế tuyệt đối trong giao tiếp. Không dây cung, không mắc cài vướng víu, khay niềng dịch chuyển răng êm ái từng micromet.',
            'tips' => ['Tháo lắp tự do khi dùng bữa và dự tiệc', 'Xem trước nụ cười tương lai trên 3D', 'Thời gian tái khám linh hoạt 6-8 tuần/lần']
        ],
    ];
@endphp

<section class="py-12 sm:py-16 bg-[#FBF9F5]" x-data="{ selectedArticle: null }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($articles as $art)
                <div class="bg-white rounded-3xl overflow-hidden border border-[#EAE5DD] shadow-xs hover:border-[#063B30] hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-48 overflow-hidden bg-slate-100 cursor-pointer" @click="selectedArticle = {{ json_encode($art) }}">
                            <img src="{{ $art['img'] }}" alt="{{ $art['title'] }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#063B30]/90 text-[#E6D5B8] border border-[#C5A880]/30 shadow">
                                {{ $art['category'] }}
                            </span>
                        </div>
                        <div class="p-5 space-y-2">
                            <div class="text-[10px] text-slate-400 font-medium">⏱ {{ $art['read_time'] }}</div>
                            <h3 @click="selectedArticle = {{ json_encode($art) }}" class="font-serif-luxury text-base font-bold text-slate-900 hover:text-[#063B30] cursor-pointer transition leading-snug">
                                {{ $art['title'] }}
                            </h3>
                            <p class="text-xs text-slate-500 font-light leading-relaxed">
                                {{ $art['excerpt'] }}
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="selectedArticle = {{ json_encode($art) }}" class="text-xs font-bold text-[#063B30] hover:underline">
                                Đọc chi tiết &rarr;
                            </button>
                            <a href="{{ route('public.booking') }}" class="px-3 py-1 bg-[#EBF4F0] text-[#063B30] rounded-xl text-xs font-bold hover:bg-[#063B30] hover:text-white transition">
                                Đặt lịch tư vấn
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Bài viết -->
        <div x-show="selectedArticle !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs" @keydown.escape.window="selectedArticle = null">
            <div @click.away="selectedArticle = null" class="bg-white rounded-3xl max-w-2xl w-full max-h-[85vh] overflow-y-auto shadow-2xl border border-[#EAE5DD] p-6 sm:p-8 space-y-4">
                <template x-if="selectedArticle">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#063B30] text-[#E6D5B8]" x-text="selectedArticle.category"></span>
                            <button type="button" @click="selectedArticle = null" class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs">✕</button>
                        </div>
                        <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-slate-900" x-text="selectedArticle.title"></h2>
                        <img :src="selectedArticle.img" :alt="selectedArticle.title" class="w-full h-56 object-cover rounded-2xl">
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light" x-text="selectedArticle.content"></p>
                        <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD] space-y-1.5">
                            <div class="font-bold text-xs text-[#063B30]">💡 Lời khuyên từ Bác sĩ Nghệ nhân:</div>
                            <ul class="space-y-1 text-xs text-slate-600 font-light list-disc list-inside">
                                <template x-for="tip in selectedArticle.tips">
                                    <li x-text="tip"></li>
                                </template>
                            </ul>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                            <button type="button" @click="selectedArticle = null" class="px-4 py-2 rounded-xl bg-slate-100 text-xs font-bold">Đóng</button>
                            <a href="{{ route('public.booking') }}" class="px-5 py-2 rounded-xl bg-[#063B30] text-[#FDFBF7] text-xs font-bold hover:bg-[#042A22] transition shadow-xs">
                                📅 Đặt lịch khám ưu tiên
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>
@endsection
