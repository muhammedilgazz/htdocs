<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

$db = Database::getInstance();

// Tüm harcamaları al
$harcamalar = $db->fetchAll("SELECT * FROM harcama_kalemleri ORDER BY id");

echo "<h2>Mevcut Harcamalar</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th>ID</th><th>Kategori</th><th>Ürün/Hizmet</th><th>Tutar</th><th>Kategori Tipi</th><th>Açıklama</th>";
echo "</tr>";

foreach ($harcamalar as $harcama) {
    echo "<tr>";
    echo "<td>" . $harcama['id'] . "</td>";
    echo "<td>" . htmlspecialchars($harcama['kategori']) . "</td>";
    echo "<td>" . htmlspecialchars($harcama['urun']) . "</td>";
    echo "<td>₺" . number_format($harcama['tutar'], 0, ',', '.') . "</td>";
    echo "<td>" . htmlspecialchars($harcama['kategori_tipi']) . "</td>";
    echo "<td>" . htmlspecialchars($harcama['aciklama'] ?? '') . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>Kategori Tipi Dağılımı:</h3>";
$kategori_dagilimi = $db->fetchAll("SELECT kategori_tipi, COUNT(*) as sayi FROM harcama_kalemleri GROUP BY kategori_tipi");
foreach ($kategori_dagilimi as $dagilim) {
    echo $dagilim['kategori_tipi'] . ": " . $dagilim['sayi'] . " adet<br>";
}
?> 