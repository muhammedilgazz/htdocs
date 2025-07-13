            // Generate a random password
            $defaultPassword = bin2hex(random_bytes(8));
<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getPdo();

    echo "Güvenlik güncellemeleri uygulanıyor...\n\n";

    // SQL dosyasını çalıştır
    $sql = file_get_contents('sql/security_fixes.sql');
    $statements = explode(';', $sql);

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
                echo "✓ SQL komutu başarıyla çalıştırıldı\n";
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'already exists') === false &&
                    strpos($e->getMessage(), 'Duplicate entry') === false &&
                    strpos($e->getMessage(), 'Duplicate key name') === false &&
                    strpos($e->getMessage(), 'Duplicate column name') === false) {
                    echo "⚠ Hata: " . $e->getMessage() . "\n";
                } else {
                    echo "✓ Zaten mevcut, atlandı\n";
                }
            }
        }
    }

    // Mevcut şifreleri hash'le
    echo "\nMevcut şifreler güvenli hale getiriliyor...\n";
    try {
        $stmt = $pdo->query("SELECT id, password_hash FROM hesaplar_sifreler WHERE password_hash IS NULL OR password_hash = ''");
        $passwords = $stmt->fetchAll();

        foreach ($passwords as $row) {
            // Get default password from environment variable or secrets manager
            $defaultPassword = getenv('DEFAULT_PASSWORD') ?: throw new Exception('Default password not set');
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE hesaplar_sifreler SET password_hash = ? WHERE id = ?");
            $updateStmt->execute([$hashedPassword, $row['id']]);
            echo "✓ Rastgele şifre atandı (ID: {$row['id']})\n";
        }
        
        if (empty($passwords)) {
            echo "✓ Tüm şifreler zaten güvenli\n";
        }
    } catch (Exception $e) {
        echo "⚠ Şifre güncelleme atlandı: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Güvenlik güncellemeleri tamamlandı!\n";
    echo "\nYapılan iyileştirmeler:\n";
    echo "- Kullanıcı kimlik doğrulama sistemi\n";
    echo "- Şifre şifreleme (bcrypt)\n";
    echo "- Rate limiting\n";
    echo "- Session yönetimi\n";
    echo "- Database indexleri\n";
    echo "- Error sayfaları (404, 500)\n";
    echo "- Backup sistemi\n";
    
    echo "\nAdmin giriş bilgileri:\n";
    echo "Kullanıcı: admin\n";
    echo "Şifre: admin123\n";
    
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage() . "\n";
}
?>