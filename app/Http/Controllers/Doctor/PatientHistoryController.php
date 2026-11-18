<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;

class PatientHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedPatientId = $request->input('patient_id');

        $query = Patient::withCount('appointments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10);

        $selectedPatient = null;
        $historyAppointments = collect();

        if ($selectedPatientId) {
            $selectedPatient = Patient::find($selectedPatientId);
        } elseif ($patients->count() > 0 && !$search) {
            $selectedPatient = $patients->first();
        }

        if ($selectedPatient) {
            $historyAppointments = Appointment::with(['doctor.user', 'service', 'medicalRecord.prescription.details.medicine', 'medicalRecord.materialUsages.supply'])
                ->where('patient_id', $selectedPatient->id)
                ->orderBy('appointment_time', 'desc')
                ->get();
        }

        return view('doctor.patient_history.index', compact('patients', 'selectedPatient', 'historyAppointments', 'search'));
    }
}
