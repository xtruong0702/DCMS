<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa Hồ sơ Bệnh nhân') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Thông tin Cơ bản (Mã: <span class="text-indigo-600">{{ $patient->patient_code }}</span>)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700">Giới tính</label>
                                        <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Chọn</option>
                                            <option value="Nam" {{ old('gender', $patient->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                            <option value="Nữ" {{ old('gender', $patient->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                            <option value="Khác" {{ old('gender', $patient->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="dob" class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                                        <input type="date" name="dob" id="dob" value="{{ old('dob', $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="job" class="block text-sm font-medium text-gray-700">Nghề nghiệp</label>
                                    <input type="text" name="job" id="job" value="{{ old('job', $patient->job) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $patient->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="contact_person" class="block text-sm font-medium text-gray-700">Người liên hệ khi khẩn cấp</label>
                                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $patient->contact_person) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Tiền sử Y tế</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="allergy_history" class="block text-sm font-medium text-gray-700">Tiền sử Dị ứng</label>
                                <textarea name="allergy_history" id="allergy_history" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('allergy_history', $patient->allergy_history) }}</textarea>
                            </div>
                            <div>
                                <label for="medical_history" class="block text-sm font-medium text-gray-700">Bệnh lý nền</label>
                                <textarea name="medical_history" id="medical_history" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('medical_history', $patient->medical_history) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Cập nhật Hồ sơ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
