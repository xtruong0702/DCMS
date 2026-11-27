<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('patient_code', 'like', '%' . $request->search . '%');
        }

        $patients = $query->latest()->paginate(10);
        return view('receptionist.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('receptionist.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'allergy_history' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        // Tự động sinh mã bệnh nhân không trùng lặp
        $validated['patient_code'] = 'BN' . date('YmdHis') . random_int(100, 999);

        Patient::create($validated);

        return redirect()->route('receptionist.patients.index')->with('success', 'Thêm bệnh nhân thành công.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['appointments.doctor.user', 'medicalRecords.doctor.user', 'medicalRecords.prescription.details', 'invoices']);
        return view('receptionist.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('receptionist.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients,phone,' . $patient->id,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'allergy_history' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('receptionist.patients.index')->with('success', 'Cập nhật thông tin bệnh nhân thành công.');
    }

    public function destroy(Patient $patient)
    {
        abort(403, 'Lễ tân không có quyền xóa hồ sơ bệnh nhân.');
    }
}
