<?php

namespace App\Enums\Admin;

enum SliderStatusEnum: string
{
    case ACTIVE = 'active';
    case PASSIVE = 'passive';

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Aktif',
            self::PASSIVE->value => 'Pasif',
        ];
    }


}
