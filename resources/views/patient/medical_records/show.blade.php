@extends('layouts.patient')

@section('title', 'Chi tiết Bệnh án - Patient Portal')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Hồ Sơ Bệnh Án</h1>
        <p class="text-gray-500 mt-1">Ngày khám: <span class="font-bold text-slate-700">{{ $record->created_at->format('d/m/Y') }}</span></p>
    </div>
    <a href="{{ route('patient.history') }}" class="inline-flex items-center gap-2 bg-white/60 hover:bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl font-bold text-sm shadow-sm transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Quay lại lịch sử
    </a>
</div>

<!-- A4 Paper styling -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden relative">
        
        <!-- Header -->
        <div class="p-8 md:p-12 border-b-2 border-dashed border-gray-200 bg-gray-50/50 relative">
            <!-- Decorative logo watermark -->
            <div class="absolute right-8 top-8 opacity-[0.03] pointer-events-none">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"></path></svg>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between gap-8 relative z-10">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-[#0D7A68] rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-xs">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-black text-2xl tracking-tight text-slate-800">Nha Khoa <span class="text-[#0D7A68]">Smile</span></h2>
                            <p class="text-xs text-gray-500 font-medium">Hệ thống Nha khoa Tiêu chuẩn Quốc tế</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600 font-medium">{{ $clinicSettings['clinic_address'] }}</p>
                        <p class="text-sm text-gray-600 font-medium">{{ $clinicSettings['clinic_name'] }} · Hotline: {{ $clinicSettings['clinic_hotline'] }} · Email: {{ $clinicSettings['clinic_email'] }}</p>
                    </div>
                </div>
                <div class="md:text-right">
                    <h3 class="text-3xl font-black text-[#0D7A68] tracking-wider uppercase mb-2">Bệnh Án</h3>
                    <p class="text-sm text-gray-500 font-medium mb-1">Mã HS: <span class="text-slate-800 font-bold">#HS-{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                    <p class="text-sm text-gray-500 font-medium">Ngày lập: <span class="text-slate-800">{{ $record->created_at->format('d/m/Y H:i') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 md:p-12 relative z-10">
            <!-- Patient Info -->
            <div class="bg-teal-50/50 border border-teal-100 rounded-2xl p-6 mb-8">
                <h4 class="text-xs font-bold text-[#0D7A68] uppercase tracking-wider mb-4">Thông tin bệnh nhân</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs text-gray-500 mb-1">Họ và tên</p>
                        <p class="font-bold text-slate-800">{{ $record->patient->name }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs text-gray-500 mb-1">Mã bệnh nhân</p>
                        <p class="font-bold text-slate-800">{{ $record->patient->patient_code }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs text-gray-500 mb-1">Giới tính</p>
                        <p class="font-bold text-slate-800">{{ $record->patient->gender ?: 'N/A' }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs text-gray-500 mb-1">Ngày sinh</p>
                        <p class="font-bold text-slate-800">{{ $record->patient->dob ? \Carbon\Carbon::parse($record->patient->dob)->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Medical Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 mb-10">
                <div class="md:col-span-2 border-b border-gray-100 pb-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dịch vụ & Bác sĩ điều trị</h4>
                    <div class="flex items-center gap-6">
                        <div class="flex-1">
                            <p class="text-lg font-extrabold text-slate-800">{{ $record->appointment && $record->appointment->service ? $record->appointment->service->name : 'Khám tổng quát' }}</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-[#0D7A68]">{{ $record->doctor ? $record->doctor->user->name : 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $record->doctor ? $record->doctor->specialty : '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Triệu chứng (Theo lời khai bệnh nhân)</h4>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
                        <p class="text-slate-700 font-medium leading-relaxed">
                            {!! nl2br(e($record->symptoms ?: 'Không ghi nhận triệu chứng cụ thể.')) !!}
                        </p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Chẩn đoán của Bác sĩ</h4>
                    <div class="bg-teal-50/80 border-l-4 border-[#0D7A68] rounded-r-xl p-5">
                        <p class="text-teal-950 font-bold text-lg leading-relaxed">
                            {!! nl2br(e($record->diagnosis ?: 'Đang chờ chẩn đoán.')) !!}
                        </p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Ghi chú & Chỉ định</h4>
                    <div class="bg-white border border-gray-200 rounded-xl p-5 border-dashed">
                        <p class="text-slate-600 italic leading-relaxed">
                            {!! nl2br(e($record->note ?: 'Không có ghi chú thêm.')) !!}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Prescription alert if exists -->
            @if($record->prescription)
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-inner">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-amber-500 shadow-sm border border-amber-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-amber-900">Bác sĩ có kê đơn thuốc</h4>
                        <p class="text-sm text-amber-700 font-medium">Vui lòng xem chi tiết đơn thuốc và hướng dẫn sử dụng.</p>
                    </div>
                </div>
                <a href="{{ route('patient.prescriptions.show', $record->id) }}" class="whitespace-nowrap bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-amber-500/30 transition-all hover:-translate-y-0.5">
                    Xem Đơn Thuốc
                </a>
            </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-100 p-8 flex justify-end text-center">
            <div class="w-48">
                <p class="text-sm font-medium text-gray-500 mb-16">Chữ ký Bác sĩ điều trị</p>
                <p class="font-bold text-slate-800 border-t border-gray-300 pt-2">{{ $record->doctor ? $record->doctor->user->name : '' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
