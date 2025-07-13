# 💰 Bütçe Yönetim ve Takip Sistemi

Modern, güvenli ve kullanıcı dostu bir bütçe yönetim web uygulaması. Gelir-gider takibi, bütçe planlama, analitik raporlar ve finansal hedefler için tasarlanmıştır.

## ✨ Özellikler

### 📊 Dashboard ve Analitik
- **Gerçek zamanlı dashboard** - Finansal durumunuzu tek bakışta görün
- **Gelir-gider analizi** - Kategori bazlı harcama analizi
- **Trend grafikleri** - Aylık/haftalık finansal trendler
- **Bütçe karşılaştırması** - Planlanan vs gerçekleşen harcamalar

### 💳 Harcama ve Gelir Yönetimi
- **Hızlı harcama ekleme** - Modal ile kolay harcama kaydı
- **Kategori sistemi** - Gıda, ulaşım, donanım, abonelikler vb.
- **Gelir takibi** - Düzenli ve tek seferlik gelirler
- **Ödeme durumu** - Beklemede, planlandı, ödendi, gecikmiş

### 🎯 Hedef ve Bütçe Planlama
- **Tasarruf hedefleri** - Belirli hedefler için para biriktirme
- **Aylık bütçe planları** - Kategori bazlı bütçe limitleri
- **İlerleme takibi** - Hedeflere ne kadar yaklaştığınızı görün
- **Hatırlatıcılar** - Bütçe limitleri ve ödeme tarihleri

### 🏦 Hesap ve Cüzdan Yönetimi
- **Çoklu hesap desteği** - Banka hesapları, kredi kartları
- **IBAN yönetimi** - Güvenli IBAN saklama
- **Bakiye takibi** - Tüm hesapların toplam bakiyesi
- **Hesap geçmişi** - Detaylı işlem geçmişi

### 🔒 Güvenlik ve Kullanıcı Yönetimi
- **Güvenli kimlik doğrulama** - Bcrypt şifreleme
- **CSRF koruması** - Cross-site request forgery koruması
- **Rate limiting** - Brute force saldırılarına karşı koruma
- **Session yönetimi** - Güvenli oturum kontrolü
- **Remember me** - 30 günlük oturum hatırlama

### 📱 Responsive Tasarım
- **Mobil uyumlu** - Tüm cihazlarda mükemmel görünüm
- **Modern UI/UX** - Bootstrap 5 ve özel tasarım
- **Hızlı yükleme** - Optimize edilmiş performans
- **Erişilebilirlik** - WCAG standartlarına uygun

## 🚀 Kurulum

### Gereksinimler
- PHP 8.0 veya üzeri
- MySQL 5.7 veya üzeri
- Apache/Nginx web sunucusu
- Composer (opsiyonel)

### Adım 1: Dosyaları İndirin
```bash
git clone https://github.com/your-username/budget-management.git
cd budget-management
```

### Adım 2: Veritabanını Kurun
```bash
# MySQL'e bağlanın
mysql -u root -p

# Veritabanını oluşturun
CREATE DATABASE butce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE butce;

# Tabloları oluşturun
source sql/create_tables.sql;
source sql/user_tables.sql;
```

### Adım 3: Yapılandırma
```bash
# Config dosyasını düzenleyin
cp config/config.example.php config/config.php
nano config/config.php
```

```php
// Veritabanı ayarları
define('DB_HOST', 'localhost');
define('DB_NAME', 'butce');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Uygulama ayarları
define('APP_NAME', 'Bütçe Yönetim Sistemi');
define('BASE_URL', 'http://localhost/budget/');
```

### Adım 4: İzinleri Ayarlayın
```bash
chmod 755 uploads/
chmod 755 backups/
chmod 644 config/config.php
```

### Adım 5: Güvenlik Kurulumu
```bash
php install_security.php
```

## 👤 Varsayılan Kullanıcılar

Sistem kurulumu tamamlandıktan sonra aşağıdaki kullanıcılarla giriş yapabilirsiniz:

### Admin Kullanıcısı
- **E-posta:** admin@example.com
- **Şifre:** password
- **Rol:** Admin (tüm yetkiler)

### Test Kullanıcısı
- **E-posta:** user@example.com
- **Şifre:** password
- **Rol:** User (sınırlı yetkiler)

## 📁 Proje Yapısı

```
budget-management/
├── ajax/                    # AJAX işleyicileri
│   ├── add_expense.php     # Harcama ekleme
│   └── add_payment.php     # Ödeme ekleme
├── assets/                  # Statik dosyalar
│   ├── css/                # Stil dosyaları
│   ├── js/                 # JavaScript dosyaları
│   ├── images/             # Görseller
│   └── vendor/             # Üçüncü parti kütüphaneler
├── classes/                # PHP sınıfları
│   ├── Database.php        # Veritabanı bağlantısı
│   ├── SecurityManager.php # Güvenlik yönetimi
│   └── BudgetManager.php   # Bütçe işlemleri
├── config/                 # Yapılandırma dosyaları
│   └── config.php          # Ana yapılandırma
├── partials/               # Sayfa parçaları
│   ├── head.php           # HTML head
│   ├── sidebar.php        # Yan menü
│   ├── header.php         # Üst menü
│   └── script.php         # JavaScript
├── sql/                    # Veritabanı dosyaları
│   ├── create_tables.sql  # Ana tablolar
│   └── user_tables.sql    # Kullanıcı tabloları
├── uploads/                # Yüklenen dosyalar
├── backups/                # Yedekler
├── logs/                   # Log dosyaları
├── index.php              # Ana sayfa
├── signin.php             # Giriş sayfası
└── README.md              # Bu dosya
```

## 🔧 Yapılandırma

### Veritabanı Ayarları
```php
// config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'butce');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### Uygulama Ayarları
```php
define('APP_NAME', 'Bütçe Yönetim Sistemi');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/budget/');
```

### Güvenlik Ayarları
```php
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 300); // 5 dakika
```

## 📊 Veritabanı Şeması

### Ana Tablolar
- **harcama_kalemleri** - Harcama kayıtları
- **odemeler** - Ödeme kayıtları
- **bakiye** - Hesap bakiyeleri
- **istek_listesi** - Alınacaklar listesi
- **iban_bilgileri** - IBAN bilgileri
- **hesaplar_sifreler** - Hesap şifreleri

### Kullanıcı Tabloları
- **users** - Kullanıcı bilgileri
- **remember_tokens** - Oturum hatırlama
- **login_logs** - Giriş logları
- **rate_limits** - Hız sınırlama
- **security_events** - Güvenlik olayları

## 🔒 Güvenlik Özellikleri

### Kimlik Doğrulama
- Bcrypt şifreleme
- Session hijacking koruması
- CSRF token koruması
- Rate limiting

### Veri Güvenliği
- SQL injection koruması
- XSS koruması
- Input validasyonu
- Güvenli dosya upload

### Güvenlik Başlıkları
- X-Content-Type-Options
- X-Frame-Options
- X-XSS-Protection
- Content-Security-Policy

## 📈 Performans Optimizasyonu

### Veritabanı
- Prepared statements
- Index optimizasyonu
- Query caching
- Connection pooling

### Frontend
- CSS/JS minification
- Image optimization
- Lazy loading
- CDN kullanımı

### Caching
- Redis/Memcached desteği
- Browser caching
- Static asset caching

## 🛠️ API Kullanımı

### Harcama Ekleme
```javascript
fetch('ajax/add_expense.php', {
    method: 'POST',
    body: new FormData(form)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        showSuccess('Harcama eklendi');
    }
});
```

### Ödeme Ekleme
```javascript
fetch('ajax/add_payment.php', {
    method: 'POST',
    body: new FormData(form)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        showSuccess('Ödeme eklendi');
    }
});
```

## 🔄 Yedekleme

### Otomatik Yedekleme
```bash
# Cron job ekleyin
0 2 * * * php /path/to/budget/backup_cron.php
```

### Manuel Yedekleme
```bash
php backup_cron.php
```

## 📝 Log Yönetimi

### Log Dosyaları
- `logs/error.log` - Hata logları
- `logs/security.log` - Güvenlik logları
- `logs/access.log` - Erişim logları

### Log Seviyeleri
- ERROR - Kritik hatalar
- WARNING - Uyarılar
- INFO - Bilgi mesajları
- DEBUG - Debug mesajları

## 🚀 Deployment

### Production Ortamı
1. SSL sertifikası kurun
2. Güvenlik duvarı yapılandırın
3. Database backup ayarlayın
4. Monitoring kurun
5. Error tracking ekleyin

### Docker Deployment
```dockerfile
FROM php:8.1-apache
COPY . /var/www/html/
RUN docker-php-ext-install pdo pdo_mysql
EXPOSE 80
```

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Push yapın (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasına bakın.

## 🆘 Destek

- **E-posta:** support@example.com
- **Dokümantasyon:** [Wiki](https://github.com/your-username/budget-management/wiki)
- **Issues:** [GitHub Issues](https://github.com/your-username/budget-management/issues)

## 🔄 Güncellemeler

### v1.0.0 (2024-01-01)
- İlk sürüm
- Temel bütçe yönetimi
- Kullanıcı kimlik doğrulama
- Dashboard ve analitik

### Gelecek Sürümler
- Mobil uygulama
- API entegrasyonu
- Çoklu para birimi
- Otomatik kategorizasyon
- AI destekli öneriler

---

**Not:** Bu sistem eğitim amaçlı geliştirilmiştir. Production ortamında kullanmadan önce güvenlik testlerini yapın. 

Şimdi projeyi detaylı analiz ettim. İşte tespit ettiğim hatalar ve kod tekrarları:
🔍 TESPİT EDİLEN HATALAR VE KOD TEKRARLARI
1. MAJÖR HATALAR
A. Güvenlik Hataları:
CSRF Token Eksikliği: Birçok AJAX endpoint'inde CSRF token kontrolü var ama bazı sayfalarda eksik
SQL Injection Riski: Bazı yerlerde LIKE '%keyword%' kullanımı güvenlik riski oluşturuyor
Session Güvenliği: Session hijacking koruması eksik
B. Veritabanı Hataları:
Tutarsız Veri Tipleri: tutar alanı bazen float, bazen string olarak kullanılıyor
Eksik İndeksler: kategori_tipi ve harcama_donemi alanlarında indeks yok
Foreign Key Eksikliği: İlişkisel bütünlük korunmuyor
C. Performans Hataları:
N+1 Query Problemi: Her sayfa yüklendiğinde aynı veriler tekrar çekiliyor
Cache Kullanımı Eksik: Sık kullanılan veriler cache'lenmiyor
Gereksiz Database Bağlantıları: Her sayfa ayrı bağlantı açıyor
2. KOD TEKRARLARI
A. Sayfa Yapısı Tekrarları:
Apply to kategori_gun...
B. Tablo Yapısı Tekrarları:
Apply to kategori_gun...
C. Modal Tekrarları:
Apply to kategori_gun...
D. SQL Query Tekrarları:
Apply to kategori_gun...
3. ÖNERİLEN ÇÖZÜMLER
A. Base Controller Sınıfı:
Apply to kategori_gun...
B. Expense Manager Sınıfı:
Apply to kategori_gun...
C. Template System:
Apply to kategori_gun...
�� SORULARIM:
Hangi öncelikle başlamak istiyorsunuz?
A) Güvenlik hatalarını düzeltme
B) Kod tekrarlarını azaltma
C) Performans iyileştirmeleri
D) Veritabanı optimizasyonu
Base Controller sınıfı oluşturup tüm sayfaları bu yapıya geçirmek ister misiniz?
Template system kurarak modal ve tablo tekrarlarını ortadan kaldırmak ister misiniz?
Hangi sayfaları öncelikli olarak refactor etmek istiyorsunuz?
Veritabanı şemasında değişiklik yapmaya hazır mısınız (indeksler, foreign key'ler)?
Hangi konudan başlamak istediğinizi belirtin, ona göre detaylı çözüm önerileri sunayım.