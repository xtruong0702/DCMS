@extends('layouts.patient')

@section('title', 'Hồ sơ cá nhân - Patient Portal')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2.5">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Hồ sơ cá nhân</h1>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                Hồ sơ y tế điện tử • Cập nhật: {{ $patient->updated_at ? $patient->updated_at->format('d/m/Y') : date('d/m/Y') }}
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Quản lý thông tin định danh, số điện thoại liên hệ và tiền sử y tế dự phòng</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
    <form action="{{ route('patient.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center gap-2.5 mb-5">
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Thông tin định danh</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Mã bệnh nhân <span class="text-slate-400 font-normal lowercase">(cố định)</span></label>
                    <input type="text" value="{{ $patient->patient_code }}" disabled class="block w-full bg-slate-100/70 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-500 font-mono font-bold cursor-not-allowed">
                </div>
                <div>
                    <label for="name" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Họ và tên <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}" required class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Số điện thoại <span class="text-slate-400 font-normal lowercase">(cố định)</span></label>
                    <input type="text" value="{{ $patient->phone }}" disabled class="block w-full bg-slate-100/70 border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-500 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Địa chỉ Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium">
                </div>
                <div>
                    <label for="gender" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Giới tính</label>
                    <select id="gender" name="gender" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ old('gender', $patient->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender', $patient->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ old('gender', $patient->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div>
                    <label for="dob" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Ngày sinh</label>
                    <input type="date" id="dob" name="dob" value="{{ old('dob', $patient->dob) }}" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium">
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Địa chỉ liên hệ</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $patient->address) }}" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium">
                </div>
            </div>
        </div>

        <div class="p-6 bg-slate-50/40">
            <div class="flex items-center gap-2.5 mb-5">
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#0D7A68] border border-teal-100 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tiền sử y tế dự phòng</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="allergy_history" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Tiền sử dị ứng <span class="text-slate-400 font-normal lowercase">(thuốc tê, kháng sinh, vật liệu nha khoa...)</span></label>
                    <textarea id="allergy_history" name="allergy_history" rows="2" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium resize-none">{{ old('allergy_history', $patient->allergy_history) }}</textarea>
                </div>
                <div>
                    <label for="medical_history" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Tiền sử bệnh lý <span class="text-slate-400 font-normal lowercase">(tim mạch, huyết áp, tiểu đường, máu khó đông...)</span></label>
                    <textarea id="medical_history" name="medical_history" rows="2" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium resize-none">{{ old('medical_history', $patient->medical_history) }}</textarea>
                </div>
                <div>
                    <label for="contact_person" class="block text-xs font-bold uppercase text-slate-600 mb-1.5">Người liên hệ khẩn cấp</label>
                    <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $patient->contact_person) }}" class="block w-full bg-white border border-slate-200 rounded-xl py-2 px-3 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#0D7A68] focus:border-[#0D7A68] transition font-medium" placeholder="Họ tên và Số điện thoại người thân">
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/70 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold rounded-xl text-xs shadow-xs transition gap-1.5">
                <span>Lưu cập nhật hồ sơ</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </div>
    </form>
</div>
@endsection
