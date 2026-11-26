@extends('layouts.public')

@section('title', 'Tra Cứu Lịch Hẹn & Hồ Sơ - Nha Khoa Smile')

@section('content')
<!-- Hero Tra Cứu -->
<section class="relative overflow-hidden bg-[#063B30] text-white py-16 sm:py-20 border-b border-[#C5A880]/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold uppercase tracking-widest shadow-2xs">
            <span class="text-[#C5A880]">✦</span>
            <span>Tra Cứu Nhanh Bằng Số Điện Thoại</span>
        </div>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold tracking-tight">
            Tra Cứu <span class="italic font-normal text-[#E6D5B8]">Lịch Hẹn & Hóa Đơn</span>
        </h1>
        <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
            Nhập số điện thoại quý khách đã đăng ký để kiểm tra trạng thái tiếp đón của Bác sĩ, lịch hẹn sắp tới và hóa đơn điện tử VietQR.
        </p>

        <!-- Thanh tìm kiếm SĐT -->
        <form action="{{ route('public.lookup') }}" method="GET" class="mt-6 max-w-lg mx-auto flex flex-col sm:flex-row gap-2.5">
            <input type="text" name="phone" value="{{ $phone }}" required
                placeholder="Nhập số điện thoại đã đăng ký (VD: 0986667788)..."
                class="flex-1 rounded-xl border-0 bg-white text-slate-900 placeholder:text-slate-400 px-4 py-3 text-xs font-medium shadow-md focus:ring-2 focus:ring-[#C5A880]">
            <button type="submit" class="px-6 py-3 rounded-xl bg-[#C5A880] hover:bg-[#D4AF37] text-[#063B30] font-bold text-xs uppercase tracking-wider shadow-md transition whitespace-nowrap">
                Tra Cứu
            </button>
        </form>
    </div>
</section>

<section class="py-12 bg-[#FBF9F5] min-h-[420px]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        @if($phone === '')
            <div class="bg-white rounded-3xl p-8 sm:p-10 text-center border border-[#EAE5DD] shadow-xs max-w-xl mx-auto space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#EBF4F0] text-[#063B30] flex items-center justify-center text-xl mx-auto">📱</div>
                <h3 class="font-serif-luxury text-xl font-bold text-slate-900">Kiểm Tra Hồ Sơ Nhanh Chóng</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-light">
                    Hệ thống tự động hiển thị Bác sĩ phụ trách, thời gian hẹn và hóa đơn điện tử của quý khách tại Nha Khoa Smile.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#063B30] text-[#FDFBF7] text-xs font-bold hover:bg-[#042A22] transition">
                        📅 Chưa có lịch hẹn? Đặt lịch online ngay
                    </a>
                </div>
            </div>
        @elseif(!$patient)
            <div class="bg-white rounded-3xl p-8 sm:p-10 text-center border border-rose-200 shadow-xs max-w-xl mx-auto space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mx-auto">⚠️</div>
                <h3 class="font-serif-luxury text-xl font-bold text-slate-900">Không tìm thấy hồ sơ với SĐT "{{ $phone }}"</h3>
                <p class="text-xs text-slate-500 font-light">
                    Vui lòng kiểm tra lại số điện thoại hoặc liên hệ Hotline 1900 1234 để được bộ phận Lễ tân hỗ trợ tra cứu trực tiếp.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.booking') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#063B30] text-[#FDFBF7] text-xs font-bold hover:bg-[#042A22] transition">
                        📅 Đặt Lịch Hẹn Mới
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                <!-- Thông tin khách hàng -->
                <div class="bg-white rounded-3xl p-6 border border-[#EAE5DD] shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-[#063B30] text-[#E6D5B8] font-bold text-base flex items-center justify-center">
                            {{ mb_strtoupper(mb_substr($patient->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-serif-luxury text-lg font-bold text-slate-900">{{ $patient->name }}</h2>
                                <span class="px-2 py-0.5 rounded-md bg-[#FDF8EE] text-[#9A7B4F] text-[10px] font-bold border border-[#E9DCBF]">{{ $patient->patient_code }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Số điện thoại: <strong class="text-slate-800">{{ $patient->phone }}</strong></p>
                        </div>
                    </div>
                    <a href="{{ route('public.booking') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-[#063B30] text-[#FDFBF7] text-xs font-bold hover:bg-[#042A22] transition">
                        + Đặt lịch khám mới
                    </a>
                </div>

                <!-- Danh sách Lịch hẹn -->
                <div class="bg-white rounded-3xl border border-[#EAE5DD] shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-[#FBF9F5]">
                        <h3 class="font-serif-luxury text-base font-bold text-slate-900">📅 Lịch Hẹn Khám Của Quý Khách ({{ $appointments->count() }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($appointments as $apt)
                            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/60 transition">
                                <div class="space-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-sm font-bold text-[#063B30]">
                                            ⏰ {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i - d/m/Y') }}
                                        </span>
                                        @if($apt->isOverdue())
                                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEE2E2] text-[#991B1B]">
                                                ⚠️ Quá giờ hẹn
                                            </span>
                                        @elseif($apt->isDueNow())
                                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-[#FEF3C7] text-[#92400E] animate-pulse">
                                                🔔 Đến giờ khám - Quý khách vui lòng vào sảnh tiếp đón
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs font-bold text-slate-800">
                                        💎 Dịch vụ: <span class="text-[#063B30]">{{ $apt->service->name ?? 'Khám & Thăm dò nụ cười' }}</span>
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        👨‍⚕️ Bác sĩ phụ trách: <strong>{{ $apt->doctor ? 'BS. ' . $apt->doctor->user->name : 'Phòng khám sắp xếp' }}</strong>
                                    </p>
                                </div>

                                <div>
                                    @if($apt->status == 'confirmed')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D1FAE5] text-[#065F46]">
                                            ✓ Bác sĩ đã xác nhận
                                        </span>
                                    @elseif($apt->status == 'completed')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            ✓ Đã hoàn tất khám
                                        </span>
                                    @elseif($apt->status == 'pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#FEF3C7] text-[#92400E]">
                                            Đang chờ Bác sĩ xác nhận
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                            {{ $apt->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-slate-400">
                                Quý khách chưa có lịch hẹn nào sắp tới.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Danh sách Hóa đơn -->
                <div class="bg-white rounded-3xl border border-[#EAE5DD] shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-[#FBF9F5]">
                        <h3 class="font-serif-luxury text-base font-bold text-slate-900">🧾 Hóa Đơn & Mã VietQR ({{ $invoices->count() }})</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($invoices as $inv)
                            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/60 transition">
                                <div>
                                    <div class="font-mono font-bold text-xs text-slate-800">#{{ $inv->invoice_code }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">Ngày lập: {{ $inv->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="font-serif-luxury text-base font-bold text-[#063B30] mt-1">
                                        {{ number_format($inv->final_amount, 0, ',', '.') }} đ
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($inv->status == 'paid')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#D1FAE5] text-[#065F46]">
                                            ✓ Đã thanh toán
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#FEF3C7] text-[#92400E]">
                                            Chưa thanh toán
                                        </span>
                                    @endif
                                    <a href="{{ route('patient.invoices.show', $inv->id) }}" class="px-3.5 py-1.5 rounded-xl bg-[#063B30] hover:bg-[#042A22] text-[#FDFBF7] text-xs font-bold transition">
                                        Chi tiết & VietQR
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-slate-400">
                                Chưa có hóa đơn nào phát sinh.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
