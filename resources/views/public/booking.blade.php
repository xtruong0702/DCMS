@extends('layouts.public')

@section('title', 'Đặt Lịch Khám Online - Nha Khoa Smile')

@section('content')
<!-- Hero Đặt Lịch Khám -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Nha Khoa Smile - Đặt Lịch Khám Trực Tuyến</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Đặt Lịch Khám <span class="italic font-normal text-[#E6D5B8]">Nha Khoa Trực Tuyến</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Chủ động lựa chọn Bác sĩ phụ trách, dịch vụ mong muốn và khung giờ khám thuận tiện nhất. Nhận mã số ưu tiên vào khám đúng giờ không chờ đợi.
        </p>
    </div>
</section>

<section class="py-12 sm:py-16 bg-[#FBF9F5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Form đặt lịch VIP (7 cột) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#EAE5DD] shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-slate-900">Thông Tin Đăng Ký Thăm Khám</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-light">Chọn Bác sĩ chuyên khoa, Dịch vụ và Khung giờ tiếp đón phù hợp.</p>
                    </div>
                    <a href="{{ route('public.lookup') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#EBF4F0] text-[#063B30] text-xs font-bold hover:bg-[#D9ECE4] transition">
                        🔍 Tra cứu lịch đã đặt
                    </a>
                </div>

                <!-- Quy định đặt lịch trước -->
                <div class="p-4 rounded-2xl bg-[#FDF8EE] border border-[#E9DCBF] text-[#785E34] text-xs leading-relaxed space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-[#5C4520]">
                        <span>📌</span> <span>Quy định tiếp đón & khám bệnh:</span>
                    </div>
                    <p class="font-light">
                        Hệ thống nhận đặt lịch trực tuyến <strong>từ ngày mai trở đi</strong> (khung giờ <strong>08:00 – 20:00</strong>) để phòng khám sắp xếp ghế khám và hồ sơ bệnh án chu đáo nhất. Nếu quý khách muốn <strong>khám ngay trong ngày hôm nay</strong>, xin vui lòng đến trực tiếp phòng khám hoặc liên hệ Hotline <strong class="text-[#063B30]">1900 1234</strong> để được tiếp đón ngay.
                    </p>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                        <p class="font-bold">Không thể gửi lịch hẹn:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $selectedDoctorId = old('doctor_id', request('doctor_id', ''));
                    $doctorImages = [
                        'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=300&q=80',
                        'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=300&q=80',
                        'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=300&q=80',
                        'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=300&q=80',
                    ];
                @endphp

                <form action="{{ route('public.booking.store') }}" method="POST" class="space-y-5" x-data="{ chosenDoctor: '{{ $selectedDoctorId }}' }">
                    @csrf

                    <!-- 1. Thông tin bệnh nhân -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Quý danh khách hàng <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                placeholder="Họ và tên quý khách..."
                                class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3.5 bg-[#FBF9F5] font-medium">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Số điện thoại liên hệ <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                placeholder="Ví dụ: 0986 667 788"
                                class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3.5 bg-[#FBF9F5] font-medium">
                        </div>
                    </div>

                    <!-- 2. Chọn Bác sĩ Nghệ nhân -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                                👨‍⚕️ Chọn Bác Sĩ Nghệ Nhân Khám 1:1
                            </label>
                            <span class="text-[10px] text-[#A37F4E] font-semibold">Nhấn vào thẻ để chỉ định Bác sĩ</span>
                        </div>

                        <input type="hidden" name="doctor_id" :value="chosenDoctor">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Tùy chọn mặc định: Sắp xếp tự động -->
                            <div @click="chosenDoctor = ''"
                                :class="chosenDoctor === '' ? 'border-[#063B30] bg-[#EBF4F0] ring-1 ring-[#063B30]' : 'border-[#EAE5DD] bg-white hover:border-[#063B30]/40'"
                                class="cursor-pointer rounded-2xl p-3 border transition flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#063B30] text-[#E6D5B8] flex items-center justify-center text-sm shrink-0 shadow-2xs font-bold">
                                    ✦
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-1">
                                        <p class="text-xs font-bold text-slate-900 truncate">Hội đồng phân bổ</p>
                                        <span x-show="chosenDoctor === ''" class="w-4 h-4 rounded-full bg-[#063B30] text-white text-[10px] flex items-center justify-center font-bold shrink-0">✓</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 truncate mt-0.5">Bác sĩ chuyên khoa tương ứng với nhu cầu</p>
                                </div>
                            </div>

                            <!-- Danh sách Bác sĩ -->
                            @foreach($doctors as $idx => $doc)
                                @php
                                    $docName = $doc->user->name ?? ('Bác sĩ #' . $doc->id);
                                    $docSpec = $doc->specialty ?: 'Chuyên khoa Thẩm mỹ';
                                    $docExp = $doc->experience_years ?? (10 + $idx * 2);
                                    $docAvatar = $doctorImages[$idx % count($doctorImages)];
                                @endphp
                                <div @click="chosenDoctor = '{{ $doc->id }}'"
                                    :class="chosenDoctor == '{{ $doc->id }}' ? 'border-[#063B30] bg-[#EBF4F0] ring-1 ring-[#063B30]' : 'border-[#EAE5DD] bg-white hover:border-[#063B30]/40'"
                                    class="cursor-pointer rounded-2xl p-3 border transition flex items-center gap-3">
                                    <img src="{{ $docAvatar }}" alt="{{ $docName }}" class="w-10 h-10 rounded-xl object-cover object-top shrink-0 border border-slate-200">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-bold text-slate-900 truncate">BS. {{ $docName }}</p>
                                            <span x-show="chosenDoctor == '{{ $doc->id }}'" class="w-4 h-4 rounded-full bg-[#063B30] text-white text-[10px] flex items-center justify-center font-bold shrink-0">✓</span>
                                        </div>
                                        <p class="text-[10px] font-semibold text-[#063B30] truncate">{{ $docSpec }}</p>
                                        <p class="text-[9px] text-[#A37F4E] font-medium">{{ $docExp }}+ năm kinh nghiệm</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Chọn Dịch vụ & Thời gian -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                💎 Dịch vụ quan tâm (Tùy chọn)
                            </label>
                            <select name="service_id" class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium">
                                <option value="">-- Khám & Thăm dò tỷ lệ nụ cười --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" @selected(old('service_id', request('service_id')) == $service->id)>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                ⏰ Ngày & Giờ tiếp đón (08:00 - 20:00) <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local"
                                name="appointment_time"
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T08:00') }}"
                                value="{{ old('appointment_time', \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00')) }}"
                                required
                                class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium">
                        </div>
                    </div>

                    <!-- 4. Ghi chú yêu cầu riêng -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Ghi chú tình trạng răng miệng (Tùy chọn)
                        </label>
                        <textarea name="note" rows="3"
                            placeholder="Mô tả triệu chứng hiện tại (ví dụ: đau răng hàm dưới, muốn cạo vôi răng, răng bị mẻ, cần tư vấn niềng răng...)"
                            class="w-full rounded-xl border-[#EAE5DD] focus:border-[#063B30] focus:ring-[#063B30] text-xs py-2.5 px-3 bg-[#FBF9F5] font-medium resize-none">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] font-bold text-xs uppercase tracking-wider shadow-sm transition flex items-center justify-center gap-2 border border-[#C5A880]/30">
                        <span>📅 Xác Nhận Đăng Ký Khám</span>
                    </button>
                </form>
            </div>

            <!-- Cột quy trình & Hotline (5 cột) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- 4 Đặc quyền tiếp đón -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#EAE5DD] shadow-xs space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#A37F4E]">Tiêu Chuẩn Nha Khoa Smile</span>
                    <h3 class="font-serif-luxury text-lg font-bold text-slate-900">Quy Trình Tiếp Đón Chu Đáo</h3>
                    
                    <div class="space-y-3.5 pt-1">
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#063B30] text-[#E6D5B8] text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Tiếp đón & Thăm khám 1:1</div>
                                <p class="text-[11px] text-slate-500 font-light mt-0.5">Bác sĩ chuyên khoa trực tiếp kiểm tra và tư vấn phác đồ phù hợp.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#063B30] text-[#E6D5B8] text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Chụp phim 3D & Sơ đồ răng DCMS</div>
                                <p class="text-[11px] text-slate-500 font-light mt-0.5">Lưu trữ hình ảnh và tình trạng 32 răng trên bệnh án điện tử.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#063B30] text-[#E6D5B8] text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Điều trị êm ái & Vô trùng tuyệt đối</div>
                                <p class="text-[11px] text-slate-500 font-light mt-0.5">Công nghệ gây tê hiện đại, phòng thủ thuật vô trùng chuẩn Bộ Y Tế.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#063B30] text-[#E6D5B8] text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Bảo hành chính hãng & Nhắc hẹn tự động</div>
                                <p class="text-[11px] text-slate-500 font-light mt-0.5">Thanh toán VietQR minh bạch, hỗ trợ chăm sóc răng định kỳ.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotline Box -->
                <div class="bg-[#063B30] rounded-3xl p-6 sm:p-7 text-white border border-[#C5A880]/30 shadow-md space-y-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#E6D5B8]">Hỗ Trợ 24/7</span>
                        <h4 class="font-serif-luxury text-lg font-bold text-white mt-0.5">Cần Khám Ngay Trong Hôm Nay?</h4>
                    </div>
                    <p class="text-xs text-slate-200 font-light leading-relaxed">
                        Quý khách cần điều trị cấp bách hoặc muốn đến khám trực tiếp ngay hôm nay, vui lòng liên hệ hotline:
                    </p>
                    <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-between">
                        <div>
                            <div class="text-[10px] uppercase text-[#E6D5B8] font-bold">Hotline Tiếp Nhận</div>
                            <div class="font-serif-luxury text-xl font-bold text-white">1900 1234</div>
                        </div>
                        <a href="tel:19001234" class="px-4 py-2 rounded-xl bg-[#E6D5B8] text-[#063B30] text-xs font-bold hover:bg-white transition">
                            Gọi Ngay
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
