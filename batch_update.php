<?php
// Quick batch update for critical files

$files_to_update = [
    'sahislara-borclar.php' => [
        'FROM harcama_kalemleri WHERE kategori_tipi=\'Borç Ödemeleri\' AND kategori LIKE \'%şahıs%\' AND harcama_donemi = ? ORDER BY id DESC' => 'FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name LIKE \'%Borç%\' ORDER BY e.id DESC'
    ],
    'vergi.php' => [
        'FROM harcama_kalemleri WHERE kategori_tipi=\'Borç Ödemeleri\' AND kategori LIKE \'%vergi%\' AND harcama_donemi = ? ORDER BY id DESC' => 'FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name LIKE \'%Vergi%\' ORDER BY e.id DESC'
    ],
    'sgk.php' => [
        'FROM harcama_kalemleri WHERE kategori_tipi=\'Borç Ödemeleri\' AND kategori LIKE \'%sgk%\' AND harcama_donemi = ? ORDER BY id DESC' => 'FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name LIKE \'%SGK%\' ORDER BY e.id DESC'
    ],
    'icralar.php' => [
        'FROM harcama_kalemleri WHERE kategori_tipi=\'Borç Ödemeleri\' AND kategori LIKE \'%icra%\' AND harcama_donemi = ? ORDER BY id DESC' => 'FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name LIKE \'%İcra%\' ORDER BY e.id DESC'
    ]
];

foreach ($files_to_update as $file => $replacements) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        foreach ($replacements as $old => $new) {
            $content = str_replace($old, $new, $content);
        }
        file_put_contents($file, $content);
        echo "Updated: $file\n";
    }
}

echo "Batch update completed!\n";
?>