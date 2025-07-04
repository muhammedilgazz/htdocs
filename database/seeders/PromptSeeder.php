<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromptSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prompts')->insert([
            [
                'title' => "Kreatif AI Prompt",
                'main_cat_id' => 1,
                'other_cats' => 'Kreatif',
                'picture' => 'assets/images/nft/ns-one.png',
                'prompt_agent' => 'ChatGPT',
                'used_times' => 0,
                'prompt_text' => 'Yaratıcı AI ile ilgili bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => 'kreatif,ai',
            ],
            [
                'title' => "Fotoğraf Düzenleme Prompt",
                'main_cat_id' => 2,
                'other_cats' => 'Foto Düzenleme',
                'picture' => 'assets/images/nft/ns-two.png',
                'prompt_agent' => 'Midjourney',
                'used_times' => 0,
                'prompt_text' => 'Fotoğraf düzenleme için bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => 'fotoğraf,düzenleme',
            ],
            [
                'title' => "3D Animasyon Prompt",
                'main_cat_id' => 3,
                'other_cats' => '3D & Animasyon',
                'picture' => 'assets/images/nft/ns-three.png',
                'prompt_agent' => 'DALL-E',
                'used_times' => 0,
                'prompt_text' => '3D animasyon için bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => '3d,animasyon',
            ],
            [
                'title' => "Sosyal Medya Prompt",
                'main_cat_id' => 4,
                'other_cats' => 'Reklamcılık',
                'picture' => 'assets/images/nft/ns-four.png',
                'prompt_agent' => 'ChatGPT',
                'used_times' => 0,
                'prompt_text' => 'Sosyal medya için bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => 'sosyal,medya',
            ],
            [
                'title' => "Portre Prompt",
                'main_cat_id' => 5,
                'other_cats' => 'Portre & Selfiler',
                'picture' => 'assets/images/nft/ns-five.png',
                'prompt_agent' => 'Midjourney',
                'used_times' => 0,
                'prompt_text' => 'Portre için bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => 'portre,selfie',
            ],
            [
                'title' => "Efekt Prompt",
                'main_cat_id' => 6,
                'other_cats' => 'Efektler',
                'picture' => 'assets/images/nft/ns-six.png',
                'prompt_agent' => 'DALL-E',
                'used_times' => 0,
                'prompt_text' => 'Efekt için bir prompt örneği.',
                'publisher' => 'admin',
                'keywords' => 'efekt',
            ],
            [
                'title' => "Squid Game Selfie",
                'main_cat_id' => 5,
                'other_cats' => 'Portre & Selfiler',
                'picture' => 'assets/images/nft/ns-four.png',
                'prompt_agent' => 'ChatGPT',
                'used_times' => 0,
                'prompt_text' => 'Squid Game temalı bir selfie promptu.',
                'publisher' => 'admin',
                'keywords' => 'squidgame,selfie',
            ],
            [
                'title' => "Cinematic Rainy Portrait",
                'main_cat_id' => 5,
                'other_cats' => 'Portre & Selfiler',
                'picture' => 'assets/images/nft/ns-four.png',
                'prompt_agent' => 'DALL·E',
                'used_times' => 0,
                'prompt_text' => 'Yağmurlu sinematik portre promptu.',
                'publisher' => 'admin',
                'keywords' => 'cinematic,portrait',
            ],
        ]);
    }
}
