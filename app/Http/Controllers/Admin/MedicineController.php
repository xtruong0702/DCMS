<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    protected function ensureDefaultMedicines(): void
    {
        if (Medicine::count() === 0) {
            $defaultMedicines = [
                ['name' => 'Gói thuốc kháng viêm - giảm đau cơ bản (3 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 60000, 'price' => 120000, 'stock_quantity' => 100, 'description' => 'Uống sau ăn sáng - tối theo chỉ dẫn của Bác sĩ'],
                ['name' => 'Gói thuốc sau nhổ răng khôn / Tiểu phẫu (5 ngày)', 'category' => 'Gói đơn thuốc', 'unit' => 'Liệu trình', 'import_price' => 130000, 'price' => 250000, 'stock_quantity' => 100, 'description' => 'Kháng sinh + giảm đau + chống phù nề 5 ngày sau tiểu phẫu'],
                ['name' => 'Kháng sinh Amoxicillin + Acid Clavulanic 625mg', 'category' => 'Kháng sinh', 'unit' => 'Viên', 'import_price' => 5000, 'price' => 8000, 'stock_quantity' => 500, 'description' => 'Ngày uống 2 lần, mỗi lần 1 viên sau ăn no'],
                ['name' => 'Thuốc giảm đau - kháng viêm Ibuprofen 400mg', 'category' => 'Giảm đau', 'unit' => 'Viên', 'import_price' => 2000, 'price' => 4000, 'stock_quantity' => 500, 'description' => 'Uống sau ăn khi đau, cách nhau ít nhất 6 tiếng'],
                ['name' => 'Thuốc chống phù nề Alpha Choay', 'category' => 'Chống viêm', 'unit' => 'Viên', 'import_price' => 2500, 'price' => 4000, 'stock_quantity' => 500, 'description' => 'Ngậm dưới lưỡi hoặc uống ngày 4-6 viên chia 2 lần'],
                ['name' => 'Nước súc miệng sát khuẩn Chlorhexidine 0.12%', 'category' => 'Chăm sóc răng', 'unit' => 'Chai 250ml', 'import_price' => 55000, 'price' => 85000, 'stock_quantity' => 90, 'description' => 'Súc miệng 15ml trong 30 giây sáng và tối sau đánh răng'],
                ['name' => 'Gel bôi nhiệt miệng & viêm lợi Kamistad-Gel N', 'category' => 'Thuốc bôi', 'unit' => 'Tuýp 10g', 'import_price' => 38000, 'price' => 55000, 'stock_quantity' => 70, 'description' => 'Bôi trực tiếp lên vùng niêm mạc lợi bị viêm ngày 3 lần'],
            ];
            foreach ($defaultMedicines as $med) {
                Medicine::firstOrCreate(['name' => $med['name']], $med);
            }
        }
    }

    public function index(Request $request)
    {
        $this->ensureDefaultMedicines();

        $query = Medicine::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        $medicines = $query->latest()->paginate(15);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:150',
            'unit' => 'required|string|max:50',
            'import_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập tên thuốc.',
            'unit.required' => 'Vui lòng nhập đơn vị tính (Viên, Vỉ, Hộp...).',
            'price.required' => 'Vui lòng nhập đơn giá bán.',
            'stock_quantity.required' => 'Vui lòng nhập số lượng tồn kho.',
        ]);

        Medicine::create([
            'name' => $request->name,
            'category' => $request->category ?: 'Dược phẩm nha khoa',
            'unit' => $request->unit,
            'import_price' => $request->import_price,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.medicines.index')->with('success', 'Đã thêm thuốc "' . $request->name . '" vào kho thành công!');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:150',
            'unit' => 'required|string|max:50',
            'import_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $medicine->update([
            'name' => $request->name,
            'category' => $request->category ?: 'Dược phẩm nha khoa',
            'unit' => $request->unit,
            'import_price' => $request->import_price,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.medicines.index')->with('success', 'Đã cập nhật thông tin thuốc "' . $medicine->name . '" thành công!');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Đã xóa thuốc khỏi kho!');
    }
}
