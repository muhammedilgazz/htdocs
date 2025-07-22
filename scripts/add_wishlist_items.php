<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Models/Wishlist.php';

use App\Models\Wishlist;

// Wishlist öğeleri
$wishlist_items = [
    [
        'item_name' => 'DJI Mavic 3 Pro Cine Premium Combo',
        'wishlist_type' => 'favori',
        'price' => 244000,
        'priority' => 1,
        'image_url' => 'https://images.unsplash.com/photo-1579829366248-204fe8413f31?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/mavic-3-pro-cine'
    ],
    [
        'item_name' => 'DJI Inspire 3 Drone',
        'wishlist_type' => 'favori',
        'price' => 817500,
        'priority' => 2,
        'image_url' => 'https://images.unsplash.com/photo-1507582020474-9a35b7d455d9?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/inspire-3'
    ],
    [
        'item_name' => 'DJI Osmo Mobile 7',
        'wishlist_type' => 'favori',
        'price' => 6999,
        'priority' => 3,
        'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/osmo-mobile-7'
    ],
    [
        'item_name' => 'DJI RS 4',
        'wishlist_type' => 'favori',
        'price' => 29999,
        'priority' => 4,
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/ronin-rs-4'
    ],
    [
        'item_name' => 'DJI Ronin 4D 4-Axis Cinema Camera 8K Combo Kit',
        'wishlist_type' => 'favori',
        'price' => 543000,
        'priority' => 5,
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/ronin-4d'
    ],
    [
        'item_name' => 'DJI Mic Mini',
        'wishlist_type' => 'favori',
        'price' => 8800,
        'priority' => 6,
        'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/mic-mini'
    ],
    [
        'item_name' => 'Blackmagic PYXIS 12K L',
        'wishlist_type' => 'favori',
        'price' => 304250,
        'priority' => 7,
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.blackmagicdesign.com/products/blackmagicpyxis'
    ]
];

$wishlist_model = new Wishlist();
$success_count = 0;
$error_count = 0;

echo "Wishlist öğeleri ekleniyor...\n";
echo "================================\n";

foreach ($wishlist_items as $item) {
    $data = [
        'item_name' => $item['item_name'],
        'wishlist_type' => $item['wishlist_type'],
        'price' => $item['price'],
        'priority' => $item['priority'],
        'progress' => 0,
        'image_url' => $item['image_url'] ?? null,
        'product_link' => $item['product_link'] ?? null
    ];
    
    if ($wishlist_model->add($data)) {
        echo "✅ " . $item['item_name'] . " - EKLENDİ\n";
        $success_count++;
    } else {
        echo "❌ " . $item['item_name'] . " - HATA\n";
        $error_count++;
    }
}

echo "================================\n";
echo "Toplam: " . count($wishlist_items) . " öğe\n";
echo "Başarılı: " . $success_count . " öğe\n";
echo "Hatalı: " . $error_count . " öğe\n";
echo "İşlem tamamlandı!\n"; 