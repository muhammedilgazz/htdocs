<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'AI Prompt Yazma Sanatı: Başlangıç Rehberi',
                'slug' => 'ai-prompt-yazma-sanati-baslangic-rehberi',
                'content' => '<p>Yapay zeka ile etkileşim kurmanın en önemli yolu doğru prompt yazmaktır. Bu rehberde AI prompt yazma sanatının temellerini öğreneceksiniz.</p><h3>Prompt Nedir?</h3><p>Prompt, yapay zeka modeline verdiğiniz talimat veya sorudur. İyi bir prompt, istediğiniz sonucu almanızı sağlar.</p>',
                'excerpt' => 'AI ile etkileşim kurmanın temellerini öğrenin ve etkili promptlar yazmaya başlayın.',
                'featured_image' => 'assets/images/blog/b-one.png',
                'status' => 'published',
                'views' => 150,
                'tags' => 'AI, Prompt, Rehber, Başlangıç',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'ChatGPT için En Etkili Prompt Teknikleri',
                'slug' => 'chatgpt-icin-en-etkili-prompt-teknikleri',
                'content' => '<p>ChatGPT ile daha iyi sonuçlar almak için kullanabileceğiniz gelişmiş prompt tekniklerini keşfedin.</p><h3>Rol Tanımlama</h3><p>ChatGPT\'ye belirli bir rol vererek daha odaklı yanıtlar alabilirsiniz.</p>',
                'excerpt' => 'ChatGPT ile daha etkili sonuçlar almak için gelişmiş prompt tekniklerini öğrenin.',
                'featured_image' => 'assets/images/blog/b-two.png',
                'status' => 'published',
                'views' => 230,
                'tags' => 'ChatGPT, Teknik, İleri Seviye',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Midjourney Prompt Rehberi: Sanat Yaratma',
                'slug' => 'midjourney-prompt-rehberi-sanat-yaratma',
                'content' => '<p>Midjourney ile etkileyici görseller oluşturmak için prompt yazma tekniklerini öğrenin.</p><h3>Stil Belirtme</h3><p>Midjourney\'de istediğiniz sanat stilini belirtmek çok önemlidir.</p>',
                'excerpt' => 'Midjourney ile profesyonel görseller oluşturmak için prompt yazma sanatını keşfedin.',
                'featured_image' => 'assets/images/blog/b-three.png',
                'status' => 'published',
                'views' => 180,
                'tags' => 'Midjourney, Görsel, Sanat, Prompt',
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}