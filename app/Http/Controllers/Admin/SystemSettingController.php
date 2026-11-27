<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'nullable|string|max:255',
            'clinic_hotline' => 'nullable|string|max:50',
            'clinic_address' => 'nullable|string|max:500',
            'clinic_email' => 'nullable|email|max:255',
            'clinic_website' => 'nullable|string|max:255',
            'vat_percentage' => 'nullable|numeric|min:0|max:100',
            'currency_unit' => 'nullable|string|max:20',
            'bank_id' => 'nullable|string|max:20',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:150',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => is_null($value) ? '' : trim((string) $value)]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Đã cập nhật cấu hình hệ thống.');
    }
}
