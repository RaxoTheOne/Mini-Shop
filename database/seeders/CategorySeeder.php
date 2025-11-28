<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Smartphones, Laptops, Tablets und mehr',
            ],
            [
                'name' => 'Kleidung',
                'description' => 'T-Shirts, Hosen, Jacken und Accessoires',
            ],
            [
                'name' => 'Buecher',
                'description' => 'Romane, Sachbücher, Fachliteratur',
            ],
            [
                'name' => 'Sport & Freizeit',
                'description' => 'Sportartikel und Freizeitprodukte',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}