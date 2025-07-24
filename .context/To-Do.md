# Proje Geliştirme ve İyileştirme Görevleri (To-Do)

Bu doküman, projenin kalitesini artırmak, bakımını kolaylaştırmak ve gelecekteki geliştirmeleri hızlandırmak için yapılması gereken görevleri öncelik sırasına göre listeler.

## Öncelik 1: Mimari ve Kod Sağlamlaştırma

Bu adımlar, projenin temelini güçlendirmeyi ve kod tekrarını azaltmayı hedefler.

-   [ ] **Merkezi AJAX Yönlendirici Oluşturma:**
    -   [ ] `ajax.php` adında merkezi bir giriş noktası oluştur.
    -   [ ] Gelen AJAX isteklerini ilgili Controller'daki `ajax_` önekli metoda yönlendirecek bir mantık kur.
    -   [ ] Tüm `ajax/*.php` dosyalarını bu yeni yapıya taşı (Örn: `ajax/add_expense.php` -> `ExpenseController::ajax_add()`).
    -   [ ] Eski `ajax/*.php` dosyalarını sil.

-   [ ] **Dependency Injection (DI) Kullanımını Standartlaştırma:**
    -   [ ] `DashboardController` başta olmak üzere, `new Model()` kullanan tüm Controller'ları, bağımlılıkları constructor üzerinden alacak şekilde refactor et.
    -   [ ] Gerekli tüm Model ve Servis bağımlılıklarını `app/container_bindings.php` dosyasına ekle.

-   [ ] **Veri Erişim Katmanını Soyutlama (Repository Pattern):**
    -   [ ] `app/Models` içindeki sınıflarda bulunan tüm SQL sorgularını, ilgili `app/Repositories` sınıfına taşı.
    -   [ ] Model sınıflarını, sadece veri özelliklerini içeren saf veri nesneleri (DTOs) haline getir.
    -   [ ] Controller'ların, veritabanı işlemleri için Repository sınıflarını kullanmasını sağla.

## Öncelik 2: Frontend ve UI/UX İyileştirmeleri

Bu adımlar, kullanıcı arayüzünü modernize etmeyi ve tutarlılığı sağlamayı amaçlar.

-   [ ] **Tasarım Sistemini Entegre Etme:**
    -   [ ] `UI_STANDARDS.md`'de belirtildiği gibi, tüm sayfalarda ve bileşenlerde `modern-design-system.css`'deki tasarım token'larının (`--primary-500`, `--space-4` vb.) kullanımını zorunlu kıl.
    -   [ ] **Pilot Sayfa Seçimi:** `dashboard.php` sayfasından başlayarak, eski CSS sınıflarını yeni `.card-modern`, `.btn-modern` gibi standart sınıflarla değiştir.
    -   [ ] Diğer sayfalara bu modernizasyonu aşamalı olarak uygula.

-   [ ] **Frontend Bağımlılık Yönetimini Merkezileştirme:**
    -   [ ] `package.json` dosyasını kullanarak `chart.js`, `perfect-scrollbar` gibi tüm frontend kütüphanelerini `npm` üzerinden yönet.
    -   [ ] Projeye `Vite` veya `Webpack` gibi bir build aracı ekleyerek tüm JS ve CSS varlıklarını tek bir yerden yönet ve optimize et (`assets/dist/app.js`, `assets/dist/app.css`).

## Öncelik 3: Gelişmiş Özellikler ve Güvenlik

Bu adımlar, projenin yeteneklerini ve güvenilirliğini artırır.

-   [ ] **Yönlendirme (Routing) Kütüphanesi Entegrasyonu:**
    -   [ ] Projeye `nikic/fast-route` gibi hafif bir yönlendirme kütüphanesi ekle.
    -   [ ] `index.php`'deki mevcut yönlendirme mantığını, rotaların merkezi bir `routes.php` dosyasında tanımlandığı yeni sisteme taşı.

-   [ ] **Kullanıcı Dostu Hata Yönetimi:**
    -   [ ] `404.php` ve `500.php` sayfalarını, uygulamanın genel `layout`'unu kullanacak şekilde yeniden tasarla.
    -   [ ] `bootstrap.php`'deki `set_exception_handler` fonksiyonunu, API istekleri için JSON hatası, web istekleri için ise hata sayfası gösterecek şekilde güncelle.

-   [ ] **Kalıcı Önbellekleme (Caching) Mekanizması:**
    -   [ ] Dosya tabanlı basit bir `CacheManager` sınıfı oluştur.
    -   [ ] Veritabanından sık çekilen ve nadiren değişen verileri (kategoriler, ayarlar vb.) bu önbellek mekanizması üzerinden sunarak performansı artır.

-   [ ] **Veritabanı Şeması (Migration) Yönetimi:**
    -   [ ] Veritabanı değişikliklerini takip etmek için `Phinx` gibi bir veritabanı migration aracı kur.
    -   [ ] Mevcut veritabanı yapısını ilk migration dosyaları olarak oluştur.