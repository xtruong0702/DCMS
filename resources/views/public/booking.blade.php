@extends('layouts.public')

@section('title', 'Đặt Lịch Khám Online - Nha Khoa Smile')

@section('content')
<!-- Hero Đặt Lịch Khám -->
<section class="relative overflow-hidden bg-gradient-to-b from-teal-50/80 via-white to-slate-50 py-14 sm:py-16 border-b border-slate-200/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-teal-500/15 text-teal-800 text-xs font-semibold shadow-sm">
            <span class="pulse-dot pulse-dot-emerald"></span>
            <span>Đăng Ký Khám Trực Tuyến • Không Cần Chờ Đợi</span>
        </div>
        <h1 class="font-heading-clinic !text-3xl sm:!text-4xl font-extrabold tracking-tight text-slate-900">
            Đặt Lịch Khám <span class="text-clinic-gradient">Nha Khoa Online</span>
        </h1>
        <p class="text-slate-600 text-sm max-w-xl mx-auto leading-relaxed">
            Chủ động lựa chọn Bác sĩ phụ trách, dịch vụ mong muốn và khung giờ khám thuận tiện nhất. Nhận mã ưu tiên vào khám đúng giờ.
        </p>
    </div>
</section>

<!-- Form & Quy Trình -->
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Form đặt lịch (7 cột) -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/40 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100/70">
                    <div>
                        <h2 class="font-heading-clinic !text-xl font-bold text-slate-900">Thông Tin Đăng Ký Khám Bệnh</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Điền thông tin để Lễ tân xác nhận và giữ khung giờ cho bạn.</p>
                    </div>
                    <a href="{{ route('public.lookup') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 text-teal-800 border border-teal-500/15 text-xs font-semibold hover:bg-teal-100 transition shrink-0">
                        🔍 Tra cứu lịch đã đặt
                    </a>
                </div>

                <!-- Quy định đặt lịch -->
                <div class="p-4 rounded-xl bg-sky-50/70 border border-sky-500/15 text-slate-700 text-xs leading-relaxed space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-sky-900">
                        <span>📌</span> <span>Lưu ý tiếp nhận khám bệnh:</span>
                    </div>
                    <p>
                        Hệ thống nhận đặt lịch trực tuyến <strong>từ ngày mai trở đi</strong> (khung giờ <strong class="tabular-nums">08:00 – 20:00</strong>). Nếu bạn cần <strong>khám ngay trong hôm nay</strong>, vui lòng đến trực tiếp phòng khám hoặc gọi Hotline <strong class="text-teal-800 tabular-nums">0775 761 388</strong> để được tiếp nhận ngay.
                    </p>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-500/15 text-emerald-800 text-xs font-semibold flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-500/15 text-rose-700 text-xs space-y-1">
                        <p class="font-bold">Vui lòng kiểm tra lại thông tin:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $selectedDoctorId = old('doctor_id', request('doctor_id', ''));
                    $selectedServiceId = old('service_id', request('service_id', ''));
                    $initialAppointmentTime = old('appointment_time', \Carbon\Carbon::tomorrow()->format('Y-m-d\T09:00'));
                    $serviceDurations = $services->mapWithKeys(fn($s) => [(string) $s->id => max(15, intval($s->duration_minutes ?? 30))])->toArray();
                @endphp

                <form action="{{ route('public.booking.store') }}" method="POST" class="space-y-5"
                    x-data="{
                        chosenDoctor: @js((string) $selectedDoctorId),
                        chosenService: @js((string) $selectedServiceId),
                        appointmentTime: @js((string) $initialAppointmentTime),
                        serviceDurations: @js($serviceDurations),
                        busySlots: [],
                        loadingSlots: false,
                        busySlotsUrl: @js(route('public.booking.busy-slots')),
                        get selectedDate() {
                            return (this.appointmentTime || '').split('T')[0] || '';
                        },
                        get selectedDuration() {
                            return this.serviceDurations[String(this.chosenService)] || 30;
                        },
                        get hasConflict() {
                            if (!this.chosenDoctor || !this.appointmentTime || !this.appointmentTime.includes('T')) return null;
                            const timePart = this.appointmentTime.split('T')[1];
                            if (!timePart) return null;
                            const [h, m] = timePart.split(':').map(Number);
                            if (isNaN(h) || isNaN(m)) return null;
                            const startMin = h * 60 + m;
                            const endMin = startMin + this.selectedDuration;
                            return this.busySlots.find(s => startMin < s.end_minutes && s.start_minutes < endMin) || null;
                        },
                        async fetchBusySlots() {
                            if (!this.chosenDoctor || !this.selectedDate) {
                                this.busySlots = [];
                                return;
                            }
                            this.loadingSlots = true;
                            try {
                                const res = await fetch(`${this.busySlotsUrl}?doctor_id=${encodeURIComponent(this.chosenDoctor)}&date=${encodeURIComponent(this.selectedDate)}`);
                                const data = await res.json();
                                this.busySlots = Array.isArray(data.slots) ? data.slots : [];
                            } catch (e) {
                                this.busySlots = [];
                            } finally {
                                this.loadingSlots = false;
                            }
                        }
                    }"
                    x-init="fetchBusySlots(); $watch('chosenDoctor', () => fetchBusySlots()); $watch('selectedDate', () => fetchBusySlots());">
                    @csrf

                    <!-- 1. Thông tin bệnh nhân -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Họ và tên bệnh nhân <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                placeholder="Nhập họ và tên..."
                                class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Số điện thoại liên hệ <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                placeholder="Ví dụ: 0986 667 788"
                                class="input-clinic w-full rounded-xl text-sm py-2.5 px-3.5 tabular-nums">
                        </div>
                    </div>

                    <!-- 2. Chọn Bác sĩ -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-semibold text-slate-700">
                                👨‍⚕️ Chọn Bác Sĩ Phụ Trách
                            </label>
                            <span class="text-[11px] text-teal-700 font-medium">Nhấn vào thẻ để chọn Bác sĩ</span>
                        </div>

                        <input type="hidden" name="doctor_id" :value="chosenDoctor">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Tùy chọn mặc định -->
                            <div @click="chosenDoctor = ''"
                                :class="chosenDoctor === '' ? 'border-teal-600 bg-teal-50/70 ring-2 ring-teal-500/20' : 'border-slate-200/45 bg-white hover:border-teal-500/25'"
                                class="cursor-pointer rounded-xl p-3 border transition flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-base shrink-0 font-bold">
                                    🏥
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-1">
                                        <p class="text-xs font-bold text-slate-900 truncate">Phòng khám phân bổ</p>
                                        <span x-show="chosenDoctor === ''" class="w-4 h-4 rounded-full bg-teal-600 text-white text-[10px] flex items-center justify-center font-bold shrink-0">✓</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5">Bác sĩ chuyên khoa phù hợp nhất</p>
                                </div>
                            </div>

                            <!-- Danh sách Bác sĩ -->
                            @foreach($doctors as $idx => $doc)
                                @php
                                    $rawDocName = trim($doc->user->name ?? ('Bác sĩ #' . $doc->id));
                                    $docName = preg_match('/^(BS|TS|ThS|PGS|GS)\b/iu', $rawDocName) ? $rawDocName : 'BS. ' . $rawDocName;
                                    $docSpec = $doc->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                                    $docExp = $doc->experience_years ?? (10 + ($idx % 4) * 2);
                                    $docAvatar = $doc->avatar_url;
                                @endphp
                                <div @click="chosenDoctor = '{{ $doc->id }}'"
                                    :class="chosenDoctor == '{{ $doc->id }}' ? 'border-teal-600 bg-teal-50/70 ring-2 ring-teal-500/20' : 'border-slate-200/45 bg-white hover:border-teal-500/25'"
                                    class="cursor-pointer rounded-xl p-3 border transition flex items-center gap-3">
                                    <img src="{{ $docAvatar }}" alt="{{ $docName }}" class="w-10 h-10 rounded-xl object-cover object-top shrink-0 border border-slate-200/40">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-1">
                                            <p class="text-xs font-bold text-slate-900 truncate">{{ $docName }}</p>
                                            <span x-show="chosenDoctor == '{{ $doc->id }}'" class="w-4 h-4 rounded-full bg-teal-600 text-white text-[10px] flex items-center justify-center font-bold shrink-0">✓</span>
                                        </div>
                                        <p class="text-[10px] font-semibold text-teal-700 truncate">{{ $docSpec }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $docExp }}+ năm kinh nghiệm</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Chọn Dịch vụ & Thời gian -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Dịch vụ quan tâm (Tùy chọn)
                            </label>
                            <select name="service_id" x-model="chosenService" class="input-clinic w-full rounded-xl text-sm py-2.5 px-3">
                                <option value="">-- Khám tổng quát & Tư vấn (30 phút) --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" @selected(old('service_id', request('service_id')) == $service->id)>
                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} đ • {{ max(15, intval($service->duration_minutes ?? 30)) }} phút)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Ngày & Giờ khám (08:00 - 20:00) <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local"
                                name="appointment_time"
                                x-model="appointmentTime"
                                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T08:00') }}"
                                value="{{ $initialAppointmentTime }}"
                                required
                                class="input-clinic w-full rounded-xl text-sm py-2.5 px-3 tabular-nums">
                        </div>
                    </div>

                    <!-- Trạng thái khung giờ bận / trống của Bác sĩ theo thời gian thực -->
                    <div x-show="chosenDoctor !== ''" x-cloak class="p-3.5 rounded-xl border border-slate-200/70 bg-slate-50/70 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-700">🕒 Lịch của Bác sĩ trong ngày <span class="font-mono text-teal-800" x-text="selectedDate ? selectedDate.split('-').reverse().join('/') : ''"></span>:</span>
                            <span class="text-[11px] text-slate-500">Thời lượng dự kiến: <strong class="text-slate-700" x-text="selectedDuration + ' phút'"></strong></span>
                        </div>

                        <template x-if="loadingSlots">
                            <p class="text-xs text-slate-500">Đang kiểm tra khung giờ trống của bác sĩ...</p>
                        </template>

                        <template x-if="!loadingSlots && busySlots.length === 0">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                                <span>✓</span>
                                <span>Bác sĩ còn trống toàn bộ khung giờ (08:00 – 20:00) trong ngày này.</span>
                            </div>
                        </template>

                        <template x-if="!loadingSlots && busySlots.length > 0">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[11px] text-slate-500 mr-1">Khung giờ đã kín:</span>
                                    <template x-for="slot in busySlots" :key="slot.start + '-' + slot.end">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-[11px] font-bold tabular-nums">
                                            <span>⛔</span>
                                            <span x-text="slot.start + ' – ' + slot.end"></span>
                                        </span>
                                    </template>
                                </div>
                                <template x-if="hasConflict">
                                    <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-300 text-rose-800 text-xs font-semibold">
                                        ⚠️ Giờ bạn chọn bị trùng với lịch đã kín (<span class="tabular-nums" x-text="hasConflict.start + ' – ' + hasConflict.end"></span>). Vui lòng chọn giờ khác hoặc đổi bác sĩ!
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- 4. Ghi chú -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Mô tả triệu chứng / Ghi chú (Tùy chọn)
                        </label>
                        <textarea name="note" rows="3"
                            placeholder="Ví dụ: đau răng hàm dưới, muốn cạo vôi răng, răng bị mẻ, cần tư vấn niềng răng..."
                            class="input-clinic w-full rounded-xl text-sm py-2.5 px-3 resize-none">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="btn-press btn-shimmer btn-clinic-primary w-full py-3.5 px-6 rounded-xl text-sm flex items-center justify-center gap-2">
                        <span>📅 Xác Nhận Đặt Lịch Khám</span>
                    </button>
                </form>
            </div>

            <!-- Cột quy trình & Hotline (5 cột) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/40 shadow-sm space-y-4">
                    <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">Tiêu Chuẩn Y Khoa</span>
                    <h3 class="font-heading-clinic !text-lg font-bold text-slate-900">Quy Trình Tiếp Đón Tại Phòng Khám</h3>

                    <div class="space-y-4 pt-1">
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-teal-600 text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Tiếp đón & Thăm khám 1:1</div>
                                <p class="text-xs text-slate-500 mt-0.5">Bác sĩ chuyên khoa trực tiếp kiểm tra và tư vấn phác đồ điều trị.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-teal-600 text-white text-xs font-bold flex items-center justify-center shrink-0">2</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Chụp phim 3D & Sơ đồ răng DCMS</div>
                                <p class="text-xs text-slate-500 mt-0.5">Lưu trữ phim chụp và tình trạng 32 răng trên hồ sơ bệnh án điện tử.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-teal-600 text-white text-xs font-bold flex items-center justify-center shrink-0">3</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Điều trị êm ái & Vô trùng tuyệt đối</div>
                                <p class="text-xs text-slate-500 mt-0.5">Gây tê không đau, phòng thủ thuật vô trùng 1 chiều chuẩn Bộ Y Tế.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-teal-600 text-white text-xs font-bold flex items-center justify-center shrink-0">4</span>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Bảo hành chính hãng & Nhắc hẹn tái khám</div>
                                <p class="text-xs text-slate-500 mt-0.5">Thanh toán VietQR minh bạch, theo dõi lịch tái khám định kỳ.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotline Box -->
                <div class="bg-gradient-to-br from-teal-700 to-teal-900 rounded-2xl p-6 sm:p-7 text-white shadow-lg space-y-4">
                    <div>
                        <span class="text-[11px] uppercase font-bold tracking-wider text-teal-200">Hỗ Trợ Cấp Cứu & Đặt Hẹn</span>
                        <h4 class="font-heading-clinic !text-lg font-bold !text-white mt-1">Cần Khám Ngay Trong Hôm Nay?</h4>
                    </div>
                    <p class="text-xs text-teal-100 leading-relaxed">
                        Nếu bạn đang bị đau răng cấp tính hoặc muốn đến khám trực tiếp trong ngày, vui lòng gọi ngay Hotline:
                    </p>
                    <div class="p-4 rounded-xl bg-white/10 border border-white/20 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-[10px] uppercase text-teal-200 font-semibold">Hotline Phòng Khám</div>
                            <div class="font-heading-clinic text-xl font-extrabold text-white tabular-nums">0775 761 388</div>
                        </div>
                        <a href="tel:0775761388" class="btn-press px-4 py-2 rounded-xl bg-white text-teal-900 font-bold text-xs shadow-sm">
                            Gọi Ngay
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
