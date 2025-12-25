<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Kupon güncelleme
        $couponId = $this->data['cart_coupon_id'] ?? null;
        
        $cart = $this->record->cart;
        
        if ($couponId) {
            if (!$cart) {
                $cart = $this->record->cart()->create([]);
            }
            $cart->update(['coupon_id' => $couponId]);
        } elseif ($cart && $cart->coupon_id) {
            // Kupon kaldırıldıysa
            $cart->update(['coupon_id' => null]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
