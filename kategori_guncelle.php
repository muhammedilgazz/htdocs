<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';

$security = new SecurityManager();
$security->checkSession();

$db = Database::getInstance();

// Tüm harcamaları al
$harcamalar = $db->fetchAll("SELECT * FROM harcama_kalemleri ORDER BY id");

echo "<h2>Harcama Kategorilerini Güncelleme</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .harcama { border: 1px solid #ddd; margin: 10px 0; padding: 15px; border-radius: 5px; }
    .kategori { font-weight: bold; color: #333; }
    .urun { color: #666; }
    .tutar { color: #e74c3c; font-weight: bold; }
    .form { margin-top: 10px; }
    select { padding: 5px; margin-right: 10px; }
    button { padding: 8px 15px; background: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; }
    button:hover { background: #2980b9; }
    .success { color: green; }
    .error { color: red; }
</style>";

// Kategori güncelleme işlemi
if ($_POST && isset($_POST['update_categories'])) {
    $db->beginTransaction();
    $success_count = 0;
    $error_count = 0;
    
    foreach ($_POST['kategori_tipi'] as $id => $kategori_tipi) {
        try {
            $db->execute("UPDATE harcama_kalemleri SET kategori_tipi = ? WHERE id = ?", [$kategori_tipi, $id]);
            $success_count++;
        } catch (Exception $e) {
            $error_count++;
            echo "<div class='error'>Hata: ID $id güncellenirken hata oluştu</div>";
        }
    }
    
    $db->commit();
    echo "<div class='success'>$success_count kayıt başarıyla güncellendi. $error_count hata oluştu.</div>";
    echo "<hr>";
}

// Kategori tanımları
$kategori_tanımları = [
    'Sabit Giderler' => [
        'keywords' => ['kira', 'elektrik', 'su', 'doğalgaz', 'internet', 'telefon', 'sigorta', 'vergi', 'aidat', 'abonelik'],
        'description' => 'Her ay düzenli olarak yapılan ve tutarı büyük ölçüde değişmeyen harcamalar'
    ],
    'Değişken Giderler' => [
        'keywords' => ['market', 'yemek', 'ulaşım', 'benzin', 'giyim', 'eğlence', 'spor', 'sağlık', 'eğitim'],
        'description' => 'Aylık tutarı değişkenlik gösteren ve kontrol edilebilir harcamalar'
    ],
    'Borç Ödemeleri' => [
        'keywords' => ['kredi', 'borç', 'taksit', 'ödeme', 'kart', 'faiz', 'asgari'],
        'description' => 'Kredi kartı, kredi ve diğer borç ödemeleri'
    ],
    'Ani/Ekstra Harcama' => [
        'keywords' => ['arıza', 'tamir', 'bakım', 'hediye', 'tatil', 'seyahat', 'acil', 'beklenmedik'],
        'description' => 'Plansız ve manuel giriş gerektiren harcamalar'
    ]
];

// Otomatik kategori önerisi
function otomatikKategoriOner($kategori, $urun, $aciklama) {
    global $kategori_tanımları;
    
    $text = strtolower($kategori . ' ' . $urun . ' ' . $aciklama);
    
    foreach ($kategori_tanımları as $tip => $tanim) {
        foreach ($tanim['keywords'] as $keyword) {
            if (strpos($text, strtolower($keyword)) !== false) {
                return $tip;
            }
        }
    }
    
    return 'Ani/Ekstra Harcama'; // Varsayılan
}

echo "<form method='post'>";
echo "<button type='submit' name='update_categories'>Kategorileri Güncelle</button>";
echo "<hr>";

foreach ($harcamalar as $harcama) {
    $otomatik_oneri = otomatikKategoriOner($harcama['kategori'], $harcama['urun'], $harcama['aciklama']);
    
    echo "<div class='harcama'>";
    echo "<div class='kategori'>Kategori: " . htmlspecialchars($harcama['kategori']) . "</div>";
    echo "<div class='urun'>Ürün/Hizmet: " . htmlspecialchars($harcama['urun']) . "</div>";
    echo "<div class='tutar'>Tutar: ₺" . number_format($harcama['tutar'], 0, ',', '.') . "</div>";
    if (!empty($harcama['aciklama'])) {
        echo "<div>Açıklama: " . htmlspecialchars($harcama['aciklama']) . "</div>";
    }
    echo "<div>Mevcut Kategori: <strong>" . htmlspecialchars($harcama['kategori_tipi']) . "</strong></div>";
    echo "<div>Önerilen Kategori: <strong style='color: #e67e22;'>" . $otomatik_oneri . "</strong></div>";
    
    echo "<div class='form'>";
    echo "<select name='kategori_tipi[" . $harcama['id'] . "]'>";
    foreach ($kategori_tanımları as $tip => $tanim) {
        $selected = ($harcama['kategori_tipi'] == $tip) ? 'selected' : '';
        echo "<option value='$tip' $selected>$tip - " . $tanim['description'] . "</option>";
    }
    echo "<option value='Ertelenen Ödemeler' " . ($harcama['kategori_tipi'] == 'Ertelenen Ödemeler' ? 'selected' : '') . ">Ertelenen Ödemeler - Gelecek tarihlere ertelenmiş ödemeler</option>";
    echo "</select>";
    echo "</div>";
    echo "</div>";
}

echo "</form>";

echo "<hr>";
echo "<h3>Kategori Tanımları:</h3>";
foreach ($kategori_tanımları as $tip => $tanim) {
    echo "<div style='margin: 10px 0;'>";
    echo "<strong>$tip:</strong> " . $tanim['description'] . "<br>";
    echo "<small>Anahtar kelimeler: " . implode(', ', $tanim['keywords']) . "</small>";
    echo "</div>";
}
?> 