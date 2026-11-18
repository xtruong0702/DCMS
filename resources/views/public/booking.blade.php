@extends('layouts.public')

@section('content')
<!-- Hero Đặt Lịch Khám -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Chủ động thời gian • Chọn Bác sĩ & Dịch vụ
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-3">
            Đặt Lịch Hẹn <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Khám Nha Khoa</span>
        </h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Đặt lịch hẹn trước từ ngày mai trở đi để chủ động chọn Bác sĩ chuyên khoa mong muốn và được tiếp đón ưu tiên đúng giờ hẹn.
        </p>
    </div>
</section>

<section class="py-14 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form đặt lịch (7 cột) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm">
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900">Thông Tin Đăng Ký Lịch Hẹn</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Chọn Bác sĩ, Dịch vụ và Thời gian khám phù hợp với bạn.</p>
                    </div>
                    <a href="{{ route('public.lookup') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-extrabold transition">
                        🔍 Tra cứu lịch đã đặt
                    </a>
                </div>

                <!-- Quy định đặt lịch trước -->
                <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200/90 text-amber-900 text-xs sm:text-sm leading-relaxed">
                    <div class="font-extrabold flex items-center gap-1.5 mb-1 text-amber-950">
                        <span>📌</span> Hướng dẫn đặt lịch khám:
                    </div>
                    Hệ thống trực tuyến nhận đặt lịch hẹn <strong>từ ngày mai trở đi</strong> (khung giờ làm việc <strong>08:00 – 20:00</strong>). Nếu quý khách muốn <strong>khám ngay trong ngày hôm nay</strong>, quý khách không cần đặt lịch trên web mà vui lòng đến trực tiếp phòng khám để được tiếp đón ngay.
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                        <p class="font-extrabold mb-1">Không thể gửi lịch hẹn:</p>
                        <ul class="list-disc list-inside text-xs space-y-1">
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
                        'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=300&q=80',
                    ];
                @endphp

                <form action="{{ route('public.booking.store') }}" method="POST" class="space-y-6" x-data="{ chosenDoctor: '{{ $selectedDoctorId }}' }">
                    @csrf

                    <!-- 1. Thông tin bệnh nhân -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Họ và tên bệnh nhân <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                placeholder="Nhập họ và tên..."
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

                    <!-- 2. Chọn Bác sĩ khám -->
                    <div>
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                                👨‍⚕️ Chọn Bác Sĩ Khám
                            </label>
                            <span class="text-[11px] font-semibold text-blue-600">Nhấn vào thẻ để chọn Bác sĩ</span>
                        </div>

                        <input type="hidden" name="doctor_id" :value="chosenDoctor">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Tùy chọn mặc định: Phòng khám tự sắp xếp -->
                            <div @click="chosenDoctor = ''"
                                :class="chosenDoctor === '' ? 'border-blue-600 bg-blue-50/70 ring-2 ring-blue-600/20' : 'border-slate-200 bg-slate-50/60 hover:border-blue-300 hover:bg-white'"
                                class="cursor-pointer rounded-2xl p-3.5 border transition flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0 shadow-xs">
                                    🏥
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-extrabold text-slate-900 truncate">Phòng khám sắp xếp</p>
                                        <span x-show="chosenDoctor === ''" class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center font-bold shrink-0">✓</span>
                                    </div>
                                    <p class="text-xs text-slate-500 truncate mt-0.5">Phân bổ Bác sĩ chuyên khoa phù hợp nhất</p>
                                </div>
                            </div>

                            <!-- Danh sách từng Bác sĩ -->
                            @foreach($doctors as $idx => $doc)
                                @php
                                    $docName = $doc->user->name ?? ('Bác sĩ #' . $doc->id);
                                    $docSpec = $doc->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                                    $docExp = $doc->experience_years ?? (8 + $idx * 2);
                                    $docAvatar = $doctorImages[$idx % count($doctorImages)];
                                @endphp
                                <div @click="chosenDoctor = '{{ $doc->id }}'"
                                    :class="chosenDoctor == '{{ $doc->id }}' ? 'border-blue-600 bg-blue-50/70 ring-2 ring-blue-600/20' : 'border-slate-200 bg-white hover:border-blue-300'"
                                    class="cursor-pointer rounded-2xl p-3.5 border transition flex items-center gap-3.5">
                                    <img src="{{ $docAvatar }}" alt="{{ $docName }}" class="w-12 h-12 rounded-xl object-cover object-top shrink-0 border border-slate-200">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-sm font-extrabold text-slate-900 truncate">BS. {{ $docName }}</p>
                                            <span x-show="chosenDoctor == '{{ $doc->id }}'" class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center font-bold shrink-0">✓</span>
                                        </div>
                                        <p class="text-xs font-bold text-blue-600 truncate mt-0.5">{{ $docSpec }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">⭐ {{ $docExp }}+ năm kinh nghiệm</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Chọn Dịch vụ & Thời gian hẹn -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                🦷 Dịch vụ quan tâm (Tùy chọn)
                            </label>
                            <select name="service_id" class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4">
                                <option value="">-- Khám & Tư vấn tổng quát --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" @selected(old('service_id', request('service_id')) == $service->id)>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                ⏰ Ngày & Giờ hẹn (08:00 - 20:00) <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local"
                                name="appointment_time"
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T08:00') }}"
                                value="{{ old('appointment_time', \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00')) }}"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4">
                        </div>
                    </div>

                    <!-- 4. Ghi chú triệu chứng -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                            Ghi chú triệu chứng hoặc yêu cầu thêm
                        </label>
                        <textarea name="note" rows="3"
                            placeholder="Ví dụ: Đau răng hàm dưới bên phải, muốn khám ngoài giờ hành chính..."
                            class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600 text-sm py-3 px-4">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-4 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-sm shadow-lg shadow-blue-600/25 transition">
                        📅 Xác Nhận Đặt Lịch Hẹn
                    </button>
                </form>
            </div>

            <!-- Cột quy trình & Hỗ trợ (5 cột) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm">
                    <h3 class="text-lg font-black text-slate-900 mb-4">Quy Trình Tiếp Đón 4 Bước Nhanh Chóng</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3.5">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <div>
                                <div class="text-sm font-extrabold text-slate-900">Chọn Bác sĩ, Dịch vụ & Giờ hẹn</div>
                                <p class="text-xs text-slate-500 mt-0.5">Chủ động chọn Bác sĩ điều trị và khung giờ phù hợp từ ngày mai trở đi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3.5">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <div>
                                <div class="text-sm font-extrabold text-slate-900">Bác sĩ & Lễ tân xác nhận 1 chạm</div>
                                <p class="text-xs text-slate-500 mt-0.5">Hệ thống kiểm tra lịch trống của Bác sĩ và giữ chỗ ghế máy ưu tiên cho bạn.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3.5">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <div>
                                <div class="text-sm font-extrabold text-slate-900">Thăm khám & Tư vấn minh bạch</div>
                                <p class="text-xs text-slate-500 mt-0.5">Bác sĩ chuyên khoa khám, chụp phim và báo giá rõ ràng trước khi điều trị.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3.5">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 mt-0.5">4</span>
                            <div>
                                <div class="text-sm font-extrabold text-slate-900">Thanh toán VietQR & Bảo hành</div>
                                <p class="text-xs text-slate-500 mt-0.5">Hóa đơn tách rõ tiền khám và tiền thuốc kèm theo, hỗ trợ quét mã QR tự động.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-blue-950 rounded-3xl p-6 sm:p-8 text-white">
                    <h4 class="text-base font-black mb-2">Cần hỗ trợ khẩn cấp hoặc khám ngay hôm nay?</h4>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        Nếu bạn đang bị đau nhức răng cấp tính hoặc muốn đến khám ngay trong ngày hôm nay, hãy ghé trực tiếp phòng khám hoặc gọi Hotline:
                    </p>
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-between">
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-blue-300 font-bold">Hotline Hỗ Trợ</div>
                            <div class="text-xl font-black text-white">1900 1234</div>
                        </div>
                        <a href="{{ route('public.contact') }}" class="px-4 py-2 rounded-xl bg-white text-slate-900 text-xs font-extrabold hover:bg-blue-50 transition">
                            Xem Bản Đồ & Địa Chỉ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
