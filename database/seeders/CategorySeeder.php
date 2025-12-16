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
                'description' => 'Discover the latest trends and newest products.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 1,
            ],
            [
                'name' => 'Kolye',
                'description' => 'Top-selling items our customers love.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 2,
            ],
            [
                'name' => 'Küpe',
                'description' => 'Highly rated products by our users.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 3,
            ],
            [
                'name' => 'Mini Set',
                'description' => 'Selected brands that our team recommends.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 4,
            ],
            [
                'name' => 'Trending',
                'description' => 'What’s hot right now in our collection.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 5,
            ],
            [
                'name' => 'Bileklik',
                'description' => 'Classic styles with a modern twist.',
                'status' => CategoryStatusEnum::ACTIVE,
                'order' => 6,
            ],
            [
                'name' => 'Su Yolu Set',
                'description' => 'Enjoy great discounts on selected items.',
                'status' => CategoryStatusEnum::PASSIVE,
                'order' => 7,
            ],
        ])->each(function ($data) {
            Category::query()->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'status' => $data['status'],
                'parent_id' => null,
                'order' => $data['order'],
            ]);
        });
    }
}
