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
        $request->validate([
            'vat_percentage' => 'nullable|numeric|min:0|max:100',
            'clinic_name' => 'nullable|string|max:255',
            'clinic_phone' => 'nullable|string|max:50',
            'clinic_email' => 'nullable|email|max:255',
            'clinic_address' => 'nullable|string|max:500',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:150',
        ]);

        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            if (!is_string($key) || !preg_match('/^[a-z0-9_]{1,64}$/', $key)) {
                continue;
            }
            if (is_array($value) || is_object($value)) {
                continue;
            }
            SystemSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => is_null($value) ? '' : trim((string) $value)]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Đã cập nhật cấu hình hệ thống.');
    }
}
