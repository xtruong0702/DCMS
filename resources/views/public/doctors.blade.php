@extends('layouts.public')

@section('title', 'Đội Ngũ Bác Sĩ Chuyên Khoa - Nha Khoa Smile')

@section('content')
<div class="bg-[#effcf9]" x-data="{
    selectedDoc: null,
    activeFilter: 'all',
    matchesFilter(spec, name) {
        if (this.activeFilter === 'all') return true;
        const text = (spec + ' ' + name).toLowerCase();
        if (this.activeFilter === 'su') return /sứ|veneer|phục hình/.test(text);
        if (this.activeFilter === 'implant') return /implant|cấy ghép|xương hàm/.test(text);
        if (this.activeFilter === 'nieng') return /chỉnh nha|niềng|invisalign|trẻ em/.test(text);
        if (this.activeFilter === 'tieuphau') return /tiểu phẫu|răng khôn|nha chu|phẫu thuật/.test(text);
        return true;
    }
}">

    <!-- 1. HERO ĐỘI NGŨ BÁC SĨ + BỘ LỌC CHUYÊN KHOA (CENTERED STITCH LAYOUT) -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#effcf9] via-white to-[#effcf9] pt-12 pb-12 sm:pt-16 sm:pb-14">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[560px] h-[260px] bg-[#d4af37]/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-5">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-[#0f3e36] text-[11px] font-bold uppercase tracking-widest shadow-sm border border-[#d4af37]/30">
                <span class="text-[#d4af37]">✦</span>
                <span>Hội Đồng Chuyên Môn Răng Hàm Mặt</span>
                <span class="text-[#d4af37]">✦</span>
            </div>

            <h1 class="font-heading-clinic !text-3xl sm:!text-4xl lg:!text-5xl font-extrabold tracking-tight text-[#0f3e36]">
                Đội Ngũ Bác Sĩ <span class="text-clinic-gradient">Nha Khoa Smile</span>
            </h1>

            <p class="text-slate-600 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                Hội tụ đội ngũ bác sĩ chuyên khoa giàu kinh nghiệm tốt nghiệp Đại học Y Dược, tu nghiệp chuyên sâu trong và ngoài nước, tận tâm vì sức khỏe răng miệng của từng bệnh nhân.
            </p>

            <!-- Bộ Lọc Chuyên Khoa Tương Tác (Matching Stitch Pills) -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-2">
                @foreach([
                    'all' => 'Tất cả chuyên gia (' . $doctors->count() . ')',
                    'su' => 'Răng sứ & Veneer',
                    'implant' => 'Cấy ghép Implant',
                    'nieng' => 'Chỉnh nha Invisalign',
                    'tieuphau' => 'Tiểu phẫu & Nha chu',
                ] as $key => $label)
                    <button type="button" @click="activeFilter = '{{ $key }}'"
                        :class="activeFilter === '{{ $key }}' ? 'gold-btn-shimmer shadow-md' : 'bg-white text-slate-600 hover:bg-teal-50 hover:text-[#0f3e36] border border-slate-200/40'"
                        class="px-4 py-2 rounded-full text-xs font-bold transition">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 2. LƯỚI 3x2 THẺ BÁC SĨ CHUYÊN KHOA + THẺ HỘI ĐỒNG HỘI CHẨN -->
    <section class="py-10 sm:py-14 bg-[#effcf9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            @php
                $doctorImages = [
                    'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=700&q=85',
                    'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=700&q=85',
                    'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=700&q=85',
                    'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=700&q=85',
                    'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=700&q=85',
                ];
                $doctorCredentials = [
                    ['edu' => 'ĐH Y Dược', 'tags' => ['Veneer 0.2mm', 'Toàn sứ Cercon', 'Phục hình 3D']],
                    ['edu' => 'ĐH Geneva, Thụy Sĩ', 'tags' => ['Implant Straumann', 'All-on-4/6', 'CT ConeBeam']],
                    ['edu' => 'ĐH Frankfurt, Đức', 'tags' => ['Invisalign Diamond', 'ClinCheck 3D', 'Khớp cắn chuẩn']],
                    ['edu' => 'ĐH Y Hà Nội', 'tags' => ['Invisalign Platinum', 'Chỉnh nha trẻ em', 'Tiền chỉnh nha']],
                    ['edu' => 'Chuyên khoa I', 'tags' => ['Piezotome 0 Đau', 'Răng khôn ngầm', 'Nha chu']],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($doctors as $index => $doctor)
                    @php
                        $rawDocName = trim($doctor->user->name ?? 'Bác sĩ Chuyên khoa');
                        $docName = preg_match('/^(BS|TS|ThS|PGS|GS)\b/iu', $rawDocName) ? $rawDocName : 'BS. ' . $rawDocName;
                        $docSpecialty = $doctor->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                        $docExp = $doctor->experience_years ?? (10 + (($index % 4) * 2));
                        $docBio = $doctor->description ?: ($doctor->bio ?: 'Chuyên gia điều trị răng hàm mặt chuẩn y khoa, ưu tiên bảo tồn răng thật và tư vấn tận tâm.');
                        $docImg = $doctorImages[$index % count($doctorImages)];
                        $cred = $doctorCredentials[$index % count($doctorCredentials)];
                        $docPayload = [
                            'id' => $doctor->id,
                            'name' => $docName,
                            'spec' => $docSpecialty,
                            'exp' => $docExp,
                            'edu' => $cred['edu'],
                            'bio' => $docBio,
                            'tags' => $cred['tags'],
                            'img' => $docImg,
                            'booking_url' => route('public.booking', ['doctor_id' => $doctor->id]),
                        ];
                    @endphp
                    <div x-show="matchesFilter(@js($docSpecialty), @js($docName))"
                         class="clinic-card doctor-card rounded-2xl overflow-hidden flex flex-col justify-between img-zoom-container">
                        <div>
                            <!-- Ảnh chân dung + Badge kinh nghiệm & đào tạo -->
                            <div class="relative h-60 overflow-hidden bg-slate-100 cursor-pointer" @click="selectedDoc = {{ json_encode($docPayload) }}">
                                <img src="{{ $docImg }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"></div>
                                <div class="absolute bottom-3 left-3">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-black/65 backdrop-blur-md text-white">
                                        🎓 {{ $cred['edu'] }}
                                    </span>
                                </div>
                                <div class="absolute bottom-3 right-3">
                                    <span class="gold-shimmer-badge px-2.5 py-1 rounded-lg text-[10px] font-bold tabular-nums shadow-sm">
                                        ★ {{ $docExp }}+ Năm KN
                                    </span>
                                </div>
                            </div>

                            <!-- Nội dung chuyên môn + 3 Skill Tags -->
                            <div class="p-5 space-y-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#0f3e36]/75 truncate">{{ $docSpecialty }}</p>
                                    <h3 @click="selectedDoc = {{ json_encode($docPayload) }}" class="font-heading-clinic !text-lg font-bold text-[#0f3e36] hover:opacity-80 cursor-pointer transition mt-0.5">
                                        {{ $docName }}
                                    </h3>
                                </div>

                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $docBio }}
                                </p>

                                <!-- 3 Skill Tags (Matching Stitch Screen) -->
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    @foreach($cred['tags'] as $tag)
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-50 dark-inner-tile text-[10px] font-semibold text-slate-600">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- 2 Equal Buttons Row (Xem hồ sơ | Đặt lịch khám) -->
                        <div class="px-5 pb-5 pt-2 grid grid-cols-2 gap-2.5">
                            <button type="button" @click="selectedDoc = {{ json_encode($docPayload) }}"
                                class="btn-press py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition text-center">
                                Xem hồ sơ
                            </button>
                            <a href="{{ route('public.booking', ['doctor_id' => $doctor->id]) }}"
                                class="btn-press btn-clinic-primary py-2 px-3 rounded-xl text-xs font-bold text-center">
                                Đặt lịch khám
                            </a>
                        </div>
                    </div>
                @endforeach

                <!-- Thẻ thứ 6: Hội Đồng Hội Chẩn Chuyên Môn (Cân đối lưới 3x2 như ảnh mẫu) -->
                <div x-show="activeFilter === 'all'"
                     class="clinic-card rounded-2xl p-6 flex flex-col justify-between text-center">
                    <div class="my-auto py-6 space-y-4">
                        <div class="w-12 h-12 rounded-full bg-[#effcf9] text-[#d4af37] mx-auto flex items-center justify-center text-xl font-bold border border-[#d4af37]/40 shadow-sm">
                            +
                        </div>
                        <div class="space-y-1.5">
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-[#0f3e36]/75">Tư Vấn Trực Tiếp</span>
                            <h3 class="font-heading-clinic !text-xl font-bold text-[#0f3e36]">Hội Đồng Hội Chẩn Chuyên Môn</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-xs mx-auto">
                            Các ca lâm sàng phức tạp (trồng răng toàn hàm, chỉnh nha kết hợp phục hình) đều được hội chẩn trực tiếp bởi nhiều bác sĩ chuyên khoa để tìm phương án an toàn nhất.
                        </p>
                    </div>
                    <a href="#quick-doctor-booking" class="btn-press block w-full py-2.5 px-4 rounded-xl bg-[#effcf9] hover:bg-[#0f3e36] text-[#0f3e36] hover:text-white text-xs font-bold border border-[#d4af37]/30 transition">
                        Đăng ký hội chẩn miễn phí &rarr;
                    </a>
                </div>
            </div>

            <!-- Modal Hồ Sơ Chi Tiết Bác Sĩ -->
            <div x-show="selectedDoc !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm" @keydown.escape.window="selectedDoc = null">
                <div @click.away="selectedDoc = null" class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-200/40">
                    <template x-if="selectedDoc">
                        <div>
                            <div class="flex items-center gap-4 p-5 bg-teal-50/70 relative border-b border-slate-200/40">
                                <img :src="selectedDoc.img" :alt="selectedDoc.name" class="w-16 h-16 rounded-2xl object-cover object-top border-2 border-white shadow-sm shrink-0">
                                <div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white text-teal-800 border border-teal-500/15" x-text="selectedDoc.spec"></span>
                                    <h3 class="font-heading-clinic !text-lg font-bold mt-1 text-slate-900" x-text="selectedDoc.name"></h3>
                                    <p class="text-xs text-slate-600 tabular-nums">★ <span x-text="selectedDoc.exp"></span>+ năm kinh nghiệm • <span x-text="selectedDoc.edu"></span></p>
                                </div>
                                <button type="button" @click="selectedDoc = null" class="absolute top-4 right-4 w-7 h-7 rounded-full bg-white hover:bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs border border-slate-200/40">✕</button>
                            </div>

                            <div class="p-5 space-y-4 text-xs text-slate-600">
                                <div>
                                    <p class="text-[11px] font-bold uppercase text-teal-700 mb-1">Giới thiệu chuyên môn</p>
                                    <p class="leading-relaxed text-slate-700" x-text="selectedDoc.bio"></p>
                                </div>

                                <div class="grid grid-cols-2 gap-3 bg-slate-50 dark-inner-tile p-3.5 rounded-xl text-xs">
                                    <div>
                                        <span class="text-slate-500 block text-[10px]">Đào tạo & Tu nghiệp</span>
                                        <span class="font-bold text-slate-900" x-text="selectedDoc.edu"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px]">Hình thức khám</span>
                                        <span class="font-bold text-teal-800">1 Bác sĩ : 1 Ghế Riêng</span>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-100/70 flex items-center justify-end gap-2">
                                    <button type="button" @click="selectedDoc = null" class="btn-press px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold">Đóng</button>
                                    <a :href="selectedDoc.booking_url" class="btn-press btn-clinic-primary px-4 py-2 rounded-xl text-xs">
                                        📅 Đặt lịch khám với Bác sĩ này
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 3. TIÊU CHUẨN Y ĐỨC & TAY NGHỀ (HORIZONTAL SPLIT CARD MATCHING STITCH) -->
            <div class="clinic-card rounded-3xl p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    <div class="lg:col-span-4 space-y-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Hội Đồng Chuyên Môn</span>
                        <h2 class="font-heading-clinic !text-2xl font-bold text-[#0f3e36]">Tiêu Chuẩn Y Đức & Tay Nghề</h2>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Mỗi ca điều trị đều được thăm khám cẩn trọng, ưu tiên phác đồ bảo tồn răng thật tối đa và tối ưu chi phí cho bệnh nhân.
                        </p>
                    </div>
                    <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                            <div class="text-base">🎓</div>
                            <div class="font-bold text-[#0f3e36] text-xs">Đào Tạo Chính Quy</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">100% tốt nghiệp ĐH Y Dược, có chứng chỉ hành nghề và tu nghiệp chuyên sâu.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                            <div class="text-base">🦷</div>
                            <div class="font-bold text-[#0f3e36] text-xs">Bảo Tồn Răng Thật</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">Điều trị ít xâm lấn, đảm bảo khớp cắn chuẩn sinh học và thẩm mỹ tự nhiên.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1.5">
                            <div class="text-base">🛡️</div>
                            <div class="font-bold text-[#0f3e36] text-xs">Vô Trùng Chuẩn Bộ Y Tế</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">Kiểm soát nhiễm khuẩn khép kín, bảo mật hồ sơ bệnh án điện tử trọn đời.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. HỘI CHẨN LIÊN CHUYÊN KHOA 3 CHIỀU + ĐỐI TÁC & HIỆP HỘI Y KHOA -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-7 clinic-card rounded-3xl p-6 sm:p-8 space-y-5">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Quy Trình Chuyên Môn</span>
                        <h3 class="font-heading-clinic !text-xl sm:!text-2xl font-bold text-[#0f3e36]">Hội Chẩn Liên Chuyên Khoa 3 Chiều</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Với các ca phục hình toàn hàm, cấy ghép Implant phức tạp hoặc chỉnh nha kết hợp thẩm mỹ, hồ sơ bệnh nhân được hội chẩn trực tiếp bởi liên chuyên khoa trước khi lập phác đồ.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#d4af37]">BƯỚC 01</div>
                            <div class="text-xs font-bold text-[#0f3e36]">Phân Tích Phim 3D</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">Đánh giá mật độ xương, khớp cắn và đường cười trên phim CT ConeBeam.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#d4af37]">BƯỚC 02</div>
                            <div class="text-xs font-bold text-[#0f3e36]">Thống Nhất Phác Đồ</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">Hội đồng chuyên môn chọn giải pháp ít xâm lấn, tối ưu thời gian và chi phí.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark-inner-tile space-y-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#d4af37]">BƯỚC 03</div>
                            <div class="text-xs font-bold text-[#0f3e36]">Theo Dõi Trọn Đời</div>
                            <p class="text-[11px] text-slate-600 leading-relaxed">Bác sĩ chính trực tiếp thực hiện, lưu bệnh án DCMS và tái khám định kỳ.</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 clinic-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between space-y-5">
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Chứng Nhận Quốc Tế</span>
                        <h3 class="font-heading-clinic !text-xl font-bold text-[#0f3e36]">Đối Tác & Hiệp Hội Y Khoa</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Hợp tác vật liệu chính hãng và cập nhật liên tục công nghệ nha khoa tiên tiến trên thế giới:
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-xs font-bold text-slate-800">
                        <div class="p-3 rounded-xl bg-slate-50 dark-inner-tile text-center">🇨🇭 Straumann ITI</div>
                        <div class="p-3 rounded-xl bg-slate-50 dark-inner-tile text-center">🇺🇸 Invisalign Diamond</div>
                        <div class="p-3 rounded-xl bg-slate-50 dark-inner-tile text-center">🇩🇪 Ivoclar Vivadent</div>
                        <div class="p-3 rounded-xl bg-slate-50 dark-inner-tile text-center">🇪🇺 ESCD Châu Âu</div>
                    </div>
                    <a href="#quick-doctor-booking" class="btn-press gold-btn-shimmer w-full py-3 rounded-xl text-xs uppercase tracking-wider text-center shadow-md">
                        Đặt Lịch Thăm Khám Cùng Bác Sĩ
                    </a>
                </div>
            </div>

            <!-- 5. FORM ĐĂNG KÝ ĐẶT LỊCH NHANH 1 HÀNG (MATCHING BOTTOM OF STITCH SCREEN) -->
            <div id="quick-doctor-booking" class="clinic-card rounded-3xl p-6 sm:p-10 text-center space-y-6">
                <div class="space-y-1.5 max-w-xl mx-auto">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-teal-700">Đặt Hẹn Trực Tuyến</span>
                    <h2 class="font-heading-clinic !text-2xl sm:!text-3xl font-bold text-[#0f3e36]">Đăng Ký Đặt Lịch Khám Với Bác Sĩ</h2>
                    <p class="text-xs text-slate-600">
                        Chọn bác sĩ mong muốn và để lại số điện thoại để Lễ tân xác nhận khung giờ khám thuận tiện nhất cho bạn.
                    </p>
                </div>

                <form action="{{ route('public.booking.store') }}" method="POST" class="max-w-4xl mx-auto space-y-4">
                    @csrf
                    <input type="hidden" name="appointment_time" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 text-left">
                        <input type="text" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}"
                            placeholder="Họ và tên của bạn *"
                            class="input-clinic w-full rounded-xl px-4 py-3 text-xs">
                        <input type="text" name="phone" required value="{{ old('phone') }}"
                            placeholder="Số điện thoại di động *"
                            class="input-clinic w-full rounded-xl px-4 py-3 text-xs tabular-nums">
                        <select name="doctor_id" class="input-clinic w-full rounded-xl px-4 py-3 text-xs">
                            <option value="">-- Chọn Bác sĩ phụ trách --</option>
                            @foreach($doctors as $doc)
                                @php
                                    $rName = trim($doc->user->name ?? ('Bác sĩ #' . $doc->id));
                                    $dName = preg_match('/^(BS|TS|ThS|PGS|GS)\b/iu', $rName) ? $rName : 'BS. ' . $rName;
                                @endphp
                                <option value="{{ $doc->id }}">{{ $dName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn-press gold-btn-shimmer px-8 py-3 rounded-full text-xs uppercase tracking-wider shadow-lg">
                            Xác Nhận Đặt Lịch Khám &rarr;
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection
