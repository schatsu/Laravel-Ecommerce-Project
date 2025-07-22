<?php

namespace App\Enums\Admin;

enum CategoryStatusEnum: string
{
    case ACTIVE = 'active';
    case PASSIVE = 'passive';

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isPassive(): bool
    {
        return $this === self::PASSIVE;
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Aktif',
            self::PASSIVE->value => 'Pasif',
        ];
    }
}
