<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialUsage;
use App\Models\Supply;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class MaterialUsageController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;

        $query = MaterialUsage::with(['supply', 'doctor.user', 'appointment.patient', 'medicalRecord'])
            ->latest();

        if ($request->filled('supply_id')) {
            $query->where('supply_id', $request->supply_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $usages = $query->paginate(15);
        $supplies = Supply::all();

        return view('doctor.material_usage.index', compact('usages', 'supplies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supply_id' => 'required|exists:supplies,id',
            'quantity' => 'required|integer|min:1',
            'appointment_id' => 'nullable|exists:appointments,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'note' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $supply = Supply::findOrFail($request->supply_id);

            if ($supply->stock_quantity < $request->quantity) {
                return back()->with('error', 'Vật tư [' . $supply->name . '] không đủ tồn kho! Tồn hiện tại: ' . $supply->stock_quantity . ' ' . $supply->unit);
            }

            // Trừ kho vật tư
            $supply->decrement('stock_quantity', $request->quantity);

            $doctorId = auth()->user()->doctor ? auth()->user()->doctor->id : null;

            MaterialUsage::create([
                'supply_id' => $request->supply_id,
                'quantity' => $request->quantity,
                'appointment_id' => $request->appointment_id,
                'medical_record_id' => $request->medical_record_id,
                'doctor_id' => $doctorId,
                'note' => $request->note,
            ]);

            DB::commit();

            return back()->with('success', 'Đã ghi nhận tiêu hao vật tư: ' . $supply->name . ' (Đã trừ kho: ' . $request->quantity . ' ' . $supply->unit . ')');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $usage = MaterialUsage::findOrFail($id);
            $supply = Supply::find($usage->supply_id);

            // Hoàn lại kho
            if ($supply) {
                $supply->increment('stock_quantity', $usage->quantity);
            }

            $usage->delete();

            DB::commit();

            return back()->with('success', 'Đã xóa ghi nhận tiêu hao và hoàn lại kho thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
