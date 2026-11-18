@extends('layouts.public')

@section('content')
<!-- Hero Đội ngũ Bác sĩ -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Chuyên gia Răng Hàm Mặt
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Đội Ngũ <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Bác Sĩ Chuyên Khoa</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
            100% Bác sĩ tại Nha Khoa Smile tốt nghiệp chính quy chuyên ngành Răng Hàm Mặt, sở hữu chứng chỉ hành nghề và tận tâm trong từng ca điều trị.
        </p>
    </div>
</section>

<!-- Danh sách Bác sĩ + Modal Hồ Sơ Chuyên Gia -->
<section class="py-16 lg:py-20 bg-slate-50" x-data="{ selectedDoc: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $doctorImages = [
                'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=700&q=85',
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($doctors as $index => $doctor)
                @php
                    $docName = $doctor->user->name ?? 'Bác sĩ Chuyên khoa';
                    $docSpecialty = $doctor->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                    $docExp = $doctor->experience_years ?? (8 + ($index * 2));
                    $docBio = $doctor->bio ?: 'Chuyên gia điều trị phục hình thẩm mỹ, cấy ghép Implant và nha khoa tổng quát không đau chuẩn Y khoa.';
                    $docImg = $doctorImages[$index % count($doctorImages)];
                    $docPayload = [
                        'id' => $doctor->id,
                        'name' => 'BS. ' . $docName,
                        'spec' => $docSpecialty,
                        'exp' => $docExp,
                        'bio' => $docBio,
                        'img' => $docImg,
                        'booking_url' => route('public.booking', ['doctor_id' => $doctor->id]),
                    ];
                @endphp
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative h-72 overflow-hidden bg-slate-100 cursor-pointer" @click="selectedDoc = {{ json_encode($docPayload) }}">
                        <img src="{{ $docImg }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top hover:scale-105 transition duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-600/95 text-white shadow">
                                {{ $docSpecialty }}
                            </span>
                        </div>
                        <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur px-3 py-1 rounded-xl text-xs font-extrabold text-slate-800 shadow">
                            ⭐ {{ $docExp }}+ năm kinh nghiệm
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 @click="selectedDoc = {{ json_encode($docPayload) }}" class="text-xl font-black text-slate-900 hover:text-blue-600 cursor-pointer transition mb-1">BS. {{ $docName }}</h3>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">{{ $docSpecialty }}</p>
                            <p class="text-sm text-slate-600 leading-relaxed mb-5">
                                {{ $docBio }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                            <button type="button" @click="selectedDoc = {{ json_encode($docPayload) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold transition">
                                🩺 Xem hồ sơ
                            </button>
                            <a href="{{ route('public.booking', ['doctor_id' => $doctor->id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-xs transition">
                                Đặt lịch với Bác sĩ
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $fallbackDoctors = [
                        ['id' => '', 'name' => 'BS.CKII Nguyễn Minh Hoàng', 'spec' => 'Chuyên gia Cấy ghép Implant', 'exp' => 15, 'img' => $doctorImages[0], 'bio' => 'Tốt nghiệp Bác sĩ Chuyên khoa II ĐH Y Dược, hơn 3.000 ca cấy ghép Implant toàn hàm All-on-4/All-on-6 thành công.', 'booking_url' => route('public.booking')],
                        ['id' => '', 'name' => 'ThS.BS Trần Thanh Thảo', 'spec' => 'Chuyên gia Chỉnh nha - Niềng răng', 'exp' => 11, 'img' => $doctorImages[1], 'bio' => 'Chứng chỉ chỉnh nha khay trong suốt Invisalign quốc tế, kiến tạo khớp cắn chuẩn cho hơn 2.500 khách hàng.', 'booking_url' => route('public.booking')],
                        ['id' => '', 'name' => 'BS.CKI Lê Quốc Bảo', 'spec' => 'Phục hình Răng sứ Thẩm mỹ', 'exp' => 10, 'img' => $doctorImages[2], 'bio' => 'Chuyên sâu thiết kế nụ cười kỹ thuật số DSD, dán sứ Veneer siêu mỏng bảo tồn tối đa mô răng thật.', 'booking_url' => route('public.booking')],
                    ];
                @endphp
                @foreach($fallbackDoctors as $doc)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                        <div class="relative h-72 overflow-hidden bg-slate-100 cursor-pointer" @click="selectedDoc = {{ json_encode($doc) }}">
                            <img src="{{ $doc['img'] }}" alt="{{ $doc['name'] }}" class="w-full h-full object-cover object-top">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-blue-600 text-white shadow">{{ $doc['spec'] }}</span>
                            </div>
                            <div class="absolute bottom-3 right-3 bg-white/95 px-3 py-1 rounded-xl text-xs font-extrabold text-slate-800 shadow">
                                ⭐ {{ $doc['exp'] }}+ năm kinh nghiệm
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 @click="selectedDoc = {{ json_encode($doc) }}" class="text-xl font-black text-slate-900 hover:text-blue-600 cursor-pointer mb-1">{{ $doc['name'] }}</h3>
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3">{{ $doc['spec'] }}</p>
                                <p class="text-sm text-slate-600 leading-relaxed mb-5">{{ $doc['bio'] }}</p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                                <button type="button" @click="selectedDoc = {{ json_encode($doc) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold transition">
                                    🩺 Xem hồ sơ
                                </button>
                                <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold transition">
                                    Đặt lịch với Bác sĩ →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

        <!-- Modal Hồ sơ Bác sĩ Chuyên khoa -->
        <div x-show="selectedDoc !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-xs" @keydown.escape.window="selectedDoc = null">
            <div @click.away="selectedDoc = null" class="bg-white rounded-3xl max-w-xl w-full overflow-hidden shadow-2xl border border-slate-200">
                <template x-if="selectedDoc">
                    <div>
                        <div class="flex items-center gap-5 p-6 bg-gradient-to-r from-slate-900 to-blue-950 text-white relative">
                            <img :src="selectedDoc.img" :alt="selectedDoc.name" class="w-20 h-20 rounded-2xl object-cover object-top border-2 border-white/30 shrink-0">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-blue-500/30 border border-blue-400/40 text-blue-200" x-text="selectedDoc.spec"></span>
                                <h3 class="text-xl font-black mt-1" x-text="selectedDoc.name"></h3>
                                <p class="text-xs text-slate-300 mt-0.5">⭐ <span x-text="selectedDoc.exp"></span>+ năm kinh nghiệm lâm sàng</p>
                            </div>
                            <button type="button" @click="selectedDoc = null" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold flex items-center justify-center">✕</button>
                        </div>

                        <div class="p-6 space-y-4 text-sm text-slate-600">
                            <div>
                                <p class="text-xs font-extrabold uppercase text-slate-400 mb-1">Giới thiệu chuyên môn</p>
                                <p class="leading-relaxed text-slate-700" x-text="selectedDoc.bio"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs">
                                <div>
                                    <span class="text-slate-400 font-bold block">Đào tạo & Bằng cấp</span>
                                    <span class="font-extrabold text-slate-800">Đại học Y Dược • CCHN Quốc gia</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block">Lịch làm việc tại phòng khám</span>
                                    <span class="font-extrabold text-emerald-700">08:00 - 20:00 (Thứ 2 - CN)</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                                <button type="button" @click="selectedDoc = null" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">Đóng</button>
                                <a :href="selectedDoc.booking_url" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow">
                                    📅 Đặt lịch khám với Bác sĩ này →
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Tiêu chuẩn tuyển chọn bác sĩ -->
        <div class="mt-16 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600">Hội đồng chuyên môn</span>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">Tiêu Chuẩn Đội Ngũ Y Bác Sĩ</h3>
                    <p class="text-sm text-slate-600 mt-2">Mỗi ca lâm sàng phức tạp đều được hội chẩn chuyên khoa kỹ lưỡng nhằm đảm bảo an toàn và hiệu quả lâu dài.</p>
                </div>
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="font-extrabold text-slate-900 text-sm mb-1">🎓 Đào tạo chính quy</div>
                        <p class="text-xs text-slate-500">100% tốt nghiệp Đại học Y Dược chuyên ngành Răng Hàm Mặt.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="font-extrabold text-slate-900 text-sm mb-1">🔬 Chuyên môn hóa sâu</div>
                        <p class="text-xs text-slate-500">Mỗi bác sĩ phụ trách chuyên biệt Implant, Chỉnh nha hoặc Nội nha.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="font-extrabold text-slate-900 text-sm mb-1">💙 Tận tâm & Êm ái</div>
                        <p class="text-xs text-slate-500">Luôn lắng nghe, giải thích rõ phác đồ và chi phí trước khi điều trị.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
