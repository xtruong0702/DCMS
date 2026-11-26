<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Tra cứu lịch sử khám bệnh
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68]"></span>
                        Hồ sơ y bạ
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Hồ sơ y bạ, diễn tiến điều trị và các đơn thuốc đã kê</p>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-xs transition">
                &larr; Tổng quan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Thanh tìm kiếm -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
                <form action="{{ route('doctor.patient-history.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tìm kiếm theo Tên bệnh nhân, Mã BN, hoặc Số điện thoại..." class="w-full pl-10 pr-4 py-2 rounded-xl border-slate-200 text-xs focus:border-[#0D7A68] focus:ring-[#0D7A68]">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl text-xs font-bold shadow-xs transition">
                        Tìm kiếm
                    </button>
                    @if($search)
                        <a href="{{ route('doctor.patient-history.index') }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition flex items-center justify-center">
                            Xóa tìm kiếm
                        </a>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cột trái: Danh sách Bệnh nhân (1/3) -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-slate-100 flex justify-between items-center bg-white">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-700">Bệnh nhân ({{ $patients->total() }})</h4>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                            @forelse($patients as $p)
                                <a href="{{ route('doctor.patient-history.index', ['patient_id' => $p->id, 'search' => $search]) }}" class="block p-4 hover:bg-slate-50/70 transition {{ ($selectedPatient && $selectedPatient->id == $p->id) ? 'bg-[#0D7A68]/5 border-l-4 border-[#0D7A68]' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-slate-900 text-xs">{{ $p->name }}</span>
                                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">{{ $p->patient_code }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-1 flex justify-between">
                                        <span>SĐT: {{ $p->phone ?: '---' }}</span>
                                        <span class="font-semibold text-[#0D7A68]">{{ $p->appointments_count ?? 0 }} lần khám</span>
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-xs text-slate-400">
                                    Không tìm thấy bệnh nhân phù hợp.
                                </div>
                            @endforelse
                        </div>
                        <div class="p-3 border-t border-slate-100 text-xs">
                            {{ $patients->links() }}
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Hồ sơ & Timeline chi tiết các lần khám (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    @if($selectedPatient)
                        <!-- Thông tin bệnh nhân đã chọn -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-slate-100 pb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">{{ $selectedPatient->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Mã BN: <span class="font-mono font-bold text-slate-800">{{ $selectedPatient->patient_code }}</span> • 
                                        SĐT: <span class="font-bold text-slate-800">{{ $selectedPatient->phone ?: '---' }}</span> • 
                                        Năm sinh: {{ $selectedPatient->dob ? \Carbon\Carbon::parse($selectedPatient->dob)->format('d/m/Y') : 'Chưa rõ' }}
                                    </p>
                                </div>
                                <span class="bg-[#D1FAE5] text-[#065F46] font-bold text-[11px] px-3 py-1 rounded-full">
                                    Tổng số: {{ $historyAppointments->count() }} lần khám
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-xs">
                                <div class="bg-red-50/50 p-3.5 rounded-xl border border-red-200/70">
                                    <span class="font-bold text-red-700 uppercase block mb-1">Tiền sử dị ứng:</span>
                                    <p class="{{ $selectedPatient->allergy_history ? 'text-red-900 font-bold' : 'text-slate-400 italic' }}">
                                        {{ $selectedPatient->allergy_history ?: 'Không ghi nhận' }}
                                    </p>
                                </div>
                                <div class="bg-amber-50/50 p-3.5 rounded-xl border border-amber-200/70">
                                    <span class="font-bold text-amber-800 uppercase block mb-1">Bệnh lý nền:</span>
                                    <p class="{{ $selectedPatient->medical_history ? 'text-amber-950 font-medium' : 'text-slate-400 italic' }}">
                                        {{ $selectedPatient->medical_history ?: 'Không ghi nhận' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline các lần khám -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#0D7A68]"></span>
                                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900">Lịch sử chi tiết từng lần khám</h4>
                            </div>

                            @forelse($historyAppointments as $app)
                                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
                                    <!-- Header ca khám -->
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-3 gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="w-10 h-10 rounded-xl bg-[#0D7A68] text-white flex items-center justify-center font-bold text-xs">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m') }}
                                            </span>
                                            <div>
                                                <h5 class="font-bold text-slate-900 text-xs">
                                                    {{ $app->service->name ?? 'Khám nha khoa' }}
                                                </h5>
                                                <p class="text-[11px] text-slate-400">
                                                    Khám lúc {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i - d/m/Y') }} • 
                                                    Bác sĩ: <span class="font-bold text-slate-800">{{ $app->doctor->user->name ?? '---' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('doctor.consultations.show', $app->id) }}" class="px-3 py-1.5 bg-[#0D7A68] hover:bg-[#0B6858] text-white rounded-xl font-bold text-xs shadow-xs transition">
                                            Mở ca khám này &rarr;
                                        </a>
                                    </div>

                                    <!-- Bệnh án -->
                                    @if($app->medicalRecord)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs bg-slate-50/70 p-4 rounded-xl border border-slate-100">
                                            <div>
                                                <span class="text-slate-400 uppercase font-bold block mb-1">Triệu chứng lâm sàng:</span>
                                                <p class="font-medium text-slate-800">{{ $app->medicalRecord->symptoms ?: 'Không ghi nhận' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-slate-400 uppercase font-bold block mb-1">Chẩn đoán:</span>
                                                <p class="font-bold text-slate-900">{{ $app->medicalRecord->diagnosis ?: 'Chưa chẩn đoán' }}</p>
                                            </div>
                                            @if($app->medicalRecord->treatment_plan)
                                            <div class="col-span-2 pt-2 border-t border-slate-200">
                                                <span class="text-slate-400 uppercase font-bold block mb-1">Kế hoạch điều trị:</span>
                                                <p class="text-slate-700">{{ $app->medicalRecord->treatment_plan }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Thuốc đã kê trong ca này -->
                                        @if($app->medicalRecord->prescription && $app->medicalRecord->prescription->details->count() > 0)
                                            <div class="pt-2">
                                                <span class="text-[11px] font-bold text-slate-400 uppercase block mb-2">Đơn thuốc đã kê:</span>
                                                <div class="flex flex-wrap gap-2 text-xs">
                                                    @foreach($app->medicalRecord->prescription->details as $d)
                                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-800 border border-slate-200 rounded-lg font-medium text-[11px]">
                                                            💊 <strong>{{ $d->medicine_name }}</strong> x {{ $d->quantity }} ({{ $d->dosage }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-xs text-slate-400 italic">Chưa có thông tin bệnh án điện tử cho lần hẹn này.</p>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white rounded-2xl p-8 text-center text-slate-400 text-xs border border-slate-200/90">
                                    Bệnh nhân này chưa có lịch sử ca khám nào.
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="bg-white rounded-2xl p-12 text-center text-slate-400 text-xs border border-slate-200/90">
                            Vui lòng chọn một bệnh nhân từ danh sách bên trái để xem lịch sử y bạ.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
