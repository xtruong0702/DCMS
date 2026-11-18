@extends('layouts.public')

@section('title', 'Răng sứ thẩm mỹ chuyên sâu - Nha Khoa Smile')

@section('content')
<div class="bg-slate-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-8">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('public.services') }}" class="hover:text-blue-600">Dịch vụ</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="font-semibold text-gray-800">Răng sứ thẩm mỹ chuyên sâu</li>
            </ol>
        </nav>

        <!-- Main Content Article -->
        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 prose prose-lg prose-blue max-w-none">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-8 uppercase">Răng sứ thẩm mỹ chuyên sâu</h1>
            
            <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=1200" alt="Bọc răng sứ thẩm mỹ" class="w-full h-80 object-cover rounded-2xl mb-10 shadow-md">

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Bọc Răng Sứ Là Gì? Có Tốt Không? Giá Bọc Răng Sứ Bao Nhiêu?</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Bọc răng sứ đang là phương pháp làm đẹp răng được đông đảo mọi người lựa chọn để cải thiện hàm răng và nụ cười. Với nhiều ưu điểm nổi bật, bọc răng sứ giúp khắc phục các khuyết điểm, mang đến một nụ cười trắng sáng, cân bằng hàm răng đều đẹp tự nhiên, giúp bạn tự tin hơn trong giao tiếp và cuộc sống hàng ngày. Vậy bọc sứ thực sự là gì? Bọc răng sứ có tốt như quảng cáo không? Chi phí bọc răng sứ là bao nhiêu? Hãy cùng Nha Khoa Smile tìm hiểu và khám phá những lợi ích của phương pháp này.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Bọc Răng Sứ Là Gì?</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Bọc răng sứ thẩm mỹ là phương pháp phục hình bằng vật liệu sứ giúp phục hồi chức năng và cải thiện thẩm mỹ, giúp mang lại dáng răng đều, đẹp, màu sắc tự nhiên như răng thật. Đó là một kỹ thuật thẩm mỹ trong nha khoa, sử dụng một lớp mão răng sứ để bao bọc bên ngoài răng thật. Quá trình này giúp cải thiện hình dáng, màu sắc và độ chắc chắn của răng.</p>
            <p class="text-gray-700 leading-relaxed mb-6">Bọc răng sứ thường được chỉ định cho những trường hợp răng bị sứt, mẻ, nhiễm màu nặng không thể tẩy trắng, răng thưa, hoặc các răng có hình dạng không đều. Bác sĩ sẽ tiến hành mài nhẹ răng hư để làm cùi răng, sau đó lắp mão răng sứ lên trên. Phần mão sứ này sẽ có độ trong và màu sắc trắng sáng tự nhiên như răng thật.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Đánh giá ưu và nhược điểm của làm răng sứ thẩm mỹ</h2>
            <h3 class="text-xl font-semibold text-blue-600 mt-6 mb-3">Ưu điểm:</h3>
            <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                <li>Cải thiện thẩm mỹ: mang lại hàm răng trắng sáng, đều đẹp, và che phủ các khuyết điểm như thưa, sứt mẻ hoặc màu răng ố vàng.</li>
                <li>Độ bền cao: Răng sứ có độ cứng và độ bền rất tốt, cho phép ăn nhai thoải mái, tuổi thọ kéo dài từ 10-15 năm hoặc hơn nếu chăm sóc đúng cách.</li>
                <li>An toàn và tương thích: Răng sứ lành tính với mô nướu, không gây kích ứng và ít biến chứng về lâu dài.</li>
                <li>Bảo vệ răng thật: Lớp sứ bao bọc giúp bảo vệ răng thật khỏi vi khuẩn và sâu răng.</li>
            </ul>

            <h3 class="text-xl font-semibold text-red-500 mt-6 mb-3">Nhược điểm:</h3>
            <ul class="list-disc pl-6 mb-8 text-gray-700 space-y-2">
                <li>Xâm lấn mô răng thật: Yêu cầu mài một phần mô răng thật để tạo hình phù hợp, điều này có thể gây ê buốt nhẹ trong thời gian đầu.</li>
                <li>Chi phí tương đối cao: Các loại răng sứ chất lượng cao (Zirconia, Emax, Nacera…) có giá thành khá cao.</li>
                <li>Yêu cầu kỹ thuật chính xác: Nếu phục hình không đúng kỹ thuật (sai khớp cắn, không khít sát) có thể gây cộm cấn, viêm nướu.</li>
                <li>Nguy cơ sứt, nứt nếu sử dụng sai cách: Dù rất bền, răng sứ vẫn có nguy cơ mẻ nếu cắn vật quá cứng.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Ai Nên Bọc Răng Sứ?</h2>
            <p class="text-gray-700 leading-relaxed mb-4">Với sự phát triển của công nghệ nha khoa hiện đại, bọc răng sứ giúp khắc phục hiệu quả các tình trạng:</p>
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 font-medium text-center">Răng nhiễm màu nặng (Tetracycline)</div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 font-medium text-center">Răng thưa, hở kẽ</div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 font-medium text-center">Răng sứt mẻ, gãy vỡ</div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 font-medium text-center">Răng khấp khểnh, lệch lạc nhẹ</div>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Tiêu chí lựa chọn răng sứ phù hợp:</h2>
            <ul class="list-disc pl-6 mb-8 text-gray-700 space-y-2">
                <li><strong>Thẩm mỹ:</strong> Chọn loại răng sứ có màu sắc tự nhiên, độ trong suốt cao, đặc biệt cho vùng răng cửa.</li>
                <li><strong>Độ bền và chịu lực:</strong> Với răng hàm cần chịu lực nhai lớn, nên chọn răng toàn sứ Zirconia.</li>
                <li><strong>Tính tương thích:</strong> Răng sứ không kim loại phù hợp cho người cơ địa dễ dị ứng kim loại.</li>
                <li><strong>Ngân sách:</strong> Răng sứ kim loại giá thấp hơn nhưng răng toàn sứ cho tính thẩm mỹ tối ưu hơn.</li>
                <li><strong>Chế độ bảo hành:</strong> Chọn nơi có bảo hành rõ ràng, chính hãng.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Quy Trình Bọc Răng Sứ Thẩm Mỹ</h2>
            <p class="text-gray-700 leading-relaxed mb-4">Quy trình bọc răng sứ tại Nha Khoa Smile được diễn ra khép kín theo tiêu chuẩn y khoa. Chỉ mất từ 4 – 5 ngày cho 2 lần hẹn:</p>
            <ol class="list-decimal pl-6 mb-8 text-gray-700 space-y-2">
                <li>Thăm khám tổng quát, tư vấn loại sứ phù hợp, chụp phim X-Quang.</li>
                <li>Vệ sinh răng miệng, gây tê và tiến hành mài cùi răng.</li>
                <li>Lấy dấu hàm kỹ thuật số và gắn răng tạm.</li>
                <li>Thiết kế và chế tác răng sứ tại Labo theo tỷ lệ 1:1.</li>
                <li>Thử lắp răng sứ, kiểm tra khớp cắn, tính thẩm mỹ.</li>
                <li>Gắn răng sứ cố định và hoàn thiện nụ cười.</li>
            </ol>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Bảng Giá Răng Sứ Thẩm Mỹ (Tham Khảo)</h2>
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-blue-50 text-blue-800">
                            <th class="p-4 border border-gray-200 font-bold">STT</th>
                            <th class="p-4 border border-gray-200 font-bold">Dịch vụ</th>
                            <th class="p-4 border border-gray-200 font-bold">Chi phí / 1 Răng (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr><td class="p-4 border border-gray-200 text-center">1</td><td class="p-4 border border-gray-200">Bọc răng sứ Kim loại Titan</td><td class="p-4 border border-gray-200 font-semibold">2.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">2</td><td class="p-4 border border-gray-200">Bọc răng sứ Katana (Nhật)</td><td class="p-4 border border-gray-200 font-semibold">3.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">3</td><td class="p-4 border border-gray-200">Bọc răng sứ Venus (Đức)</td><td class="p-4 border border-gray-200 font-semibold">4.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">4</td><td class="p-4 border border-gray-200">Bọc răng sứ Cercon (Đức)</td><td class="p-4 border border-gray-200 font-semibold">5.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">5</td><td class="p-4 border border-gray-200">Bọc răng sứ Emax (Đức)</td><td class="p-4 border border-gray-200 font-semibold">5.500.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">6</td><td class="p-4 border border-gray-200">Bọc răng sứ Ceramil (Đức)</td><td class="p-4 border border-gray-200 font-semibold">6.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">7</td><td class="p-4 border border-gray-200">Bọc răng sứ Nacera (Đức)</td><td class="p-4 border border-gray-200 font-semibold">9.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">8</td><td class="p-4 border border-gray-200">Dán sứ Veneer Emax</td><td class="p-4 border border-gray-200 font-semibold">9.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">9</td><td class="p-4 border border-gray-200">Răng sứ Lava Plus Esthetic (Mỹ)</td><td class="p-4 border border-gray-200 font-semibold">15.000.000</td></tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Vì Sao Chọn Làm Răng Sứ Tại Nha Khoa Smile?</h2>
            <ul class="list-disc pl-6 mb-12 text-gray-700 space-y-2">
                <li>Đối tác chiến lược của các tập đoàn sứ nha khoa hàng đầu như Cercon, Nacera, Oredent.</li>
                <li>Đội ngũ bác sĩ chuyên môn cao, hơn 10 năm kinh nghiệm trong lĩnh vực phục hình sứ thẩm mỹ.</li>
                <li>Sử dụng phôi sứ chính hãng, có thẻ bảo hành check mã vạch toàn cầu.</li>
                <li>Thiết kế nụ cười chuyên biệt (Smile Design), xem trước kết quả.</li>
                <li>Cơ sở vật chất hiện đại, hệ thống vô trùng đạt tiêu chuẩn.</li>
            </ul>

            <!-- Booking Section inside Article -->
            <div class="bg-blue-600 rounded-2xl p-8 mt-12 text-white shadow-xl" id="dat-lich">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2 uppercase">Đăng Ký Tư Vấn Miễn Phí Từ Chuyên Gia</h3>
                    <p class="text-blue-100">Hãy để lại thông tin, bác sĩ chuyên khoa phục hình sứ của chúng tôi sẽ liên hệ lại ngay!</p>
                </div>
                
                <form action="{{ route('public.booking.store') }}" method="POST" class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-lg">
                    @csrf
                    <!-- Pre-select Service ID if passed -->
                    @if(isset($targetService))
                        <input type="hidden" name="service_id" value="{{ $targetService->id }}">
                    @endif
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên *</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-800" placeholder="Nhập tên của bạn">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Số điện thoại *</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-800" placeholder="Nhập số điện thoại">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Dịch vụ bạn quan tâm *</label>
                            <select name="service_id_display" disabled class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-600">
                                <option value="">Răng sứ thẩm mỹ chuyên sâu</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Dịch vụ đã được chọn tự động.</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Chọn Bác sĩ khám (Tùy chọn)</label>
                            <select name="doctor_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-800">
                                <option value="">-- Để phòng khám sắp xếp Bác sĩ chuyên khoa --</option>
                                @if(isset($doctors))
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}">BS. {{ $doc->user->name ?? '' }} ({{ $doc->specialty ?: 'Chuyên khoa RHM' }})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Lịch hẹn dự kiến -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Thời gian dự kiến (Từ ngày mai) *</label>
                            <input type="datetime-local" name="appointment_time" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\T00:00') }}" value="{{ old('appointment_time', \Carbon\Carbon::tomorrow()->setTime(9, 0)->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-800">
                            <p class="text-xs text-amber-600 mt-1">Lưu ý: Chỉ nhận đặt lịch từ ngày hôm sau trở đi. Nếu khám trong ngày, quý khách không cần đặt lịch mà vui lòng đến trực tiếp phòng khám.</p>
                            @error('appointment_time') <span class="text-red-500 text-xs font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-full shadow-lg transform hover:-translate-y-1 transition-all duration-300 text-lg">
                                Xác Nhận Đăng Ký
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
        </article>
    </div>
</div>
@endsection
