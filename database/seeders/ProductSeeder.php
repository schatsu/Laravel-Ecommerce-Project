<?php

namespace Database\Seeders;

use App\Enums\Admin\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            // Yüzük Kategorisi (3 ürün)
            [
                'category' => 'Yüzük',
                'name' => 'Gümüş Tek Taş Yüzük',
                'short_description' => 'Zarif tek taş zirkon gümüş yüzük',
                'description' => 'El işçiliğiyle üretilmiş 925 ayar gümüş tek taş yüzük. Parlak zirkon taşlı, günlük kullanıma uygun şık tasarım. Nişan ve söz yüzüğü olarak da tercih edilebilir.',
                'selling_price' => 450.00,
                'cost_price' => 220.00,
                'discount_price' => 399.00,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Tek+Tas+Yuzuk',
            ],
            [
                'category' => 'Yüzük',
                'name' => 'Çift Sıra Tamtur Yüzük',
                'short_description' => 'Çift sıra zirkon taşlı tamtur yüzük',
                'description' => 'Modern ve şık çift sıra tamtur yüzük. 925 ayar gümüş üzerine parlak kesim zirkon taşlar. Her parmağa uyum sağlayan klasik tasarım.',
                'selling_price' => 650.00,
                'cost_price' => 320.00,
                'discount_price' => null,
                'is_featured' => false,
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Tamtur+Yuzuk',
            ],
            [
                'category' => 'Yüzük',
                'name' => 'Vintage Gümüş Yüzük',
                'short_description' => 'Antik görünümlü el yapımı vintage yüzük',
                'description' => 'Geleneksel el işçiliğiyle üretilen vintage tasarım gümüş yüzük. Oksitli gümüş detaylar ve zarif motifler. Özel günler için ideal hediye seçeneği.',
                'selling_price' => 520.00,
                'cost_price' => 250.00,
                'discount_price' => 469.00,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Vintage+Yuzuk',
            ],

            // Kolye Kategorisi (3 ürün)
            [
                'category' => 'Kolye',
                'name' => 'Gümüş Kelebek Kolye',
                'short_description' => 'Zarif kelebek figürlü gümüş kolye',
                'description' => '925 ayar gümüş kelebek kolye. İnce zincir üzerinde zarif kelebek figürü. Zirkon taş detaylı, günlük kullanıma uygun şık tasarım.',
                'selling_price' => 380.00,
                'cost_price' => 180.00,
                'discount_price' => null,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Kelebek+Kolye',
            ],
            [
                'category' => 'Kolye',
                'name' => 'İsim Yazılı Özel Kolye',
                'short_description' => 'Kişiye özel isim yazılı gümüş kolye',
                'description' => 'Özel tasarım isim yazılı kolye. 925 ayar gümüş, el yazısı font seçenekleri. Sevdiklerinize özel hediye. Zincir uzunluğu ayarlanabilir.',
                'selling_price' => 550.00,
                'cost_price' => 280.00,
                'discount_price' => 499.00,
                'is_featured' => false,
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Isim+Kolye',
            ],
            [
                'category' => 'Kolye',
                'name' => 'Tiffany Model Kalp Kolye',
                'short_description' => 'Klasik kalp figürlü gümüş kolye',
                'description' => 'Zamansız Tiffany model kalp kolye. 925 ayar parlak gümüş, zirkon taş detaylı. Romantik hediye seçeneği. Kalp boyutu: 15mm.',
                'selling_price' => 420.00,
                'cost_price' => 200.00,
                'discount_price' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Kalp+Kolye',
            ],

            // Küpe Kategorisi (3 ürün)
            [
                'category' => 'Küpe',
                'name' => 'Gümüş Halka Küpe',
                'short_description' => 'Klasik model gümüş halka küpe',
                'description' => 'Şık ve zarif halka küpe. 925 ayar gümüş, parlak yüzey. Farklı boyut seçenekleri mevcut. Her stil ile uyumlu klasik tasarım.',
                'selling_price' => 280.00,
                'cost_price' => 130.00,
                'discount_price' => 249.00,
                'is_featured' => false,
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Halka+Kupe',
            ],
            [
                'category' => 'Küpe',
                'name' => 'Zirkon Taşlı Sallantı Küpe',
                'short_description' => 'Elegant zirkon taşlı sallanan küpe',
                'description' => 'Özel günler için tasarlanmış sallantılı küpe. 925 ayar gümüş, parlak kesim zirkon taşlar. Düğün ve davet için ideal tercih.',
                'selling_price' => 480.00,
                'cost_price' => 240.00,
                'discount_price' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Sallanti+Kupe',
            ],
            [
                'category' => 'Küpe',
                'name' => 'Minimal Tektaş Küpe',
                'short_description' => 'Günlük kullanım için minimal tektaş küpe',
                'description' => 'Modern minimal tasarım tektaş küpe. 925 ayar gümüş, 4mm parlak zirkon taş. Günlük kullanım ve iş ortamı için uygun.',
                'selling_price' => 220.00,
                'cost_price' => 100.00,
                'discount_price' => null,
                'is_featured' => false,
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Tektas+Kupe',
            ],

            // Bileklik Kategorisi (3 ürün)
            [
                'category' => 'Bileklik',
                'name' => 'Gümüş Kelepçe Bileklik',
                'short_description' => 'Şık ayarlanabilir kelepçe bileklik',
                'description' => 'Zarif kelepçe model bileklik. 925 ayar gümüş, ayarlanabilir boyut. Markazetler ile süslenmiş uç detayları. Hediyelik kutusunda.',
                'selling_price' => 580.00,
                'cost_price' => 290.00,
                'discount_price' => 529.00,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Kelepce+Bileklik',
            ],
            [
                'category' => 'Bileklik',
                'name' => 'İnce Zincir Bileklik',
                'short_description' => 'Minimal ince zincir gümüş bileklik',
                'description' => 'Günlük kullanım için tasarlanmış ince zincir bileklik. 925 ayar gümüş, 1.5mm zincir kalınlığı. Ayarlanabilir uzunluk: 16-19cm.',
                'selling_price' => 320.00,
                'cost_price' => 150.00,
                'discount_price' => null,
                'is_featured' => false,
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Zincir+Bileklik',
            ],
            [
                'category' => 'Bileklik',
                'name' => 'Charm Süslemeli Bileklik',
                'short_description' => 'Farklı charm seçenekli şık bileklik',
                'description' => 'Özelleştirilebilir charm bileklik. 925 ayar gümüş, 5 adet charm ile birlikte. Ek charm takılabilir tasarım. Kalp, yıldız, ay ve sonsuzluk sembolleri.',
                'selling_price' => 680.00,
                'cost_price' => 350.00,
                'discount_price' => 599.00,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Charm+Bileklik',
            ],

            // Set Kategorisi (3 ürün)
            [
                'category' => 'Set',
                'name' => 'Su Yolu Takı Seti',
                'short_description' => 'Kolye ve küpeden oluşan su yolu seti',
                'description' => 'Şık su yolu tasarımı takı seti. 925 ayar gümüş kolye ve küpe. Zirkon taşlı zarif tasarım. Hediyelik özel kutusunda.',
                'selling_price' => 950.00,
                'cost_price' => 480.00,
                'discount_price' => 849.00,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => true,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Su+Yolu+Set',
            ],
            [
                'category' => 'Set',
                'name' => 'Minimal Günlük Set',
                'short_description' => 'İnce kolye ve mini küpe seti',
                'description' => 'Günlük kullanım için tasarlanmış minimal takı seti. İnce zincir kolye ve tektaş küpe. 925 ayar gümüş. İş ve sosyal ortamlar için ideal.',
                'selling_price' => 620.00,
                'cost_price' => 310.00,
                'discount_price' => null,
                'is_featured' => false,
                'is_new' => false,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Gunluk+Set',
            ],
            [
                'category' => 'Set',
                'name' => 'Düğün Özel Takı Seti',
                'short_description' => 'Kolye, küpe ve bileklikten oluşan düğün seti',
                'description' => 'Özel günler için tasarlanmış premium takı seti. Taşlı kolye, sallantılı küpe ve kelepçe bileklik. 925 ayar gümüş. Kadife kutuda sunulur.',
                'selling_price' => 1450.00,
                'cost_price' => 750.00,
                'discount_price' => 1299.00,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => false,
                'image' => 'https://placehold.co/600x600/f5f5f5/333333?text=Dugun+Seti',
            ],
        ])->each(function ($data) {
            $category = Category::query()->where('name', $data['category'])->first();

            if (!$category) {
                return;
            }

            $product = Product::query()->create([
                'category_id' => $category->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'short_description' => $data['short_description'],
                'description' => $data['description'],
                'selling_price' => $data['selling_price'],
                'cost_price' => $data['cost_price'],
                'discount_price' => $data['discount_price'],
                'status' => ProductStatusEnum::PUBLISHED,
                'is_featured' => $data['is_featured'],
                'is_new' => $data['is_new'],
                'is_best_seller' => $data['is_best_seller'],
            ]);

            // Add product image using Spatie Media Library
            $product->addMediaFromUrl($data['image'])
                ->toMediaCollection('images');
        });
    }
}
