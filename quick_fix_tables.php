<?php
/**
 * Quick Fix for Table Names
 * This script quickly replaces the most common old table name references
 */

// Define replacements
$replacements = [
    'harcama_kalemleri' => 'expense_items',
    'bakiye' => 'balances',
    'odemeler' => 'payments',
    'istek_listesi' => 'wishlist_items',
    'hesaplar_sifreler' => 'account_credentials',
    'iban_bilgileri' => 'iban_details',
    'kategori_tipleri' => 'categories',
    'kullanicilar' => 'users',
    'notlar' => 'notes',
    'gorevler' => 'todos',
    'toplam_bakiye' => 'total_balance',
    'kategori_tipi' => 'category_id',
    'kullanici_id' => 'user_id',
    'kalem_adi' => 'item_name',
    'urun' => 'item_name',
    'tutar' => 'amount',
    'aciklama' => 'description',
    'durum' => 'status_id'
];

// Files to update
$files = [
    'sabit-giderler.php',
    'istek-listesi.php',
    'ihtiyaclar.php',
    'degisken-giderler.php',
    'ekstra-harcamalar.php',
    'gorevler.php',
    'projeler.php',
    'sahislara-borclar.php',
    'sgk.php',
    'vergi.php',
    'icralar.php',
    'todo-list.php',
    'iban_tablosu.php',
    'hesaplar_sifreler.php'
];

$updated = 0;
$errors = 0;

echo "Quick Table Name Fix\n";
echo "===================\n\n";

foreach ($files as $file) {
    if (!file_exists($file)) {
        echo "❌ $file - File not found\n";
        continue;
    }
    
    try {
        $content = file_get_contents($file);
        $original = $content;
        
        // Apply replacements
        foreach ($replacements as $old => $new) {
            $content = str_replace($old, $new, $content);
        }
        
        // Fix common query patterns
        $content = preg_replace(
            '/SELECT \* FROM expense_items WHERE category_id=\'([^\']+)\'/',
            'SELECT e.*, c.name as kategori_adi FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name=\'$1\'',
            $content
        );
        
        if ($content !== $original) {
            file_put_contents($file, $content);
            echo "✅ $file - Updated\n";
            $updated++;
        } else {
            echo "⚪ $file - No changes needed\n";
        }
        
    } catch (Exception $e) {
        echo "❌ $file - Error: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "\n===================\n";
echo "Summary:\n";
echo "✅ Updated: $updated files\n";
echo "❌ Errors: $errors files\n";
echo "===================\n";
?>