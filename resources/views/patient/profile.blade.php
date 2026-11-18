@extends('layouts.patient')

@section('title', 'Hồ sơ cá nhân - Patient Portal')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Hồ sơ cá nhân</h1>
    <p class="text-gray-500 mt-1">Quản lý thông tin liên hệ và lịch sử y tế cá nhân của bạn</p>
</div>

<div class="glass-card rounded-[2rem] overflow-hidden">
    <form action="{{ route('patient.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-10 border-b border-gray-100/50">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800">Thông tin cơ bản</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Mã bệnh nhân <span class="text-xs text-gray-400 font-normal">(Không đổi)</span></label>
                    <input type="text" value="{{ $patient->patient_code }}" disabled class="block w-full bg-gray-100/50 border border-gray-200 rounded-xl py-3 px-4 text-gray-500 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}" required class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Số điện thoại <span class="text-xs text-gray-400 font-normal">(Không đổi)</span></label>
                    <input type="text" value="{{ $patient->phone }}" disabled class="block w-full bg-gray-100/50 border border-gray-200 rounded-xl py-3 px-4 text-gray-500 font-medium cursor-not-allowed">
                </div>
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300">
                </div>
                <div>
                    <label for="gender" class="block text-sm font-bold text-gray-700 mb-2">Giới tính</label>
                    <div class="relative">
                        <select id="gender" name="gender" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300 appearance-none">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gender', $patient->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $patient->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender', $patient->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="dob" class="block text-sm font-bold text-gray-700 mb-2">Ngày sinh</label>
                    <input type="date" id="dob" name="dob" value="{{ old('dob', $patient->dob) }}" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300">
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Địa chỉ hiện tại</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $patient->address) }}" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300">
                </div>
            </div>
        </div>

        <div class="p-6 md:p-10 bg-white/40">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800">Thông tin Y tế dự phòng</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="allergy_history" class="block text-sm font-bold text-gray-700 mb-2">Tiền sử dị ứng <span class="text-xs text-gray-400 font-normal">(Thuốc, thức ăn, vật liệu...)</span></label>
                    <textarea id="allergy_history" name="allergy_history" rows="2" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300 resize-none">{{ old('allergy_history', $patient->allergy_history) }}</textarea>
                </div>
                <div>
                    <label for="medical_history" class="block text-sm font-bold text-gray-700 mb-2">Tiền sử bệnh lý <span class="text-xs text-gray-400 font-normal">(Tim mạch, huyết áp, tiểu đường...)</span></label>
                    <textarea id="medical_history" name="medical_history" rows="2" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300 resize-none">{{ old('medical_history', $patient->medical_history) }}</textarea>
                </div>
                <div>
                    <label for="contact_person" class="block text-sm font-bold text-gray-700 mb-2">Người liên hệ khẩn cấp</label>
                    <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $patient->contact_person) }}" class="block w-full bg-white border border-gray-200 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium hover:border-gray-300" placeholder="Họ tên và Số điện thoại người thân">
                </div>
            </div>
        </div>

        <div class="px-6 py-5 md:px-10 border-t border-gray-100/50 bg-gray-50/50 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Lưu Hồ Sơ
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </div>
    </form>
</div>
@endsection
