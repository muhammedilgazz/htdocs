<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Veritabanı olmadan bağlan
    // amazonq-ignore-next-line
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Veritabanını oluştur
    $pdo->exec("CREATE DATABASE IF NOT EXISTS butce");
    $pdo->exec("USE butce");
    
    // Tabloları oluştur
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS odemeler (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kisi_adi VARCHAR(100) NOT NULL,
            iban VARCHAR(50),
            tutar DECIMAL(10,2) NOT NULL,
            durum ENUM('Beklemede', 'Gecikmiş', 'Planlandı', 'Ödendi') DEFAULT 'Beklemede',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bakiye (
            id INT AUTO_INCREMENT PRIMARY KEY,
            toplam_bakiye DECIMAL(15,2) DEFAULT 0,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    
    
    
    // Diğer tabloları oluştur
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS harcama_kalemleri (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sira INT NOT NULL,
            kategori VARCHAR(50) NOT NULL,
            urun VARCHAR(200) NOT NULL,
            tutar DECIMAL(10,2) NOT NULL,
            link TEXT,
            aciklama TEXT,
            durum VARCHAR(50) DEFAULT 'Beklemede',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS istek_listesi (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ad VARCHAR(200) NOT NULL,
            kategori VARCHAR(50) NOT NULL,
            fiyat DECIMAL(10,2) NOT NULL,
            gorsel TEXT,
            link TEXT,
            will_get ENUM('yes', 'no') DEFAULT 'no',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS hesaplar_sifreler (
            id INT AUTO_INCREMENT PRIMARY KEY,
            platform VARCHAR(100) NOT NULL,
            kullanici_adi VARCHAR(100) NOT NULL,
            sifre VARCHAR(100) NOT NULL,
            giris_linki TEXT,
            hesap_turu ENUM('İnternet Bankacılığı', 'Mail', 'Sosyal Medya', 'Bahis Sitesi') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS iban_bilgileri (
            id INT AUTO_INCREMENT PRIMARY KEY,
            hesap_sahibi VARCHAR(100) NOT NULL,
            iban VARCHAR(50),
            kolay_adres VARCHAR(50),
            banka VARCHAR(100) NOT NULL,
            logo VARCHAR(200),
            aciklama TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    
    
    
    
    
    
    
    
    
    
    echo "Veritabanı ve tüm tablolar başarıyla oluşturuldu!";
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>