<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Medicine;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = strtolower($user->role->name ?? 'patient');

        $query = Appointment::with(['patient', 'doctor.user', 'service'])
            ->whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress']);

        if ($role === 'patient') {
            $patientId = $user->patient->id ?? 0;
            $query->where('patient_id', $patientId);
        } elseif ($role === 'doctor') {
            $doctorId = $user->doctor->id ?? 0;
            $query->where(function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)->orWhereNull('doctor_id');
            });
        }

        $appointments = $query->orderBy('appointment_time', 'asc')->get();

        // 1. Bệnh nhân đã Check-in đang ngồi chờ khám tại sảnh
        $waitingList = $appointments->where('status', 'waiting')->values();

        // 2. Lịch hẹn mới đặt đang chờ duyệt / xác nhận
        $pendingList = $appointments->where('status', 'pending')->values();

        // 3. Lịch hẹn đang trong khung giờ đến hẹn (30p trước -> 15p sau)
        $dueNowList = $appointments->filter(fn($app) => $app->isDueNow())->values();

        // 4. Lịch hẹn quá thời gian hẹn (trong 7 ngày gần nhất để tránh rác dữ liệu cũ)
        $overdueList = $appointments->filter(function ($app) {
            return $app->isOverdue() && Carbon::parse($app->appointment_time)->gte(now()->subDays(7));
        })->values();

        // 5. Lịch khám sắp tới đã xác nhận (chưa quá hạn)
        $confirmedList = $appointments->filter(function ($app) {
            return $app->status === 'confirmed' && !$app->isOverdue();
        })->values();

        // 6. Hóa đơn & Đơn thuốc chờ thu ngân (Dành cho Lễ tân & Admin)
        $unpaidInvoices = collect();
        if (in_array($role, ['admin', 'receptionist']) && Schema::hasTable('invoices')) {
            $unpaidInvoices = Invoice::with(['patient', 'details', 'appointment.doctor.user'])
                ->where('status', 'unpaid')
                ->latest()
                ->take(10)
                ->get();
        }

        // 7. Cảnh báo Thuốc sắp hết tồn kho (Dành cho Admin)
        $lowStockMedicines = collect();
        if ($role === 'admin' && Schema::hasTable('medicines')) {
            $lowStockMedicines = Medicine::where('stock_quantity', '<=', 20)
                ->orderBy('stock_quantity', 'asc')
                ->take(10)
                ->get();
        }

        // 8. Yêu cầu Tư vấn / Liên hệ từ Website (Dành cho Lễ tân & Admin)
        $contactInquiries = collect();
        if (in_array($role, ['admin', 'receptionist'])) {
            $contactInquiries = \App\Support\ContactInquiryStore::all()->take(15);
        }

        $totalNotificationsCount = $waitingList->count()
            + $pendingList->count()
            + $dueNowList->count()
            + $overdueList->count()
            + $unpaidInvoices->count()
            + $lowStockMedicines->count()
            + $contactInquiries->where('status', 'pending')->count();

        return view('system.notifications.index', compact(
            'role',
            'waitingList',
            'pendingList',
            'dueNowList',
            'overdueList',
            'confirmedList',
            'unpaidInvoices',
            'lowStockMedicines',
            'contactInquiries',
            'totalNotificationsCount'
        ));
    }

    public function resolveInquiry($id)
    {
        $user = auth()->user();
        \App\Support\ContactInquiryStore::resolve($id, $user->name ?? 'Lễ tân');

        return back()->with('success', 'Đã đánh dấu yêu cầu tư vấn là "Đã gọi tư vấn"!');
    }

    public function destroyInquiry($id)
    {
        \App\Support\ContactInquiryStore::delete($id);

        return back()->with('success', 'Đã xóa yêu cầu liên hệ khỏi danh sách!');
    }
}
