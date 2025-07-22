<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Models/Wishlist.php';

use App\Models\Wishlist;

$csv_file = __DIR__ . '/../favorite_products.csv';
if (!file_exists($csv_file)) {
    exit("CSV dosyası bulunamadı: $csv_file\n");
}

$wishlist_model = new Wishlist();
$success_count = 0;
$not_found_count = 0;

// Tüm mevcut wishlist ürünlerini bir defada al
$db_items = $wishlist_model->getAll('favori');

if (($handle = fopen($csv_file, 'r')) !== false) {
    $header = fgetcsv($handle); // başlık satırı
    while (($row = fgetcsv($handle)) !== false) {
        $data = array_combine($header, $row);
        $csv_name = trim(strtolower($data['baslik']));
        $found = false;
        foreach ($db_items as $row_db) {
            if (trim(strtolower($row_db['item_name'])) === $csv_name) {
                $found = true;
                $update_data = [
                    'item_name' => $row_db['item_name'],
                    'wishlist_type' => $row_db['wishlist_type'],
                    'image_url' => $data['resim'],
                    'product_link' => $data['link'],
                    'price' => $row_db['price'],
                    'priority' => $row_db['priority'],
                    'progress' => $row_db['progress']
                ];
                $wishlist_model->update($row_db['id'], $update_data);
                echo "Güncellendi: {$row_db['item_name']}\n";
                $success_count++;
                break;
            }
        }
        if (!$found) {
            echo "Bulunamadı: {$data['baslik']}\n";
            $not_found_count++;
        }
    }
    fclose($handle);
} else {
    exit("CSV dosyası açılamadı!\n");
}

echo "\nToplam güncellenen: $success_count\nBulunamayan: $not_found_count\n"; 