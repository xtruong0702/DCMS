<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = DoctorSchedule::with('doctor.user');

        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        $schedules = $query->orderBy('date', 'desc')->orderBy('start_time')->paginate(15);
        $doctors = Doctor::with('user')->get();

        return view('admin.schedules.index', compact('schedules', 'doctors'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'shift' => 'required|in:morning,afternoon,evening',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,booked,time_off',
        ]);

        // Check if there is already a schedule for this doctor on this date and shift
        $exists = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('shift', $request->shift)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['shift' => 'Bác sĩ này đã có lịch trực trong ca này!']);
        }

        DoctorSchedule::create($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Đã thêm lịch trực thành công!');
    }

    public function edit(DoctorSchedule $schedule)
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, DoctorSchedule $schedule)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'shift' => 'required|in:morning,afternoon,evening',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,booked,time_off',
        ]);

        // Check for duplicates excluding the current schedule
        $exists = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('shift', $request->shift)
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['shift' => 'Bác sĩ này đã có lịch trực trong ca này!']);
        }

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Đã cập nhật lịch trực!');
    }

    public function destroy(DoctorSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Đã xóa lịch trực!');
    }
}
