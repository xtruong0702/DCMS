@extends('layouts.patient')

@section('title', 'Hồ sơ cá nhân - Cổng Bệnh Nhân')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <div class="flex flex-wrap items-center gap-2.5">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Hồ sơ cá nhân</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                Chỉ xem • Cập nhật: {{ $patient->updated_at ? $patient->updated_at->format('d/m/Y') : date('d/m/Y') }}
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Thông tin định danh và tiền sử y tế điện tử của bạn tại {{ $clinicSettings['clinic_name'] }}</p>
    </div>
</div>

<!-- Thông báo quyền chỉnh sửa -->
<div class="mb-5 p-4 rounded-2xl bg-sky-50/80 border border-sky-200/80 text-sky-900 text-xs flex items-start gap-3">
    <span class="w-7 h-7 rounded-xl bg-white text-sky-700 flex items-center justify-center shrink-0 shadow-xs font-bold">🔒</span>
    <div class="leading-relaxed">
        <strong class="font-bold">Hồ sơ y tế được bảo vệ chống chỉnh sửa tự do:</strong>
        Để đảm bảo tính chính xác của bệnh án điện tử, chỉ có <strong>Bác sĩ</strong> hoặc <strong>Lễ tân</strong> mới có quyền cập nhật hồ sơ bệnh nhân. Nếu cần điều chỉnh thông tin, vui lòng thông báo tại quầy Lễ tân hoặc gọi Hotline <a href="tel:{{ $clinicHotlineTel }}" class="font-bold underline tabular-nums">{{ $clinicSettings['clinic_hotline'] }}</a>.
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
    <!-- Thông tin định danh (Chỉ xem) -->
    <div class="p-6 border-b border-slate-100">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Thông tin định danh</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Mã bệnh nhân</div>
                <div class="text-sm font-mono font-bold text-[#0D7A68] mt-1">{{ $patient->patient_code }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Họ và tên</div>
                <div class="text-sm font-bold text-slate-900 mt-1">{{ $patient->name ?: 'Chưa cập nhật' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Số điện thoại liên hệ</div>
                <div class="text-sm font-semibold text-slate-900 mt-1 tabular-nums">{{ $patient->phone ?: 'Chưa cập nhật' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Địa chỉ Email</div>
                <div class="text-sm font-medium text-slate-900 mt-1">{{ $patient->email ?: (auth()->user()->email ?? 'Chưa cập nhật') }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Giới tính</div>
                <div class="text-sm font-medium text-slate-900 mt-1">{{ $patient->gender ?: 'Chưa cập nhật' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Ngày sinh</div>
                <div class="text-sm font-medium text-slate-900 mt-1 tabular-nums">
                    {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : 'Chưa cập nhật' }}
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Nghề nghiệp</div>
                <div class="text-sm font-medium text-slate-900 mt-1">{{ $patient->job ?: 'Chưa cập nhật' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100">
                <div class="text-[11px] font-bold uppercase text-slate-500">Địa chỉ liên hệ</div>
                <div class="text-sm font-medium text-slate-900 mt-1">{{ $patient->address ?: 'Chưa cập nhật' }}</div>
            </div>
        </div>
    </div>

    <!-- Tiền sử y tế dự phòng (Chỉ xem) -->
    <div class="p-6 bg-slate-50/40">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tiền sử y tế dự phòng</h3>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div class="p-4 rounded-xl bg-white border border-slate-200/80">
                <div class="text-[11px] font-bold uppercase text-slate-500">Tiền sử dị ứng <span class="font-normal lowercase text-slate-400">(thuốc tê, kháng sinh, vật liệu nha khoa...)</span></div>
                <div class="text-sm text-slate-800 mt-1.5 leading-relaxed">{{ $patient->allergy_history ?: 'Chưa ghi nhận tiền sử dị ứng.' }}</div>
            </div>

            <div class="p-4 rounded-xl bg-white border border-slate-200/80">
                <div class="text-[11px] font-bold uppercase text-slate-500">Tiền sử bệnh lý <span class="font-normal lowercase text-slate-400">(tim mạch, huyết áp, tiểu đường, máu khó đông...)</span></div>
                <div class="text-sm text-slate-800 mt-1.5 leading-relaxed">{{ $patient->medical_history ?: 'Chưa ghi nhận tiền sử bệnh lý.' }}</div>
            </div>

            <div class="p-4 rounded-xl bg-white border border-slate-200/80">
                <div class="text-[11px] font-bold uppercase text-slate-500">Người liên hệ khẩn cấp</div>
                <div class="text-sm text-slate-800 mt-1.5">{{ $patient->contact_person ?: 'Chưa cập nhật' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
