<?php

namespace App\Support;

use Illuminate\Support\Collection;
use App\Models\ContactInquiry;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContactInquiryStore
{
    public static function all(): Collection
    {
        self::importLegacyFile();
        return ContactInquiry::query()->latest()->get();
    }

    private static function importLegacyFile(): void
    {
        $disk = Storage::disk('local');
        $filePath = 'contact_inquiries.json';
        if (!$disk->exists($filePath)) {
            return;
        }

        $rows = json_decode($disk->get($filePath), true);
        if (!is_array($rows)) {
            return;
        }

        $now = now();
        $rows = collect($rows)->filter(fn ($row) => is_array($row) && !empty($row['id']))
            ->map(fn ($row) => [
                'id' => (string) $row['id'],
                'name' => (string) ($row['name'] ?? ''),
                'phone' => (string) ($row['phone'] ?? ''),
                'email' => ($row['email'] ?? '') ?: null,
                'topic' => ($row['topic'] ?? '') ?: null,
                'message' => (string) ($row['message'] ?? ''),
                'status' => in_array($row['status'] ?? '', ['pending', 'resolved'], true) ? $row['status'] : 'pending',
                'resolved_by' => $row['resolved_by'] ?? null,
                'resolved_at' => $row['resolved_at'] ?? null,
                'created_at' => $row['created_at'] ?? $now,
                'updated_at' => $now,
            ])->values()->all();

        if ($rows) {
            ContactInquiry::upsert($rows, ['id'], [
                'name', 'phone', 'email', 'topic', 'message', 'status', 'resolved_by',
                'resolved_at', 'created_at', 'updated_at',
            ]);
        }

        $disk->delete($filePath);
    }

    public static function pending(): Collection
    {
        return self::all()->where('status', 'pending')->values();
    }

    public static function add(array $data): array
    {
        return ContactInquiry::create([
            'id' => 'LH' . now()->format('YmdHis') . Str::upper(Str::random(6)),
            'name' => trim($data['name'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'email' => trim($data['email'] ?? '') ?: null,
            'topic' => trim($data['topic'] ?? 'Tư vấn dịch vụ nha khoa'),
            'message' => trim($data['message'] ?? ''),
            'status' => 'pending',
        ])->toArray();
    }

    public static function resolve(string $id, ?string $resolvedBy = null): bool
    {
        return ContactInquiry::whereKey($id)->update([
            'status' => 'resolved',
            'resolved_by' => $resolvedBy ?: 'Nhân viên tư vấn',
            'resolved_at' => now(),
        ]) > 0;
    }

    public static function delete(string $id): bool
    {
        return ContactInquiry::whereKey($id)->delete() > 0;
    }
}

