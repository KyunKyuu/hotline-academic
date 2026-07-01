<?php

namespace App\Services;

use App\Support\HotlineState;
use Illuminate\Support\Str;

class BiodataParserService
{
    public function parse(string $message): array
    {
        $normalized = trim(str_replace("\r", '', $message));
        $lines = preg_split('/\n+/', $normalized) ?: [];

        $data = [
            'name' => null,
            'semester' => null,
            'campus' => null,
            'major' => null,
        ];

        foreach ($lines as $line) {
            $cleanLine = trim($line);

            if ($cleanLine === '') {
                continue;
            }

            if (preg_match('/^nama\s*[:=-]\s*(.+)$/i', $cleanLine, $matches)) {
                $data['name'] = $this->normalizeValue($matches[1]);
                continue;
            }

            if (preg_match('/^semester\s*[:=-]\s*(.+)$/i', $cleanLine, $matches)) {
                $data['semester'] = $this->normalizeSemester($matches[1]);
                continue;
            }

            if (preg_match('/^(kampus|universitas)\s*[:=-]\s*(.+)$/i', $cleanLine, $matches)) {
                $data['campus'] = $this->normalizeValue($matches[2]);
                continue;
            }

            if (preg_match('/^(jurusan|prodi|program studi)\s*[:=-]\s*(.+)$/i', $cleanLine, $matches)) {
                $data['major'] = $this->normalizeValue($matches[2]);
            }
        }

        if ($this->isComplete($data)) {
            return [
                'success' => true,
                'mode' => 'template',
                'data' => $data,
                'missing' => [],
            ];
        }

        $fallback = $this->parseLooseText($normalized);
        $merged = array_merge($data, array_filter($fallback, fn ($value) => filled($value)));
        $missing = $this->missingFields($merged);

        return [
            'success' => count($missing) === 0,
            'mode' => count($missing) === 0 ? 'loose' : 'guided',
            'data' => $merged,
            'missing' => $missing,
        ];
    }

    public function nextStateFromMissing(array $missing): string
    {
        return match ($missing[0] ?? null) {
            'name' => HotlineState::AWAITING_NAME,
            'semester' => HotlineState::AWAITING_SEMESTER,
            'campus' => HotlineState::AWAITING_CAMPUS,
            'major' => HotlineState::AWAITING_MAJOR,
            default => HotlineState::AWAITING_REFERRAL,
        };
    }

    public function questionForState(string $state): string
    {
        return match ($state) {
            HotlineState::AWAITING_NAME => 'Nama lengkap Anda siapa?',
            HotlineState::AWAITING_SEMESTER => 'Saat ini Anda semester berapa?',
            HotlineState::AWAITING_CAMPUS => 'Anda kuliah di kampus mana?',
            HotlineState::AWAITING_MAJOR => 'Jurusan atau prodi Anda apa?',
            default => config('hotline.referral_prompt'),
        };
    }

    public function normalizeSingleField(string $state, string $value): ?string
    {
        return match ($state) {
            HotlineState::AWAITING_SEMESTER => $this->normalizeSemester($value),
            HotlineState::AWAITING_NAME,
            HotlineState::AWAITING_CAMPUS,
            HotlineState::AWAITING_MAJOR => $this->normalizeValue($value),
            default => trim($value),
        };
    }

    private function parseLooseText(string $message): array
    {
        $compact = Str::of($message)->lower()->replace(["\n", "\r"], ' ')->squish()->value();
        $data = [
            'name' => null,
            'semester' => null,
            'campus' => null,
            'major' => null,
        ];

        if (preg_match('/semester\s*(\d{1,2})/i', $compact, $matches)) {
            $data['semester'] = $matches[1];
        }

        if (preg_match('/(?:nama saya|saya|aku)\s+([a-z\s\.\'-]{3,60}?)(?:\s+semester|\s+kampus|\s+jurusan|$)/i', $compact, $matches)) {
            $data['name'] = $this->normalizeValue($matches[1]);
        }

        if (preg_match('/(?:kampus|universitas|univ|di)\s+([a-z0-9\s\.\'-]{3,80})/i', $compact, $matches)) {
            $data['campus'] = $this->normalizeValue($matches[1]);
        }

        if (preg_match('/(?:jurusan|prodi|program studi)\s+([a-z0-9\s\.\'-]{3,80})/i', $compact, $matches)) {
            $data['major'] = $this->normalizeValue($matches[1]);
        }

        return $data;
    }

    private function isComplete(array $data): bool
    {
        return count($this->missingFields($data)) === 0;
    }

    private function missingFields(array $data): array
    {
        return collect(['name', 'semester', 'campus', 'major'])
            ->filter(fn (string $field) => blank($data[$field] ?? null))
            ->values()
            ->all();
    }

    private function normalizeValue(string $value): ?string
    {
        $normalized = trim(Str::of($value)->replaceMatches('/\s+/', ' ')->value(), " \t\n\r\0\x0B:,-");

        return $normalized !== '' ? Str::title($normalized) : null;
    }

    private function normalizeSemester(string $value): ?string
    {
        if (preg_match('/(\d{1,2})/', $value, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
