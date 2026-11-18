<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-slate-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">👔 Quản Lý Tài Khoản Nhân Sự</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Phân quyền Quản trị viên (Admin), Bác sĩ điều trị (Doctor), Lễ tân & Thu ngân (Receptionist)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.doctors.create') }}" class="px-3.5 py-2 bg-white hover:bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-xs rounded-xl shadow-xs transition">
                    🩺 + Thêm Bác Sĩ
                </a>
                <a href="{{ route('admin.staff.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    ➕ Thêm Nhân Sự Mới
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs">!</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Thanh tìm kiếm & Lọc theo Vai trò -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col lg:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('admin.staff.index') }}" class="flex flex-wrap items-center gap-2.5 w-full lg:w-3/4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo họ tên, email, số điện thoại..." class="flex-1 min-w-[220px] rounded-xl border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                    <select name="role" class="rounded-xl border-gray-300 text-xs font-semibold focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Tất cả vai trò --</option>
                        <option value="Admin" @selected(strtolower(request('role')) === 'admin')>🛡️ Quản trị viên (Admin)</option>
                        <option value="Doctor" @selected(strtolower(request('role')) === 'doctor')>🩺 Bác sĩ điều trị (Doctor)</option>
                        <option value="Receptionist" @selected(strtolower(request('role')) === 'receptionist')>🛎️ Lễ tân & Thu ngân (Receptionist)</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Lọc / Tìm kiếm
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-xl transition">
                            Xóa lọc
                        </a>
                    @endif
                </form>

                <span class="text-xs text-slate-500 font-semibold whitespace-nowrap">
                    Tổng cộng: <strong class="text-indigo-700">{{ $staffs->total() }}</strong> tài khoản nhân sự
                </span>
            </div>

            <!-- Bảng danh sách -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Nhân sự</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Email đăng nhập</th>
                                <th class="px-5 py-3.5 text-left font-bold text-slate-600 uppercase">Số điện thoại</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Vai trò & Chuyên môn</th>
                                <th class="px-5 py-3.5 text-center font-bold text-slate-600 uppercase">Trạng thái</th>
                                <th class="px-5 py-3.5 text-right font-bold text-slate-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($staffs as $staff)
                                @php
                                    $rName = strtolower($staff->role->name ?? '');
                                    $roleLabel = match($rName) {
                                        'admin' => '🛡️ Quản trị viên',
                                        'doctor' => '🩺 Bác sĩ điều trị',
                                        'receptionist' => '🛎️ Lễ tân & Thu ngân',
                                        default => $staff->role->name ?? 'N/A',
                                    };
                                @endphp
                                <tr class="hover:bg-indigo-50/30 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-extrabold text-sm">
                                                {{ mb_strtoupper(mb_substr($staff->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                                    <span>{{ $staff->name }}</span>
                                                    @if(auth()->id() === $staff->id)
                                                        <span class="px-1.5 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-200 text-[10px] font-extrabold">Bạn</span>
                                                    @endif
                                                </div>
                                                @if($staff->address)
                                                    <div class="text-[11px] text-slate-400">{{ $staff->address }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-slate-700 font-medium">{{ $staff->email }}</td>
                                    <td class="px-5 py-4 font-semibold text-slate-700">{{ $staff->phone ?: '---' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $rName === 'admin' ? 'bg-purple-100 text-purple-700 border-purple-200' : ($rName === 'doctor' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200') }}">
                                            {{ $roleLabel }}
                                        </span>
                                        @if($rName === 'doctor' && $staff->doctor && $staff->doctor->specialty)
                                            <div class="text-[11px] text-slate-500 font-semibold mt-1">{{ $staff->doctor->specialty }}</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if(auth()->id() === $staff->id)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ● Đang đăng nhập
                                            </span>
                                        @else
                                            <form action="{{ route('admin.staff.toggle', $staff) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ ($staff->is_active ?? true) ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }} transition">
                                                    {{ ($staff->is_active ?? true) ? '● Đang hoạt động' : '○ Đã khóa' }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                        <a href="{{ route('admin.staff.edit', $staff) }}" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg font-bold transition">Sửa</a>
                                        @if(auth()->id() !== $staff->id)
                                            <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân sự {{ $staff->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg font-bold transition">Xóa</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Chưa có nhân sự nào phù hợp.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($staffs->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $staffs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
