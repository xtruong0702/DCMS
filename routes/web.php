<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReceptionistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\PublicController::class, 'home'])->name('home');

// Public Pages
Route::get('/dich-vu-va-bang-gia', [\App\Http\Controllers\PublicController::class, 'services'])->name('public.services');
Route::get('/dich-vu/{slug}', [\App\Http\Controllers\PublicController::class, 'serviceDetail'])->name('public.service.detail');
Route::get('/ve-chung-toi/nha-khoa-smile', [\App\Http\Controllers\PublicController::class, 'about'])->name('public.about');
Route::get('/ve-chung-toi/bac-si', [\App\Http\Controllers\PublicController::class, 'doctors'])->name('public.doctors');
Route::get('/kien-thuc', [\App\Http\Controllers\PublicController::class, 'knowledge'])->name('public.knowledge');
Route::get('/tuyen-dung', [\App\Http\Controllers\PublicController::class, 'careers'])->name('public.careers');
Route::get('/lien-he', [\App\Http\Controllers\PublicController::class, 'contact'])->name('public.contact');
Route::post('/lien-he', [\App\Http\Controllers\PublicController::class, 'storeContact'])->name('public.contact.store');
Route::get('/dat-lich', [\App\Http\Controllers\PublicController::class, 'booking'])->name('public.booking');
Route::post('/dat-lich', [\App\Http\Controllers\PublicController::class, 'storeBooking'])->name('public.booking.store');
Route::get('/tra-cuu', [\App\Http\Controllers\PublicController::class, 'lookup'])->name('public.lookup');

// Route tự động nạp dữ liệu mẫu trực tiếp (Seed Database)
Route::get('/seed-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return response()->json([
            'success' => true,
            'message' => 'Đã tự động nạp toàn bộ danh sách Bệnh nhân, Bác sĩ, Lễ tân và Lịch sử khám thành công!',
            'output' => \Illuminate\Support\Facades\Artisan::output(),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Patient Auth Routes
Route::get('/patient/register', [\App\Http\Controllers\PatientAuthController::class, 'showRegister'])->name('patient.register');
Route::post('/patient/register', [\App\Http\Controllers\PatientAuthController::class, 'register'])->name('patient.register.store');
Route::get('/patient/login', [\App\Http\Controllers\PatientAuthController::class, 'showLogin'])->name('patient.login');
Route::post('/patient/login', [\App\Http\Controllers\PatientAuthController::class, 'login'])->name('patient.login.store');
Route::post('/patient/logout', [\App\Http\Controllers\PatientAuthController::class, 'logout'])->name('patient.logout');
Route::get('/patient/forgot-password', [\App\Http\Controllers\PatientAuthController::class, 'showForgotPassword'])->name('patient.password.request');
Route::post('/patient/forgot-password', [\App\Http\Controllers\PatientAuthController::class, 'sendResetOtp'])->name('patient.password.email');
Route::get('/patient/reset-password', [\App\Http\Controllers\PatientAuthController::class, 'showResetPassword'])->name('patient.password.reset');
Route::post('/patient/reset-password', [\App\Http\Controllers\PatientAuthController::class, 'resetPassword'])->name('patient.password.update');

// Common Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // System Notifications
    Route::get('/notifications', [\App\Http\Controllers\System\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/contact-inquiries/{id}/resolve', [\App\Http\Controllers\System\NotificationController::class, 'resolveInquiry'])->name('contact-inquiries.resolve');
    Route::delete('/contact-inquiries/{id}', [\App\Http\Controllers\System\NotificationController::class, 'destroyInquiry'])->name('contact-inquiries.destroy');
    
    // Redirect /dashboard based on role
    Route::get('/dashboard', function () {
        try {
            if (\App\Models\Patient::count() === 0 && \Illuminate\Support\Facades\Schema::hasTable('patients')) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Auto seed failed: ' . $e->getMessage());
        }
        $role = strtolower(auth()->user()->role->name ?? '');
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'doctor') return redirect()->route('doctor.dashboard');
        if ($role === 'receptionist') return redirect()->route('receptionist.dashboard');
        if ($role === 'patient') return redirect()->route('patient.dashboard');
        return view('dashboard');
    })->name('dashboard');
});

// 🔐 ADMIN – QUẢN TRỊ
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/seed-demo-data', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            return back()->with('success', 'Đã tự động nạp thành công toàn bộ danh sách Bệnh nhân, Bác sĩ, Lễ tân và Lịch sử khám mẫu vào hệ thống!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Lỗi khi nạp dữ liệu mẫu: ' . $e->getMessage());
        }
    })->name('seed-demo-data');
    
    // Quản lý tài khoản (Admin, Lễ tân, Bác sĩ)
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class)->except(['show']);
    Route::patch('staff/{staff}/toggle', [\App\Http\Controllers\Admin\StaffController::class, 'toggleStatus'])->name('staff.toggle');
    
    // Quản lý bệnh nhân
    Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class);
    
    // Quản lý bác sĩ
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class)->except(['show']);
    Route::resource('specialties', \App\Http\Controllers\Admin\SpecialtyController::class)->except(['show']);
    Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class)->except(['show']);
    
    // Quản lý lịch hẹn
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class)->except(['show']);
    
    // Quản lý dịch vụ
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['show']);
    Route::patch('services/{service}/toggle', [\App\Http\Controllers\Admin\ServiceController::class, 'toggleStatus'])->name('services.toggle');
    Route::resource('service-categories', \App\Http\Controllers\Admin\ServiceCategoryController::class)->except(['show']);
    
    // Quản lý hóa đơn
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
    Route::post('invoices/{invoice}/refund', [\App\Http\Controllers\Admin\InvoiceController::class, 'refund'])->name('invoices.refund');
    
    // Quản lý kho
    Route::resource('medicines', \App\Http\Controllers\Admin\MedicineController::class)->except(['show']);
    Route::resource('supplies', \App\Http\Controllers\Admin\SupplyController::class)->except(['show']);
    
    // Báo cáo
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
    
    // System Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');
});

// 🧑💼 LỄ TÂN – TIẾP NHẬN
Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
    Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
    
    // Quản lý bệnh nhân
    Route::resource('patients', \App\Http\Controllers\Receptionist\PatientController::class);
    
    // Quản lý lịch hẹn & Check-in
    Route::resource('appointments', \App\Http\Controllers\Receptionist\AppointmentController::class)->except(['show', 'destroy']);
    Route::patch('appointments/{appointment}/checkin', [\App\Http\Controllers\Receptionist\AppointmentController::class, 'checkIn'])->name('appointments.checkin');
    
    // Danh sách chờ & Điều phối
    Route::get('queue', [\App\Http\Controllers\Receptionist\QueueController::class, 'index'])->name('queue.index');
    
    // Hóa đơn & thanh toán
    Route::resource('invoices', \App\Http\Controllers\Receptionist\InvoiceController::class)->only(['index', 'create', 'store', 'show', 'update']);
    Route::post('invoices/{invoice}/pay', [\App\Http\Controllers\Receptionist\InvoiceController::class, 'pay'])->name('invoices.pay');
    Route::get('invoices/{invoice}/print', [\App\Http\Controllers\Receptionist\InvoiceController::class, 'print'])->name('invoices.print');
});

// 👨‍⚕️ BÁC SĨ – KHÁM BỆNH
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    
    // Danh sách chờ khám
    Route::get('queue', [\App\Http\Controllers\Doctor\QueueController::class, 'index'])->name('queue.index');
    
    // Khám bệnh (Thông tin, Triệu chứng, Odontogram, Chẩn đoán, Chỉ định)
    Route::post('consultations/{consultation}/complete', [\App\Http\Controllers\Doctor\ConsultationController::class, 'complete'])->name('consultations.complete');
    Route::resource('consultations', \App\Http\Controllers\Doctor\ConsultationController::class)->only(['index', 'show', 'update']);
    
    // Hồ sơ bệnh án
    Route::resource('medical-records', \App\Http\Controllers\Doctor\MedicalRecordController::class)->only(['update']);
    Route::post('medical-records/{medical_record}/services', [\App\Http\Controllers\Doctor\MedicalRecordController::class, 'storeServiceDetail'])->name('medical-records.services.store');
    Route::delete('medical-records/services/{detail}', [\App\Http\Controllers\Doctor\MedicalRecordController::class, 'destroyServiceDetail'])->name('medical-records.services.destroy');
    
    // Lịch sử khám
    Route::get('patient-history', [\App\Http\Controllers\Doctor\PatientHistoryController::class, 'index'])->name('patient-history.index');
    
    // Kê đơn thuốc
    Route::resource('prescriptions', \App\Http\Controllers\Doctor\PrescriptionController::class)->only(['index', 'store', 'update', 'destroy']);
    
    // Chỉ định vật tư
    Route::resource('material-usage', \App\Http\Controllers\Doctor\MaterialUsageController::class)->only(['index', 'store', 'destroy']);
});

// Patient Portal Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\PatientController::class, 'updateProfile'])->name('profile.update');
    Route::get('/history', [\App\Http\Controllers\PatientController::class, 'history'])->name('history');
    Route::get('/appointments', [\App\Http\Controllers\PatientController::class, 'history'])->name('appointments');
    Route::patch('/appointments/{id}/cancel', [\App\Http\Controllers\PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/medical-records/{id}', [\App\Http\Controllers\PatientController::class, 'medicalRecord'])->name('medical_records.show');
    Route::get('/prescriptions/{id}', [\App\Http\Controllers\PatientController::class, 'prescription'])->name('prescriptions.show');
    Route::get('/invoices', [\App\Http\Controllers\PatientController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/{id}', [\App\Http\Controllers\PatientController::class, 'invoiceShow'])->name('invoices.show');
});

require __DIR__.'/auth.php';
