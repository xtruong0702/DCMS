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
                        Dữ liệu bệnh nhân
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Tra cứu, tiếp nhận mới và cập nhật thông tin y tế của bệnh nhân</p>
            </div>
            <a href="{{ route('receptionist.patients.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5">
                <span>+ Thêm Hồ Sơ Bệnh Nhân</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Thanh tìm kiếm -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('receptionist.patients.index') }}" class="flex items-center gap-2.5 w-full sm:w-2/3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo Mã BN, Họ tên hoặc Số điện thoại..." class="w-full pl-9 pr-4 py-2 rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Tìm kiếm
                    </button>
                    @if(request('search'))
                        <a href="{{ route('receptionist.patients.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng số: <strong class="text-slate-800">{{ $patients->total() }}</strong> hồ sơ
                </span>
            </div>

            <!-- Bảng danh sách bệnh nhân -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mã BN</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Họ và Tên</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Giới tính / Ngày sinh</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Điện thoại</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Địa chỉ</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap font-mono font-bold text-[#0D7A68]">
                                        {{ $patient->patient_code }}
                                    </td>
                                    <td class="px-4 py-3.5 font-bold text-slate-900 text-xs">
                                        {{ $patient->name }}
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-600">
                                        {{ $patient->gender ?? '---' }} • {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : '---' }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">
                                        {{ $patient->phone }}
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-500 truncate max-w-xs">
                                        {{ $patient->address ?: '---' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                        <a href="{{ route('receptionist.patients.show', $patient) }}" class="px-2.5 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                            Hồ sơ
                                        </a>
                                        <a href="{{ route('receptionist.patients.edit', $patient) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                                            Sửa
                                        </a>
                                        <form action="{{ route('receptionist.patients.destroy', $patient) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hồ sơ bệnh nhân này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">
                                                Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                        Chưa có dữ liệu bệnh nhân.
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
