@extends('layouts.public')

@section('title', 'Tẩy trắng răng - Nha Khoa Smile')

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
                <li class="font-semibold text-gray-800">Tẩy trắng răng</li>
            </ol>
        </nav>

        <!-- Main Content Article -->
        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 prose prose-lg prose-blue max-w-none">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-8 uppercase">Tẩy trắng răng</h1>
            
            <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=1200" alt="Tẩy trắng răng" class="w-full h-80 object-cover rounded-2xl mb-10 shadow-md">

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Tẩy trắng răng Là Gì?</h2>
            <p class="text-gray-700 leading-relaxed mb-6">Lấy lại nụ cười trắng sáng rạng rỡ chỉ sau 60 phút với công nghệ tẩy trắng răng Laser.</p>
            <p class="text-gray-700 leading-relaxed mb-6">Nha Khoa Smile tự hào áp dụng các công nghệ tiên tiến nhất trong nha khoa để mang đến dịch vụ <strong>Tẩy trắng răng</strong> an toàn, nhanh chóng và đạt hiệu quả thẩm mỹ cao nhất cho mọi khách hàng. Đội ngũ y bác sĩ giàu kinh nghiệm sẽ trực tiếp thăm khám và lên phác đồ điều trị chuyên biệt cho từng trường hợp.</p>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Quy Trình Thực Hiện Tại Nha Khoa Smile</h2>
            <ol class="list-decimal pl-6 mb-8 text-gray-700 space-y-2">
                <li>Thăm khám tổng quát và chụp phim X-quang kỹ thuật số.</li>
                <li>Bác sĩ chuyên khoa phân tích và lên phác đồ điều trị chi tiết.</li>
                <li>Tiến hành vệ sinh răng miệng và vô cảm (gây tê) đảm bảo không đau.</li>
                <li>Thực hiện quy trình điều trị chuẩn y khoa với thiết bị vô trùng tuyệt đối.</li>
                <li>Kiểm tra sau điều trị, hướng dẫn chăm sóc tại nhà và hẹn lịch tái khám.</li>
            </ol>

            <h2 class="text-2xl font-bold text-slate-800 mt-10 mb-4 uppercase">Vì Sao Chọn Nha Khoa Smile?</h2>
            <ul class="list-disc pl-6 mb-12 text-gray-700 space-y-2">
                <li>Đội ngũ bác sĩ chuyên khoa răng hàm mặt giỏi, trên 10 năm kinh nghiệm.</li>
                <li>Hệ thống trang thiết bị, máy móc nhập khẩu nguyên chiếc từ Châu Âu.</li>
                <li>Phòng khám vô trùng đạt tiêu chuẩn khắt khe của Bộ Y Tế.</li>
                <li>Chi phí minh bạch, cam kết không phát sinh trong suốt quá trình điều trị.</li>
                <li>Chế độ bảo hành chính hãng và chăm sóc khách hàng trọn đời.</li>
            </ul>

            <!-- Booking Section inside Article -->
            <div class="bg-blue-600 rounded-2xl p-8 mt-12 text-white shadow-xl" id="dat-lich">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2 uppercase">Đăng Ký Tư Vấn Miễn Phí Từ Chuyên Gia</h3>
                    <p class="text-blue-100">Hãy để lại thông tin, bác sĩ chuyên khoa của chúng tôi sẽ liên hệ lại ngay!</p>
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
                                <option value="">{{ isset($targetService) ? $targetService->name : 'Dịch vụ' }}</option>
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