<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\User;

class TransformerService
{
    private const DEFAULT_IMAGES = [
        'seller' => 'assets/images/sellers/default.png',
        'artist_cover' => 'assets/images/artists/sc-one.png',
        'artist_avatar' => 'assets/images/sellers/seller-two.png',
        'blog' => 'assets/images/blog/default.png'
    ];

    public function toSeller(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'image' => $user->avatar ?: self::DEFAULT_IMAGES['seller'],
            'spend' => '$1,954'
        ];
    }

    public function toArtist(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'cover' => $user->cover ?: self::DEFAULT_IMAGES['artist_cover'],
            'avatar' => $user->avatar ?: self::DEFAULT_IMAGES['artist_avatar']
        ];
    }

    public function toBlogData(Blog $blog): array
    {
        return array(
            'id' => $blog->id,
            'title' => $blog->title,
            'image' => $blog->image ?: self::DEFAULT_IMAGES['blog'],
            'tag' => $blog->tag ?: 'General',
            'writer' => $blog->writer ?: 'Admin',
            'date' => $blog->created_at?->format('M d Y') ?? now()->format('M d Y'),
            'url' => "blog/" . route('blog.show', $blog->slug), // Tam URL'yi ekledik
            'slug' => "blog/" . $blog->slug
        );
    }
}
