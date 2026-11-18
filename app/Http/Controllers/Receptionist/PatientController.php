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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:patients',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
        ]);

        $data = $request->all();
        // Tự động sinh mã bệnh nhân: BN + YmdHis
        $data['patient_code'] = 'BN' . date('YmdHis');

        Patient::create($data);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:patients,phone,' . $patient->id,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Nam,Nữ,Khác',
        ]);

        $patient->update($request->all());

        return redirect()->route('receptionist.patients.index')->with('success', 'Cập nhật thông tin bệnh nhân thành công.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('receptionist.patients.index')->with('success', 'Xóa bệnh nhân thành công.');
    }
}
