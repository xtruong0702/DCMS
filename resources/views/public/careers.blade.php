@extends('layouts.public')

@section('content')
<!-- Hero Tuyển Dụng -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-extrabold uppercase tracking-wider mb-4">
            Gia nhập đội ngũ Nha Khoa Smile
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Cơ Hội Nghề Nghiệp & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Phát Triển Y Khoa</span>
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
            Môi trường làm việc chuyên nghiệp, trang thiết bị hiện đại cùng lộ trình đào tạo liên tục và đãi ngộ xứng đáng.
        </p>
    </div>
</section>

<!-- Phúc lợi nhân sự & Danh sách vị trí -->
<section class="py-16 bg-white" x-data="{ applyJob: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black mb-4">💰</div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-1">Thu Nhập & Thưởng Hấp Dẫn</h3>
                <p class="text-sm text-slate-600">Lương cứng cạnh tranh + % hoa hồng chuyên môn rõ ràng + thưởng lễ Tết và lương tháng 13 đầy đủ.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black mb-4">🎓</div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-1">Đào Tạo Y Khoa Liên Tục (CME)</h3>
                <p class="text-sm text-slate-600">Tài trợ chi phí tham gia các hội thảo chuyên sâu về Implant, Chỉnh nha và công nghệ nha khoa kỹ thuật số.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black mb-4">🏥</div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-1">Phúc Lợi Chăm Sóc Sức Khỏe</h3>
                <p class="text-sm text-slate-600">Đóng BHXH, BHYT đầy đủ theo luật định; miễn giảm 50-100% chi phí chăm sóc răng miệng cho nhân sự và người thân.</p>
            </div>
        </div>

        <!-- Vị trí đang tuyển -->
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-blue-600">Đang mở ứng tuyển</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Các Vị Trí Tuyển Dụng Hiện Tại</h2>
                </div>
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200">
                    3 vị trí đang tuyển
                </span>
            </div>

            <div class="space-y-6">
                <!-- Job 1 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 hover:border-blue-400 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-100 text-blue-700">Toàn thời gian</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">TP. Hồ Chí Minh</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">1. Bác Sĩ Răng Hàm Mặt (Tổng quát / Phục hình)</h3>
                        </div>
                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                            <div class="text-left sm:text-right">
                                <div class="text-xs text-slate-400 font-semibold uppercase">Mức thu nhập</div>
                                <div class="text-lg font-black text-emerald-600">25 - 50 Triệu + % Ca</div>
                            </div>
                            <button type="button" @click="applyJob = 'Bác Sĩ Răng Hàm Mặt (Tổng quát / Phục hình)'" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-xs transition">
                                📝 Ứng tuyển vị trí này
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-5 text-sm text-slate-600">
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Mô tả công việc:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Thăm khám, chẩn đoán và lập phác đồ điều trị cho bệnh nhân trên hệ thống DCMS.</li>
                                <li>Thực hiện các thủ thuật nha khoa tổng quát, nội nha, phục hình sứ thẩm mỹ.</li>
                                <li>Kê đơn thuốc điện tử và phối hợp cùng điều dưỡng đảm bảo vô trùng.</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Yêu cầu ứng viên:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Tốt nghiệp Bác sĩ Răng Hàm Mặt chính quy, có Chứng chỉ hành nghề (CCHN).</li>
                                <li>Tối thiểu 2 năm kinh nghiệm lâm sàng tại bệnh viện hoặc nha khoa uy tín.</li>
                                <li>Tận tâm, thao tác nhẹ nhàng, giao tiếp tư vấn rõ ràng với bệnh nhân.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Job 2 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 hover:border-blue-400 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700">Toàn thời gian</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">TP. Hồ Chí Minh</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">2. Phụ Tá Nha Khoa (Điều Dưỡng Răng Hàm Mặt)</h3>
                        </div>
                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                            <div class="text-left sm:text-right">
                                <div class="text-xs text-slate-400 font-semibold uppercase">Mức thu nhập</div>
                                <div class="text-lg font-black text-emerald-600">9 - 15 Triệu / tháng</div>
                            </div>
                            <button type="button" @click="applyJob = 'Phụ Tá Nha Khoa (Điều Dưỡng Răng Hàm Mặt)'" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-xs transition">
                                📝 Ứng tuyển vị trí này
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-5 text-sm text-slate-600">
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Mô tả công việc:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Chuẩn bị ghế máy, dụng cụ vô trùng và vật tư tiêu hao trước mỗi ca khám.</li>
                                <li>Phụ ghế 4 tay cùng Bác sĩ trong quá trình điều trị, tiểu phẫu, lấy dấu.</li>
                                <li>Hướng dẫn bệnh nhân chăm sóc răng miệng sau điều trị.</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Yêu cầu ứng viên:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Tốt nghiệp Điều dưỡng, Y sĩ hoặc có chứng chỉ Phụ tá nha khoa.</li>
                                <li>Cẩn thận, sạch sẽ, nắm vững quy trình kiểm soát nhiễm khuẩn.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Job 3 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 hover:border-blue-400 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-indigo-100 text-indigo-700">Theo ca / Toàn thời gian</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">TP. Hồ Chí Minh</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">3. Chuyên Viên Lễ Tân & Chăm Sóc Khách Hàng</h3>
                        </div>
                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                            <div class="text-left sm:text-right">
                                <div class="text-xs text-slate-400 font-semibold uppercase">Mức thu nhập</div>
                                <div class="text-lg font-black text-emerald-600">8 - 13 Triệu + Thưởng</div>
                            </div>
                            <button type="button" @click="applyJob = 'Chuyên Viên Lễ Tân & Chăm Sóc Khách Hàng'" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-xs transition">
                                📝 Ứng tuyển vị trí này
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-5 text-sm text-slate-600">
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Mô tả công việc:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Tiếp đón khách hàng, xác nhận lịch hẹn trực tuyến trên phần mềm DCMS.</li>
                                <li>Thực hiện lập hóa đơn thanh toán dịch vụ & đơn thuốc, hỗ trợ quét mã VietQR.</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 mb-2">Yêu cầu ứng viên:</p>
                            <ul class="space-y-1.5 list-disc list-inside text-xs sm:text-sm">
                                <li>Ngoại hình thiện cảm, giọng nói rõ ràng, sử dụng máy tính thành thạo.</li>
                                <li>Ưu tiên ứng viên từng làm lễ tân phòng khám, bệnh viện hoặc thẩm mỹ.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hướng dẫn nộp hồ sơ -->
            <div class="mt-10 bg-gradient-to-r from-slate-900 to-blue-950 rounded-3xl p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-xl font-black mb-1">Cách thức ứng tuyển nhanh</h4>
                    <p class="text-sm text-slate-300">Gửi CV qua email <a href="mailto:tuyendung@nhakhoasmile.vn" class="text-white font-bold underline">tuyendung@nhakhoasmile.vn</a> hoặc điền biểu mẫu ứng tuyển trực tuyến.</p>
                </div>
                <button type="button" @click="applyJob = 'Ứng tuyển nhân sự Nha Khoa Smile'" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-extrabold text-sm whitespace-nowrap transition">
                    📝 Nộp Hồ Sơ Trực Tuyến →
                </button>
            </div>
        </div>

        <!-- Modal Nộp hồ sơ ứng tuyển nhanh -->
        <div x-show="applyJob !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-xs" @keydown.escape.window="applyJob = null">
            <div @click.away="applyJob = null" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-600">Ứng tuyển trực tuyến</span>
                        <h3 class="text-lg font-black text-slate-900 mt-0.5" x-text="applyJob"></h3>
                    </div>
                    <button type="button" @click="applyJob = null" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center">✕</button>
                </div>

                <form action="{{ route('public.contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Họ và tên ứng viên *</label>
                        <input type="text" name="name" required placeholder="Nhập họ và tên của bạn..." class="w-full rounded-xl border-slate-300 text-sm py-2.5 px-3.5 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Số điện thoại liên hệ *</label>
                        <input type="text" name="phone" required placeholder="Ví dụ: 0901 234 567" class="w-full rounded-xl border-slate-300 text-sm py-2.5 px-3.5 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-slate-700 mb-1.5">Tóm tắt kinh nghiệm & Vị trí ứng tuyển *</label>
                        <textarea name="message" rows="4" required class="w-full rounded-xl border-slate-300 text-sm py-2.5 px-3.5 focus:border-blue-600 focus:ring-blue-600" :value="'[ỨNG TUYỂN: ' + applyJob + '] - Kinh nghiệm chuyên môn: '"></textarea>
                    </div>
                    <div class="pt-2 flex items-center justify-end gap-3">
                        <button type="button" @click="applyJob = null" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">Hủy</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow">Gửi Hồ Sơ Ứng Tuyển</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
