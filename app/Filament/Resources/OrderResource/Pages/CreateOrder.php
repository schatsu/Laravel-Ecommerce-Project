<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Manuel Sipariş Oluştur';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Müşteri Bilgileri')
                    ->schema([
                        Select::make('user_id')
                            ->label('Müşteri')
                            ->options(User::query()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state) {
                                    $user = User::find($state);
                                    if ($user && $user->invoices()->exists()) {
                                        $invoice = $user->invoices()->first();
                                        $set('billing_address', [
                                            'name' => $invoice->name . ' ' . $invoice->surname,
                                            'phone' => $invoice->phone,
                                            'address' => $invoice->address,
                                            'city' => $invoice->city?->name ?? '',
                                            'district' => $invoice->district?->name ?? '',
                                        ]);
                                        $set('shipping_address', [
                                            'name' => $invoice->name . ' ' . $invoice->surname,
                                            'phone' => $invoice->phone,
                                            'address' => $invoice->address,
                                            'city' => $invoice->city?->name ?? '',
                                            'district' => $invoice->district?->name ?? '',
                                        ]);
                                    }
                                }
                            }),
                    ]),

                Section::make('Sipariş Ürünleri')
                    ->schema([
                        Repeater::make('items')
                            ->label('')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Ürün')
                                            ->options(Product::query()->active()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                                $set('variation_id', null);
                                                if ($state) {
                                                    $product = Product::find($state);
                                                    if ($product && !$product->variations()->exists()) {
                                                        $set('unit_price', $product->discount_price > 0 ? $product->discount_price : $product->selling_price);
                                                    }
                                                }
                                            }),
                                        Select::make('variation_id')
                                            ->label('Varyant')
                                            ->options(function (Get $get) {
                                                $productId = $get('product_id');
                                                if (!$productId) return [];
                                                
                                                return ProductVariation::where('product_id', $productId)
                                                    ->where('is_active', true)
                                                    ->get()
                                                    ->mapWithKeys(function ($v) {
                                                        $options = $v->selectedOptions()->pluck('name')->join(' / ');
                                                        return [$v->id => $options ?: "Varyant #{$v->id}"];
                                                    });
                                            })
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                                if ($state) {
                                                    $variation = ProductVariation::find($state);
                                                    if ($variation) {
                                                        $price = $variation->discount_price > 0 
                                                            ? $variation->discount_price 
                                                            : $variation->selling_price;
                                                        $set('unit_price', $price);
                                                    }
                                                }
                                            }),
                                        TextInput::make('quantity')
                                            ->label('Adet')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required(),
                                        TextInput::make('unit_price')
                                            ->label('Birim Fiyat')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->required(),
                                    ]),
                            ])
                            ->addActionLabel('Ürün Ekle')
                            ->minItems(1)
                            ->defaultItems(1)
                            ->reorderable(false)
                            ->columns(1),
                    ]),

                Section::make('Fatura Adresi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('billing_address.name')
                                    ->label('Ad Soyad')
                                    ->required(),
                                TextInput::make('billing_address.phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->required(),
                                Textarea::make('billing_address.address')
                                    ->label('Adres')
                                    ->rows(2)
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('billing_address.city')
                                    ->label('İl')
                                    ->required(),
                                TextInput::make('billing_address.district')
                                    ->label('İlçe')
                                    ->required(),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Teslimat Adresi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shipping_address.name')
                                    ->label('Ad Soyad')
                                    ->required(),
                                TextInput::make('shipping_address.phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->required(),
                                Textarea::make('shipping_address.address')
                                    ->label('Adres')
                                    ->rows(2)
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('shipping_address.city')
                                    ->label('İl')
                                    ->required(),
                                TextInput::make('shipping_address.district')
                                    ->label('İlçe')
                                    ->required(),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Sipariş Ayarları')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('status')
                                    ->label('Sipariş Durumu')
                                    ->options(collect(OrderStatusEnum::cases())->mapWithKeys(
                                        fn($case) => [$case->value => $case->label()]
                                    ))
                                    ->default(OrderStatusEnum::PENDING->value)
                                    ->required(),
                                Select::make('payment_status')
                                    ->label('Ödeme Durumu')
                                    ->options(collect(OrderPaymentStatusEnum::cases())->mapWithKeys(
                                        fn($case) => [$case->value => $case->label()]
                                    ))
                                    ->default(OrderPaymentStatusEnum::PENDING->value)
                                    ->required(),
                                TextInput::make('shipping_cost')
                                    ->label('Kargo Ücreti')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('₺'),
                            ]),
                        Textarea::make('notes')
                            ->label('Sipariş Notu')
                            ->rows(2),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_number'] = Order::generateOrderNumber();
        $data['payment_method'] = 'manual';
        
        // Toplam hesapla
        $subtotal = 0;
        foreach ($data['items'] ?? [] as $item) {
            $subtotal += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        
        $data['subtotal'] = $subtotal;
        $data['total'] = $subtotal + ($data['shipping_cost'] ?? 0);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $items = $this->data['items'] ?? [];
        
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $variation = $item['variation_id'] ? ProductVariation::find($item['variation_id']) : null;
            
            $variationInfo = null;
            if ($variation) {
                $variationInfo = $variation->selectedOptions()->pluck('name')->join(' / ');
            }
            
            $this->record->items()->create([
                'product_id' => $item['product_id'],
                'product_variation_id' => $item['variation_id'] ?? null,
                'name' => $product->name,
                'variation_info' => $variationInfo,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['unit_price'] * $item['quantity'],
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
