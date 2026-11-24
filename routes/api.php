<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Tuyến đường API cho hệ thống DCMS. Các route này mặc định không bị ràng buộc
| bởi xác thực CSRF Token và thích hợp cho Webhook Ngân hàng & Gọi dữ liệu AJAX.
|
*/

// Nhóm Route Webhook Thanh toán tự động (Ngân hàng / SePay / PayOS / Casso)
Route::post('/payment/webhook', [PaymentWebhookController::class, 'handleWebhook'])->name('api.payment.webhook');
Route::post('/webhooks/sepay', [PaymentWebhookController::class, 'handleWebhook'])->name('api.webhooks.sepay');
Route::post('/webhooks/payos', [PaymentWebhookController::class, 'handleWebhook'])->name('api.webhooks.payos');

// API kiểm tra trạng thái thanh toán thời gian thực (cho trang Bệnh nhân & Lễ tân tự động đổi màu)
Route::get('/invoices/{code}/status', [PaymentWebhookController::class, 'checkStatus'])->name('api.invoices.status');

// API mô phỏng thanh toán (Test / Demo)
Route::post('/payment/simulate', [PaymentWebhookController::class, 'simulate'])->name('api.payment.simulate');

// Debug kiểm tra và sửa nhanh tài khoản Admin
Route::get('/check-users', function () {
    $users = \App\Models\User::with('role')->get()->map(function ($u) {
        return [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'phone' => $u->phone,
            'role' => $u->role->name ?? null,
            'is_password_valid' => \Illuminate\Support\Facades\Hash::check('password', $u->password),
            'raw_password_prefix' => substr($u->password, 0, 15),
        ];
    });
    return response()->json($users);
});

Route::get('/fix-admin', function () {
    $adminRole = \App\Models\Role::firstOrCreate(['name' => 'Admin'], ['description' => 'Quản trị viên']);
    $user = \App\Models\User::updateOrCreate(
        ['email' => 'admin@smile.com'],
        [
            'name' => 'Quản trị viên Hệ thống',
            'phone' => '0901234567',
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]
    );
    \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update([
        'password' => \Illuminate\Support\Facades\Hash::make('password')
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Đã cập nhật mật khẩu tài khoản admin@smile.com thành password!',
        'check' => \Illuminate\Support\Facades\Hash::check('password', \App\Models\User::find($user->id)->password),
    ]);
});
