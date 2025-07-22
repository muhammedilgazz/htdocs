<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Models/Wishlist.php';

use App\Models\Wishlist;

$wishlist = new Wishlist();
$items = $wishlist->getByType('istek');

echo "Toplam " . count($items) . " istek öğesi bulundu:\n";
echo "================================\n";

foreach($items as $item) {
    $price = $item['price'] > 0 ? '₺' . number_format($item['price'], 0, ',', '.') : 'Fiyat belirtilmemiş';
    echo "- " . $item['item_name'] . " (" . $price . ")\n";
}

echo "================================\n";
echo "İşlem tamamlandı!\n"; 