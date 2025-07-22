<?php

namespace App\Enums;

enum InvoiceCompanyTypeEnum: string
{
    case INDIVIDUAL = 'individual';
    case CORPORATE = 'corporate';

    public static function labels(): array
    {
        return [
            self::INDIVIDUAL->value => 'Bireysel',
            self::CORPORATE->value => 'Kurumsal',
        ];
    }

    public function isIndividual(): bool
    {
        return $this === self::INDIVIDUAL;
    }

    public function isCorporate(): bool
    {
        return $this === self::CORPORATE;
    }

}
