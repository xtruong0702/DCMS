<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-indigo-600 font-extrabold">📂 Tra Cứu Lịch Sử Khám Bệnh</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">Hồ sơ y bạ, diễn tiến điều trị và các đơn thuốc đã kê</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-bold transition">
                &larr; Về Bảng điều khiển
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Thanh tìm kiếm -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('doctor.patient-history.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tìm kiếm theo Tên bệnh nhân, Mã BN, hoặc Số điện thoại..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-sm transition">
                        Tìm kiếm
                    </button>
                    @if($search)
                        <a href="{{ route('doctor.patient-history.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-bold transition flex items-center justify-center">
                            Xóa tìm kiếm
                        </a>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cột trái: Danh sách Bệnh nhân (1/3) -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-3.5 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h4 class="font-bold text-xs uppercase text-gray-700">Danh sách Bệnh nhân ({{ $patients->total() }})</h4>
                        </div>
                        <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
                            @forelse($patients as $p)
                                <a href="{{ route('doctor.patient-history.index', ['patient_id' => $p->id, 'search' => $search]) }}" class="block p-4 hover:bg-indigo-50/50 transition {{ ($selectedPatient && $selectedPatient->id == $p->id) ? 'bg-indigo-50 border-l-4 border-indigo-600' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-gray-900 text-sm">{{ $p->name }}</span>
                                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-gray-100 text-gray-600">{{ $p->patient_code }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex justify-between">
                                        <span>SĐT: {{ $p->phone ?: '---' }}</span>
                                        <span class="font-semibold text-indigo-700">{{ $p->appointments_count ?? 0 }} lần khám</span>
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-xs text-gray-400">
                                    Không tìm thấy bệnh nhân phù hợp.
                                </div>
                            @endforelse
                        </div>
                        <div class="p-3 border-t border-gray-100 text-xs">
                            {{ $patients->links() }}
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Hồ sơ & Timeline chi tiết các lần khám (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    @if($selectedPatient)
                        <!-- Thông tin bệnh nhân đã chọn -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-gray-100 pb-4">
                                <div>
                                    <h3 class="text-2xl font-extrabold text-indigo-950">{{ $selectedPatient->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        Mã BN: <span class="font-mono font-bold text-gray-800">{{ $selectedPatient->patient_code }}</span> | 
                                        SĐT: <span class="font-bold text-gray-800">{{ $selectedPatient->phone ?: '---' }}</span> | 
                                        Năm sinh: {{ $selectedPatient->dob ? \Carbon\Carbon::parse($selectedPatient->dob)->format('d/m/Y') : 'Chưa rõ' }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full font-bold text-xs">
                                    Tổng số: {{ $historyAppointments->count() }} lần khám
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-xs">
                                <div class="bg-red-50 p-3 rounded-xl border border-red-200">
                                    <span class="font-bold text-red-700 uppercase block mb-1">Tiền sử dị ứng:</span>
                                    <p class="{{ $selectedPatient->allergy_history ? 'text-red-800 font-bold' : 'text-gray-500 italic' }}">
                                        {{ $selectedPatient->allergy_history ?: 'Không ghi nhận' }}
                                    </p>
                                </div>
                                <div class="bg-amber-50 p-3 rounded-xl border border-amber-200">
                                    <span class="font-bold text-amber-700 uppercase block mb-1">Bệnh lý nền:</span>
                                    <p class="{{ $selectedPatient->medical_history ? 'text-amber-800 font-medium' : 'text-gray-500 italic' }}">
                                        {{ $selectedPatient->medical_history ?: 'Không ghi nhận' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline các lần khám -->
                        <div class="space-y-4">
                            <h4 class="font-bold text-sm uppercase text-gray-700 flex items-center gap-2">
                                <span>📜 Lịch Sử Chi Tiết Từng Lần Khám</span>
                            </h4>

                            @forelse($historyAppointments as $app)
                                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 space-y-4">
                                    <!-- Header ca khám -->
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-3 gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m') }}
                                            </span>
                                            <div>
                                                <h5 class="font-bold text-gray-900 text-sm">
                                                    {{ $app->service->name ?? 'Khám nha khoa' }}
                                                </h5>
                                                <p class="text-xs text-gray-500">
                                                    Khám lúc {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }} | 
                                                    Bác sĩ: <span class="font-bold text-indigo-700">{{ $app->doctor->user->name ?? '---' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('doctor.consultations.show', $app->id) }}" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg font-bold text-xs border border-indigo-200 transition">
                                            Mở ca khám này &rarr;
                                        </a>
                                    </div>

                                    <!-- Bệnh án -->
                                    @if($app->medicalRecord)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs bg-gray-50 p-4 rounded-xl">
                                            <div>
                                                <span class="text-gray-400 uppercase font-bold block mb-1">Triệu chứng lâm sàng:</span>
                                                <p class="font-medium text-gray-800">{{ $app->medicalRecord->symptoms ?: 'Không ghi nhận' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-gray-400 uppercase font-bold block mb-1">Chẩn đoán:</span>
                                                <p class="font-bold text-indigo-900">{{ $app->medicalRecord->diagnosis ?: 'Chưa chẩn đoán' }}</p>
                                            </div>
                                            @if($app->medicalRecord->treatment_plan)
                                            <div class="col-span-2 pt-2 border-t border-gray-200">
                                                <span class="text-gray-400 uppercase font-bold block mb-1">Kế hoạch điều trị:</span>
                                                <p class="text-gray-700">{{ $app->medicalRecord->treatment_plan }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Thuốc đã kê trong ca này -->
                                        @if($app->medicalRecord->prescription && $app->medicalRecord->prescription->details->count() > 0)
                                            <div class="pt-2">
                                                <span class="text-xs font-bold text-gray-700 uppercase block mb-2">Đơn thuốc đã kê:</span>
                                                <div class="flex flex-wrap gap-2 text-xs">
                                                    @foreach($app->medicalRecord->prescription->details as $d)
                                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-800 border border-blue-200 rounded-lg">
                                                            💊 <strong>{{ $d->medicine_name }}</strong> x {{ $d->quantity }} ({{ $d->dosage }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-xs text-gray-400 italic">Chưa có thông tin bệnh án điện tử cho lần hẹn này.</p>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white rounded-2xl p-8 text-center text-gray-400 text-sm border border-gray-200">
                                    Bệnh nhân này chưa có lịch sử ca khám nào.
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="bg-white rounded-2xl p-12 text-center text-gray-400 text-sm border border-gray-200">
                            Vui lòng chọn một bệnh nhân từ danh sách bên trái để xem lịch sử y bạ.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>