<?php

namespace Database\Seeders;

use App\Enums\Admin\CategoryStatusEnum;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Yüzük',
                'description' => 'El işçiliğiyle üretilen zarif gümüş yüzükler. Nişan yüzükleri, alyanslar ve günlük kullanım için şık tasarımlar.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 1,
                'image' => 'https://placehold.co/400x400/e8e8e8/555555?text=Yuzuk',
            ],
            [
                'name' => 'Kolye',
                'description' => 'Özel tasarım gümüş kolyeler. İnce zincirler, taşlı kolyeler ve kişiye özel hediye seçenekleri.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 2,
                'image' => 'https://placehold.co/400x400/e8e8e8/555555?text=Kolye',
            ],
            [
                'name' => 'Küpe',
                'description' => 'Şık ve modern gümüş küpeler. Halka küpeler, sallanan küpeler ve günlük kullanıma uygun tasarımlar.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 3,
                'image' => 'https://placehold.co/400x400/e8e8e8/555555?text=Kupe',
            ],
            [
                'name' => 'Bileklik',
                'description' => 'El yapımı gümüş bileklikler. Kelepçe bileklikler, zincir bileklikler ve charm bileklikler.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 4,
                'image' => 'https://placehold.co/400x400/e8e8e8/555555?text=Bileklik',
            ],
            [
                'name' => 'Set',
                'description' => 'Uyumlu gümüş takı setleri. Kolye-Küpe setleri, düğün setleri ve hediye paketleri.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 5,
                'image' => 'https://placehold.co/400x400/e8e8e8/555555?text=Set',
            ],
        ])->each(function ($data) {
            $category = Category::query()->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'status' => $data['status'],
                'parent_id' => null,
                'order' => $data['order'],
            ]);

            // Add category image using Spatie Media Library
            $category->addMediaFromUrl($data['image'])
                ->toMediaCollection('featured_cover');
        });
    }
}
