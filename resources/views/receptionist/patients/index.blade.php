<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">👥 Quản Lý Hồ Sơ Bệnh Nhân</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Tra cứu, tiếp nhận mới và cập nhật thông tin y tế của bệnh nhân</p>
            </div>
            <a href="{{ route('receptionist.patients.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                + Thêm Hồ Sơ Bệnh Nhân
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Thanh tìm kiếm -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('receptionist.patients.index') }}" class="flex items-center gap-2.5 w-full sm:w-2/3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo Mã BN, Họ tên hoặc Số điện thoại..." class="w-full pl-9 pr-4 py-2 rounded-xl border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Tìm kiếm
                    </button>
                    @if(request('search'))
                        <a href="{{ route('receptionist.patients.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-xl transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng số: <strong>{{ $patients->total() }}</strong> hồ sơ
                </span>
            </div>

            <!-- Bảng danh sách bệnh nhân -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Mã BN</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Họ và Tên</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Giới tính / Ngày sinh</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Điện thoại</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Địa chỉ</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap font-mono font-bold text-indigo-600">
                                        {{ $patient->patient_code }}
                                    </td>
                                    <td class="px-5 py-4 font-bold text-slate-900 text-sm">
                                        {{ $patient->name }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-600">
                                        {{ $patient->gender ?? '---' }} • {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') : '---' }}
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-800">
                                        {{ $patient->phone }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-500 truncate max-w-xs">
                                        {{ $patient->address ?: '---' }}
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                        <a href="{{ route('receptionist.patients.show', $patient) }}" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg font-bold transition">
                                            Hồ sơ
                                        </a>
                                        <a href="{{ route('receptionist.patients.edit', $patient) }}" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold transition">
                                            Sửa
                                        </a>
                                        <form action="{{ route('receptionist.patients.destroy', $patient) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hồ sơ bệnh nhân này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg font-bold transition">
                                                Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Chưa có dữ liệu bệnh nhân.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($patients->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $patients->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
