<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý đội ngũ bác sĩ
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Đội ngũ y tế
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Danh sách bác sĩ, hồ sơ chuyên môn, phân khoa và trạng thái tài khoản</p>
            </div>
            <a href="{{ route('admin.doctors.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                <span>+ Thêm Bác Sĩ Mới</span>
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
                <form action="{{ route('admin.doctors.index') }}" method="GET" class="w-full sm:w-80 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, SĐT, chuyên khoa..." class="w-full rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68] pr-10">
                    <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                <span class="text-xs text-slate-500 font-medium">
                    Tổng số: <strong class="text-slate-800">{{ $doctors->total() }}</strong> bác sĩ
                </span>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Họ và Tên</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thông tin liên hệ</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Chuyên khoa</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($doctors as $doctor)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-9 w-9">
                                                <div class="h-9 w-9 rounded-xl bg-[#0D7A68]/10 text-[#0D7A68] flex items-center justify-center font-bold text-xs">
                                                    {{ substr($doctor->user->name ?? 'B', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-bold text-xs text-slate-900">{{ $doctor->user->name ?? 'Không rõ' }}</div>
                                                <div class="text-[11px] text-slate-400 font-mono">ID: #{{ $doctor->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="text-xs text-slate-800">{{ $doctor->user->email ?? '' }}</div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $doctor->user->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap font-medium text-slate-800">
                                        {{ $doctor->specialty ?? 'Đa khoa' }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                        @if($doctor->user && $doctor->user->is_active)
                                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2.5 py-0.5 rounded-md">Hoạt động</span>
                                        @else
                                            <span class="bg-[#FEE2E2] text-[#991B1B] font-bold text-[10px] px-2.5 py-0.5 rounded-md">Tạm khóa</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right space-x-1.5">
                                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">Sửa</a>
                                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này? Hành động này sẽ xóa cả tài khoản đăng nhập!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">
                                        Không tìm thấy bác sĩ nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($doctors->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $doctors->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
