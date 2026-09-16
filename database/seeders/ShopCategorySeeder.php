<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Livres', 'order' => 1],
            ['name' => 'Fournitures', 'order' => 2],
            ['name' => 'Magazines', 'order' => 3],
            ['name' => 'Accessoires', 'order' => 4],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'type' => 'shop',
                    'is_active' => true,
                    'order' => $category['order'],
                ]
            );
        }
    }
}
