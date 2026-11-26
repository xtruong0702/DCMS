<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl text-slate-900 tracking-tight">Danh Mục Dịch Vụ Khám Chữa Bệnh</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                        Bảng giá niêm yết • Hôm nay: {{ date('d/m/Y') }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Quản lý danh sách dịch vụ, định lượng thời gian khám, bảng giá niêm yết và trạng thái áp dụng</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.services.create') }}" class="px-3.5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center gap-1.5">
                    <span>+ Thêm Dịch Vụ Mới</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.services.index') }}" method="GET" class="w-full sm:w-80 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm mã hoặc tên dịch vụ..." class="w-full rounded-xl border-slate-200 text-xs font-medium focus:border-[#0D7A68] focus:ring-[#0D7A68] pr-10 py-2">
                <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-[#0D7A68]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <span class="text-xs text-slate-500 font-medium">
                Tổng cộng: <strong class="text-slate-900 font-bold">{{ $services->total() }}</strong> dịch vụ
            </span>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/90 text-slate-400 font-bold text-[11px] uppercase tracking-wider">
                            <th class="py-2.5 px-5">Mã Dịch Vụ</th>
                            <th class="py-2.5 px-5">Tên Dịch Vụ</th>
                            <th class="py-2.5 px-5">Phân loại</th>
                            <th class="py-2.5 px-5">Thời gian</th>
                            <th class="py-2.5 px-5 text-right">Đơn giá niêm yết</th>
                            <th class="py-2.5 px-5 text-center">Trạng thái</th>
                            <th class="py-2.5 px-5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($services as $service)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-5 font-mono font-bold text-[#0D7A68]">{{ $service->service_code }}</td>
                                <td class="py-3 px-5 font-bold text-slate-900 text-xs">{{ $service->name }}</td>
                                <td class="py-3 px-5 text-slate-500">{{ $service->type ?? 'Nha khoa chung' }}</td>
                                <td class="py-3 px-5 text-slate-700 font-medium">{{ $service->duration_minutes }} phút</td>
                                <td class="py-3 px-5 text-right font-bold text-slate-900 text-xs">
                                    {{ number_format($service->price, 0, ',', '.') }} đ
                                </td>
                                <td class="py-3 px-5 text-center">
                                    <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-md transition {{ $service->is_active ? 'bg-[#D1FAE5] text-[#065F46]' : 'bg-[#FEE2E2] text-[#991B1B]' }}">
                                            {{ $service->is_active ? '● Khả dụng' : '○ Tạm ngưng' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3 px-5 text-right space-x-1.5">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="px-2.5 py-1 bg-white hover:bg-slate-50 text-[#0D7A68] border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Sửa</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 rounded-lg font-bold text-xs shadow-2xs transition">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 text-xs">
                                    Không tìm thấy dịch vụ nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($services->hasPages())
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                    {{ $services->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
