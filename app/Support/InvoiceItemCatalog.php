<?php

namespace App\Support;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Medicine;
use App\Models\Service;
use Illuminate\Validation\ValidationException;

class InvoiceItemCatalog
{
    /**
     * Resolve client-selected identifiers to authoritative catalog names and prices.
     * Existing legacy rows can be retained by their invoice detail ID while an
     * unpaid invoice is edited; new rows must always reference a catalog item.
     */
    public static function normalize(array $items, ?Invoice $invoice = null): array
    {
        $serviceIds = collect($items)->pluck('service_id')->filter()->map(fn ($id) => (int) $id)->unique();
        $medicineIds = collect($items)->pluck('medicine_id')->filter()->map(fn ($id) => (int) $id)->unique();
        $services = Service::whereIn('id', $serviceIds)->where('is_active', true)->get()->keyBy('id');
        $medicines = Medicine::whereIn('id', $medicineIds)->get()->keyBy('id');
        $legacyDetails = $invoice
            ? $invoice->details()->whereIn('id', collect($items)->pluck('existing_detail_id')->filter())->get()->keyBy('id')
            : collect();

        $normalized = [];

        foreach ($items as $index => $item) {
            $serviceId = !empty($item['service_id']) ? (int) $item['service_id'] : null;
            $medicineId = !empty($item['medicine_id']) ? (int) $item['medicine_id'] : null;
            $existingDetailId = !empty($item['existing_detail_id']) ? (int) $item['existing_detail_id'] : null;
            $quantity = max(1, (int) ($item['quantity'] ?? 1));

            if (($serviceId !== null) === ($medicineId !== null)) {
                if (!$serviceId && !$medicineId && $existingDetailId && $legacyDetails->has($existingDetailId)) {
                    $detail = $legacyDetails->get($existingDetailId);
                    $unitPrice = (float) $detail->unit_price;
                    $normalized[] = [
                        'service_id' => $detail->service_id,
                        'medicine_id' => $detail->medicine_id,
                        'item_name' => $detail->item_name,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'total_price' => $unitPrice * $quantity,
                    ];
                    continue;
                }

                throw ValidationException::withMessages([
                    "items.{$index}.service_id" => 'Mỗi dòng hóa đơn phải chọn đúng một dịch vụ hoặc thuốc trong danh mục.',
                ]);
            }

            if ($serviceId !== null) {
                $service = $services->get($serviceId);
                if (!$service) {
                    throw ValidationException::withMessages([
                        "items.{$index}.service_id" => 'Dịch vụ không còn khả dụng trong danh mục.',
                    ]);
                }

                $unitPrice = (float) $service->price;
                $normalized[] = [
                    'service_id' => $service->id,
                    'medicine_id' => null,
                    'item_name' => 'Dịch vụ: ' . $service->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total_price' => $unitPrice * $quantity,
                ];
                continue;
            }

            $medicine = $medicines->get($medicineId);
            if (!$medicine) {
                throw ValidationException::withMessages([
                    "items.{$index}.medicine_id" => 'Thuốc không tồn tại trong danh mục.',
                ]);
            }

            $unitPrice = (float) $medicine->price;
            $unit = $medicine->unit ?: 'Đơn vị';
            $normalized[] = [
                'service_id' => null,
                'medicine_id' => $medicine->id,
                'item_name' => "Thuốc: {$medicine->name} ({$unit})",
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'total_price' => $unitPrice * $quantity,
            ];
        }

        return $normalized;
    }
}
