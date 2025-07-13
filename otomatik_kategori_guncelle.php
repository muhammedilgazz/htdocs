<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

$db = Database::getInstance();

// Kategori kuralları
$kategori_kurallari = [
    'Sabit Giderler' => [
        'keywords' => ['kira', 'elektrik', 'su', 'doğalgaz', 'internet', 'telefon', 'sigorta', 'vergi', 'aidat', 'abonelik', 'iptv', 'netflix', 'spotify', 'youtube'],
        'categories' => ['Ev', 'Fatura', 'Abonelik', 'Sigorta', 'Vergi']
    ],
    'Değişken Giderler' => [
        'keywords' => ['market', 'yemek', 'ulaşım', 'benzin', 'giyim', 'eğlence', 'spor', 'sağlık', 'eğitim', 'restoran', 'kafe', 'otobüs', 'metro', 'taksi'],
        'categories' => ['Market', 'Yemek', 'Ulaşım', 'Giyim', 'Eğlence', 'Spor', 'Sağlık', 'Eğitim']
    ],
    'Borç Ödemeleri' => [
        'keywords' => ['kredi', 'borç', 'taksit', 'ödeme', 'kart', 'faiz', 'asgari', 'kredi kartı', 'kredi karti'],
        'categories' => ['Kredi', 'Borç', 'Kredi Kartı']
    ],
    'Alınacak Ürünler' => [
        'keywords' => ['alınacak', 'satın al', 'istek', 'wishlist', 'alışveriş listesi', 'alışveriş', 'ürün', 'eşya', 'malzeme', 'kitap', 'elektronik', 'giyim', 'aksesuar'],
        'categories' => ['Alışveriş', 'İstek', 'Ürün', 'Eşya', 'Malzeme', 'Kitap', 'Elektronik', 'Aksesuar']
    ],
    'Ani/Ekstra Harcama' => [
        'keywords' => ['arıza', 'tamir', 'bakım', 'hediye', 'tatil', 'seyahat', 'acil', 'beklenmedik', 'hediye', 'doğum günü'],
        'categories' => ['Tamir', 'Hediye', 'Tatil', 'Seyahat', 'Acil']
    ]
];

function kategoriOner($kategori, $urun, $aciklama) {
    global $kategori_kurallari;
    
    $text = strtolower($kategori . ' ' . $urun . ' ' . $aciklama);
    
    foreach ($kategori_kurallari as $tip => $kurallar) {
        // Anahtar kelime kontrolü
        foreach ($kurallar['keywords'] as $keyword) {
            if (strpos($text, strtolower($keyword)) !== false) {
                return $tip;
            }
        }
        
        // Kategori adı kontrolü
        foreach ($kurallar['categories'] as $cat) {
            if (strpos(strtolower($kategori), strtolower($cat)) !== false) {
                return $tip;
            }
        }
    }
    
    return 'Ani/Ekstra Harcama'; // Varsayılan
}

// Tüm harcamaları al
$harcamalar = $db->fetchAll("SELECT * FROM harcama_kalemleri ORDER BY id");

echo "<h2>Otomatik Kategori Güncelleme</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .current { background-color: #fff3cd; }
    .suggested { background-color: #d1ecf1; }
    .update { background-color: #d4edda; }
    button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #0056b3; }
</style>";

// Güncelleme işlemi
if (isset($_POST['update'])) {
    $db->beginTransaction();
    $updated = 0;
    
    foreach ($harcamalar as $harcama) {
        $oneri = kategoriOner($harcama['kategori'], $harcama['urun'], $harcama['aciklama']);
        
        if ($harcama['kategori_tipi'] != $oneri) {
            $db->execute("UPDATE harcama_kalemleri SET kategori_tipi = ? WHERE id = ?", [$oneri, $harcama['id']]);
            $updated++;
        }
    }
    
    $db->commit();
    echo "<div style='background: #d4edda; padding: 10px; border-radius: 4px; margin: 10px 0;'>";
    echo "$updated kayıt güncellendi!";
    echo "</div>";
    
    // Güncellenmiş verileri tekrar al
    $harcamalar = $db->fetchAll("SELECT * FROM harcama_kalemleri ORDER BY id");
}

echo "<form method='post'>";
echo "<button type='submit' name='update'>Otomatik Kategori Güncelle</button>";
echo "</form>";

echo "<table>";
echo "<tr>";
echo "<th>ID</th><th>Kategori</th><th>Ürün/Hizmet</th><th>Tutar</th><th>Mevcut Kategori</th><th>Önerilen Kategori</th>";
echo "</tr>";

foreach ($harcamalar as $harcama) {
    $oneri = kategoriOner($harcama['kategori'], $harcama['urun'], $harcama['aciklama']);
    $row_class = ($harcama['kategori_tipi'] != $oneri) ? 'current' : 'update';
    
    echo "<tr class='$row_class'>";
    echo "<td>" . $harcama['id'] . "</td>";
    echo "<td>" . htmlspecialchars($harcama['kategori']) . "</td>";
    echo "<td>" . htmlspecialchars($harcama['urun']) . "</td>";
    echo "<td>₺" . number_format($harcama['tutar'], 0, ',', '.') . "</td>";
    echo "<td>" . htmlspecialchars($harcama['kategori_tipi']) . "</td>";
    echo "<td>" . $oneri . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>Güncelleme Sonrası Kategori Dağılımı:</h3>";
$kategori_dagilimi = $db->fetchAll("SELECT kategori_tipi, COUNT(*) as sayi FROM harcama_kalemleri GROUP BY kategori_tipi ORDER BY sayi DESC");
foreach ($kategori_dagilimi as $dagilim) {
    echo "<strong>" . $dagilim['kategori_tipi'] . ":</strong> " . $dagilim['sayi'] . " adet<br>";
}
?> 