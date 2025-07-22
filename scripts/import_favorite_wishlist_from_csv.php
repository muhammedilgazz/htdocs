<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Models/Wishlist.php';

use App\Models\Wishlist;

$csv_file = __DIR__ . '/favorite_products.csv';

echo "📁 Gerçek yol: " . realpath($csv_file) . "\n";
echo "📦 Dosya mevcut mu? " . (file_exists($csv_file) ? 'EVET' : 'HAYIR') . "\n";
echo "📏 Dosya boyutu: " . (file_exists($csv_file) ? filesize($csv_file) . ' bayt' : 'YOK') . "\n";

if (($handle = fopen($csv_file, 'r')) !== false) {
    $line = fgets($handle);
    echo "📄 İlk satır ham (hex): " . bin2hex($line) . "\n";
    rewind($handle);
    $header = fgetcsv($handle, 0, ',');
    echo "🧩 fgetcsv sonucu: ";
    var_dump($header);
} else {
    echo "❌ fopen() dosyayı açamadı.\n";
}

$csv_file = __DIR__ . '/favorite_products.csv';
if (!file_exists($csv_file)) {
    exit("❌ CSV dosyası bulunamadı: $csv_file\n");
}
$handle = fopen($csv_file, 'r');
$first_line = fgets($handle);
echo "📄 İlk satır ham hali:\n";
echo bin2hex($first_line) . "\n\n";  // karakter karakter göreceğiz
rewind($handle);

$delimiter = ',';  // Önemli: , kullanılıyor

$header = fgetcsv($handle, 0, $delimiter);
echo "🧩 fgetcsv sonrası:\n";
var_dump($header);

$wishlist_model = new Wishlist();
$success_count = 0;
$error_count = 0;
$row_count = 0;

// Hangi ayırıcıyı kullandığını kontrol etmek için manuel belirtiyoruz
$delimiter = ','; // CSV'n virgül (,) içeriyorsa ',' yap

if (($handle = fopen($csv_file, 'r')) !== false) {
    // İlk satırı oku ve BOM karakterini temizle
    $header = fgetcsv($handle, 0, $delimiter);
    if ($header && isset($header[0])) {
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
    }

    if (!$header || count($header) < 2) {
        exit("❌ Başlık satırı okunamadı veya yetersiz sütun içeriyor.\n");
    }

    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
        $row_count++;

        // Sütun sayısı uyuşmuyorsa atla
        if (count($row) !== count($header)) {
            echo "⚠️  Satır #$row_count: Sütun sayısı eşleşmiyor, atlandı.\n";
            continue;
        }

        // Başlıkları veriyle eşle
        $data = array_combine($header, $row);
        if (!$data) {
            echo "⚠️  Satır #$row_count: Eşleştirme başarısız, atlandı.\n";
            continue;
        }

        // Fiyatı temizle: "1.205,34TL" -> 1205.34
        $raw_price = $data['fiyat'] ?? '';
        $price_stripped = str_replace(['TL', ' ', '₺'], '', $raw_price);
        $price_stripped = str_replace('.', '', $price_stripped); // binlik ayırıcıları sil
        $price_stripped = str_replace(',', '.', $price_stripped); // ondalık ayırıcıya çevir
        $price = is_numeric($price_stripped) ? (float)$price_stripped : null;

        $item = [
            'item_name'     => trim($data['baslik'] ?? 'Adsız Ürün'),
            'wishlist_type' => 'favori',
            'price'         => $price,
            'priority'      => null,
            'progress'      => 0,
            'image_url'     => trim($data['resim'] ?? ''),
            'product_link'  => trim($data['link'] ?? '')
        ];

        // Veritabanına ekle
        $result = $wishlist_model->add($item);

        if ($result) {
            echo "✅ #$row_count: '{$item['item_name']}' eklendi\n";
            $success_count++;
        } else {
            echo "❌ #$row_count: '{$item['item_name']}' eklenemedi\n";
            $error_count++;
        }
    }

    fclose($handle);
} else {
    exit("❌ CSV dosyası açılamadı!\n");
}

echo "\n📊 İşlem Özeti:\n";
echo "   ✅ Başarıyla eklenen: $success_count\n";
echo "   ❌ Hatalı/atlanan   : $error_count\n";
echo "   📄 Toplam satır     : $row_count\n";
