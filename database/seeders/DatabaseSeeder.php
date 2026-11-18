<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\Service;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'description' => 'Quản trị viên hệ thống']);
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor', 'description' => 'Bác sĩ nha khoa']);
        $receptionRole = Role::firstOrCreate(['name' => 'Receptionist', 'description' => 'Nhân viên lễ tân']);

        // 2. Tạo Tài khoản Admin
        User::firstOrCreate(
            ['email' => 'admin@smile.com'],
            [
                'name' => 'Quản trị viên',
                'password' => Hash::make('password'), // password là: password
                'phone' => '0901234567',
                'role_id' => $adminRole->id,
            ]
        );

        // 3. Tạo Tài khoản Lễ tân
        $receptionist = User::firstOrCreate(
            ['email' => 'letan@smile.com'],
            [
                'name' => 'Lễ tân Ngọc Ánh',
                'password' => Hash::make('password'),
                'phone' => '0912345678',
                'role_id' => $receptionRole->id,
            ]
        );
        Receptionist::firstOrCreate(['user_id' => $receptionist->id]);

        // 4. Tạo Tài khoản Bác sĩ
        $doctor = User::firstOrCreate(
            ['email' => 'bacsi@smile.com'],
            [
                'name' => 'BS. Trần Văn A',
                'password' => Hash::make('password'),
                'phone' => '0923456789',
                'role_id' => $doctorRole->id,
            ]
        );
        Doctor::firstOrCreate([
            'user_id' => $doctor->id,
            'specialty' => 'Nha khoa thẩm mỹ',
            'description' => 'Bác sĩ chuyên môn cao với 10 năm kinh nghiệm'
        ]);

        // 5. Cấu hình Hệ thống (System Settings)
        $settings = [
            'clinic_name' => 'Nha Khoa Smile',
            'clinic_hotline' => '1900 1234',
            'clinic_address' => '123 Nguyễn Văn Cừ, Quận 5, TP.HCM',
            'vat_percentage' => '10',
            'currency_unit' => 'VNĐ',
            'bank_id' => 'TCB',
            'bank_account_no' => '6362566666',
            'bank_account_name' => 'PHAM XUAN TRUONG',
        ];
        foreach ($settings as $key => $value) {
            SystemSetting::firstOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }

        // 6. Dữ liệu Dịch vụ mẫu (Services)
        $services = [
            ['service_code' => 'SV001', 'name' => 'Khám tổng quát & Tư vấn', 'price' => 100000, 'duration_minutes' => 15, 'is_active' => true],
            ['service_code' => 'SV002', 'name' => 'Cạo vôi răng, đánh bóng', 'price' => 200000, 'duration_minutes' => 30, 'is_active' => true],
            ['service_code' => 'SV003', 'name' => 'Nhổ răng khôn (Răng số 8)', 'price' => 1500000, 'duration_minutes' => 45, 'is_active' => true],
            ['service_code' => 'SV004', 'name' => 'Trám răng thẩm mỹ', 'price' => 300000, 'duration_minutes' => 30, 'is_active' => true],
            ['service_code' => 'SV005', 'name' => 'Tẩy trắng răng Laser', 'price' => 2500000, 'duration_minutes' => 60, 'is_active' => true],
        ];
        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }

        $this->command->info('Đã tạo thành công dữ liệu mẫu (Roles, Admin, Lễ tân, Bác sĩ, Dịch vụ, Cấu hình)!');
    }
}
