@extends('layouts.public')

@section('title', 'Trồng răng implant chuyên sâu - Nha Khoa Smile')

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
                <li class="font-semibold text-gray-800">Trồng răng implant chuyên sâu</li>
            </ol>
        </nav>

        <!-- Main Content Article -->
        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 prose prose-lg prose-blue max-w-none">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-8">Trồng răng implant chuyên sâu</h1>
            
            <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=1200" alt="Trồng răng implant" class="w-full h-80 object-cover rounded-2xl mb-10 shadow-md">

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Trồng răng Implant là gì?</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Trồng răng Implant là phương pháp khôi phục răng mất cố định, được thực hiện bằng cách phẫu thuật đặt trụ Implant được làm từ vật liệu Titanium vào trong xương hàm. Sau khi chờ một thời gian để trụ Implant tích hợp với xương hàm, bác sĩ sẽ tiến hành lắp khớp nối Abutment và phục hình răng sứ bên trên.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Kỹ thuật trồng răng Implant</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Phương pháp trồng răng Implant được nghiên cứu và phát triển bởi GS. Per-Ingvar Brånemark – Trưởng nhóm nghiên cứu trường Đại học Lund, Thụy Điển. Ông được coi là cha đẻ của phương pháp cấy ghép Implant. Năm 1965, ông thực hiện thành công ca cấy ghép titan đầu tiên cho một bệnh nhân tại Thụy Điển. Sự nghiệp của Brånemark đã thay đổi diện mạo ngành nha khoa, cải thiện chất lượng cuộc sống cho hàng triệu người.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Các đối tượng nên trồng răng Implant</h2>
            <p class="text-gray-700 leading-relaxed mb-4">Phương pháp trồng răng Implant có thể áp dụng cho hầu hết các trường hợp mất răng ở bất kỳ vị trí nào trên hàm. Các đối tượng phù hợp bao gồm:</p>
            <ul class="list-disc pl-6 mb-8 text-gray-700 space-y-2">
                <li>Người mất 1 răng, nhiều răng hoặc mất toàn bộ răng ở hàm trên hoặc hàm dưới.</li>
                <li>Bệnh nhân mất răng bẩm sinh hoặc do tai nạn, bệnh lý.</li>
                <li>Răng bị hỏng nặng, viêm nha chu không thể bảo tồn và phải nhổ bỏ.</li>
                <li>Răng bị lung lay, mất xương ổ răng.</li>
                <li>Người đã từng làm răng giả nhưng gặp hư hỏng và muốn thay thế.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Đánh giá ưu và nhược điểm của phương pháp trồng răng Implant</h2>
            <h3 class="text-xl font-semibold text-blue-600 mt-6 mb-3">Ưu điểm:</h3>
            <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                <li>Phục hồi toàn diện từ chân đến thân răng, mang lại thẩm mỹ tự nhiên.</li>
                <li>Khả năng ăn nhai gần như răng thật, hồi phục đến 99%.</li>
                <li>Đứng độc lập tại vị trí răng mất, không ảnh hưởng đến các răng bên cạnh.</li>
                <li>Hấp thụ lực truyền tải đến xương hàm, duy trì mật độ xương, ngăn ngừa tiêu xương.</li>
                <li>Độ bền cao, có thể kéo dài hơn 20 năm hoặc vĩnh viễn nếu chăm sóc tốt.</li>
            </ul>

            <h3 class="text-xl font-semibold text-red-500 mt-6 mb-3">Nhược điểm:</h3>
            <ul class="list-disc pl-6 mb-8 text-gray-700 space-y-2">
                <li>Chi phí cao hơn so với các phương pháp phục hình răng khác.</li>
                <li>Thời gian điều trị kéo dài từ 2 đến 6 tháng để trụ Implant hợp nhất với xương.</li>
                <li>Không phù hợp với trẻ dưới 18 tuổi, người sức khỏe yếu hoặc mắc bệnh lý nền không kiểm soát.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Quy trình trồng răng Implant tại Nha Khoa Smile</h2>
            <p class="text-gray-700 leading-relaxed mb-4">Quy trình trồng răng Implant được thực hiện theo 9 bước chuẩn y khoa:</p>
            <ol class="list-decimal pl-6 mb-8 text-gray-700 space-y-2">
                <li>Thăm khám tổng quát, xác định tình trạng xương hàm, số lượng răng mất.</li>
                <li>Chụp phim X-quang CT Cone Beam, Scan dấu răng 3D.</li>
                <li>Lên phác đồ điều trị với công nghệ kỹ thuật số.</li>
                <li>Tư vấn phác đồ điều trị thông qua hình ảnh 3D.</li>
                <li>Ký kết hợp đồng bảo hành dịch vụ.</li>
                <li>Tiến hành gây tê, đặt trụ Implant an toàn, không đau.</li>
                <li>Kiểm tra và cắt chỉ sau 10 ngày – 2 tuần.</li>
                <li>Đặt trụ lành thương, thử mão sứ sau 2 – 3 tháng.</li>
                <li>Lắp răng sứ cố định và kết thúc quá trình trồng răng Implant.</li>
            </ol>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Bảng giá Trồng răng Implant</h2>
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-blue-50 text-blue-800">
                            <th class="p-4 border border-gray-200 font-bold">STT</th>
                            <th class="p-4 border border-gray-200 font-bold">Dịch vụ</th>
                            <th class="p-4 border border-gray-200 font-bold">Chi phí (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr><td class="p-4 border border-gray-200 text-center">1</td><td class="p-4 border border-gray-200">Cấy ghép implant Yes Biotech</td><td class="p-4 border border-gray-200 font-semibold">8.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">2</td><td class="p-4 border border-gray-200">Cấy ghép implant Straumann Thụy Sĩ</td><td class="p-4 border border-gray-200 font-semibold">30.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">3</td><td class="p-4 border border-gray-200">Phục hình cố định trên implant Sứ Titan</td><td class="p-4 border border-gray-200 font-semibold">2.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">4</td><td class="p-4 border border-gray-200">Phục hình cố định trên implant Ceramil</td><td class="p-4 border border-gray-200 font-semibold">6.000.000</td></tr>
                        <tr><td class="p-4 border border-gray-200 text-center">5</td><td class="p-4 border border-gray-200">Phẫu thuật ghép xương</td><td class="p-4 border border-gray-200 font-semibold">5.000.000 – 10.000.000</td></tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Cấy răng Implant có đau không? An toàn không?</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Trước khi trồng răng Implant bác sĩ đã tiến hành gây tê cục bộ tại vùng phẫu thuật. Do đó bệnh nhân sẽ không cảm thấy đau đớn hay khó chịu trong quá trình thực hiện. Sau khi cấy ghép, bạn sẽ được kê đơn thuốc giảm đau, kháng viêm để đảm bảo sự thoải mái nhất.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4">Vì sao nên lựa chọn trồng răng Implant tại Nha Khoa Smile?</h2>
            <ul class="list-disc pl-6 mb-12 text-gray-700 space-y-2">
                <li>Đối tác chiến lược của Straumann Group và Osstem.</li>
                <li>Đội ngũ bác sĩ nha khoa có trình độ chuyên môn cao và nhiều năm kinh nghiệm.</li>
                <li>Miễn phí khám, nhận phác đồ điều trị và chụp phim.</li>
                <li>Báo giá trọn gói, minh bạch, không phát sinh thêm chi phí.</li>
                <li>Trang thiết bị y tế và cơ sở vật chất hiện đại, vô trùng chuẩn y tế.</li>
            </ul>

            <!-- Booking Section inside Article -->
            <div class="bg-blue-600 rounded-2xl p-8 mt-12 text-white shadow-xl" id="dat-lich">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2">ĐĂNG KÝ NGAY ĐỂ ĐƯỢC TƯ VẤN MIỄN PHÍ TỪ CHUYÊN GIA</h3>
                    <p class="text-blue-100">Hãy để lại thông tin, chúng tôi sẽ gọi lại ngay cho bạn!</p>
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
                                <option value="">Trồng răng implant chuyên sâu</option>
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
