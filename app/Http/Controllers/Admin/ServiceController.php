<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('service_code', 'like', "%{$search}%");
            });
        }

        $services = $query->latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_code' => 'required|string|max:50|unique:services',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Service::create([
            'service_code' => $request->service_code,
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ khám chữa bệnh thành công!');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::where('is_active', true)->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_code' => ['required', 'string', 'max:50', Rule::unique('services')->ignore($service->id)],
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $service->update([
            'service_code' => $request->service_code,
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    public function toggleStatus(Service $service)
    {
        $service->is_active = !$service->is_active;
        $service->save();
        return redirect()->route('admin.services.index')->with('success', 'Đã thay đổi trạng thái dịch vụ "' . $service->name . '".');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Đã xóa dịch vụ!');
    }
}
