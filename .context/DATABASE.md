# Veritabanı Yapısı

Bu doküman, projenin veritabanı şemasını, ana tabloları ve aralarındaki ilişkileri açıklamaktadır.

## 1. Genel Bakış

Proje, kullanıcıların finansal verilerini depolamak için bir **MySQL/MariaDB** veritabanı kullanır. Veritabanı adı varsayılan olarak `budget_db`'dir. Veritabanı, kullanıcı bilgileri, hesaplar, gelir-gider işlemleri, borçlar, hedefler ve diğer uygulama verilerini içeren bir dizi tablodan oluşur.

## 2. Ana Tablolar ve Açıklamaları

Aşağıda, projenin temel işlevlerini destekleyen ana tablolar ve açıklamaları yer almaktadır.

### `users`
-   **Açıklama:** Uygulama kullanıcılarının temel bilgilerini saklar.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz kullanıcı kimliği (Primary Key).
    -   `email`: Kullanıcının e-posta adresi (Unique).
    -   `password_hash`: Güvenlik için hash'lenmiş kullanıcı şifresi.
    -   `full_name`: Kullanıcının tam adı.
    -   `role`: Kullanıcı rolü (`admin`, `user`).

### `bank_accounts`
-   **Açıklama:** Kullanıcıya ait veya başkalarına ait banka hesap bilgilerini tutar.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz hesap kimliği (PK).
    -   `user_id`: Hesabın ilişkili olduğu kullanıcı (FK to `users.id`).
    -   `account_holder`: Hesap sahibinin adı.
    -   `iban_number`: IBAN numarası.
    -   `bank_name`: Banka adı.
    -   `account_type`: Hesabın kime ait olduğu (`own`, `other`).

### `expenses`
-   **Açıklama:** Kullanıcının yaptığı tüm harcamaları kaydeder.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz gider kimliği (PK).
    -   `amount`: Harcama tutarı.
    -   `category_type`: Giderin kategorisi (`sabit_gider`, `degisken_gider`, `ani_ekstra`, `ertelenmis`).
    -   `description`: Harcama açıklaması.
    -   `date`: Harcama tarihi.

### `incomes` (Dosya yapısından varsayılan)
-   **Açıklama:** Kullanıcının gelirlerini kaydeder. (SQL dosyasında `incomes` tablosu bulunamadı, ancak proje yapısına göre olması beklenir.)
-   **Önemli Sütunlar (Tahmini):**
    -   `id`: Benzersiz gelir kimliği (PK).
    -   `amount`: Gelir tutarı.
    -   `source`: Gelir kaynağı.
    -   `date`: Gelir tarihi.

### Borç Tabloları
Proje, farklı borç türlerini ayrı tablolarda yönetir:
-   **`bank_debts`:** Banka kredileri ve borçları.
-   **`execution_debts`:** İcra takibindeki borçlar.
-   **`personal_debts`:** Kişilere olan borçlar.
-   **`sgk_debts`:** SGK prim borçları.
-   **`tax_debts`:** Vergi borçları.
-   **Ortak Sütunlar:** `id`, `owner` (borçlu), `principal` (anapara), `total` (toplam borç), `planned_payment_date` (planlanan ödeme tarihi).

### `wishlist_items`
-   **Açıklama:** Kullanıcının almak istediği ürünleri, ihtiyaçlarını veya hayallerini tutar.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz istek kimliği (PK).
    -   `item_name`: Ürün veya hedefin adı.
    -   `wishlist_type`: İsteğin türü (`alinacak`, `ihtiyac`, `istek`, `hayal`, `favori`).
    -   `price`: Hedefin maliyeti.
    -   `progress`: Hedefe ulaşma ilerlemesi.

### `market_products`
-   **Açıklama:** Sık alınan market ürünlerini veya diğer ürünleri stok takibi amacıyla kaydeder.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz ürün kimliği (PK).
    -   `product_name`: Ürün adı.
    -   `price`: Birim fiyatı.
    -   `quantity`: Adet.
    -   `total_amount`: Toplam tutar (Otomatik hesaplanır).
    -   `current_stock`: Mevcut stok.

### `account_credentials`
-   **Açıklama:** Kullanıcının farklı platformlardaki (banka, e-ticaret, sosyal medya vb.) hesap bilgilerini güvenli bir şekilde saklar.
-   **Önemli Sütunlar:**
    -   `id`: Benzersiz kimlik bilgisi (PK).
    -   `user_id`: İlişkili kullanıcı (FK to `users.id`).
    -   `platform_name`: Platformun adı (örn: 'Garanti Bankası', 'Trendyol').
    -   `username`: Kullanıcı adı.
    -   `password_hash`: Şifrelenmiş parola.

## 3. İlişkiler (Relationships)

-   **`users` - `bank_accounts`:** Bir kullanıcının birden fazla banka hesabı olabilir (One-to-Many).
-   **`users` - `notes`:** Bir kullanıcının birden fazla notu olabilir (One-to-Many).
-   **`users` - `account_credentials`:** Bir kullanıcının birden fazla hesap bilgisi olabilir (One-to-Many).
-   **`account_credentials` - `account_types`:** Her hesap bilgisinin bir türü vardır (Many-to-One).

Veritabanı şeması, uygulamanın modüler yapısını destekleyecek şekilde tasarlanmıştır. Her tablo, belirli bir sorumluluk alanına odaklanmıştır.