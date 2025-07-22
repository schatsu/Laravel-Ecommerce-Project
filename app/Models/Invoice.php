<?php

namespace App\Models;

use App\Enums\InvoiceCompanyTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Invoice extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id',
        'order_id',
        'name',
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
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function casts(): array
    {
        return [
            'company_type' => InvoiceCompanyTypeEnum::class,
            'default_invoice' => 'boolean',
        ];
    }

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
}
