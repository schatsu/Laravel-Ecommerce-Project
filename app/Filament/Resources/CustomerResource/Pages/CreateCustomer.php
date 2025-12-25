<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static ?string $title = 'Müşteri Ekle';

    protected function afterCreate(): void
    {
        // Kupon seçildiyse sepet oluştur ve kuponu ata
        $couponId = $this->data['cart_coupon_id'] ?? null;
        
        if ($couponId) {
            $cart = $this->record->cart()->create([
                'coupon_id' => $couponId,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
