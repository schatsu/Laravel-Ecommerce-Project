<?php

namespace App\Enums\Admin;

enum AddressType: string
{
    case DELIVERY = 'delivery';
    case BILLING = 'billing';

    public function label(): string
    {
        return match($this) {
            self::DELIVERY => 'Teslimat Adresi',
            self::BILLING => 'Fatura Adresi',
        };
    }

    public static function labels(): array
    {
        return [
            self::DELIVERY->value => self::DELIVERY->label(),
            self::BILLING->value => self::BILLING->label(),
        ];
    }
}
