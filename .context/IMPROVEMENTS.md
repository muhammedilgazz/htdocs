# Proje Eksiklikleri ve İyileştirme Önerileri

Bu doküman, projenin mevcut durum analizine dayanarak tespit edilen teknik, mimari ve yapısal eksiklikleri ve bu eksiklikleri gidermek için önerilen eylem adımlarını içermektedir. Amaç, projenin bakımını kolaylaştırmak, performansını artırmak, güvenliğini güçlendirmek ve gelecekteki geliştirmelere zemin hazırlamaktır.

## 1. Mimari ve Kod Yapısı

### 1.1. Dağınık AJAX Mimarisi
*   **Sorun:** `ajax/` dizini altındaki her PHP dosyası, MVC yapısını ve Dependency Injection (DI) container'ı atlayarak kendi başına bir giriş noktası (entry point) görevi görmektedir. Bu durum, ciddi kod tekrarına (veritabanı bağlantısı, session başlatma, CSRF kontrolü) ve bakım zorluklarına yol açmaktadır.
*   **Öneri:**
    1.  Tüm AJAX isteklerini merkezi bir yönlendiriciye (router) yönlendirin. Örneğin, `ajax.php` adında tek bir giriş noktası oluşturulabilir.
    2.  Bu merkezi yönlendirici, isteği analiz ederek ilgili Controller sınıfındaki bir metoda (örn. `ExpenseController::ajax_add()`) yönlendirmelidir.
    3.  AJAX metodları, standart Controller'lar gibi DI container'dan faydalanmalı ve `json_response()` gibi standart bir yanıt fonksiyonu kullanmalıdır.
    4.  Mevcut `ajax/*.php` dosyaları aşamalı olarak bu yeni yapıya taşınmalı ve ardından kaldırılmalıdır.

### 1.2. Tutarsız Bağımlılık Yönetimi
*   **Sorun:** Bazı kontrolcüler (`ExpenseController`) DI container kullanarak bağımlılıklarını (servisler, repository'ler) alırken, bazıları (`DashboardController`) `new Model()` şeklinde doğrudan nesne oluşturmaktadır. Bu, tutarsızlığa ve test edilebilirliğin azalmasına neden olur.
*   **Öneri:**
    1.  **Kural:** Hiçbir Controller, `new` anahtar kelimesi ile kendi bağımlılığını oluşturmamalıdır.
    2.  Tüm Controller'ların ve Servis'lerin ihtiyaç duyduğu bağımlılıklar, `app/container_bindings.php` dosyasında tanımlanmalı ve constructor üzerinden enjekte edilmelidir.
    3.  Mevcut Controller'lar, bu kurala uymaları için refactor edilmelidir.

### 1.3. Gelişmiş Yönlendirme (Routing) Eksikliği
*   **Sorun:** `index.php` içindeki yönlendirme mekanizması, dizi tabanlı basit bir eşlemedir. RESTful rotalar, parametre bağlama (parameter binding) ve ara katman (middleware) gibi modern yönlendirme yeteneklerinden yoksundur.
*   **Öneri:**
    1.  `nikic/fast-route` veya `league/route` gibi hafif ve popüler bir yönlendirme kütüphanesi projeye dahil edilebilir.
    2.  Rotalar, merkezi bir `routes.php` dosyasında tanımlanmalıdır. Bu, `index.php`'nin temiz kalmasını sağlar.
    3.  Yeni yönlendirici, URL'den parametreleri otomatik olarak ayıklayıp Controller metodlarına argüman olarak geçirebilmelidir.

## 2. UI/UX ve Frontend

### 2.1. CSS Tutarsızlığı
*   **Sorun:** Proje, en az üç farklı CSS dosyası (`style.css`, `modern-design-system.css`, `custom-colors.css`) kullanıyor. Bu, stil çakışmalarına, gereksiz kod tekrarına ve tutarsız bir kullanıcı arayüzüne yol açmaktadır. `.btn` ve `.btn-modern` gibi farklı standartlarda bileşenler mevcuttur.
*   **Öneri:**
    1.  **Tek Gerçek Kaynak:** `modern-design-system.css` dosyasını tek gerçek kaynak (single source of truth) olarak belirleyin.
    2.  Tüm yeni bileşenler, bu dosyadaki CSS değişkenlerini (tasarım token'ları) ve yardımcı sınıfları kullanmalıdır.
    3.  Mevcut sayfalar ve bileşenler, zamanla eski stillerden arındırılıp yeni sisteme taşınmalıdır. `style.css` ve `custom-colors.css` dosyaları nihayetinde kaldırılmalıdır.
    4.  Sayfa standardizasyonu sağlanmalı; boşluklar, başlık boyutları ve kart yapıları tüm sayfalarda tutarlı olmalıdır.

### 2.2. Frontend Bağımlılık Yönetimi
*   **Sorun:** JavaScript kütüphaneleri ve eklentileri (örn. `chart.js`, `perfect-scrollbar`) manuel olarak yönetiliyor gibi görünmektedir. Bu, güncellemeleri ve bağımlılık takibini zorlaştırır.
*   **Öneri:**
    1.  `package.json` dosyası zaten mevcut. Projenin frontend bağımlılıklarını yönetmek için `npm` veya `yarn` aktif olarak kullanılmalıdır.
    2.  Tüm vendor (üçüncü parti) JavaScript dosyaları, `node_modules` dizininden çekilmeli ve bir build aracı (örn. Webpack, Vite) ile tek bir `vendor.js` dosyası olarak paketlenmelidir.

## 3. Veritabanı ve Veri Erişimi

### 3.1. Model Sorumlulukları
*   **Sorun:** `Database.php` Singleton sınıfı, veritabanı erişimini merkezileştirse de, diğer Modellerin içinde hala doğrudan SQL sorguları bulunmaktadır. Bu, Model sınıflarının birden fazla sorumluluk üstlenmesine (hem veri yapısını temsil etme hem de veri erişim mantığını içerme) neden olur.
*   **Öneri:**
    1.  **Repository Katmanı:** Tüm SQL sorguları, `app/Repositories` dizini altındaki ilgili Repository sınıflarına taşınmalıdır.
    2.  Modeller, sadece veritabanı tablosunun sütunlarını temsil eden özellikler (properties) içermelidir (Data Transfer Object - DTO gibi).
    3.  Controller'lar, veri almak için doğrudan Model'i değil, Repository'yi (veya Servis katmanını) kullanmalıdır.

## 4. Güvenlik ve Performans

### 4.1. Hata Yönetimi
*   **Sorun:** Hata ve istisna (exception) durumlarında kullanıcı doğrudan `500.php` sayfasına yönlendiriliyor. Bu, kullanıcı deneyimi açısından zayıftır ve API istekleri için uygun değildir.
*   **Öneri:**
    1.  **Kullanıcı Dostu Hata Sayfaları:** `404.php` ve `500.php` gibi hata sayfaları, uygulamanın genel tasarımıyla uyumlu hale getirilmeli ve kullanıcıya bir sonraki adımı (örn. ana sayfaya dönme) göstermelidir.
    2.  **API Hata Yanıtları:** API (AJAX) isteklerinde bir hata oluştuğunda, sayfa yönlendirmesi yerine uygun HTTP durum kodu (örn. 400, 403, 500) ile birlikte standart bir JSON hata mesajı (`{"status": "error", "message": "..."}`) döndürülmelidir.

### 4.2. Önbellekleme (Caching)
*   **Sorun:** `Database.php` içinde basit bir dizi (array) tabanlı önbellekleme mevcut, ancak bu sadece tek bir istek yaşam döngüsü için geçerlidir. Sık değişmeyen veritabanı sorguları (kategoriler, ayarlar vb.) her seferinde yeniden çalıştırılır.
*   **Öneri:**
    1.  Daha kalıcı bir önbellekleme mekanizması (örn. Dosya tabanlı cache, Redis, Memcached) için bir `CacheManager` sınıfı oluşturulabilir.
    2.  Sık erişilen ve nadiren değişen veriler (örn. `get_categories`, `get_settings`) bu önbellek mekanizması üzerinden sunulmalıdır.