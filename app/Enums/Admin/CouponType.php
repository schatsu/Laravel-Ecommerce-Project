<?php

namespace App\Enums\Admin;

enum CouponType: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public function label(): string
    {
        return match($this) {
            self::PERCENTAGE => 'Yüzde İndirim (%)',
            self::FIXED => 'Sabit Tutar (₺)',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
