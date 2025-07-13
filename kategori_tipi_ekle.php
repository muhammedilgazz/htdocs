<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

$db = Database::getInstance();

echo "<h2>Kategori Tipi Sütunu Ekleme</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { background: #d4edda; padding: 10px; border-radius: 4px; margin: 10px 0; color: #155724; }
    .error { background: #f8d7da; padding: 10px; border-radius: 4px; margin: 10px 0; color: #721c24; }
    .info { background: #d1ecf1; padding: 10px; border-radius: 4px; margin: 10px 0; color: #0c5460; }
    button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
    button:hover { background: #0056b3; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>";

// Mevcut tablo yapısını kontrol et
try {
    $columns = $db->fetchAll("SHOW COLUMNS FROM harcama_kalemleri");
    echo "<div class='info'>";
    echo "<h3>Mevcut Tablo Yapısı:</h3>";
    echo "<table>";
    echo "<tr><th>Sütun Adı</th><th>Tip</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='error'>Tablo yapısı kontrol edilirken hata: " . $e->getMessage() . "</div>";
}

// kategori_tipi sütununun var olup olmadığını kontrol et
$kategori_tipi_exists = false;
foreach ($columns as $column) {
    if ($column['Field'] == 'kategori_tipi') {
        $kategori_tipi_exists = true;
        break;
    }
}

if ($kategori_tipi_exists) {
    echo "<div class='info'>kategori_tipi sütunu zaten mevcut!</div>";
} else {
    echo "<div class='info'>kategori_tipi sütunu bulunamadı. Eklenmesi gerekiyor.</div>";
}

// Sütun ekleme işlemi
if (isset($_POST['add_column']) && !$kategori_tipi_exists) {
    try {
        $db->beginTransaction();
        
        // kategori_tipi sütununu ekle
        $db->execute("ALTER TABLE harcama_kalemleri ADD COLUMN kategori_tipi VARCHAR(50) DEFAULT 'Ani/Ekstra Harcama' AFTER kategori");
        
        // erteleme_tarihi sütununu da ekle (eğer yoksa)
        $erteleme_tarihi_exists = false;
        foreach ($columns as $column) {
            if ($column['Field'] == 'erteleme_tarihi') {
                $erteleme_tarihi_exists = true;
                break;
            }
        }
        
        if (!$erteleme_tarihi_exists) {
            $db->execute("ALTER TABLE harcama_kalemleri ADD COLUMN erteleme_tarihi DATE NULL AFTER kategori_tipi");
        }
        
        $db->commit();
        echo "<div class='success'>kategori_tipi sütunu başarıyla eklendi!</div>";
        
        // Güncellenmiş tablo yapısını göster
        $columns = $db->fetchAll("SHOW COLUMNS FROM harcama_kalemleri");
        echo "<div class='info'>";
        echo "<h3>Güncellenmiş Tablo Yapısı:</h3>";
        echo "<table>";
        echo "<tr><th>Sütun Adı</th><th>Tip</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        
    } catch (Exception $e) {
        $db->rollback();
        echo "<div class='error'>Sütun eklenirken hata oluştu: " . $e->getMessage() . "</div>";
    }
}

// Mevcut verileri göster
try {
    $harcamalar = $db->fetchAll("SELECT * FROM harcama_kalemleri ORDER BY id LIMIT 10");
    echo "<div class='info'>";
    echo "<h3>Örnek Veriler (İlk 10 kayıt):</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Kategori</th><th>Kategori Tipi</th><th>Ürün/Hizmet</th><th>Tutar</th></tr>";
    foreach ($harcamalar as $harcama) {
        echo "<tr>";
        echo "<td>" . $harcama['id'] . "</td>";
        echo "<td>" . htmlspecialchars($harcama['kategori']) . "</td>";
        echo "<td>" . htmlspecialchars($harcama['kategori_tipi'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($harcama['urun']) . "</td>";
        echo "<td>₺" . number_format($harcama['tutar'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='error'>Veriler gösterilirken hata: " . $e->getMessage() . "</div>";
}

// Sütun ekleme formu
if (!$kategori_tipi_exists) {
    echo "<form method='post'>";
    echo "<button type='submit' name='add_column'>kategori_tipi Sütununu Ekle</button>";
    echo "</form>";
}

// Otomatik kategori güncelleme linki
if ($kategori_tipi_exists) {
    echo "<div style='margin-top: 20px;'>";
    echo "<a href='otomatik_kategori_guncelle.php' style='text-decoration: none;'>";
    echo "<button type='button' style='background: #28a745;'>Otomatik Kategori Güncelle</button>";
    echo "</a>";
    echo "</div>";
}
?> 