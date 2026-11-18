<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Đảm bảo các vai trò nhân sự cốt lõi luôn tồn tại trong CSDL
     */
    protected function ensureStaffRoles()
    {
        Role::firstOrCreate(['name' => 'Admin'], ['description' => 'Quản trị viên hệ thống']);
        Role::firstOrCreate(['name' => 'Doctor'], ['description' => 'Bác sĩ nha khoa']);
        Role::firstOrCreate(['name' => 'Receptionist'], ['description' => 'Lễ tân & Thu ngân']);

        return Role::whereIn('name', ['Admin', 'Doctor', 'Receptionist'])->get();
    }

    public function index(Request $request)
    {
        $roles = $this->ensureStaffRoles();

        $query = User::with(['role', 'doctor', 'receptionist'])->whereHas('role', function ($q) {
            $q->whereIn('name', ['Admin', 'Doctor', 'Receptionist', 'admin', 'doctor', 'receptionist']);
        });

        if ($request->filled('role')) {
            $roleFilter = $request->role;
            $query->whereHas('role', function ($q) use ($roleFilter) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($roleFilter)]);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $staffs = $query->latest()->paginate(12);
        return view('admin.staff.index', compact('staffs', 'roles'));
    }

    public function create()
    {
        $roles = $this->ensureStaffRoles();
        $specialties = Schema::hasTable('specialties')
            ? Specialty::where('is_active', true)->get()
            : collect();

        return view('admin.staff.create', compact('roles', 'specialties'));
    }

    public function store(Request $request)
    {
        $this->ensureStaffRoles();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:25',
            'role_id' => 'required|exists:roles,id',
            'specialty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];

        if (Schema::hasColumn('users', 'cccd') && $request->filled('cccd')) {
            $rules['cccd'] = 'nullable|string|max:30|unique:users,cccd';
        }

        $messages = [
            'name.required' => 'Vui lòng nhập họ và tên nhân sự.',
            'email.required' => 'Vui lòng nhập email đăng nhập.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng bởi một tài khoản khác.',
            'password.required' => 'Vui lòng nhập mật khẩu khởi tạo.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role_id.required' => 'Vui lòng chọn vai trò phân quyền.',
            'role_id.exists' => 'Vai trò đã chọn không hợp lệ.',
            'cccd.unique' => 'Số CCCD này đã tồn tại trên hệ thống.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role_id' => $request->role_id,
            ];

            if (Schema::hasColumn('users', 'is_active')) {
                $userData['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;
            }
            if (Schema::hasColumn('users', 'cccd')) {
                $userData['cccd'] = $request->cccd ?: null;
            }
            if (Schema::hasColumn('users', 'address')) {
                $userData['address'] = $request->address ?: null;
            }

            $user = User::create($userData);
            $role = Role::find($request->role_id);
            $roleName = strtolower($role->name ?? '');

            if ($roleName === 'doctor') {
                Doctor::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'specialty' => $request->specialty ?: 'Nha khoa tổng quát',
                        'description' => $request->description,
                    ]
                );
            } elseif ($roleName === 'receptionist') {
                Receptionist::firstOrCreate(['user_id' => $user->id]);
            }

            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Đã thêm tài khoản nhân sự "' . $user->name . '" (' . ($role->name ?? '') . ') thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Không thể tạo nhân sự mới: ' . $e->getMessage()]);
        }
    }

    public function edit(User $staff)
    {
        $roles = $this->ensureStaffRoles();
        $staff->load('doctor', 'receptionist');
        $specialties = Schema::hasTable('specialties')
            ? Specialty::where('is_active', true)->get()
            : collect();

        return view('admin.staff.edit', compact('staff', 'roles', 'specialties'));
    }

    public function update(Request $request, User $staff)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($staff->id)],
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:25',
            'role_id' => 'required|exists:roles,id',
            'specialty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];

        if (Schema::hasColumn('users', 'cccd') && $request->filled('cccd')) {
            $rules['cccd'] = ['nullable', 'string', 'max:30', Rule::unique('users', 'cccd')->ignore($staff->id)];
        }

        $messages = [
            'name.required' => 'Vui lòng nhập họ và tên nhân sự.',
            'email.required' => 'Vui lòng nhập email đăng nhập.',
            'email.unique' => 'Email này đã được sử dụng bởi một tài khoản khác.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'role_id.required' => 'Vui lòng chọn vai trò phân quyền.',
            'cccd.unique' => 'Số CCCD này đã tồn tại trên hệ thống.',
        ];

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role_id,
            ];

            if (Schema::hasColumn('users', 'cccd')) {
                $data['cccd'] = $request->cccd ?: null;
            }
            if (Schema::hasColumn('users', 'address')) {
                $data['address'] = $request->address ?: null;
            }
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $oldRoleId = $staff->role_id;
            $staff->update($data);

            $newRole = Role::find($request->role_id);
            $newRoleName = strtolower($newRole->name ?? '');

            if ($oldRoleId != $request->role_id) {
                $oldRole = Role::find($oldRoleId);
                $oldRoleName = strtolower($oldRole->name ?? '');
                if ($oldRoleName === 'doctor') {
                    $staff->doctor()->delete();
                } elseif ($oldRoleName === 'receptionist') {
                    $staff->receptionist()->delete();
                }
            }

            if ($newRoleName === 'doctor') {
                Doctor::updateOrCreate(
                    ['user_id' => $staff->id],
                    [
                        'specialty' => $request->specialty ?: ($staff->doctor->specialty ?? 'Nha khoa tổng quát'),
                        'description' => $request->filled('description') ? $request->description : ($staff->doctor->description ?? null),
                    ]
                );
            } elseif ($newRoleName === 'receptionist') {
                Receptionist::firstOrCreate(['user_id' => $staff->id]);
            }

            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Đã cập nhật thông tin nhân sự "' . $staff->name . '" thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Không thể cập nhật nhân sự: ' . $e->getMessage()]);
        }
    }

    public function destroy(User $staff)
    {
        if (auth()->id() === $staff->id) {
            return redirect()->route('admin.staff.index')->with('error', 'Bạn không thể tự xóa tài khoản Quản trị viên đang đăng nhập!');
        }

        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Đã xóa nhân sự khỏi hệ thống.');
    }

    public function toggleStatus(User $staff)
    {
        if (auth()->id() === $staff->id) {
            return redirect()->route('admin.staff.index')->with('error', 'Bạn không thể tự khóa tài khoản đang đăng nhập!');
        }

        $staff->is_active = !$staff->is_active;
        $staff->save();
        return redirect()->route('admin.staff.index')->with('success', 'Đã cập nhật trạng thái hoạt động của nhân sự "' . $staff->name . '".');
    }
}
