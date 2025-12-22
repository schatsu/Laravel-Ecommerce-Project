<?php

namespace App\Enums\Admin;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Beklemede',
            self::PROCESSING => 'Hazırlanıyor',
            self::SHIPPED => 'Kargoda',
            self::DELIVERED => 'Teslim Edildi',
            self::CANCELLED => 'İptal Edildi',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'secondary',
            self::PROCESSING => 'primary',
            self::SHIPPED => 'info',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
