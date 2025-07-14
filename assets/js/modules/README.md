# Ekash JavaScript Modules

Bu dizin, Ekash Bütçe Yönetim Sistemi'nin yeni modüler JavaScript mimarisini içerir.

## 🏗️ Modül Yapısı

### 1. **core.js** - Temel İşlevler
- **Sorumluluklar:**
  - Tema yönetimi (açık/koyu mod)
  - Event sistemi (custom events)
  - Yardımcı fonksiyonlar (debounce, throttle, formatters)
  - Cihaz tespiti (mobile, tablet, desktop)
  - Session ve localStorage yönetimi

- **API:**
  ```javascript
  EkashCore.init()                    // Modülü başlat
  EkashCore.toggleTheme()             // Tema değiştir
  EkashCore.on(event, callback)       // Event dinleyici ekle
  EkashCore.formatCurrency(amount)    // Para formatı
  EkashCore.isMobile()                // Mobil cihaz kontrolü
  ```

### 2. **ui.js** - Kullanıcı Arayüzü
- **Sorumluluklar:**
  - Sidebar kontrolü
  - Material Design ripple efektleri
  - Snackbar bildirimleri
  - Button loading durumları
  - Submenu yönetimi

- **API:**
  ```javascript
  EkashUI.init()                      // Modülü başlat
  EkashUI.toggleSidebar()             // Sidebar aç/kapat
  EkashUI.showSnackbar(msg, type)     // Bildirim göster
  EkashUI.setButtonLoading(btn)       // Button loading
  ```

### 3. **forms.js** - Form Yönetimi
- **Sorumluluklar:**
  - Form validasyonu
  - AJAX form gönderimi
  - CSRF token yönetimi
  - Real-time validation
  - FAB (Floating Action Button) işlemleri

- **API:**
  ```javascript
  EkashForms.init()                   // Modülü başlat
  EkashForms.validateForm(form)       // Form doğrula
  EkashForms.submitAjaxRequest(url, data) // AJAX istek
  EkashForms.resetForm(form)          // Formu sıfırla
  ```

### 4. **navigation.js** - Navigasyon
- **Sorumluluklar:**
  - Menü aktif durumu
  - Breadcrumb yönetimi
  - Sayfa geçişleri
  - Menü arama
  - Dinamik menü ekleme/çıkarma

- **API:**
  ```javascript
  EkashNavigation.init()              // Modülü başlat
  EkashNavigation.setActiveMenuItem() // Aktif menü belirle
  EkashNavigation.navigateTo(url)     // Sayfaya git
  EkashNavigation.searchMenu(term)    // Menü ara
  ```

## 🚀 Kullanım

### Temel Başlatma
```javascript
// Modüller otomatik olarak başlatılır, ancak manuel başlatma:
EkashCore.ready(() => {
    console.log('Tüm modüller hazır');
});
```

### Event Sistemi
```javascript
// Event dinle
EkashCore.on('themeChanged', (e) => {
    console.log('Tema değişti:', e.detail.theme);
});

// Event tetikle
EkashCore.triggerEvent('customEvent', { data: 'value' });
```

### Form İşlemleri
```javascript
// AJAX form gönderimi
EkashForms.submitAjaxRequest('ajax/save.php', {
    name: 'John',
    email: 'john@example.com'
}).then(response => {
    if (response.success) {
        EkashUI.showSnackbar('Başarılı!', 'success');
    }
});
```

## 🔧 Konfigürasyon

### Debug Modu
```javascript
// scripts.js içinde
EkashApp.config.debug = true; // Geliştirme için
EkashApp.config.debug = false; // Üretim için
```

### Modül Ayarları
```javascript
// Her modülün kendi config objesi var
EkashCore.config.theme.default = 'dark';
EkashUI.config.animation.duration = 500;
EkashForms.config.validation.realTimeValidation = false;
```

## 📂 Dosya Yapısı
```
assets/js/modules/
├── core.js         # Temel işlevler
├── ui.js           # UI bileşenleri
├── forms.js        # Form yönetimi
├── navigation.js   # Navigasyon
└── README.md       # Bu dosya

assets/js/
├── scripts.js      # Ana uygulama dosyası
├── scripts-legacy.js # Eski versiyon (yedek)
└── modules/        # Modül dizini
```

## 🔄 Legacy Uyumluluk

Eski kod ile uyumluluk için global fonksiyonlar korunmuştur:

```javascript
// Eski kullanım (hala çalışır)
showSuccess('Mesaj');
showError('Hata');
themeToggle();

// Yeni kullanım (önerilen)
EkashUI.showSnackbar('Mesaj', 'success');
EkashCore.toggleTheme();
```

## ⚡ Performans İyileştirmeleri

### Önceki Durum
- Tek büyük script dosyası (~224 satır)
- Çakışan fonksiyonlar
- Kod tekrarları
- Zor bakım

### Yeni Durum
- Modüler yapı (4 ayrı modül)
- Temiz API'ler
- Event-driven mimari
- Kolay genişletme

## 🧪 Test Etme

### Browser Console'da Test
```javascript
// Modül durumlarını kontrol et
console.log(EkashApp.moduleStatus);

// Tüm modüllerin yüklendiğini kontrol et
Object.values(EkashApp.moduleStatus).every(status => status === true);

// Event sistemini test et
EkashCore.on('testEvent', (e) => console.log('Test passed!', e.detail));
EkashCore.triggerEvent('testEvent', { test: true });
```

## 🔮 Gelecek Geliştirmeler

1. **Charts Module** - Chart.js entegrasyonu
2. **Analytics Module** - Kullanıcı davranış analizi
3. **Offline Module** - PWA/ServiceWorker desteği
4. **API Module** - REST API client
5. **Utils Module** - Ek yardımcı fonksiyonlar

## 📝 Notlar

- Tüm modüller ES5 uyumlu (IE11+ desteği)
- jQuery bağımlılığı legacy uyumluluk için korundu
- Bootstrap 5.x ile tam uyumlu
- Material Design 3 prensiplerine uygun

## 🐛 Bilinen Sorunlar

Şu anda bilinen kritik sorun bulunmamaktadır. Sorun bildirmek için:
1. Browser console'daki hataları kontrol edin
2. Network sekmesinde failed istekleri kontrol edin
3. Modül yükleme sırasını kontrol edin

---

**Version:** 2.0.0  
**Last Updated:** 2024  
**Author:** Claude AI Assistant