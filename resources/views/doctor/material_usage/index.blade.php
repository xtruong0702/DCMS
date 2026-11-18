<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📦 Quản Lý Tiêu Hao Vật Tư Y Tế</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">Ghi nhận và giám sát vật tư y tế sử dụng trong các ca điều trị (Tự động trừ kho)</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-bold transition">
                &larr; Về Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between" role="alert">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between" role="alert">
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Ghi nhận nhanh vật tư tiêu hao -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <h3 class="font-bold text-base text-gray-800 mb-4 flex items-center gap-2">
                    <span class="p-1.5 bg-emerald-100 text-emerald-700 rounded-lg">➕</span>
                    Ghi Nhận Vật Tư Tiêu Hao Nhanh (Trừ Kho Ngay)
                </h3>

                <form action="{{ route('doctor.material-usage.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-5">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Vật tư y tế trong kho <span class="text-red-500">*</span></label>
                        <select name="supply_id" required class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Chọn vật tư cần xuất dùng --</option>
                            @foreach($supplies as $sup)
                                <option value="{{ $sup->id }}">
                                    {{ $sup->name }} (Tồn: {{ $sup->stock_quantity }} {{ $sup->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Số lượng <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="1" value="1" required class="w-full rounded-lg border-gray-300 text-xs text-center focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mục đích / Ghi chú</label>
                        <input type="text" name="note" placeholder="Dùng trong phẫu thuật, vô trùng..." class="w-full rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-sm transition">
                            Xuất Dùng & Trừ Kho
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bảng Lịch sử sử dụng vật tư -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h3 class="font-bold text-sm text-gray-800 uppercase">
                        📋 Nhật Ký Xuất Dùng Vật Tư Tiêu Hao
                    </h3>

                    <!-- Bộ lọc theo ngày -->
                    <form action="{{ route('doctor.material-usage.index') }}" method="GET" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        @if(request('date'))
                            <a href="{{ route('doctor.material-usage.index') }}" class="text-xs text-indigo-600 font-bold">Xóa lọc</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Thời gian</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Vật tư y tế</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-600 uppercase">Số lượng</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Bác sĩ thực hiện</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Bệnh nhân / Ca khám</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase">Ghi chú</th>
                                <th class="px-4 py-3 text-right font-bold text-gray-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($usages as $u)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-4 py-3 text-gray-500 font-mono">{{ $u->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 font-bold text-emerald-800">{{ $u->supply->name ?? '---' }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-gray-900">
                                        {{ $u->quantity }} {{ $u->supply->unit ?? '' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 font-semibold">{{ $u->doctor->user->name ?? '---' }}</td>
                                    <td class="px-4 py-3">
                                        @if($u->appointment && $u->appointment->patient)
                                            <span class="font-bold text-indigo-700">{{ $u->appointment->patient->name }}</span>
                                            <span class="text-[10px] text-gray-400 block">(#{{ $u->appointment->id }})</span>
                                        @else
                                            <span class="text-gray-400 italic">Xuất dùng chung</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 italic">{{ $u->note ?: '---' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('doctor.material-usage.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hủy xuất dùng vật tư này và hoàn lại kho?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded">
                                                Hoàn kho
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-400 italic">
                                        Chưa có bản ghi tiêu hao vật tư nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 text-xs">
                    {{ $usages->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>