<?php

namespace App\Enums\Admin;

enum ProductStatusEnum: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case SOLD_OUT = 'sold_out';

    public static function labels(): array
    {
        return [
          self::PUBLISHED->value => 'Aktif',
          self::DRAFT->value => 'Taslak',
          self::SOLD_OUT->value => 'Stok Yok'
        ];
    }

    public static function colors(): array
    {
        return [
            self::PUBLISHED->value => 'success',
            self::DRAFT->value => 'gray',
            self::SOLD_OUT->value => 'warning',
        ];
    }
}
