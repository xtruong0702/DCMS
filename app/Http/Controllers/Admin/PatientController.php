<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $patientCode = 'BN' . date('YmdHis');

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
        return view('admin.patients.edit', compact('patient'));
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
        ]);

        $patient->update($request->only([
            'name', 'phone', 'gender', 'dob', 'job', 
            'address', 'email', 'allergy_history', 'medical_history', 'contact_person'
        ]));

        return redirect()->route('admin.patients.index')->with('success', 'Cập nhật thông tin bệnh nhân thành công!');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Đã xóa hồ sơ bệnh nhân!');
    }
}
