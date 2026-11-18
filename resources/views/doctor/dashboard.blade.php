<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng Điều Khiển Bác Sĩ') }} - BS. {{ $doctor->user->name ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg font-medium text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg font-medium text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Thống kê nhanh hôm nay -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center border-l-4 border-blue-500">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Tổng ca khám hôm nay</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalToday }}</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center border-l-4 border-orange-500">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Đang chờ ngoài sảnh</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $waitingCount }}</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center border-l-4 border-green-500">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Đã khám xong</p>
                        <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Bệnh nhân đang khám -->
                <div class="lg:col-span-2 space-y-8">
                    @if($inProgress)
                        <div class="bg-white rounded-lg shadow-lg border border-purple-200 overflow-hidden relative">
                            <div class="absolute top-0 right-0 px-4 py-1 bg-purple-600 text-white text-xs font-bold rounded-bl-lg animate-pulse">
                                ĐANG KHÁM
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Ca Khám Hiện Tại</h3>
                                <div class="flex flex-col md:flex-row gap-6">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">Bệnh nhân:</p>
                                        <p class="text-2xl font-bold text-indigo-700">{{ $inProgress->patient->name }}</p>
                                        <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
                                            <p><span class="text-gray-500">Mã BN:</span> {{ $inProgress->patient->patient_code }}</p>
                                            <p><span class="text-gray-500">Tuổi:</span> {{ $inProgress->patient->dob ? \Carbon\Carbon::parse($inProgress->patient->dob)->age : 'Chưa rõ' }}</p>
                                            <p><span class="text-gray-500">Giới tính:</span> {{ $inProgress->patient->gender ?? 'Chưa rõ' }}</p>
                                            <p><span class="text-gray-500">Giờ hẹn:</span> <span class="font-bold">{{ \Carbon\Carbon::parse($inProgress->appointment_time)->format('H:i') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex-1 bg-purple-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 mb-1">Dịch vụ yêu cầu:</p>
                                        <p class="text-lg font-semibold text-purple-900">{{ $inProgress->service->name ?? 'Khám tổng quát' }}</p>
                                        
                                        @if($inProgress->note)
                                            <div class="mt-3">
                                                <p class="text-xs text-gray-500">Ghi chú từ Lễ tân:</p>
                                                <p class="text-sm text-gray-800 italic bg-white p-2 rounded mt-1 border border-purple-100">{{ $inProgress->note }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t flex justify-end gap-4">
                                    <a href="{{ route('doctor.consultations.show', $inProgress) }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-md transition-colors flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        Ghi Bệnh Án & Kê Đơn
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg shadow-inner border border-gray-200 p-8 text-center flex flex-col items-center justify-center h-48">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="text-lg text-gray-500 font-medium">Không có ca khám nào đang diễn ra.</p>
                            @if($waitingCount > 0)
                                <p class="text-sm text-indigo-600 mt-2">Vui lòng gọi bệnh nhân tiếp theo trong hàng đợi vào khám.</p>
                            @endif
                        </div>
                    @endif

                    <!-- Danh sách chờ -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-700 flex items-center">
                                Hàng Đợi Bệnh Nhân
                                <span class="ml-2 bg-orange-100 text-orange-800 text-xs py-1 px-2 rounded-full">{{ $waitingCount }}</span>
                            </h3>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($waitingList as $app)
                                <div class="flex justify-between items-center p-3 bg-white border border-gray-200 rounded-lg hover:border-orange-300 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-orange-100 text-orange-700 font-bold p-2 rounded text-center w-16">
                                            {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $app->patient->name }} <span class="text-xs text-gray-500 font-normal ml-2">({{ $app->patient->gender ?? '-' }}, {{ $app->patient->dob ? \Carbon\Carbon::parse($app->patient->dob)->age : '?' }}T)</span></p>
                                            <p class="text-sm text-gray-500">{{ $app->service->name ?? 'Khám tổng quát' }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Form gọi vào khám (chuyển trạng thái sang in_progress) -->
                                        @if(!$inProgress)
                                            <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded hover:bg-orange-600 transition-colors shadow-sm">
                                                    Gọi vào phòng
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="px-4 py-2 bg-gray-200 text-gray-400 text-sm font-semibold rounded cursor-not-allowed" title="Vui lòng hoàn thành ca khám hiện tại">
                                                Đang bận
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm bg-gray-50 rounded-lg">
                                    Không có bệnh nhân nào đang chờ.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Lịch hẹn chờ Bác sĩ xác nhận -->
                    <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-blue-800 flex items-center">
                                📋 Lịch Hẹn Chờ Bác Sĩ Xác Nhận
                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs py-1 px-2.5 rounded-full font-bold">{{ $pendingConfirmList->count() }}</span>
                            </h3>
                        </div>

                        <div class="space-y-3">
                            @forelse($pendingConfirmList as $app)
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center p-3.5 bg-blue-50/40 border border-blue-200 rounded-lg gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-blue-700 text-sm">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}
                                            </span>
                                            @if($app->isOverdue())
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 border border-red-300 rounded-full text-xs font-bold">⚠️ Quá thời gian hẹn</span>
                                            @elseif($app->isDueNow())
                                                <span class="px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 rounded-full text-xs font-bold animate-pulse">🔔 Đến thời gian hẹn</span>
                                            @endif
                                        </div>
                                        <p class="font-bold text-gray-800 mt-1">{{ $app->patient->name }} <span class="text-xs font-normal text-gray-500">({{ $app->patient->phone }})</span></p>
                                        <p class="text-xs text-gray-600">Dịch vụ: <span class="font-semibold">{{ $app->service->name ?? 'Khám tổng quát' }}</span></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('doctor.consultations.update', $app->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                                                ✓ Bác sĩ xác nhận lịch
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-sm bg-gray-50 rounded-lg">
                                    Không có lịch hẹn nào đang chờ bác sĩ xác nhận.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Lịch làm việc & Danh sách tổng -->
                <div class="space-y-6">
                    
                    <!-- Lịch trực hôm nay -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Ca Trực Của Bạn (Hôm Nay)</h3>
                        @forelse($todaySchedule as $sch)
                            <div class="mb-3 p-3 {{ $sch->shift == 'morning' ? 'bg-blue-50 border-blue-200' : ($sch->shift == 'afternoon' ? 'bg-orange-50 border-orange-200' : 'bg-indigo-50 border-indigo-200') }} border rounded-lg">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-gray-800">
                                        @if($sch->shift == 'morning') Ca Sáng
                                        @elseif($sch->shift == 'afternoon') Ca Chiều
                                        @else Ca Tối
                                        @endif
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded bg-white text-gray-600 font-semibold border">{{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}</span>
                                </div>
                                <div class="text-sm">
                                    @if($sch->status == 'available')
                                        <span class="text-green-600 font-medium">● Sẵn sàng khám</span>
                                    @elseif($sch->status == 'time_off')
                                        <span class="text-red-600 font-medium">● Nghỉ phép</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-2">Bạn không có lịch trực hôm nay.</p>
                        @endforelse
                    </div>

                    <!-- Danh sách tất cả lịch hẹn hôm nay -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-700">Tất Cả Cuộc Hẹn Hôm Nay</h3>
                            <a href="{{ route('doctor.queue.index') }}" class="text-sm text-indigo-600 hover:underline">Xem lịch sử &rarr;</a>
                        </div>
                        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                            @forelse($todayAppointments as $app)
                                <div class="flex flex-col border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-bold text-indigo-600">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}</span>
                                        <div class="flex items-center gap-1">
                                            @if($app->isOverdue())
                                                <span class="text-[11px] px-2 py-0.5 rounded-full font-bold bg-red-100 text-red-700 border border-red-300">
                                                    ⚠️ Quá thời gian hẹn
                                                </span>
                                            @elseif($app->isDueNow())
                                                <span class="text-[11px] px-2 py-0.5 rounded-full font-bold bg-amber-100 text-amber-800 border border-amber-300 animate-pulse">
                                                    🔔 Đến giờ hẹn
                                                </span>
                                            @endif
                                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                                @if($app->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($app->status == 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($app->status == 'waiting') bg-orange-100 text-orange-800
                                                @elseif($app->status == 'in_progress') bg-purple-100 text-purple-800
                                                @elseif($app->status == 'completed') bg-green-100 text-green-800
                                                @elseif($app->status == 'cancelled' || $app->status == 'no_show') bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                @if($app->status == 'pending') Chờ BS xác nhận
                                                @elseif($app->status == 'confirmed') BS đã xác nhận
                                                @elseif($app->status == 'waiting') Đợi khám
                                                @elseif($app->status == 'in_progress') Đang khám
                                                @elseif($app->status == 'completed') Xong
                                                @else Hủy
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $app->patient->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $app->service->name ?? 'Tổng quát' }}</p>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    Không có cuộc hẹn nào trong hệ thống hôm nay.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Lịch hẹn Bác sĩ đã xác nhận (Sắp tới) -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-700">Lịch Đã Xác Nhận (Sắp tới)</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs py-0.5 px-2 rounded-full font-bold">{{ $confirmedUpcoming->count() }}</span>
                        </div>
                        <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                            @forelse($confirmedUpcoming as $app)
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-bold text-blue-700">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }}</span>
                                        @if($app->isOverdue())
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 border border-red-300 rounded-full text-[11px] font-bold">⚠️ Quá thời gian hẹn</span>
                                        @elseif($app->isDueNow())
                                            <span class="px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 rounded-full text-[11px] font-bold animate-pulse">🔔 Đến thời gian hẹn</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[11px] font-semibold">✓ Đã xác nhận</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-bold text-gray-800">{{ $app->patient->name }}</p>
                                    <p class="text-xs text-gray-500">DV: {{ $app->service->name ?? 'Khám tổng quát' }}</p>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    Chưa có lịch hẹn nào đã xác nhận.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
