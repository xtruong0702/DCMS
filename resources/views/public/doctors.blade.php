@extends('layouts.public')

@section('title', 'Đội Ngũ Bác Sĩ Chuyên Khoa - Nha Khoa Smile')

@section('content')
<!-- Hero Đội ngũ Bác sĩ -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Đội Ngũ Bác Sĩ Chuyên Khoa</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Đội Ngũ Bác Sĩ <span class="italic font-normal text-[#E6D5B8]">Nha Khoa Smile</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Hội tụ các chuyên gia giàu kinh nghiệm tốt nghiệp các trường Y khoa uy tín, tu nghiệp chuyên sâu trong và ngoài nước, mang triết lý điều trị chuẩn y khoa và tận tâm vì sức khỏe người bệnh.
        </p>
    </div>
</section>

<!-- Danh sách Bác sĩ + Modal Hồ Sơ Chuyên Gia -->
<section class="py-12 sm:py-16 bg-[#FBF9F5]" x-data="{ selectedDoc: null }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        @php
            $doctorImages = [
                'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=700&q=85',
                'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=700&q=85',
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($doctors as $index => $doctor)
                @php
                    $docName = $doctor->user->name ?? 'Bác sĩ Chuyên khoa';
                    $docSpecialty = $doctor->specialty ?: 'Chuyên khoa Nha khoa Thẩm mỹ';
                    $docExp = $doctor->experience_years ?? (10 + ($index * 2));
                    $docBio = $doctor->bio ?: 'Chuyên gia phục hình nụ cười, cấy ghép Implant và nha khoa thẩm mỹ cao cấp chuẩn tỷ lệ vàng khuôn mặt.';
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
                <div class="bg-white rounded-3xl overflow-hidden border border-[#EAE5DD] shadow-xs hover:border-[#063B30] hover:shadow-md transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="relative h-64 overflow-hidden bg-slate-100 cursor-pointer" @click="selectedDoc = {{ json_encode($docPayload) }}">
                            <img src="{{ $docImg }}" alt="{{ $docName }}" class="w-full h-full object-cover object-top hover:scale-105 transition duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#063B30]/90 text-[#E6D5B8] border border-[#C5A880]/30 shadow">
                                    {{ $docSpecialty }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur px-2.5 py-1 rounded-xl text-[10px] font-bold text-slate-800 shadow">
                                ⭐ {{ $docExp }}+ năm kinh nghiệm
                            </div>
                        </div>

                        <div class="p-5 space-y-2">
                            <h3 @click="selectedDoc = {{ json_encode($docPayload) }}" class="font-serif-luxury text-lg font-bold text-slate-900 hover:text-[#063B30] cursor-pointer transition">
                                BS. {{ $docName }}
                            </h3>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#A37F4E]">{{ $docSpecialty }}</p>
                            <p class="text-xs text-slate-500 font-light leading-relaxed">
                                {{ $docBio }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <button type="button" @click="selectedDoc = {{ json_encode($docPayload) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Xem tiểu sử
                            </button>
                            <a href="{{ route('public.booking', ['doctor_id' => $doctor->id]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] text-xs font-bold shadow-2xs transition">
                                <span>Đặt lịch</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-500 text-xs">
                    Đang cập nhật danh sách bác sĩ chuyên khoa.
                </div>
            @endforelse
        </div>

        <!-- Modal Hồ Sơ Bác Sĩ -->
        <div x-show="selectedDoc !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs" @keydown.escape.window="selectedDoc = null">
            <div @click.away="selectedDoc = null" class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-[#EAE5DD]">
                <template x-if="selectedDoc">
                    <div>
                        <div class="flex items-center gap-4 p-5 bg-[#063B30] text-white relative">
                            <img :src="selectedDoc.img" :alt="selectedDoc.name" class="w-16 h-16 rounded-2xl object-cover object-top border-2 border-[#C5A880]/50 shrink-0">
                            <div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/10 text-[#E6D5B8]" x-text="selectedDoc.spec"></span>
                                <h3 class="font-serif-luxury text-lg font-bold mt-1 text-white" x-text="selectedDoc.name"></h3>
                                <p class="text-[11px] text-slate-300">⭐ <span x-text="selectedDoc.exp"></span>+ năm kinh nghiệm điều trị</p>
                            </div>
                            <button type="button" @click="selectedDoc = null" class="absolute top-4 right-4 w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold flex items-center justify-center text-xs">✕</button>
                        </div>

                        <div class="p-5 space-y-4 text-xs text-slate-600">
                            <div>
                                <p class="text-[10px] font-bold uppercase text-[#A37F4E] mb-1">Giới thiệu chuyên môn</p>
                                <p class="leading-relaxed font-light text-slate-700" x-text="selectedDoc.bio"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 bg-[#FBF9F5] p-3.5 rounded-2xl border border-[#EAE5DD] text-xs">
                                <div>
                                    <span class="text-slate-400 font-medium block text-[10px]">Đào tạo & Tu nghiệp</span>
                                    <span class="font-bold text-slate-800">Harvard • Geneva • Y Dược</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-medium block text-[10px]">Phòng khám riêng</span>
                                    <span class="font-bold text-[#063B30]">Thăm khám 1:1 Chu Đáo</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-2">
                                <button type="button" @click="selectedDoc = null" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">Đóng</button>
                                <a :href="selectedDoc.booking_url" class="px-4 py-2 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] text-xs font-bold shadow-xs">
                                    📅 Đặt lịch khám với Bác sĩ này
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Tiêu chuẩn tuyển chọn bác sĩ -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#EAE5DD] shadow-xs">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Hội Đồng Chuyên Môn</span>
                    <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-slate-900 mt-1">Tiêu Chuẩn Chuyên Môn Bác Sĩ Nha Khoa Smile</h3>
                    <p class="text-xs text-slate-500 font-light mt-1.5 leading-relaxed">
                        Mỗi ca điều trị đều được thăm khám cẩn trọng, đưa ra phác đồ tối ưu giúp bảo tồn răng thật và tiết kiệm chi phí cho người bệnh.
                    </p>
                </div>
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-bold text-slate-900 text-xs mb-1">🎓 Đào Tạo Chính Quy</div>
                        <p class="text-[11px] text-slate-500 font-light leading-relaxed">Tốt nghiệp ĐH Y Dược, tu nghiệp chuyên sâu các kỹ thuật mới.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-bold text-slate-900 text-xs mb-1">🎨 Thẩm Mỹ Tự Nhiên</div>
                        <p class="text-[11px] text-slate-500 font-light leading-relaxed">Thiết kế form răng hài hòa với đường cười, nhân trung và khuôn mặt.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#FBF9F5] border border-[#EAE5DD]">
                        <div class="font-bold text-slate-900 text-xs mb-1">🛡️ Y Đức & Bảo Mật</div>
                        <p class="text-[11px] text-slate-500 font-light leading-relaxed">Tiếp đón tận tâm, bảo mật thông tin hồ sơ bệnh án trọn đời.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
