@extends('layouts.patient')

@section('title', 'Chi tiết Đơn thuốc - Patient Portal')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Đơn Thuốc</h1>
        <p class="text-gray-500 mt-1">Kê ngày: <span class="font-bold text-slate-700">{{ $prescription->created_at->format('d/m/Y') }}</span></p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white px-4 py-2 rounded-xl font-bold text-xs shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            In Đơn Thuốc
        </button>
        <a href="{{ route('patient.medical_records.show', $record->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-bold text-xs shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Về Bệnh án
        </a>
    </div>
</div>

<style>
@media print {
    body { background: white !important; }
    header, aside, .mb-6, button { display: none !important; }
    .max-w-4xl { max-width: 100% !important; margin: 0 !important; }
    .shadow-\[0_10px_40px_rgba\(0\,0\,0\,0\.08\)\] { box-shadow: none !important; border: none !important; }
}
</style>

<!-- A4 Paper styling -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden relative">
        
        <!-- Header -->
        <div class="p-8 md:p-12 border-b-4 border-double border-slate-200 bg-white relative">
            <div class="flex flex-col md:flex-row justify-between gap-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-[#0D7A68] rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-xs">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl tracking-tight text-slate-800 uppercase">Nha Khoa Smile</h2>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">123 Nguyễn Văn Cừ, Quận 5, TP.HCM</p>
                        <p class="text-xs text-slate-500 font-medium">0775 761 388 - nhakhoasmile.com</p>
                    </div>
                </div>
                <div class="md:text-right flex flex-col justify-center">
                    <h3 class="text-3xl font-black text-[#0D7A68] tracking-wider uppercase">Đơn Thuốc</h3>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 md:p-12 relative z-10">
            <!-- Patient Info (Compact) -->
            <div class="mb-8 flex flex-wrap gap-x-12 gap-y-4 text-slate-800">
                <div>
                    <span class="text-gray-500 text-sm font-medium mr-2">Họ và tên:</span>
                    <span class="font-bold text-lg uppercase">{{ $record->patient->name }}</span>
                </div>
                <div>
                    <span class="text-gray-500 text-sm font-medium mr-2">Tuổi/Năm sinh:</span>
                    <span class="font-bold">{{ $record->patient->dob ? \Carbon\Carbon::parse($record->patient->dob)->format('Y') : 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 text-sm font-medium mr-2">Giới tính:</span>
                    <span class="font-bold">{{ $record->patient->gender ?: 'N/A' }}</span>
                </div>
                <div class="w-full">
                    <span class="text-gray-500 text-sm font-medium mr-2">Chẩn đoán:</span>
                    <span class="font-bold text-[#0D7A68]">{{ $record->diagnosis ?: 'Đang chờ chẩn đoán' }}</span>
                </div>
            </div>

            <!-- Rx Symbol -->
            <div class="mb-6">
                <span class="text-5xl font-black italic text-slate-800 font-serif">Rx</span>
            </div>

            <!-- Medication List -->
            <div class="mb-10">
                @php
                    $details = \App\Models\PrescriptionDetail::where('prescription_id', $prescription->id)->get();
                @endphp
                
                @if($details->count() > 0)
                    <div class="space-y-6">
                        @foreach($details as $index => $detail)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-lg text-slate-800">
                                    {{ $index + 1 }}. {{ $detail->medicine_name }}
                                </h4>
                                <span class="font-bold text-slate-700 whitespace-nowrap bg-gray-100 px-3 py-1 rounded-lg text-sm">
                                    SL: {{ $detail->quantity }} {{ $detail->dosage }}
                                </span>
                            </div>
                            
                            <div class="pl-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-teal-50/50 rounded-xl p-3 border border-teal-100 flex items-center gap-4">
                                    <div class="flex gap-2">
                                        <div class="flex flex-col items-center">
                                            <span class="text-[10px] text-gray-500 font-bold uppercase">Sáng</span>
                                            <span class="font-bold text-[#0D7A68]">{{ $detail->usage_morning ?: '0' }}</span>
                                        </div>
                                        <div class="flex flex-col items-center border-l border-teal-200 pl-2">
                                            <span class="text-[10px] text-gray-500 font-bold uppercase">Trưa</span>
                                            <span class="font-bold text-[#0D7A68]">{{ $detail->usage_noon ?: '0' }}</span>
                                        </div>
                                        <div class="flex flex-col items-center border-l border-teal-200 pl-2">
                                            <span class="text-[10px] text-gray-500 font-bold uppercase">Chiều</span>
                                            <span class="font-bold text-[#0D7A68]">{{ $detail->usage_evening ?: '0' }}</span>
                                        </div>
                                        <div class="flex flex-col items-center border-l border-teal-200 pl-2">
                                            <span class="text-[10px] text-gray-500 font-bold uppercase">Tối</span>
                                            <span class="font-bold text-[#0D7A68]">{{ $detail->usage_night ?: '0' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center text-slate-600 font-medium">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Cách dùng: {{ $detail->instructions ?: 'Uống theo chỉ định' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center bg-gray-50 rounded-2xl border border-gray-100">
                        <p class="text-gray-500 font-medium">Chưa có chi tiết đơn thuốc được cập nhật.</p>
                    </div>
                @endif
            </div>

            <!-- Doctor Notes & Follow up -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-bold text-slate-800 mb-2 border-b border-gray-200 pb-2">Lời dặn của Bác sĩ</h4>
                    <p class="text-slate-600 italic leading-relaxed">
                        {{ $prescription->note ?: 'Uống thuốc đúng giờ, đúng liều lượng. Tái khám nếu có dấu hiệu bất thường.' }}
                    </p>
                    
                    @if($prescription->follow_up_date)
                    <div class="mt-6 inline-flex items-center gap-3 bg-teal-50 border border-teal-100 text-teal-900 px-5 py-3 rounded-xl font-bold">
                        <svg class="w-6 h-6 text-[#0D7A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Tái khám: {{ \Carbon\Carbon::parse($prescription->follow_up_date)->format('d/m/Y H:i') }}
                    </div>
                    @endif
                </div>
                
                <div class="text-center md:text-right pt-4">
                    <p class="text-sm font-medium text-gray-500 mb-2">Ngày {{ $prescription->created_at->format('d') }} tháng {{ $prescription->created_at->format('m') }} năm {{ $prescription->created_at->format('Y') }}</p>
                    <p class="font-bold text-slate-800 mb-16">Bác sĩ kê đơn</p>
                    <p class="font-bold text-xl text-[#0D7A68]">{{ $record->doctor ? $record->doctor->user->name : '' }}</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
