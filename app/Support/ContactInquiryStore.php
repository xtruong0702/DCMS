<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ContactInquiryStore
{
    protected static string $filePath = 'contact_inquiries.json';

    public static function all(): Collection
    {
        if (!Storage::disk('local')->exists(self::$filePath)) {
            return collect();
        }

        $raw = Storage::disk('local')->get(self::$filePath);
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return collect();
        }

        return collect($decoded)->sortByDesc('created_at')->values();
    }

    public static function pending(): Collection
    {
        return self::all()->where('status', 'pending')->values();
    }

    public static function add(array $data): array
    {
        $items = self::all()->all();

        $newItem = [
            'id' => 'LH' . date('YmdHis') . rand(10, 99),
            'name' => trim($data['name'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'topic' => trim($data['topic'] ?? 'Tư vấn dịch vụ nha khoa'),
            'message' => trim($data['message'] ?? ''),
            'status' => 'pending',
            'resolved_by' => null,
            'resolved_at' => null,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        array_unshift($items, $newItem);
        Storage::disk('local')->put(self::$filePath, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $newItem;
    }

    public static function resolve(string $id, ?string $resolvedBy = null): bool
    {
        $items = self::all()->all();
        $updated = false;

        foreach ($items as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item['status'] = 'resolved';
                $item['resolved_by'] = $resolvedBy ?: 'Nhân viên tư vấn';
                $item['resolved_at'] = now()->format('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            Storage::disk('local')->put(self::$filePath, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        return $updated;
    }

    public static function delete(string $id): bool
    {
        $items = self::all();
        $filtered = $items->reject(fn($item) => ($item['id'] ?? '') === $id)->values()->all();

        Storage::disk('local')->put(self::$filePath, json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return true;
    }
}

