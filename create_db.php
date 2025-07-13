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
    
    // Verileri ekle
    $pdo->exec("
        INSERT IGNORE INTO odemeler (id, kisi_adi, iban, tutar, durum) VALUES
        (1, 'Buket GÖNÜL', NULL, 4000.00, 'Beklemede'),
        (2, 'Şenay POLAT', NULL, 8000.00, 'Gecikmiş'),
        (3, 'Yılmaz YILDIZ', 'TR65 0006 7010 0000 0090 5192 31', 1500.00, 'Planlandı')
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
    
    $pdo->exec("INSERT IGNORE INTO bakiye (id, toplam_bakiye) VALUES (1, 1245680.00)");
    
    // Harcama kalemleri verilerini ekle
    $pdo->exec("
        INSERT IGNORE INTO harcama_kalemleri (id, sira, kategori, urun, tutar, link, aciklama, durum) VALUES
        (1, 1, 'ödeme', 'Teknosa CELL TL Yükleme', 500, '', '', 'Beklemede'),
        (2, 2, 'ödeme', 'Money Pay Ödeme', 500, '', '', 'Beklemede'),
        (3, 3, 'ödeme', 'E-imza Kimlik Kartı (3 YIL)', 2650, 'https://www.e-guven.com/form/ciplikimlik', 'Akıllı kart okuyucu gerekli', 'Beklemede'),
        (4, 4, 'abonelikler', 'Google Drive', 205, 'https://one.google.com/dynamic-plans', '', 'Beklemede'),
        (5, 5, 'abonelikler', 'Youtube Premium', 159, 'https://www.youtube.com/paid_memberships', '', 'Beklemede'),
        (6, 6, 'donanım', 'Klavye', 480, 'https://www.teknosa.com/everest-b-2012', 'Everest KM-6121', 'Beklemede'),
        (7, 7, 'donanım', 'Mousepad', 200, '', '', 'Beklemede'),
        (8, 8, 'kişisel', 'Moser Tarak Seti 1-4 No', 149, 'https://www.trendyol.com/moser/1400-kesim-tarak-seti', '', 'Beklemede'),
        (9, 9, 'abonelikler', 'Chat GPT', 700, '', '', 'Beklemede'),
        (10, 10, 'ulaşım', 'Scooter', 16000, '', '', 'Beklemede'),
        (11, 11, 'kişisel', 'Vural Yusuf Yüksek', 0, '', '', 'Beklemede'),
        (14, 14, 'aksesuar', 'Laptop Çantası', 1000, '', '', 'Beklemede'),
        (15, 15, 'kişisel', 'Boxer', 500, '', '', 'Beklemede'),
        (16, 16, 'donanım', 'Kulaklık', 600, 'https://www.teknosa.com/preo-ms36-dokunmatik-kontrol', 'Preo MS36', 'Beklemede'),
        (17, 17, 'gıda', 'Yemek', 10000, '', '', 'Beklemede'),
        (18, 18, 'abonelikler', 'Hornet Premium', 200, '', '', 'Beklemede')
    ");
    
    // İstek listesi verilerini ekle
    $pdo->exec("
        INSERT IGNORE INTO istek_listesi (id, ad, kategori, fiyat, gorsel, link, will_get) VALUES
        (1, 'Samsung Galaxy Watch5 44MM', 'aksesuar', 6489, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/145061605/145061605_0_MC/15984a57.png', 'https://www.teknosa.com/samsunggalaxy-watch5-44mm-safir-akilli-saat', 'no'),
        (2, 'Samsung Galaxy Tab S10 Ultra 5G', 'teknoloji', 49999, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/786400252/786400252_0_MC/dd2ef30144f448368de0b2ca62944b9e.jpg', 'https://www.teknosa.com/samsung-galaxy-tab-s10-ultra-5g', 'no'),
        (3, 'Preo Mcs020 14.1\" Notebook Çantası', 'aksesuar', 399.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125049600/125049600_0_MC/74978930.jpg', 'https://www.teknosa.com/preo-mcs020-141-mycase-siyah-notebook-cantasi', 'no'),
        (4, 'Preo MCS019 15.6\" Sırt Çantası', 'aksesuar', 999.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125047196/125047196_0_MC/74835743.png', 'https://www.teknosa.com/preo-mcs019-156-mycase-siyah-notebook-sirt-cantasi', 'yes'),
        (5, 'Ducati Pro-I Evo Scooter', 'ulaşım', 16000, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/789130013/789130013_0_MC/5b42353c9b87419e833106020318dbbe.jpg', 'https://www.teknosa.com/ducati-proi-evo-siyah-elektrikli-scooter', 'yes')
    ");
    
    // Hesaplar şifreler verilerini ekle
    $pdo->exec("
        INSERT IGNORE INTO hesaplar_sifreler (id, platform, kullanici_adi, sifre, giris_linki, hesap_turu) VALUES
        (1, 'Ziraat Bankası', 'mveyselilgaz', '****1234', 'https://bireysel.ziraatbank.com.tr', 'İnternet Bankacılığı'),
        (2, 'Gmail', 'mveysel@gmail.com', '****5678', 'https://gmail.com', 'Mail'),
        (3, 'Instagram', '@mveyselilgaz', '****9012', 'https://instagram.com', 'Sosyal Medya')
    ");
    
    // IBAN bilgileri verilerini ekle
    $pdo->exec("
        INSERT IGNORE INTO iban_bilgileri (id, hesap_sahibi, iban, kolay_adres, banka, logo, aciklama) VALUES
        (1, 'Muhammed Veysel Ilgaz', 'TR68 0011 1000 0000 0037 2387 48', '5060302085', 'Ziraat Bankası', './images/logoi.png', 'Ana hesap'),
        (2, 'Yalçın Yıldırım', 'TR71 0006 2000 7120 0006 8437 92', '', 'Garanti BBVA', './images/logo2.png', 'İş hesabı'),
        (3, 'Buket GÖNÜL', '', '', 'Yapı Kredi', '', 'Kişisel hesap'),
        (4, 'Yılmaz YILDIZ', 'TR65 0006 7010 0000 0090 5192 31', '', 'Garanti BBVA', '', 'Ana hesap')
    ");
    
    echo "Veritabanı ve tüm tablolar başarıyla oluşturuldu!";
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>