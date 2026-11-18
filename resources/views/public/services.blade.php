@extends('layouts.public')

@section('content')
<!-- Hero Dịch Vụ & Bảng Giá -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Minh bạch chi phí • Không phát sinh
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Dịch Vụ Nha Khoa & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Bảng Giá Niêm Yết</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
            Cung cấp đầy đủ các giải pháp từ Nha khoa tổng quát đến Phục hình thẩm mỹ, Chỉnh nha và Cấy ghép Implant kỹ thuật cao.
        </p>
    </div>
</section>

<!-- Các chuyên khoa mũi nhọn (Có link trang chi tiết) -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Chuyên khoa mũi nhọn</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3">Khám Phá Chi Tiết Các Dịch Vụ</h2>
            </div>
            <p class="text-sm text-slate-500">Nhấn vào từng dịch vụ để xem quy trình chuẩn Y khoa</p>
        </div>

        @php
            $catalog = [
                ['slug' => 'implant-chuyen-sau', 'title' => 'Trồng Răng Implant Chuyên Sâu', 'tag' => 'Phục hình mất răng', 'desc' => 'Khôi phục chân răng titan tích hợp xương bền chắc trọn đời, ăn nhai 99% như răng thật.', 'icon' => '🦷'],
                ['slug' => 'rang-su-chuyen-sau', 'title' => 'Bọc Răng Sứ Thẩm Mỹ', 'tag' => 'Thẩm mỹ nụ cười', 'desc' => 'Sứ toàn phần chính hãng Đức, Mỹ trắng trong tự nhiên, bảo tồn tối đa mô răng gốc.', 'icon' => '✨'],
                ['slug' => 'nieng-rang', 'title' => 'Niềng Răng Thẩm Mỹ', 'tag' => 'Chỉnh nha', 'desc' => 'Khắc phục hô, móm, răng khấp khểnh với mắc cài kim loại, sứ hoặc khay trong suốt.', 'icon' => '😁'],
                ['slug' => 'nho-rang-khon', 'title' => 'Nhổ Răng Khôn Không Đau', 'tag' => 'Tiểu phẫu siêu âm', 'desc' => 'Ứng dụng máy siêu âm Piezotome nhổ răng số 8 mọc lệch, mọc ngầm êm ái, mau lành thương.', 'icon' => '🛡️'],
                ['slug' => 'tay-trang-rang', 'title' => 'Tẩy Trắng Răng Laser', 'tag' => 'Thẩm mỹ', 'desc' => 'Bật tông răng trắng sáng chỉ sau 45 phút với công nghệ ánh sáng lạnh không ê buốt.', 'icon' => '💎'],
                ['slug' => 'dieu-tri-tuy', 'title' => 'Điều Trị Tủy Răng Vi Phẫu', 'tag' => 'Nội nha', 'desc' => 'Chấm dứt cơn đau nhức răng cấp tính, làm sạch ống tủy bằng máy định vị chóp hiện đại.', 'icon' => '🔬'],
                ['slug' => 'lay-cao-rang', 'title' => 'Cạo Vôi & Đánh Bóng Răng', 'tag' => 'Nha khoa phòng ngừa', 'desc' => 'Loại bỏ mảng bám, vôi răng dưới nướu bằng sóng siêu âm nhẹ nhàng, ngăn ngừa viêm nha chu.', 'icon' => '🫧'],
                ['slug' => 'tram-rang', 'title' => 'Trám Răng Thẩm Mỹ Composite', 'tag' => 'Phục hồi răng sâu', 'desc' => 'Bít kín lỗ sâu răng, mẻ cổ răng bằng vật liệu Composite trùng màu răng thật bền đẹp.', 'icon' => '🩹'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($catalog as $item)
                <a href="{{ route('public.service.detail', $item['slug']) }}" class="group bg-slate-50 hover:bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-blue-400 hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-12 h-12 rounded-2xl bg-blue-600/10 text-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                                {{ $item['icon'] }}
                            </span>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-600">
                                {{ $item['tag'] }}
                            </span>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition mb-2">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                    <div class="text-xs font-extrabold text-blue-600 flex items-center gap-1 group-hover:translate-x-1 transition">
                        Xem quy trình chi tiết <span>→</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Bảng giá niêm yết từ hệ thống -->
<section class="py-16 bg-slate-50 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3.5 py-1.5 rounded-full">Bảng giá niêm yết chính thức</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-3">Bảng Giá Dịch Vụ Khám & Điều Trị</h2>
            <p class="text-sm text-slate-500 mt-2">
                Giá dịch vụ dưới đây được đồng bộ trực tiếp với hệ thống thanh toán của phòng khám. Bác sĩ sẽ tư vấn rõ chi phí trước khi thực hiện.
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-extrabold">Dịch vụ nha khoa</th>
                            <th class="py-4 px-6 font-extrabold">Mô tả chi tiết</th>
                            <th class="py-4 px-6 font-extrabold text-center">Thời gian dự kiến</th>
                            <th class="py-4 px-6 font-extrabold text-right">Đơn giá niêm yết</th>
                            <th class="py-4 px-6 font-extrabold text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($services as $service)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="py-4 px-6 font-extrabold text-slate-900">
                                    🦷 {{ $service->name }}
                                </td>
                                <td class="py-4 px-6 text-slate-600">
                                    {{ $service->description ?: 'Thăm khám và thực hiện theo quy trình vô trùng tiêu chuẩn Bộ Y Tế.' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                                        ⏱ {{ $service->duration ?? 30 }} phút
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-blue-600 text-base whitespace-nowrap">
                                    {{ number_format($service->price, 0, ',', '.') }} đ
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <a href="{{ route('public.booking', ['service_id' => $service->id]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-sm transition">
                                        Đặt lịch ngay
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500">
                                    Danh mục bảng giá đang được cập nhật. Vui lòng liên hệ Hotline 1900 1234 để được tư vấn trực tiếp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200/70 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    💡 <strong>Lưu ý:</strong> Bảng giá trên chưa bao gồm thuế GTGT (VAT 10%) và đơn thuốc kèm theo (nếu có chỉ định của Bác sĩ).
                </div>
                <a href="{{ route('public.contact') }}" class="font-bold text-blue-600 hover:underline">Cần tư vấn báo giá chi tiết? Liên hệ ngay →</a>
            </div>
        </div>
    </div>
</section>
@endsection
