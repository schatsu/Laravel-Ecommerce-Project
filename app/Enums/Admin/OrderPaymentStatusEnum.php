<?php

namespace App\Enums\Admin;

enum OrderPaymentStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Ödeme Bekleniyor',
            self::PAID => 'Ödendi',
            self::FAILED => 'Ödeme Başarısız',
            self::REFUNDED => 'İade Edildi',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PAID => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'dark',
        };
    }
}
