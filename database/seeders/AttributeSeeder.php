<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            'Kaplama Türü' => ['Altın', 'Rose', 'Beyaz Altın', 'Rodyum', 'Okside'],
            'Renk' => ['Gümüş', 'Gold', 'Rose Gold', 'Siyah'],
            'Taş Türü' => ['Pırlanta', 'Zirkon', 'Yakut', 'Safir', 'Opal', 'İnci'],
            'Kullanım Alanı' => ['Günlük', 'Özel Gün', 'Düğün', 'Nişan', 'Hediye'],
            'Uzunluk' => ['40 cm', '45 cm', '50 cm', '55 cm', '60 cm'],
            'Tarz' => ['Vintage', 'Modern', 'Zarif', 'Bohem'],
            'Kapama Türü' => ['Kilitli', 'Ayarlanabilir', 'Mıknatıslı'],
            'Ürün Tipi' => ['Kolye', 'Bileklik', 'Yüzük', 'Küpe'],
            'Cinsiyet' => ['Kadın', 'Erkek', 'Unisex'],
            'Ağırlık (gram)' => ['2', '5', '10', '15', '20'],
            'Karat Değeri' => ['14 Ayar', '18 Ayar', '22 Ayar', '24 Ayar'],
            'Beden / Ölçü' => ['16', '17', '18', '19', '20'],
        ])->each(function ($values, $attributeName) {
            $attribute = Attribute::query()->create(['name' => $attributeName]);

            collect($values)->each(function ($value) use ($attribute) {
                $attribute->values()->create(['value' => $value]);
            });
        });
    }
}
