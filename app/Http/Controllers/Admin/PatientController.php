<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
        }

        $patients = $query->latest()->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:patients',
            'gender' => 'nullable|string|in:Nam,Nữ,Khác',
            'dob' => 'nullable|date',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'allergy_history' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $patientCode = 'BN' . date('YmdHis') . random_int(100, 999);

        Patient::create([
            'patient_code' => $patientCode,
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'job' => $request->job,
            'address' => $request->address,
            'email' => $request->email,
            'allergy_history' => $request->allergy_history,
            'medical_history' => $request->medical_history,
            'contact_person' => $request->contact_person,
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Thêm bệnh nhân thành công!');
    }

    public function show(Patient $patient)
    {
        $patient->load(['appointments.doctor.user', 'medicalRecords.doctor.user', 'medicalRecords.prescription.details', 'invoices']);
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patientAccounts = User::whereHas('role', fn ($query) => $query->whereRaw('LOWER(name) = ?', ['patient']))
            ->where(function ($query) use ($patient) {
                $query->whereDoesntHave('patient')->orWhere('id', $patient->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('admin.patients.edit', compact('patient', 'patientAccounts'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('patients')->ignore($patient->id)],
            'gender' => 'nullable|string|in:Nam,Nữ,Khác',
            'dob' => 'nullable|date',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'allergy_history' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'user_id' => ['nullable', 'integer', 'exists:users,id', Rule::unique('patients', 'user_id')->ignore($patient->id)],
        ]);

        if ($request->filled('user_id') && !User::whereKey($request->user_id)
            ->whereHas('role', fn ($query) => $query->whereRaw('LOWER(name) = ?', ['patient']))
            ->exists()) {
            return back()->withInput()->withErrors(['user_id' => 'Chỉ có thể liên kết hồ sơ với tài khoản bệnh nhân.']);
        }

        $patient->update($request->only([
            'name', 'phone', 'gender', 'dob', 'job', 
            'address', 'email', 'allergy_history', 'medical_history', 'contact_person', 'user_id'
        ]));

        Log::info('Patient account link updated by admin.', [
            'patient_id' => $patient->id,
            'user_id' => $patient->user_id,
            'admin_user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Cập nhật thông tin bệnh nhân thành công!');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->appointments()->exists() || $patient->medicalRecords()->exists() || $patient->invoices()->exists()) {
            return redirect()->route('admin.patients.index')->with('error', 'Không thể xóa hồ sơ bệnh nhân đã có lịch hẹn, bệnh án hoặc hóa đơn trong hệ thống.');
        }

        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Đã xóa hồ sơ bệnh nhân!');
    }
}
