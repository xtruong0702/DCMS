<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index(Request $request)
    {
        $query = Supply::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $supplies = $query->latest()->paginate(15);
        return view('admin.supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('admin.supplies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'import_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        Supply::create($validated);

        return redirect()->route('admin.supplies.index')->with('success', 'Thêm vật tư thành công!');
    }

    public function edit(Supply $supply)
    {
        return view('admin.supplies.edit', compact('supply'));
    }

    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'import_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $supply->update($validated);

        return redirect()->route('admin.supplies.index')->with('success', 'Cập nhật thông tin vật tư thành công!');
    }

    public function destroy(Supply $supply)
    {
        if (\App\Models\MaterialUsage::where('supply_id', $supply->id)->exists()) {
            return redirect()->route('admin.supplies.index')->with('error', 'Không thể xóa vật tư đã có lịch sử tiêu hao trong ca khám.');
        }

        $supply->delete();
        return redirect()->route('admin.supplies.index')->with('success', 'Đã xóa vật tư!');
    }
}
