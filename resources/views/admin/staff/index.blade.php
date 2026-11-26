<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Quản lý tài khoản nhân sự
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Phân quyền nhân viên
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Phân quyền Quản trị viên (Admin), Bác sĩ điều trị (Doctor), Lễ tân & Thu ngân (Receptionist)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.doctors.create') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs rounded-xl shadow-xs transition">
                    + Thêm Bác Sĩ
                </a>
                <a href="{{ route('admin.staff.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center gap-1.5">
                    <span>+ Thêm Nhân Sự Mới</span>
                </a>
            </div>
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

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs font-semibold" role="alert">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Thanh tìm kiếm & Lọc theo Vai trò -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col lg:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('admin.staff.index') }}" class="flex flex-wrap items-center gap-2.5 w-full lg:w-3/4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo họ tên, email, số điện thoại..." class="flex-1 min-w-[220px] rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                    <select name="role" class="rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <option value="">-- Tất cả vai trò --</option>
                        <option value="Admin" @selected(strtolower(request('role')) === 'admin')>Quản trị viên (Admin)</option>
                        <option value="Doctor" @selected(strtolower(request('role')) === 'doctor')>Bác sĩ điều trị (Doctor)</option>
                        <option value="Receptionist" @selected(strtolower(request('role')) === 'receptionist')>Lễ tân & Thu ngân (Receptionist)</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Lọc / Tìm kiếm
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-medium whitespace-nowrap">
                    Tổng số: <strong class="text-slate-800">{{ $staffs->total() }}</strong> nhân sự
                </span>
            </div>

            <!-- Bảng danh sách -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/70">
                            <tr>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nhân sự</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email đăng nhập</th>
                                <th class="px-4 py-2.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Số điện thoại</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Vai trò & Chuyên môn</th>
                                <th class="px-4 py-2.5 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-2.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($staffs as $staff)
                                @php
                                    $rName = strtolower($staff->role->name ?? '');
                                    $roleLabel = match($rName) {
                                        'admin' => 'Quản trị viên',
                                        'doctor' => 'Bác sĩ điều trị',
                                        'receptionist' => 'Lễ tân & Thu ngân',
                                        default => $staff->role->name ?? 'N/A',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-[#0D7A68]/10 text-[#0D7A68] flex items-center justify-center font-bold text-xs">
                                                {{ mb_strtoupper(mb_substr($staff->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                                                    <span>{{ $staff->name }}</span>
                                                    @if(auth()->id() === $staff->id)
                                                        <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">Bạn</span>
                                                    @endif
                                                </div>
                                                @if($staff->address)
                                                    <div class="text-[11px] text-slate-400">{{ $staff->address }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-700 font-medium">{{ $staff->email }}</td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $staff->phone ?: '---' }}</td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-md text-[10px] font-bold {{ $rName === 'admin' ? 'bg-[#EEF2FF] text-[#3730A3]' : ($rName === 'doctor' ? 'bg-[#ECFDF5] text-[#065F46]' : 'bg-[#FFFBEB] text-[#B45309]') }}">
                                            {{ $roleLabel }}
                                        </span>
                                        @if($rName === 'doctor' && $staff->doctor && $staff->doctor->specialty)
                                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $staff->doctor->specialty }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        @if(auth()->id() === $staff->id)
                                            <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[10px] px-2.5 py-0.5 rounded-md">
                                                ● Đang đăng nhập
                                            </span>
                                        @else
                                            <form action="{{ route('admin.staff.toggle', $staff) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-0.5 rounded-md text-[10px] font-bold border {{ ($staff->is_active ?? true) ? 'bg-[#D1FAE5] text-[#065F46] border-emerald-200' : 'bg-[#FEE2E2] text-[#991B1B] border-red-200' }} transition">
                                                    {{ ($staff->is_active ?? true) ? '● Hoạt động' : '○ Đã khóa' }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap space-x-1.5">
                                        <a href="{{ route('admin.staff.edit', $staff) }}" class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl font-semibold text-xs transition">Sửa</a>
                                        @if(auth()->id() !== $staff->id)
                                            <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân sự {{ $staff->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-white hover:bg-red-50 text-red-600 border border-slate-200 rounded-xl font-semibold text-xs transition">Xóa</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">Chưa có nhân sự nào phù hợp.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($staffs->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $staffs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
