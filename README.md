<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel Logo" width="400">
</p>

# 🏥 Dental Clinic Management System (DCMS)

Hệ thống Quản lý Phòng khám Nha khoa (DCMS) là một ứng dụng Web toàn diện được xây dựng bằng **Laravel 13**, **Tailwind CSS**, và **MySQL**. Dự án được thiết kế đặc biệt cho đồ án tốt nghiệp, cung cấp đầy đủ các tính năng để quản lý một phòng khám nha khoa chuyên nghiệp.

## 🌟 Các tính năng chính (Features)

Hệ thống được chia thành 3 phân hệ (Roles) với các chức năng độc lập nhưng liên kết chặt chẽ với nhau:

### 1. 👑 Phân hệ Admin (Quản trị viên)
- Quản lý Nhân sự: Thêm/Sửa/Xóa tài khoản Bác sĩ, Lễ tân.
- Quản lý Dịch vụ: Thêm/Sửa/Xóa các dịch vụ khám bệnh và đơn giá.
- Cấu hình Hệ thống: Quản lý thông tin phòng khám, Hotline, Thuế VAT.
- Báo cáo & Thống kê: Xem doanh thu, số lượng bệnh nhân, lượt khám. Hỗ trợ xuất dữ liệu ra file **CSV (Excel)** và In báo cáo.

### 2. 👩‍💼 Phân hệ Lễ tân (Receptionist)
- Quản lý Bệnh nhân: Thêm, sửa, xóa hồ sơ bệnh nhân (Lịch sử bệnh lý, dị ứng).
- Quản lý Lịch hẹn: Đặt lịch khám cho bệnh nhân, **Check-in** bệnh nhân vào phòng chờ.
- Quản lý Hóa đơn: Lập hóa đơn chi tiết, áp dụng mã giảm giá, thuế VAT, thanh toán nhiều hình thức (Tiền mặt, Chuyển khoản).

### 3. 👨‍⚕️ Phân hệ Bác sĩ (Doctor)
- Bảng điều khiển: Xem danh sách bệnh nhân đang ở phòng chờ.
- Khám bệnh: Nhập triệu chứng, chẩn đoán bệnh, chỉ định dịch vụ.
- Kê đơn thuốc: Thêm đơn thuốc động với liều lượng chi tiết.
- Hồ sơ bệnh án: Xem lại lịch sử và in phiếu khám bệnh (hỗ trợ in PDF qua trình duyệt).

### 4. 🌍 Phân hệ Khách (Public)
- **Landing Page cao cấp**: Giao diện giới thiệu phòng khám chuyên nghiệp với hiệu ứng Glassmorphism.
- **Trang Đăng nhập (Custom Login)**: Giao diện đăng nhập hiện đại, tự động chuyển hướng theo phân quyền.

---

## 🚀 Công nghệ sử dụng
- **Backend:** Laravel 13, PHP 8.3
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Bảo mật:** Laravel Breeze (Authentication), Custom Middleware (`CheckRole`)

---

## ⚙️ Hướng dẫn Cài đặt & Khởi chạy (Installation)

Dự án này tương thích tốt nhất với **Laragon** trên Windows.

1. **Clone dự án (nếu tải từ GitHub):**
   ```bash
   git clone https://github.com/your-username/DCMS.git
   cd DCMS
   ```

2. **Cài đặt thư viện (PHP & Node):**
   ```bash
   composer install
   npm install
   ```

3. **Cấu hình môi trường (.env):**
   Copy file `.env.example` thành `.env`, sau đó cập nhật thông tin Database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dcms
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Tạo key và khởi tạo Database:**
   *(Hãy chắc chắn bạn đã tạo database `dcms` trong MySQL bằng HeidiSQL hoặc PhpMyAdmin)*
   ```bash
   php artisan key:generate
   
   # Chạy lệnh này để xóa DB cũ, tạo lại toàn bộ bảng và nạp dữ liệu mẫu
   php artisan migrate:fresh --seed
   ```

5. **Biên dịch giao diện (Tailwind CSS):**
   ```bash
   npm.cmd run build 
   # (Hoặc npm run build tùy cấu hình máy)
   ```

6. **Khởi chạy Server:**
   Nếu dùng Laragon, hãy bật tính năng `Auto Virtual Hosts` và truy cập `http://dcms.test`.
   Hoặc chạy lệnh thủ công:
   ```bash
   php artisan serve
   ```
   Sau đó truy cập: `http://localhost:8000`

---

## 🔑 Tài khoản Test (Dummy Data)

Sau khi chạy lệnh `--seed` ở trên, hệ thống sẽ tự động tạo sẵn 3 tài khoản mẫu để bạn test ngay lập tức:

- **Admin:** `admin@smile.com` / Mật khẩu: `password`
- **Lễ tân:** `letan@smile.com` / Mật khẩu: `password`
- **Bác sĩ:** `bacsi@smile.com` / Mật khẩu: `password`

---

## 📜 Giấy phép (License)
Dự án này là mã nguồn mở. Được thiết kế riêng cho mục đích học tập và làm đồ án tốt nghiệp.
