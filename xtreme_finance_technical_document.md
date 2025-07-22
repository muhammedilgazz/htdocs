
# 📊 Xtreme Bütçe Yönetim Sistemi - Yazılım Teknik Belgesi

## 📌 1. Genel Tanım

**Xtreme Bütçe Yönetim Sistemi**, bireylerin gelir-gider dengesini kurmalarına yardımcı olan, borçlarını, alınacak ürünlerini ve yapılacak görevlerini detaylı şekilde organize edebilecekleri bir kişisel finans yönetimi uygulamasıdır. Sistem, modern web teknolojileriyle geliştirilen modüler, ölçeklenebilir ve kullanıcı dostu bir yapıya sahiptir.

## 🧱 2. Temel Yapı (Uygulama İskeleti)

### 2.1 Backend Teknolojileri
- **Dil:** PHP 8.x (Vanilla PHP - Framework kullanılmıyor)
- **Veritabanı:** MySQL 8.x
- **ORM:** PDO (Native PHP Database Objects)
- **API Desteği:** RESTful JSON Endpoints (AJAX ile)
- **Kimlik Doğrulama:** Session-based authentication
- **Dependency Management:** Composer
- **Code Quality:** PHPStan, PHPUnit, PHP_CodeSniffer

### 2.2 Frontend Teknolojileri
- **Yapı:** PHP Template System (Include/Require based)
- **UI Framework:** Bootstrap 5.3.0
- **Icons:** Bootstrap Icons 1.11.0, Material Icons Round
- **Responsive Design:** Mobil öncelikli yapı
- **JavaScript:** Vanilla JS + jQuery
- **CSS:** Custom CSS + Bootstrap 5 + Perfect Scrollbar

### 2.3 Ek Teknolojiler
- **Yedekleme:** Custom backup scripts
- **Bildirim:** Toastr notifications
- **Güvenlik:** CSRF, XSS, SQL Injection korumaları, HTTPS, Session security
- **AI Entegrasyonu:** OpenAI / LLM API bağlantıları (Xtreme AI modülü için)
- **PWA Support:** Manifest.json, Service Worker hazırlığı
- **Data Export:** PHPSpreadsheet (Excel export)

## 🧭 3. Sayfa ve Modül Organizasyonu

### 3.1 Dashboard (Ana Sayfa)
- Finansal özet (bakiyeler, gider grafiği, borç uyarısı, son 5 işlem)
- Mini analitik: En çok harcama yapılan kategori, ayın özeti
- Hatırlatıcılar ve yaklaşan ödemeler

### 3.2 Giderler (Expenses)
| Rota | Açıklama |
|------|---------|
| `/giderler?filter=month` | Bu ayın giderleri |
| `/giderler?filter=next_month` | Gelecek ay planlı giderler |
| `/giderler?filter=year` | Yıllık özet |
| `/giderler?filter=all` | Tüm zamanlar giderleri |

Her kayıt:
- Kategori (sabit/değişken vs.)
- Tutar
- Tarih
- Not
- Durum (ödendi/ertelendi)

### 3.3 Gelirler (Incomes) - YENİ
| Rota | Açıklama |
|------|---------|
| `/incomes` | Tüm gelirler |
| `/incomes/fixed` | Sabit gelirler (aylık, yıllık) |
| `/incomes/extra` | Ekstra gelirler (günlük, haftalık, tek seferlik) |

Her gelir kaydı:
- **Başlık** (title): Gelir kaynağının adı
- **Para Birimi** (currency): TRY, USD, EUR, GBP
- **Tutar** (amount): Gelir miktarı
- **Periyot** (period): daily, weekly, monthly, yearly, one_time
- **Alım Tarihi** (receive_date): Gelirin alınacağı tarih
- **Borç mu?** (is_debt): Gelir kaynağının borç olup olmadığı
- **Açıklama** (description): İsteğe bağlı açıklama
- **Durum** (status): active, inactive, pending

### 3.4 Harcamalar (Spendings)
- Sabit, değişken, ani/ekstra ve ertelenmiş harcamalar ayrı sayfalarda listelenir.
- Her harcama kategoriye bağlıdır.
- Ay bazında filtreleme yapılabilir.

### 3.5 Alınacaklar (Wishlist)
Alt kategoriler:
- **İhtiyaçlar**
- **İstekler**
- **Hayaller**
- **Favoriler**

Her ürün için:
- Adı, fiyatı
- Link, resim
- Öncelik puanı
- Not ve ilerleme yüzdesi

### 3.6 Market & Gıda
- Haftalık / Aylık market harcamaları
- Gıda vs. temizlik ürünleri ayrıştırması

### 3.7 Tüm Borçlar (Debts)
Alt bölümler:
- Vergi
- SGK
- Banka
- İcra
- Şahıslara Borçlar

### 3.8 Yapılacaklar ve Projeler
- Projeler
- Görevler
- Notlar
- To-do list

### 3.9 Hesaplar & Şifreler
- Şifreli şekilde saklanır
- Kategori
- Kullanıcı adı, şifre, not

### 3.10 Banka Hesapları
- IBAN, banka adı
- Hesap türü, bakiye, geçmişi

### 3.11 Xtreme AI
- Harcama önerileri
- Borç ödeme önceliklendirme
- Grafik yorumlama
- Soru-cevap arayüzü

## ⚙️ 4. Ayarlar & Kullanıcı İşlemleri

- Kullanıcı Profili
- Bildirim Tercihleri
- Dil ve Tema Ayarları
- Referans Programı
- Destek Merkezi

## 🔐 5. Güvenlik Özellikleri

- Session-based authentication
- CSRF token protection
- Input sanitization
- SQL injection prevention (PDO prepared statements)
- XSS protection
- Secure session configuration
- Error logging

## 💾 6. Veritabanı Ana Tabloları

- `users`
- `expenses`
- `spendings`
- `incomes` - **YENİ**: Gelir kayıtları
- `wishlist_items`
- `debts`
- `tasks`, `projects`, `notes`, `todos`
- `bank_accounts`
- `account_passwords`
- `settings`, `logs`, `notifications`

## 📈 7. Raporlama & Görselleştirme

- Aylık grafikler (Chart.js)
- Kategori bazlı harcama dağılımı
- Borç ödeme takibi
- Bütçe hedefleri ilerleme çubuğu
- DataTables entegrasyonu

## 🔄 8. Entegrasyonlar

- Mail (SMTP)
- AI servisleri (OpenAI vs.)
- Google Takvim (gelecek)
- Mobil uyumlu PWA
- Excel export (PHPSpreadsheet)

## ✅ 9. Yol Haritası

1. ✅ Backend iskeleti (Vanilla PHP)
2. ✅ Auth sistemi (Session-based)
3. ✅ Harcama yönetimi
4. ✅ **Gelir yönetimi** - **YENİ EKLENDİ**
5. ✅ Alınacaklar ve borçlar
6. ✅ Dashboard
7. 🟡 AI destekli modül
8. 🟡 Mobil uygulama
9. 🟡 Kullanıcı davranış analitiği

## 📁 10. Proje Yapısı

```
htdocs/
├── app/
│   ├── Controllers/     # İş mantığı kontrolcüleri
│   │   └── IncomeController.php  # YENİ: Gelir yönetimi
│   ├── Core/           # Çekirdek sınıflar (DB, Container)
│   ├── Models/         # Veri modelleri
│   │   └── Income.php  # YENİ: Gelir modeli
│   ├── Repositories/   # Veri erişim katmanı
│   └── Services/       # İş servisleri
├── assets/
│   ├── css/           # Stil dosyaları
│   ├── js/            # JavaScript dosyaları
│   ├── images/        # Görseller
│   └── vendor/        # 3. parti kütüphaneler
├── views/             # PHP template dosyaları
│   └── incomes/       # YENİ: Gelir sayfaları
│       ├── index.php  # Tüm gelirler
│       ├── fixed.php  # Sabit gelirler
│       └── extra.php  # Ekstra gelirler
├── ajax/              # AJAX endpoint'leri
│   ├── add_income.php     # YENİ
│   ├── delete_income.php  # YENİ
│   ├── update_income.php  # YENİ
│   └── get_income.php     # YENİ
├── config/            # Konfigürasyon dosyaları
└── vendor/            # Composer dependencies
```

## 🆕 11. Yeni Eklenen Gelirler Modülü

### 11.1 Özellikler
- **Çoklu Para Birimi Desteği**: TRY, USD, EUR, GBP
- **Periyot Kategorileri**: Günlük, Haftalık, Aylık, Yıllık, Tek Seferlik
- **Borç Takibi**: Gelir kaynağının borç olup olmadığını belirtme
- **İstatistik Kartları**: Toplam, sabit ve ekstra gelir özetleri
- **AJAX Desteği**: Dinamik veri işlemleri
- **DataTables Entegrasyonu**: Gelişmiş tablo özellikleri

### 11.2 Veritabanı Yapısı
```sql
CREATE TABLE `incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'TRY',
  `amount` decimal(10,2) NOT NULL,
  `period` enum('daily','weekly','monthly','yearly','one_time') NOT NULL DEFAULT 'monthly',
  `receive_date` date NOT NULL,
  `is_debt` enum('yes','no') NOT NULL DEFAULT 'no',
  `description` text,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
```

### 11.3 API Endpoints
- `POST /ajax/add_income.php` - Gelir ekleme
- `POST /ajax/delete_income.php` - Gelir silme
- `POST /ajax/update_income.php` - Gelir güncelleme
- `GET /ajax/get_income.php` - Gelir getirme

### 11.4 Güvenlik Özellikleri
- CSRF token koruması
- Input sanitization
- SQL injection koruması (PDO prepared statements)
- XSS koruması
