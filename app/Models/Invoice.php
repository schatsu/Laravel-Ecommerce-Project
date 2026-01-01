<?php

namespace App\Models;

use App\Enums\Admin\AddressType;
use App\Enums\Admin\InvoiceCompanyTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Invoice extends Model
{
    use HasSlug;

    protected $appends = [
        'full_name',
        'full_address',
    ];

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'name',
        'surname',
        'slug',
        'address',
        'phone',
        'country_id',
        'city_id',
        'district_id',
        'identity_number',
        'company_type',
        'company_name',
        'tax_number',
        'tax_office',
        'default_invoice',
        'default_delivery',
        'default_billing',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'surname'])
            ->saveSlugsTo('slug');
    }

    protected function casts(): array
    {
        return [
            'type' => AddressType::class,
            'company_type' => InvoiceCompanyTypeEnum::class,
            'default_invoice' => 'boolean',
            'default_delivery' => 'boolean',
            'default_billing' => 'boolean',
        ];
    }

    // Scopes
    public function scopeDelivery(Builder $query): Builder
    {
        return $query->where('type', AddressType::DELIVERY);
    }

    public function scopeBilling(Builder $query): Builder
    {
        return $query->where('type', AddressType::BILLING);
    }

    public function scopeDefaultDelivery(Builder $query): Builder
    {
        return $query->where('default_delivery', true);
    }

    public function scopeDefaultBilling(Builder $query): Builder
    {
        return $query->where('default_billing', true);
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address,
            $this->district?->name,
            $this->city?->name,
            $this->country?->name,
        ]));
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->surname);
    }
}
