# Budget_DB - Modern Bütçe Yönetim Sistemi Mimarisi

## Genel Bakış
Bu dokümantasyon, yeni `budget_db` veritabanı yapısı ve kodlarının nasıl eşleştiğini detaylıca açıklar.

## Veritabanı Yapısı

### Ana Veritabanı: `budget_db` (Modern Yapı)

#### 1. `expenses` (Giderler) - **ANA GIDER TABLOSU**
```sql
CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10,2) NOT NULL,
    category_type VARCHAR(50) NOT NULL,
    description TEXT,
    date DATE NOT NULL DEFAULT (CURRENT_DATE),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

**Kategori Tipleri:**
- `sabit_gider` - Sabit Giderler (kira, abonelik vs.)
- `degisken_gider` - Değişken Giderler (market, yakıt vs.)
- `ani_ekstra` - Ani/Ekstra Harcamalar
- `ertelenmis` - Ertelenmiş Ödemeler

**Nerede Kullanılır:**
- `ExpenseController` → `views/expenses/index.php` (Tüm giderler)
- `DashboardController` → Ana sayfa istatistikleri için

#### 2. `wishlist_items` (İstek Listesi) - **WISHLIST/İHTİYAÇLAR TABLOSU**
```sql
CREATE TABLE wishlist_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    wishlist_type ENUM('ihtiyac', 'istek', 'hayal', 'favori') DEFAULT 'istek',
    image_url TEXT,
    product_link TEXT,
    price DECIMAL(10,2) DEFAULT 0.00,
    priority INT,
    progress INT DEFAULT 0,
    status ENUM('active', 'purchased', 'removed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

**Wishlist Tipleri:**
- `ihtiyac` - Temel ihtiyaçlar
- `istek` - İstenilen ürünler
- `hayal` - Hayaller/büyük hedefler
- `favori` - Favori ürünler

**Nerede Kullanılır:**
- `WishlistController` → `views/wishlist/index.php` (Tüm wishlist)
- `NeedController` → `views/needs/index.php` (wishlist_type = 'ihtiyac')

#### 3. `users` (Kullanıcılar)
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

#### 4. `bank_accounts` (Banka Hesapları)
```sql
CREATE TABLE bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_holder VARCHAR(100) NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    iban VARCHAR(50),
    account_number VARCHAR(50),
    balance DECIMAL(15,2) DEFAULT 0.00,
    account_type ENUM('checking', 'savings', 'credit') DEFAULT 'checking',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

#### 5. `account_credentials` (Hesap Şifreleri)
```sql
CREATE TABLE account_credentials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255),
    login_url TEXT,
    account_type ENUM('banking', 'email', 'social_media', 'shopping', 'streaming', 'other') DEFAULT 'other',
    notes TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

#### 6. Borç Tabloları

**6.1. `tax_debts` (Vergi Borçları)**
```sql
CREATE TABLE tax_debts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    debt_type VARCHAR(100) NOT NULL,
    total_debt DECIMAL(10,2) NOT NULL,
    this_month_payment DECIMAL(10,2) DEFAULT 0.00,
    payment_due DATE,
    status ENUM('pending', 'paid', 'overdue') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

**6.2. `sgk_debts` (SGK Borçları)**
**6.3. `execution_debts` (İcra Borçları)**
**6.4. `personal_debts` (Şahıs Borçları)**
**6.5. `bank_debts` (Banka Borçları)**

## Model Yapısı (budget_db için güncellenmiş)

### 1. `Expense.php` - Gider İşlemleri
```php
class Expense {
    public function add(array $data): bool
    public function update(int $id, array $data): bool
    public function delete(int $id): bool
    public function getById(int $id)
    public function getAll(?string $category_type = null): array
    public function getTotalForMonth(string $month): float
}
```

**Metod Kullanımı:**
- `getAll()` → Tüm giderler
- `getAll('sabit_gider')` → Sabit giderler
- `getAll('degisken_gider')` → Değişken giderler
- `getAll('ani_ekstra')` → Ani/ekstra harcamalar

### 2. `Wishlist.php` - Wishlist İşlemleri
```php
class Wishlist {
    public function add(array $data): bool
    public function update(int $id, array $data): bool
    public function delete(int $id): bool
    public function getById(int $id)
    public function getAll(?string $wishlist_type = null): array
    public function getNeeds(): array
    public function getFavorites(): array
    public function getTotalForMonth(string $month): float
}
```

**Metod Kullanımı:**
- `getAll()` → Tüm wishlist items
- `getNeeds()` → İhtiyaçlar (wishlist_type = 'ihtiyac')
- `getFavorites()` → Favoriler (wishlist_type = 'favori')

### 3. `Dashboard.php` - Dashboard İstatistikleri
```php
class Dashboard {
    public function getDashboardStats(): array
    public function getRecentTransactions(): array
    public function getCategoryExpenses(): array
}
```

## Controller-View Eşleştirmesi

### 1. ExpenseController → views/expenses/index.php
**Veri Akışı:**
```php
// ExpenseController.php
$expense_model = new Expense();
$rows = $expense_model->getAll($category_type);

// views/expenses/index.php
foreach ($rows as $row) {
    echo $row['description'];  // Açıklama
    echo $row['amount'];       // Tutar
    echo $row['category_type']; // Kategori
    echo $row['date'];         // Tarih
}
```

### 2. WishlistController → views/wishlist/index.php
**Veri Akışı:**
```php
// WishlistController.php
$wishlist_model = new Wishlist();
$rows = $wishlist_model->getAll();

// views/wishlist/index.php
foreach ($rows as $row) {
    echo $row['item_name'];      // Ürün adı
    echo $row['price'];          // Fiyat
    echo $row['wishlist_type'];  // Tip (ihtiyac, istek, vs.)
    echo $row['status'];         // Durum (active, purchased, vs.)
}
```

### 3. NeedController → views/needs/index.php
**Veri Akışı:**
```php
// NeedController.php
$wishlist_model = new Wishlist();
$rows = $wishlist_model->getNeeds(); // wishlist_type = 'ihtiyac'

// views/needs/index.php
foreach ($rows as $row) {
    echo $row['item_name'];    // Ürün adı
    echo $row['price'];        // Fiyat
    echo $row['priority'];     // Öncelik
    echo $row['progress'];     // İlerleme
}
```

## AJAX Endpoint'leri

### Expense AJAX'ları
```
ajax/add_expense.php → Yeni gider ekleme
ajax/get_expense.php → Gider getirme
ajax/update_expense.php → Gider güncelleme
ajax/delete_expense.php → Gider silme
```

### Wishlist AJAX'ları
```
ajax/add_wishlist_item.php → Yeni wishlist item ekleme
ajax/get_wishlist_item.php → Wishlist item getirme
ajax/update_wishlist_item.php → Wishlist item güncelleme
ajax/delete_wishlist_item.php → Wishlist item silme
```

## Menü Yapısı ve Sayfa Eşleştirmesi

### Güncellenmiş Sidebar Menüsü

#### 1. Dashboard
- **URL:** `/`
- **Controller:** `DashboardController`
- **View:** `views/dashboard.php`
- **Veriler:** `expenses`, `wishlist_items` tablolarından özet

#### 2. Giderler
```
├── Bu Ayın Giderleri → /giderler → current month expenses
└── Tüm Giderler → /expense → ExpenseController → expenses tablosu
```

#### 3. Alınacaklar
```
Alınacaklar/
├── Tüm Alınacaklar → /wishlist → WishlistController → wishlist_items
├── İhtiyaçlar → /wishlist?type=ihtiyac → wishlist_type='ihtiyac'
├── İstekler → /wishlist?type=istek → wishlist_type='istek'
├── Hayaller → /wishlist?type=hayal → wishlist_type='hayal'
└── Favoriler → /wishlist?type=favori → wishlist_type='favori'
```

#### 4. Borçlar
```
Tüm Borçlar/
├── Vergi → /tax → tax_debts tablosu
├── SGK → /sgk → sgk_debts tablosu
├── Banka → /bank → bank_debts tablosu
├── İcralar → /execution → execution_debts tablosu
└── Şahıslara Borçlar → /individualdebt → personal_debts tablosu
```

#### 5. Diğer
```
├── Hesaplar & Şifreler → /accountpassword → account_credentials
├── Banka Hesapları → /bankaccount → bank_accounts
└── Xtreme AI → /xtremeai
```

## Veri Akış Diyagramı (Budget_DB)

```
[budget_db] → [Model] → [Controller] → [View] → [Kullanıcı]
     ↑                                    ↓
     └── [AJAX] ← [JavaScript] ← [Form/Button]
```

### Detaylı Akış Örneği - Gider Ekleme

1. **Form Submission:**
   ```javascript
   // views/expenses/index.php
   $('#addForm').submit() → ajax/add_expense.php
   ```

2. **AJAX Processing:**
   ```php
   // ajax/add_expense.php
   $expense = new Expense();
   $expense->add($_POST);
   ```

3. **Model Operation:**
   ```php
   // models/Expense.php
   INSERT INTO expenses (amount, category_type, description, date) VALUES (?, ?, ?, ?)
   ```

4. **Response:**
   ```json
   {"success": true, "message": "Gider başarıyla eklendi"}
   ```

## Güvenlik ve Performans

### 1. Database Security
- Prepared statements kullanımı
- Input validation ve sanitization
- CSRF token koruması

### 2. Session Management
```php
// Her controller'da
$auth = new Auth();
$auth->requireAuth();
```

### 3. Data Validation
```php
// AJAX dosyalarında
if (!validate_csrf_token($_POST['csrf_token'])) {
    json_response(['success' => false, 'message' => 'Güvenlik hatası'], 403);
}
```

## Kurulum ve Migration

### 1. Veritabanı Setup
```bash
# Tarayıcıda çalıştır:
http://localhost/check_budget_db_schema.php
```

### 2. Config Güncellemesi
```php
// config/config.php
define('DB_NAME', 'budget_db');
```

### 3. Test Pages
- Dashboard: `http://localhost/`
- Giderler: `http://localhost/expense`
- Wishlist: `http://localhost/wishlist`
- İhtiyaçlar: `http://localhost/wishlist?type=ihtiyac`

## Troubleshooting (Budget_DB)

### Yaygın Sorunlar

1. **"Table doesn't exist" Hatası:**
   ```bash
   http://localhost/check_budget_db_schema.php
   ```

2. **AJAX 500 Error:**
   - Model dosyaları mevcut mu?
   - Database bağlantısı aktif mi?
   - CSRF token doğru mu?

3. **Boş Sayfa:**
   - Controller'da model require edilmiş mi?
   - View dosyası doğru yolda mı?
   - Database'de veri var mı?

4. **Login Problemi:**
   - Default kullanıcı: admin / admin123
   - Session tablolarını kontrol et

## Migration Checklist

- [x] config.php → DB_NAME = 'budget_db'
- [x] Expense model → budget_db tabloları
- [x] Wishlist model → budget_db tabloları
- [x] Dashboard model → budget_db istatistikleri
- [x] AJAX endpoints → budget_db uyumlu
- [x] Views → yeni model yapısı uyumlu
- [x] Sidebar menü → yeni URL'ler

Bu dokümantasyon, eski `butce` veritabanından yeni `budget_db` veritabanına geçiş için tam rehberdir. Sistem artık daha temiz, normalize edilmiş ve genişletilebilir bir yapıya sahiptir.