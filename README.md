<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel Logo" width="280">
</p>

<h1 align="center">🦷 Nha Khoa Smile — Dental Clinic Management System (DCMS)</h1>

<p align="center">
  Hệ thống Quản lý Phòng khám Nha khoa toàn diện xây dựng trên <strong>Laravel 13</strong>, <strong>Tailwind CSS</strong>, <strong>Alpine.js</strong> và <strong>MySQL</strong>.<br>
  Tích hợp <strong>Trợ lý AI Nha khoa 24/7 (Google Gemini)</strong>, <strong>Thanh toán tự động VietQR / SePay</strong> và <strong>Đặt lịch thông minh chống trùng giờ</strong>.
</p>

---

## ✨ Tính năng nổi bật

Hệ thống được thiết kế với **4 phân hệ người dùng (RBAC)** kết nối xuyên suốt từ trải nghiệm khách hàng bên ngoài đến quy trình vận hành lâm sàng bên trong:

### 1. 🌍 Website Khách hàng & Đặt lịch trực tuyến (Public)
- **Landing Page chuẩn 5 sao**: Giao diện Luxury Emerald & Gold, tích hợp **Thanh trượt So sánh Trước & Sau dán sứ Veneer Emax** tương tác và **Thư viện không gian phòng khám & thiết bị** (CT ConeBeam 3D, phòng VIP vô trùng, sảnh chờ).
- **Trợ lý AI Nha khoa 24/7 (Google Gemini)**: Chatbot nổi góc màn hình tư vấn triệu chứng răng miệng, giải đáp bảng giá dịch vụ theo dữ liệu thực tế từ hệ thống và hỗ trợ hướng dẫn đặt lịch.
- **Đặt lịch khám thông minh**: Chọn dịch vụ, bác sĩ và ngày khám; hệ thống tự động tính **thời lượng dịch vụ (`duration_minutes`)**, hiển thị các khung giờ bác sĩ đã bận theo thời gian thực và chặn trùng lịch.
- **Đội ngũ Bác sĩ & Giới thiệu**: Hồ sơ chuyên môn chi tiết của 5 bác sĩ Việt Nam, bảng giá dịch vụ minh bạch và trang tra cứu lịch hẹn/hồ sơ nhanh.

### 2. 👑 Phân hệ Quản trị viên (Admin)
- **Trung tâm Điều hành (Dashboard)**: Tổng quan KPI doanh thu, lịch hẹn trong ngày, tỉ lệ hoàn thành, lịch khám sắp tới và cảnh báo tồn kho.
- **Quản lý Nhân sự & Chuyên môn**: Thêm/sửa/vô hiệu hóa tài khoản Bác sĩ, Lễ tân và phân quyền truy cập.
- **Quản lý Dịch vụ, Thuốc & Vật tư tiêu hao**: Cấu hình đơn giá, thời lượng thực hiện dịch vụ, tồn kho thuốc, định mức cảnh báo vật tư.
- **Báo cáo & Thống kê chuyên sâu**: Lọc doanh thu theo khoảng thời gian, phương thức thanh toán, hiệu suất bác sĩ; hỗ trợ **xuất CSV (Excel)** và in báo cáo.
- **Cấu hình Hệ thống**: Cập nhật tên phòng khám, địa chỉ, hotline, thuế VAT và thông tin tài khoản ngân hàng nhận VietQR.

### 3. 👩‍💼 Phân hệ Lễ tân (Receptionist)
- **Điều phối Lịch hẹn & Phòng chờ**: Tiếp nhận lịch đặt online, duyệt lịch, đổi giờ chống trùng bác sĩ và **Check-in** đưa bệnh nhân vào hàng đợi khám.
- **Quản lý Bệnh nhân**: Tạo và cập nhật hồ sơ bệnh nhân, tiền sử bệnh lý, dị ứng thuốc *(bảo toàn dữ liệu y tế — không cho phép xóa hồ sơ bệnh nhân)*.
- **Tiếp nhận Yêu cầu Tư vấn**: Xem chi tiết nội dung câu hỏi/yêu cầu liên hệ của khách hàng và cập nhật trạng thái xử lý.
- **Hóa đơn & Thanh toán tự động (VietQR + SePay)**: Lập hóa đơn chi tiết (dịch vụ + thuốc + giảm giá + VAT), tạo mã **VietQR** động theo từng mã hóa đơn. Khi khách chuyển khoản thành công, **SePay Webhook** tự động xác nhận và gạch nợ hóa đơn ngay lập tức.

### 4. 👨‍⚕️ Phân hệ Bác sĩ (Doctor)
- **Hàng đợi Khám bệnh**: Theo dõi danh sách bệnh nhân đã check-in tại phòng chờ theo thời gian thực.
- **Khám lâm sàng & Sơ đồ răng (Dental Chart)**: Ghi nhận triệu chứng, chẩn đoán, phác đồ điều trị và đánh dấu tình trạng chi tiết từng vị trí răng.
- **Chỉ định Dịch vụ, Vật tư & Kê đơn thuốc**: Chọn dịch vụ thực hiện, ghi nhận vật tư tiêu hao, kê đơn thuốc chi tiết liều dùng (Sáng / Trưa / Chiều / Tối) và hẹn ngày tái khám.
- **Hồ sơ Bệnh án & In ấn**: Tra cứu lịch sử khám trước đó và in phiếu khám / đơn thuốc trực tiếp ra PDF.

### 5. 🧑‍💻 Cổng Bệnh nhân (Patient Portal)
- Đăng nhập bằng **Email** hoặc **Số điện thoại**.
- Xem lịch hẹn sắp tới, lịch sử hồ sơ bệnh án, đơn thuốc, hóa đơn và quét mã QR thanh toán trực tuyến.

---

## 🛠️ Công nghệ sử dụng

| Thành phần | Công nghệ |
| :--- | :--- |
| **Backend** | Laravel 13, PHP 8.3+ |
| **Frontend** | Blade Templates, Tailwind CSS, Alpine.js, Vite |
| **Cơ sở dữ liệu** | MySQL 8+ |
| **Xác thực & Phân quyền** | Laravel Breeze, Custom Middleware (`CheckRole`) |
| **Trí tuệ nhân tạo (AI)** | Google Gemini API (`gemini-3.1-flash-lite`) |
| **Thanh toán tự động** | VietQR + SePay Webhook |
| **Triển khai (Deploy)** | Railway / Laragon (Local Windows) |

---

## ⚙️ Hướng dẫn Cài đặt & Khởi chạy (Local)

Dự án hoạt động mượt mà với **Laragon** trên Windows (hoặc PHP 8.3+, Composer, Node.js, MySQL trên macOS/Linux).

### 1. Clone mã nguồn
```bash
git clone https://github.com/xtruong0702/DCMS.git
cd DCMS
```

### 2. Cài đặt thư viện PHP & Node
```bash
composer install
npm install
```

### 3. Cấu hình file `.env`
Sao chép `.env.example` thành `.env` và điền thông tin kết nối:
```env
APP_NAME="Nha Khoa Smile DCMS"
APP_URL=http://dcms.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dcms
DB_USERNAME=root
DB_PASSWORD=

# Trợ lý AI Nha khoa 24/7 (Google Gemini)
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-3.1-flash-lite

# Thanh toán tự động SePay Webhook (tùy chọn)
SEPAY_API_KEY=your_sepay_webhook_api_key
```

### 4. Khởi tạo khóa ứng dụng & Database mẫu
*(Tạo sẵn database `dcms` trong MySQL trước khi chạy)*
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

### 5. Biên dịch giao diện & Khởi chạy
```bash
npm run build
php artisan serve
```
Truy cập ứng dụng tại `http://127.0.0.1:8000` (hoặc `http://dcms.test` nếu bật Auto Virtual Hosts của Laragon).

---

## 🔑 Tài khoản Demo (Sau khi chạy `--seed`)

Tất cả tài khoản mẫu dùng chung mật khẩu: **`password`**

| Vai trò | Họ tên | Email đăng nhập |
| :--- | :--- | :--- |
| **Admin** | Quản trị viên Hệ thống | `admin@smile.com` |
| **Lễ tân** | Lễ tân Ngọc Ánh | `letan@smile.com` |
| **Lễ tân** | Lễ tân Mai Phương | `phuong.letan@smile.com` |
| **Bác sĩ** | BS. Trần Văn A | `bacsi@smile.com` |
| **Bác sĩ** | BS. CKII Lê Hoàng Nam | `nam.le@smile.com` |
| **Bác sĩ** | ThS. BS. Nguyễn Thu Hà | `ha.nguyen@smile.com` |
| **Bác sĩ** | ThS. BS. Mai Phương Uyên | `uyen.mai@smile.com` |
| **Bác sĩ** | BS. CKI Vũ Đức Trọng | `trong.vu@smile.com` |
| **Bệnh nhân** | Nguyễn Văn Hùng | `hung.nguyen@gmail.com` *(hoặc SĐT `0981112233`)* |
| **Bệnh nhân** | Trần Thị Mai *(có hóa đơn chưa thanh toán để test QR)* | `mai.tran@gmail.com` *(hoặc SĐT `0982223344`)* |

---

## 📜 Giấy phép (License)

Dự án phát triển cho mục đích học tập và đồ án tốt nghiệp, phát hành theo giấy phép **MIT License**.
