<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Models/Wishlist.php';

use App\Models\Wishlist;

$wishlist_items = [
    [
        'item_name' => 'DJI Mavic 3 Pro Cine Premium Combo',
        'image_url' => 'https://images.unsplash.com/photo-1579829366248-204fe8413f31?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/mavic-3-pro-cine'
    ],
    [
        'item_name' => 'DJI Inspire 3 Drone',
        'image_url' => 'https://images.unsplash.com/photo-1507582020474-9a35b7d455d9?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/inspire-3'
    ],
    [
        'item_name' => 'DJI Osmo Mobile 7',
        'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/osmo-mobile-7'
    ],
    [
        'item_name' => 'DJI RS 4',
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/ronin-rs-4'
    ],
    [
        'item_name' => 'DJI Ronin 4D 4-Axis Cinema Camera 8K Combo Kit',
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/ronin-4d'
    ],
    [
        'item_name' => 'DJI Mic Mini',
        'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=400&h=300&fit=crop',
        'product_link' => 'https://www.dji.com/tr/mic-mini'
    ],
    [
        'item_name' => 'Blackmagic PYXIS 12K L',
        'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop',
        'product_link' => 'https://www.blackmagicdesign.com/products/blackmagicpyxis'
    ]
];

$wishlist_model = new Wishlist();
$success_count = 0;
$not_found_count = 0;

foreach ($wishlist_items as $item) {
    $db_item = $wishlist_model->getAll();
    $found = false;
    foreach ($db_item as $row) {
        if (trim(strtolower($row['item_name'])) === trim(strtolower($item['item_name']))) {
            $found = true;
            $update_data = [
                'item_name' => $row['item_name'],
                'wishlist_type' => $row['wishlist_type'],
                'image_url' => $item['image_url'],
                'product_link' => $item['product_link'],
                'price' => $row['price'],
                'priority' => $row['priority'],
                'progress' => $row['progress']
            ];
            $wishlist_model->update($row['id'], $update_data);
            echo "Güncellendi: {$row['item_name']}\n";
            $success_count++;
            break;
        }
    }
    if (!$found) {
        echo "Bulunamadı: {$item['item_name']}\n";
        $not_found_count++;
    }
}
echo "\nToplam güncellenen: $success_count\nBulunamayan: $not_found_count\n"; 