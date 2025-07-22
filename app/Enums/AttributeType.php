<?php

namespace App\Enums;

enum AttributeType: string
{
    case SIZE = 'size';
    case COLOR = 'color';
    case MATERIAL = 'material';
    case CUSTOM = 'custom';

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => match($case) {
                self::SIZE => 'Beden',
                self::COLOR => 'Renk',
                self::MATERIAL => 'Malzeme',
                self::CUSTOM => 'Özel',
            }
        ])->toArray();
    }

}
