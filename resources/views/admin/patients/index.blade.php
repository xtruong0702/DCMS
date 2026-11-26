<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý hồ sơ bệnh nhân
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Toàn hệ thống
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Tra cứu thông tin, bệnh án điện tử, tiền sử y khoa và lịch sử điều trị</p>
            </div>
            <a href="{{ route('admin.patients.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                <span>+ Thêm Bệnh Nhân</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold" role="alert">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.patients.index') }}" method="GET" class="w-full sm:w-80 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã BN, tên, SĐT..." class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68] pr-10">
                    <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng số: <strong class="text-slate-800">{{ $patients->total() }}</strong> bệnh nhân
                </span>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mã BN</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Họ và Tên</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Giới tính / Năm sinh</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Số điện thoại</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($patients as $patient)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap font-mono font-bold text-[#0D7A68]">{{ $patient->patient_code }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap font-bold text-slate-900 text-xs">
                                        {{ $patient->name }}
                                        @if($patient->user_id)
                                            <span title="Đã liên kết tài khoản" class="ml-1 text-emerald-600 inline-block align-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-slate-600">
                                        {{ $patient->gender ?? '-' }} / {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap font-medium text-slate-800">{{ $patient->phone ?? 'Không có' }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.patients.show', $patient) }}" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">Hồ sơ & Y bạ</a>
                                        <a href="{{ route('admin.patients.edit', $patient) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">Sửa</a>
                                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bệnh nhân này? (Dữ liệu liên quan cũng có thể bị ảnh hưởng)');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">
                                        Không tìm thấy bệnh nhân nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($patients->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $patients->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
