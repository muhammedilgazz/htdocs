<?php
// scripts/import_market_products.php

$pdo = new PDO('mysql:host=localhost;dbname=budget_db;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$csvFile = __DIR__ . '/../tum_urunler_utf8bom.csv';

if (($handle = fopen($csvFile, 'r')) !== false) {
    $row = 0;
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        if ($row === 0) {
            // Başlıkları küçük harfe çevir ve BOM karakterini temizle
            $headers = array_map(function($h) {
                return ltrim(mb_strtolower($h), "\xEF\xBB\xBF \t\n\r\0\x0B");
            }, $data);
        } else {
            // Anahtarları küçük harfe çevir (Türkçe başlıklar için)
            $rowData = array_combine($headers, $data);
            $rowData = array_change_key_case($rowData, CASE_LOWER);

            // Alanları eşleştir
            $category      = isset($rowData['kategori']) && $rowData['kategori'] !== '' ? $rowData['kategori'] : 'market';
            $product_name  = $rowData['urun_adi'] ?? null;
            $quantity      = $rowData['miktar'] ?? 1;
            $price         = str_replace(',', '.', $rowData['fiyat'] ?? 0); // Türkçe ondalık için
            $company_name  = $rowData['market_adi'] ?? null;
            $image_url     = $rowData['resim_linki'] ?? '';
            $link          = '';
            $user_id       = 1;
            $min_stock     = 0;
            $current_stock = 0;
            $total_amount  = is_numeric($price) ? ((float)$price) : 0;
            $created_at    = date('Y-m-d H:i:s');
            $updated_at    = $created_at;

            if (empty($product_name)) continue;

            $stmt = $pdo->prepare("INSERT INTO market_products (
                user_id, product_name, company_name, link, image_url, quantity, price, total_amount, min_stock, current_stock, created_at, updated_at, category
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $user_id,
                $product_name,
                $company_name,
                $link,
                $image_url,
                $quantity,
                $price,
                $total_amount,
                $min_stock,
                $current_stock,
                $created_at,
                $updated_at,
                $category
            ]);
        }
        $row++;
    }
    fclose($handle);
    echo "Market ürünleri başarıyla eklendi!";
} else {
    echo "CSV dosyası açılamadı!";
}