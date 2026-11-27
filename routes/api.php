<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentWebhookController;
use App\Http\Controllers\Api\DentalAiChatController;

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

// API Trợ lý AI Tư vấn Nha khoa 24/7
Route::post('/ai-assistant/chat', [DentalAiChatController::class, 'chat'])->middleware('throttle:25,1')->name('api.ai.chat');

