@extends('layouts.public')

@section('title', 'Tra Cứu Lịch Hẹn & Hóa Đơn - Nha Khoa Smile')

@section('content')
<!-- Hero Tra Cứu -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Tra cứu nhanh bằng Số điện thoại
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-3">
            Tra Cứu <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Lịch Hẹn & Hóa Đơn</span>
        </h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Nhập số điện thoại bạn đã dùng khi đặt lịch để kiểm tra trạng thái xác nhận của Bác sĩ, thời gian hẹn và chi tiết hóa đơn (tiền dịch vụ khám, tiền thuốc kèm theo & mã VietQR).
        </p>

        <!-- Thanh tìm kiếm SĐT -->
        <form action="{{ route('public.lookup') }}" method="GET" class="mt-8 max-w-xl mx-auto flex flex-col sm:flex-row gap-3">
            <input type="text" name="phone" value="{{ $phone }}" required
                placeholder="Nhập số điện thoại hoặc Mã bệnh nhân (VD: 0901234567)..."
                class="flex-1 rounded-2xl border-0 bg-white/95 text-slate-900 placeholder:text-slate-400 px-5 py-4 text-sm font-bold shadow-lg focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="px-7 py-4 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-sm shadow-lg transition whitespace-nowrap">
                🔍 Tra Cứu Ngay
            </button>
        </form>
    </div>
</section>

<section class="py-12 bg-slate-50 min-h-[420px]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($phone === '')
            <div class="bg-white rounded-3xl p-10 text-center border border-slate-200/80 shadow-xs max-w-2xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl mx-auto mb-4">📱</div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Kiểm tra lịch khám & hóa đơn dễ dàng</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Chỉ cần nhập Số điện thoại đã đăng ký lịch hẹn, hệ thống sẽ hiển thị ngay thông tin Bác sĩ phụ trách, trạng thái xác nhận lịch và hóa đơn điện tử của bạn.
                </p>
                <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-extrabold hover:bg-blue-700 transition">
                    📅 Chưa có lịch hẹn? Đặt lịch ngay
                </a>
            </div>
        @elseif(!$patient)
            <div class="bg-white rounded-3xl p-10 text-center border border-rose-200 shadow-xs max-w-2xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-3xl mx-auto mb-4">⚠️</div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Không tìm thấy hồ sơ với SĐT "{{ $phone }}"</h3>
                <p class="text-sm text-slate-500 mb-6">
                    Vui lòng kiểm tra lại số điện thoại hoặc đặt lịch hẹn mới nếu bạn chưa từng đăng ký tại Nha Khoa Smile.
                </p>
                <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white text-xs font-extrabold hover:bg-blue-700 transition">
                    📅 Đặt Lịch Hẹn Mới
                </a>
            </div>
        @else
            <div class="space-y-8">
                <!-- Thông tin khách hàng -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-black text-xl flex items-center justify-center">
                            {{ mb_strtoupper(mb_substr($patient->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-xl font-black text-slate-900">{{ $patient->name }}</h2>
                                <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-extrabold">{{ $patient->patient_code }}</span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Số điện thoại: <strong class="text-slate-800">{{ $patient->phone }}</strong></p>
                        </div>
                    </div>
                    <a href="{{ route('public.booking') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white text-xs font-extrabold transition">
                        + Đặt thêm lịch hẹn mới
                    </a>
                </div>

                <!-- Danh sách Lịch hẹn -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900">📅 Lịch Hẹn Khám Của Bạn ({{ $appointments->count() }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($appointments as $apt)
                            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/60 transition">
                                <div class="space-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-base font-black text-blue-700">
                                            ⏰ {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i - d/m/Y') }}
                                        </span>
                                        @if($apt->isOverdue())
                                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700 border border-rose-300">
                                                ⚠️ Quá thời gian hẹn
                                            </span>
                                        @elseif($apt->isDueNow())
                                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                                🔔 Đến thời gian hẹn - Vui lòng vào quầy Lễ tân Check-in
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-bold text-slate-800">
                                        🦷 Dịch vụ: <span class="text-indigo-600">{{ $apt->service->name ?? 'Khám & Tư vấn tổng quát' }}</span>
                                    </p>
                                    <p class="text-xs text-slate-600">
                                        👨‍⚕️ Bác sĩ phụ trách: <strong>{{ $apt->doctor && $apt->doctor->user ? 'BS. ' . $apt->doctor->user->name : 'Phòng khám đang phân bổ Bác sĩ' }}</strong>
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($apt->status === 'pending')
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200">⏳ Chờ xác nhận</span>
                                    @elseif($apt->status === 'confirmed')
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200">✓ Đã xác nhận lịch</span>
                                    @elseif($apt->status === 'waiting')
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200">🏥 Đã Check-in phòng chờ</span>
                                    @elseif($apt->status === 'in_progress')
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-purple-50 text-purple-700 border border-purple-200">🩺 Đang khám</span>
                                    @elseif($apt->status === 'completed')
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">✅ Hoàn thành khám</span>
                                    @else
                                        <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-slate-100 text-slate-600">Đã hủy / Vắng mặt</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-slate-500">Chưa có lịch hẹn nào được ghi nhận.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Danh sách Hóa đơn & Chi tiết Dịch vụ / Thuốc -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-lg font-black text-slate-900">🧾 Hóa Đơn Khám & Đơn Thuốc ({{ $invoices->count() }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($invoices as $inv)
                            @php
                                $medicinePrefixes = ['thuốc:', 'đơn thuốc:', 'gói thuốc'];
                                $serviceItems = $inv->details->filter(function ($d) use ($medicinePrefixes) {
                                    $lower = mb_strtolower(trim($d->item_name));
                                    foreach ($medicinePrefixes as $p) {
                                        if (str_starts_with($lower, $p)) return false;
                                    }
                                    return true;
                                });
                                $medicineItems = $inv->details->reject(function ($d) use ($medicinePrefixes) {
                                    $lower = mb_strtolower(trim($d->item_name));
                                    foreach ($medicinePrefixes as $p) {
                                        if (str_starts_with($lower, $p)) return false;
                                    }
                                    return true;
                                });
                                $serviceTotal = $serviceItems->sum('total_price');
                                $medicineTotal = $medicineItems->sum('total_price');
                            @endphp
                            <div class="p-6 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div>
                                        <span class="text-base font-black text-slate-900">Mã HĐ: #{{ $inv->invoice_code }}</span>
                                        <span class="text-xs text-slate-400 ml-2">{{ $inv->created_at->format('H:i - d/m/Y') }}</span>
                                    </div>
                                    <div>
                                        @if($inv->status === 'paid')
                                            <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700">✓ Đã thanh toán</span>
                                        @else
                                            <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700">Chưa thanh toán</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs">
                                    <div>
                                        <span class="text-slate-500 font-semibold">🦷 Tiền dịch vụ khám:</span>
                                        <p class="text-sm font-black text-indigo-700 mt-0.5">{{ number_format($serviceTotal, 0, ',', '.') }} đ</p>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 font-semibold">💊 Tiền thuốc kèm theo:</span>
                                        <p class="text-sm font-black text-emerald-700 mt-0.5">{{ number_format($medicineTotal, 0, ',', '.') }} đ</p>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 font-semibold">💰 Tổng thanh toán (Gồm VAT 10%):</span>
                                        <p class="text-base font-black text-rose-600 mt-0.5">{{ number_format($inv->final_amount, 0, ',', '.') }} đ</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-slate-500">Chưa có hóa đơn phát sinh.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

