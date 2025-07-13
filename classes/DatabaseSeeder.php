<?php
class DatabaseSeeder {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function seed() {
        // Seed Status Types
        $this->pdo->exec("INSERT IGNORE INTO status_types (id, name) VALUES
            (1, 'Beklemede'),
            (2, 'Gecikmiş'),
            (3, 'Planlandı'),
            (4, 'Ödendi'),
            (5, 'Ertelendi')
        ");

        // Seed Categories
        $this->pdo->exec("INSERT IGNORE INTO categories (id, name, type) VALUES
            (1, 'ödeme', 'expense'),
            (2, 'abonelikler', 'expense'),
            (3, 'donanım', 'expense'),
            (4, 'kişisel', 'expense'),
            (5, 'ulaşım', 'expense'),
            (6, 'aksesuar', 'expense'),
            (7, 'gıda', 'expense'),
            (8, 'teknoloji', 'wishlist')
        ");

        // Seed Account Types
        $this->pdo->exec("INSERT IGNORE INTO account_types (id, name) VALUES
            (1, 'İnternet Bankacılığı'),
            (2, 'Mail'),
            (3, 'Sosyal Medya'),
            (4, 'Bahis Sitesi')
        ");

        // Seed Banks
        $this->pdo->exec("INSERT IGNORE INTO banks (id, name, logo_path) VALUES
            (1, 'Ziraat Bankası', './assets/images/logo_ziraat.png'),
            (2, 'Garanti BBVA', './assets/images/logo_garanti.png'),
            (3, 'Yapı Kredi', './assets/images/logo_yapikredi.png')
        ");

        // Seed data for payments table
        $this->pdo->exec("INSERT IGNORE INTO payments (id, person_name, iban, amount, status_id) VALUES
            (1, 'Buket GÖNÜL', NULL, 4000.00, (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (2, 'Şenay POLAT', NULL, 8000.00, (SELECT id FROM status_types WHERE name = 'Gecikmiş')),
            (3, 'Yılmaz YILDIZ', 'TR65 0006 7010 0000 0090 5192 31', 1500.00, (SELECT id FROM status_types WHERE name = 'Planlandı'))
        ");

        // Seed data for balances table
        $this->pdo->exec("INSERT IGNORE INTO balances (id, total_balance) VALUES (1, 1245680.00)");

        // Seed data for expense_items table
        $this->pdo->exec("INSERT IGNORE INTO expense_items (id, order_number, category_id, item_name, amount, link, description, status_id) VALUES
            (1, 1, (SELECT id FROM categories WHERE name = 'ödeme' AND type = 'expense'), 'Teknosa CELL TL Yükleme', 500, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (2, 2, (SELECT id FROM categories WHERE name = 'ödeme' AND type = 'expense'), 'Money Pay Ödeme', 500, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (3, 3, (SELECT id FROM categories WHERE name = 'ödeme' AND type = 'expense'), 'E-imza Kimlik Kartı (3 YIL)', 2650, 'https://www.e-guven.com/form/ciplikimlik', 'Akıllı kart okuyucu gerekli', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (4, 4, (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense'), 'Google Drive', 205, 'https://one.google.com/dynamic-plans', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (5, 5, (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense'), 'Youtube Premium', 159, 'https://www.youtube.com/paid_memberships', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (6, 6, (SELECT id FROM categories WHERE name = 'donanım' AND type = 'expense'), 'Klavye', 480, 'https://www.teknosa.com/everest-b-2012', 'Everest KM-6121', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (7, 7, (SELECT id FROM categories WHERE name = 'donanım' AND type = 'expense'), 'Mousepad', 200, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (8, 8, (SELECT id FROM categories WHERE name = 'kişisel' AND type = 'expense'), 'Moser Tarak Seti 1-4 No', 149, 'https://www.trendyol.com/moser/1400-kesim-tarak-seti', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (9, 9, (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense'), 'Chat GPT', 700, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (10, 10, (SELECT id FROM categories WHERE name = 'ulaşım' AND type = 'expense'), 'Scooter', 16000, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (11, 11, (SELECT id FROM categories WHERE name = 'kişisel' AND type = 'expense'), 'Vural Yusuf Yüksek', 0, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (14, 14, (SELECT id FROM categories WHERE name = 'aksesuar' AND type = 'expense'), 'Laptop Çantası', 1000, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (15, 15, (SELECT id FROM categories WHERE name = 'kişisel' AND type = 'expense'), 'Boxer', 500, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (16, 16, (SELECT id FROM categories WHERE name = 'donanım' AND type = 'expense'), 'Kulaklık', 600, 'https://www.teknosa.com/preo-ms36-dokunmatik-kontrol', 'Preo MS36', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (17, 17, (SELECT id FROM categories WHERE name = 'gıda' AND type = 'expense'), 'Yemek', 10000, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede')),
            (18, 18, (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense'), 'Hornet Premium', 200, '', '', (SELECT id FROM status_types WHERE name = 'Beklemede'))
        ");

        // Seed data for wishlist_items table
        $this->pdo->exec("INSERT IGNORE INTO wishlist_items (id, item_name, category_id, price, image_path, link, will_get) VALUES
            (1, 'Samsung Galaxy Watch5 44MM', (SELECT id FROM categories WHERE name = 'aksesuar' AND type = 'wishlist'), 6489, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/145061605/145061605_0_MC/15984a57.png', 'https://www.teknosa.com/samsunggalaxy-watch5-44mm-safir-akilli-saat', FALSE),
            (2, 'Samsung Galaxy Tab S10 Ultra 5G', (SELECT id FROM categories WHERE name = 'teknoloji' AND type = 'wishlist'), 49999, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/786400252/786400252_0_MC/dd2ef30144f448368de0b2ca62944b9e.jpg', 'https://www.teknosa.com/samsung-galaxy-tab-s10-ultra-5g', FALSE),
            (3, 'Preo Mcs020 14.1\" Notebook Çantası', (SELECT id FROM categories WHERE name = 'aksesuar' AND type = 'wishlist'), 399.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125049600/125049600_0_MC/74978930.jpg', 'https://www.teknosa.com/preo-mcs020-141-mycase-siyah-notebook-cantasi', FALSE),
            (4, 'Preo MCS019 15.6\" Sırt Çantası', (SELECT id FROM categories WHERE name = 'aksesuar' AND type = 'wishlist'), 999.90, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/125047196/125047196_0_MC/74835743.png', 'https://www.teknosa.com/preo-mcs019-156-mycase-siyah-notebook-sirt-cantasi', TRUE),
            (5, 'Ducati Pro-I Evo Scooter', (SELECT id FROM categories WHERE name = 'ulaşım' AND type = 'wishlist'), 16000, 'https://reimg-teknosa-cloud-prod.mncdn.com/mnresize/200/200/productimage/789130013/789130013_0_MC/5b42353c9b87419e833106020318dbbe.jpg', 'https://www.teknosa.com/ducati-proi-evo-siyah-elektrikli-scooter', TRUE)
        ");

        // Seed data for account_credentials table
        $this->pdo->exec("INSERT IGNORE INTO account_credentials (id, platform, username, password, login_link, account_type_id) VALUES
            (1, 'Ziraat Bankası', 'mveyselilgaz', '****1234', 'https://bireysel.ziraatbank.com.tr', (SELECT id FROM account_types WHERE name = 'İnternet Bankacılığı')),
            (2, 'Gmail', 'mveysel@gmail.com', '****5678', 'https://gmail.com', (SELECT id FROM account_types WHERE name = 'Mail')),
            (3, 'Instagram', '@mveyselilgaz', '****9012', 'https://instagram.com', (SELECT id FROM account_types WHERE name = 'Sosyal Medya'))
        ");

        // Seed data for iban_details table
        $this->pdo->exec("INSERT IGNORE INTO iban_details (id, account_holder_name, iban, easy_address, bank_id, description) VALUES
            (1, 'Muhammed Veysel Ilgaz', 'TR68 0011 1000 0000 0037 2387 48', '5060302085', (SELECT id FROM banks WHERE name = 'Ziraat Bankası'), 'Ana hesap'),
            (2, 'Yalçın Yıldırım', 'TR71 0006 2000 7120 0006 8437 92', '', (SELECT id FROM banks WHERE name = 'Garanti BBVA'), 'İş hesabı'),
            (3, 'Buket GÖNÜL', '', '', (SELECT id FROM banks WHERE name = 'Yapı Kredi'), 'Kişisel hesap'),
            (4, 'Yılmaz YILDIZ', 'TR65 0006 7010 0000 0090 5192 31', '', (SELECT id FROM banks WHERE name = 'Garanti BBVA'), 'Ana hesap')
        ");
    }
}