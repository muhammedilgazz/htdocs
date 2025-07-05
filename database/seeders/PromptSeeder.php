<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    public function run(): void
    {
        $prompts = [
            ['title' => 'React Component Oluştur', 'category' => 'Yazılım', 'agent' => 'ChatGPT', 'text' => 'React ile yeniden kullanılabilir bir button component oluştur'],
            ['title' => 'Logo Tasarımı', 'category' => 'Tasarım', 'agent' => 'DALL-E', 'text' => 'Modern ve minimalist bir teknoloji şirketi logosu tasarla'],
            ['title' => 'Blog Yazısı', 'category' => 'İçerik', 'agent' => 'GPT-4', 'text' => 'Yapay zeka hakkında 500 kelimelik SEO uyumlu blog yazısı yaz'],
            ['title' => 'SQL Sorgusu', 'category' => 'Yazılım', 'agent' => 'Claude', 'text' => 'Kullanıcı verilerini analiz eden karmaşık SQL sorgusu oluştur'],
            ['title' => 'Sosyal Medya İçeriği', 'category' => 'Pazarlama', 'agent' => 'ChatGPT', 'text' => 'Instagram için yaratıcı ve etkileşimli post içeriği oluştur'],
        ];

        foreach ($prompts as $promptData) {
            $category = Category::where('name', $promptData['category'])->first();

            Prompt::create([
                'title' => $promptData['title'],
                'main_cat_id' => $category?->id ?? 1,
                'other_cats' => '',
                'picture' => '',
                'prompt_agent' => $promptData['agent'],
                'used_times' => rand(0, 100),
                'prompt_text' => $promptData['text'],
                'publisher' => '1',
                'keywords' => json_encode(['ai', 'prompt', strtolower($promptData['category'])]),
            ]);
        }
    }
}
