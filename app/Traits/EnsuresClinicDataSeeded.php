<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

trait EnsuresClinicDataSeeded
{
    /**
     * Tự động kiểm tra và khởi tạo dữ liệu mẫu nếu chưa có trên hệ thống.
     * Đảm bảo tài khoản admin@smile.com và toàn bộ bác sĩ, lễ tân, bệnh nhân luôn sẵn sàng đăng nhập.
     */
    protected function ensureClinicData(): void
    {
        try {
            if (!Schema::hasTable('users') || !Schema::hasTable('roles')) {
                return;
            }

            $admin = User::where('email', 'admin@smile.com')->first();
            $patientCount = Schema::hasTable('patients') ? Patient::count() : 0;

            if (!$admin || $patientCount === 0) {
                Artisan::call('db:seed', ['--force' => true]);
            } elseif (!Hash::check('password', $admin->password)) {
                DB::table('users')->where('id', $admin->id)->update([
                    'password' => Hash::make('password'),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Auto ensure clinic data seeder error: ' . $e->getMessage());
        }
    }
}
