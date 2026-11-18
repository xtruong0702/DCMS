<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::latest()->paginate(10);
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Thêm danh mục dịch vụ thành công!');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service_categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $serviceCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $serviceCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Cập nhật danh mục dịch vụ thành công!');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();
        return redirect()->route('admin.service-categories.index')->with('success', 'Đã xóa danh mục dịch vụ!');
    }
}
