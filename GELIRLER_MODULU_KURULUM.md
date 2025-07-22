# 📊 Gelirler Modülü - Kurulum ve Kullanım Kılavuzu

## 🎯 Genel Bakış

Gelirler modülü, kullanıcıların gelirlerini kategorize ederek takip edebilmelerini sağlayan kapsamlı bir sistemdir. Sabit gelirler (aylık, yıllık) ve ekstra gelirler (günlük, haftalık, tek seferlik) olarak ayrılmıştır.

## 📋 Özellikler

- ✅ **Tüm Gelirler**: Tüm gelir kayıtlarını görüntüleme
- ✅ **Sabit Gelirler**: Aylık ve yıllık düzenli gelirler
- ✅ **Ekstra Gelirler**: Günlük, haftalık ve tek seferlik gelirler
- ✅ **Çoklu Para Birimi**: TRY, USD, EUR, GBP desteği
- ✅ **Borç Takibi**: Gelir kaynağının borç olup olmadığını belirtme
- ✅ **İstatistikler**: Gelir özetleri ve grafikler
- ✅ **AJAX Desteği**: Dinamik veri işlemleri

## 🗄️ Veritabanı Yapısı

### Incomes Tablosu

| Sütun | Tip | Açıklama |
|-------|-----|----------|
| `id` | int(11) | Otomatik artan ID |
| `user_id` | int(11) | Kullanıcı ID'si |
| `title` | varchar(255) | Gelir başlığı |
| `currency` | varchar(10) | Para birimi (TRY, USD, EUR, GBP) |
| `amount` | decimal(10,2) | Tutar |
| `period` | enum | Periyot (daily, weekly, monthly, yearly, one_time) |
| `receive_date` | date | Alım tarihi |
| `is_debt` | enum | Borç mu? (yes, no) |
| `description` | text | Açıklama |
| `status` | enum | Durum (active, inactive, pending) |
| `created_at` | timestamp | Oluşturulma tarihi |
| `updated_at` | timestamp | Güncellenme tarihi |

## 🚀 Kurulum

### 1. Veritabanı Tablosu Oluşturma

```bash
# Kurulum scriptini çalıştırın
php install_incomes_table.php
```

### 2. Dosya Yapısı Kontrolü

Aşağıdaki dosyaların oluşturulduğundan emin olun:

```
📁 app/
├── 📁 Models/
│   └── 📄 Income.php
├── 📁 Controllers/
│   └── 📄 IncomeController.php

📁 views/
└── 📁 incomes/
    ├── 📄 index.php (Tüm Gelirler)
    ├── 📄 fixed.php (Sabit Gelirler)
    └── 📄 extra.php (Ekstra Gelirler)

📁 ajax/
├── 📄 add_income.php
├── 📄 delete_income.php
├── 📄 update_income.php
└── 📄 get_income.php

📄 incomes.php (Ana routing)
📄 incomes-fixed.php (Sabit gelirler routing)
📄 incomes-extra.php (Ekstra gelirler routing)
```

### 3. Sidebar Menüsü

Sidebar menüsüne gelirler bölümü otomatik olarak eklenmiştir:

- **Gelirler** (Ana menü)
  - Tüm Gelirler
  - Sabit Gelirler
  - Ekstra Gelirler

## 📱 Kullanım

### 1. Gelir Ekleme

1. Sidebar'dan "Gelirler" menüsünü açın
2. İstediğiniz kategoriyi seçin (Tüm/Sabit/Ekstra)
3. "Yeni Gelir Ekle" butonuna tıklayın
4. Formu doldurun:
   - **Başlık**: Gelir kaynağının adı
   - **Para Birimi**: TRY, USD, EUR, GBP
   - **Tutar**: Gelir miktarı
   - **Periyot**: Günlük, Haftalık, Aylık, Yıllık, Tek Seferlik
   - **Alım Tarihi**: Gelirin alınacağı tarih
   - **Borç mu?**: Gelir kaynağı borç mu?
   - **Açıklama**: İsteğe bağlı açıklama

### 2. Gelir Düzenleme

1. Gelir listesinde düzenlemek istediğiniz kaydın yanındaki kalem ikonuna tıklayın
2. Açılan formda değişiklikleri yapın
3. "Kaydet" butonuna tıklayın

### 3. Gelir Silme

1. Gelir listesinde silmek istediğiniz kaydın yanındaki çöp kutusu ikonuna tıklayın
2. Onay penceresinde "Tamam"a tıklayın

## 🔧 API Endpoints

### Gelir Ekleme
```
POST /ajax/add_income.php
```

**Parametreler:**
- `title` (string, zorunlu)
- `currency` (string, zorunlu)
- `amount` (float, zorunlu)
- `period` (string, zorunlu)
- `receive_date` (date, zorunlu)
- `is_debt` (string, zorunlu)
- `description` (string, opsiyonel)
- `csrf_token` (string, zorunlu)

### Gelir Silme
```
POST /ajax/delete_income.php
```

**Parametreler:**
- `id` (int, zorunlu)
- `csrf_token` (string, zorunlu)

### Gelir Güncelleme
```
POST /ajax/update_income.php
```

**Parametreler:**
- `id` (int, zorunlu)
- `title` (string, zorunlu)
- `currency` (string, zorunlu)
- `amount` (float, zorunlu)
- `period` (string, zorunlu)
- `receive_date` (date, zorunlu)
- `is_debt` (string, zorunlu)
- `description` (string, opsiyonel)
- `status` (string, opsiyonel)
- `csrf_token` (string, zorunlu)

### Gelir Getirme
```
GET /ajax/get_income.php?id={income_id}
```

## 📊 İstatistikler

Gelirler modülü aşağıdaki istatistikleri sağlar:

- **Toplam Gelir**: Tüm gelirlerin toplamı
- **Sabit Gelirler**: Aylık ve yıllık gelirlerin toplamı
- **Ekstra Gelirler**: Günlük, haftalık ve tek seferlik gelirlerin toplamı
- **Gelir Sayısı**: Toplam kayıt sayısı
- **Aylık Özet**: Ay bazında gelir dağılımı

## 🎨 Özelleştirme

### CSS Sınıfları

```css
/* Gelir kartları için özel stiller */
.income-card {
    border-left: 4px solid #28a745;
}

.income-card.fixed {
    border-left-color: #17a2b8;
}

.income-card.extra {
    border-left-color: #ffc107;
}

/* Para birimi badge'leri */
.currency-badge {
    font-size: 0.8em;
    padding: 0.25em 0.5em;
}
```

### JavaScript Fonksiyonları

```javascript
// Gelir ekleme
function addIncome(formData) {
    return fetch('/ajax/add_income.php', {
        method: 'POST',
        body: formData
    });
}

// Gelir silme
function deleteIncome(id) {
    return fetch('/ajax/delete_income.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&csrf_token=${getCsrfToken()}`
    });
}

// Gelir güncelleme
function updateIncome(id, formData) {
    formData.append('id', id);
    return fetch('/ajax/update_income.php', {
        method: 'POST',
        body: formData
    });
}
```

## 🔒 Güvenlik

- **CSRF Koruması**: Tüm form işlemlerinde CSRF token kontrolü
- **Input Sanitization**: Tüm kullanıcı girdileri temizlenir
- **SQL Injection Koruması**: PDO prepared statements kullanılır
- **XSS Koruması**: HTML çıktıları escape edilir

## 🐛 Sorun Giderme

### Yaygın Sorunlar

1. **Tablo bulunamadı hatası**
   ```bash
   php install_incomes_table.php
   ```

2. **CSRF token hatası**
   - Sayfayı yenileyin
   - Session'ı kontrol edin

3. **AJAX hatası**
   - Browser console'u kontrol edin
   - Network sekmesinde hata detaylarını görün

### Log Dosyaları

Hata logları şu dosyalarda bulunur:
- `logs/error.log` - Genel hatalar
- `logs/json_response_debug.log` - AJAX yanıtları

## 📈 Gelecek Geliştirmeler

- [ ] Gelir grafikleri ve raporları
- [ ] Gelir hedefleri ve takibi
- [ ] Otomatik gelir hatırlatıcıları
- [ ] Gelir kategorileri
- [ ] Gelir export/import özellikleri
- [ ] Mobil uygulama entegrasyonu

## 📞 Destek

Herhangi bir sorun yaşarsanız:
1. Log dosyalarını kontrol edin
2. Browser console'u inceleyin
3. Veritabanı bağlantısını test edin
4. Gerekirse kurulum scriptini tekrar çalıştırın

---

**Gelirler modülü başarıyla kuruldu! 🎉** 