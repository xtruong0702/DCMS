<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('user');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($outer) use ($search) {
                $outer->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                })->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        $doctors = $query->latest()->paginate(15);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specialties = Schema::hasTable('specialties')
            ? Specialty::where('is_active', true)->get()
            : collect();
        return view('admin.doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:25',
            'specialty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên Bác sĩ.',
            'email.required' => 'Vui lòng nhập email đăng nhập.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu khởi tạo.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        DB::beginTransaction();
        try {
            $doctorRole = Role::firstOrCreate(
                ['name' => 'Doctor'],
                ['description' => 'Bác sĩ nha khoa']
            );

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role_id' => $doctorRole->id,
            ];

            if (Schema::hasColumn('users', 'is_active')) {
                $userData['is_active'] = $request->has('is_active');
            }

            $user = User::create($userData);

            Doctor::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty ?: 'Nha khoa tổng quát',
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('admin.doctors.index')->with('success', 'Đã thêm Bác sĩ "' . $user->name . '" thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm Bác sĩ: ' . $e->getMessage()]);
        }
    }

    public function edit(Doctor $doctor)
    {
        $specialties = Schema::hasTable('specialties')
            ? Specialty::where('is_active', true)->get()
            : collect();
        return view('admin.doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($doctor->user_id)],
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:25',
            'specialty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên Bác sĩ.',
            'email.required' => 'Vui lòng nhập email đăng nhập.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            if (Schema::hasColumn('users', 'is_active')) {
                $userData['is_active'] = $request->has('is_active');
            }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($doctor->user) {
                $doctor->user->update($userData);
            }

            $doctor->update([
                'specialty' => $request->specialty ?: 'Nha khoa tổng quát',
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('admin.doctors.index')->with('success', 'Cập nhật thông tin Bác sĩ thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->user) {
            $doctor->user->delete();
        } else {
            $doctor->delete();
        }
        return redirect()->route('admin.doctors.index')->with('success', 'Đã xóa Bác sĩ và tài khoản liên quan!');
    }
}
