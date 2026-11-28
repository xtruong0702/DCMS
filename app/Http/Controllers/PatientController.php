<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Invoice;

class PatientController extends Controller
{
    private function getPatient()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $patient = $user->patient;

        if (!$patient) {
            $normalizedUserPhone = preg_replace('/\D+/', '', (string) $user->phone);
            if ($normalizedUserPhone !== '') {
                $unlinked = \App\Models\Patient::whereNull('user_id')
                    ->whereNotNull('phone')
                    ->orderBy('id')
                    ->get()
                    ->first(fn ($p) => preg_replace('/\D+/', '', (string) $p->phone) === $normalizedUserPhone);

                if ($unlinked) {
                    $unlinked->update([
                        'user_id' => $user->id,
                        'email' => $unlinked->email ?: $user->email,
                    ]);
                    $patient = $unlinked;
                }
            }
        }

        if (!$patient) {
            $patient = $user->patient()->create([
                'patient_code' => 'BN' . date('YmdHis') . random_int(100, 999),
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
            ]);
        }

        // Tự động gộp các lịch hẹn đặt online (hồ sơ chưa gắn user_id) cùng SĐT vào hồ sơ chính của bệnh nhân
        $normalizedPhone = preg_replace('/\D+/', '', (string) ($patient->phone ?: $user->phone));
        if ($normalizedPhone !== '') {
            $orphanIds = \App\Models\Patient::whereNull('user_id')
                ->where('id', '!=', $patient->id)
                ->whereNotNull('phone')
                ->get()
                ->filter(fn ($p) => preg_replace('/\D+/', '', (string) $p->phone) === $normalizedPhone)
                ->pluck('id');

            if ($orphanIds->isNotEmpty()) {
                Appointment::whereIn('patient_id', $orphanIds)->update(['patient_id' => $patient->id]);
                MedicalRecord::whereIn('patient_id', $orphanIds)->update(['patient_id' => $patient->id]);
                Invoice::whereIn('patient_id', $orphanIds)->update(['patient_id' => $patient->id]);
            }
        }

        return $patient;
    }

    public function dashboard()
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }

        // Lấy lịch hẹn sắp tới
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed', 'waiting'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('patient.dashboard', compact('patient', 'upcomingAppointments'));
    }

    public function profile()
    {
        $patient = $this->getPatient();
        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        abort(403, 'Hồ sơ bệnh nhân chỉ có Bác sĩ hoặc Lễ tân mới được phép chỉnh sửa.');
    }

    public function history()
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }
        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);
            
        return view('patient.history', compact('appointments'));
    }

    public function cancelAppointment($id)
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }
        $appointment = Appointment::where('patient_id', $patient->id)->findOrFail($id);

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Chỉ có thể hủy lịch hẹn khi đang ở trạng thái chờ xác nhận hoặc đã xác nhận.');
        }

        if ($appointment->appointment_time && \Carbon\Carbon::parse($appointment->appointment_time)->isPast()) {
            return back()->with('error', 'Không thể hủy lịch hẹn đã quá thời gian khám.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy lịch hẹn thành công.');
    }

    public function medicalRecord($id)
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }
        $record = MedicalRecord::where('patient_id', $patient->id)->findOrFail($id);
        return view('patient.medical_records.show', compact('record'));
    }

    public function prescription($id)
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }

        $prescription = \App\Models\Prescription::with('medicalRecord')
            ->where('id', $id)
            ->whereHas('medicalRecord', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->first();

        if ($prescription) {
            $record = $prescription->medicalRecord;
        } else {
            $record = MedicalRecord::with('prescription')
                ->where('patient_id', $patient->id)
                ->where('id', $id)
                ->whereHas('prescription')
                ->firstOrFail();
            $prescription = $record->prescription;
        }
        
        return view('patient.prescriptions.show', compact('prescription', 'record'));
    }

    public function invoices()
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }
        $invoices = Invoice::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('patient.invoices', compact('invoices'));
    }

    public function invoiceShow($id)
    {
        $patient = $this->getPatient();
        if (!$patient) {
            return redirect()->route('home')->withErrors('Không tìm thấy thông tin bệnh nhân.');
        }
        $invoice = Invoice::with(['details', 'payments', 'appointment.doctor.user'])
            ->where('patient_id', $patient->id)
            ->findOrFail($id);
        $settings = \App\Models\SystemSetting::pluck('setting_value', 'setting_key')->toArray();
        return view('patient.invoices.show', compact('invoice', 'settings'));
    }

    public function invoiceStatus(string $code)
    {
        $invoice = Invoice::where('invoice_code', strtoupper(trim($code)))->firstOrFail();
        $user = Auth::user();

        if (strtolower((string) $user->role?->name) === 'patient') {
            $patient = $this->getPatient();
            abort_unless($patient && $invoice->patient_id === $patient->id, 404);
        }

        $paidAmount = (float) $invoice->payments()->where('status', 'completed')->sum('amount');
        $remainingAmount = max(0, (float) $invoice->final_amount - $paidAmount);

        return response()->json([
            'success' => true,
            'status' => $invoice->status,
            'is_paid' => $invoice->status === 'paid',
            'paid_amount' => round($paidAmount),
            'remaining_amount' => round($remainingAmount),
        ]);
    }
}
