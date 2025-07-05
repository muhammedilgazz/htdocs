<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Yazılım', 'description' => 'Yazılım Geliştirme'],
            ['name' => 'Tasarım', 'description' => 'Grafik Tasarım'],
            ['name' => 'İçerik', 'description' => 'İçerik Üretimi'],
            ['name' => 'Pazarlama', 'description' => 'Dijital Pazarlama'],
            ['name' => 'Eğitim', 'description' => 'Eğitim ve Öğretim'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}