# Proje Mimarisi

Bu doküman, projenin yazılım mimarisini, kullanılan tasarım desenlerini ve bileşenler arasındaki ilişkileri açıklamaktadır.

## 1. Genel Bakış

Proje, **Model-View-Controller (MVC)** mimari desenini temel alan katmanlı bir yapıya sahiptir. Bu yapı, iş mantığı (Model), kullanıcı arayüzü (View) ve kullanıcı girdilerini işleyen mantığın (Controller) birbirinden ayrılmasını sağlar. Bu sayede kodun yeniden kullanılabilirliği, yönetilebilirliği ve test edilebilirliği artırılır.

Proje ayrıca, sorumlulukların daha net ayrılması için **Servis (Service)** ve **Depo (Repository)** gibi tasarım desenlerini de kullanmaktadır.

## 2. Mimari Katmanlar

Projenin ana dizin yapısı, bu katmanlı mimariyi yansıtmaktadır:

```
/
|-- app/
|   |-- Controllers/  (Controller Katmanı)
|   |-- Models/       (Model Katmanı - İş Mantığı)
|   |-- Repositories/ (Veri Erişim Katmanı)
|   |-- Services/     (Servis Katmanı)
|   |-- Core/         (Çekirdek Bileşenler)
|-- views/            (View Katmanı - Sunum)
|-- ajax/             (Asenkron İşlem Yöneticileri)
|-- config/           (Yapılandırma Dosyaları)
|-- public/           (Genel Erişime Açık Dosyalar - CSS, JS, Resimler)
|-- helpers/          (Yardımcı Fonksiyonlar)
|-- bootstrap.php     (Uygulama Başlatıcı)
```

### 2.1. Controller Katmanı (`app/Controllers`)

-   Kullanıcıdan gelen HTTP isteklerini karşılar.
-   İstekleri doğrular ve işlenmesi için ilgili **Servis** katmanına yönlendirir.
-   Servis katmanından dönen sonuçları (verileri) alır ve bu verileri `View` katmanına göndererek kullanıcıya bir yanıt (genellikle HTML) oluşturur.
-   Uygulamanın akışını kontrol eder.

### 2.2. Service Katmanı (`app/Services`)

-   Uygulamanın ana iş mantığını (business logic) içerir.
-   Birden fazla **Repository** veya başka servislerle etkileşime girerek karmaşık işlemleri gerçekleştirir.
-   Controller'ların doğrudan veri erişim katmanıyla konuşmasını engelleyerek iş mantığını merkezileştirir.
-   Örneğin, `ExpenseService`, gider ekleme, silme veya güncelleme gibi işlemleri yönetir.

### 2.3. Repository Katmanı (`app/Repositories`)

-   Veri erişim mantığını soyutlar.
-   Veritabanı ile doğrudan etkileşim kuran katmandır. SQL sorguları bu katmanda yer alır.
-   Servis katmanına, veritabanı yapısından bağımsız bir şekilde veri sağlayan metotlar sunar (örneğin, `findById`, `findAll`, `save`).
-   Bu yapı, ileride veritabanı sisteminin (örn: MySQL'den PostgreSQL'e geçiş) değiştirilmesini kolaylaştırır.

### 2.4. Model Katmanı (`app/Models`)

-   Uygulamanın temel veri yapılarını ve varlıklarını (entities) temsil eder. Örneğin, `User`, `Expense`, `Income` gibi.
-   Genellikle veritabanı tablolarındaki sütunlara karşılık gelen özellikleri içerir.
-   Bazı durumlarda temel iş kurallarını veya veri doğrulama mantığını da içerebilir.

### 2.5. View Katmanı (`views/`)

-   Kullanıcı arayüzünü (UI) oluşturan dosyalardır. Genellikle HTML ve PHP kodunun bir karışımını içerir.
-   Controller'dan gelen verileri kullanarak dinamik HTML sayfaları oluşturur.
-   Kullanıcıya sunulan son çıktıyı temsil eder.

### 2.6. AJAX Yöneticileri (`ajax/`)

-   Bu dizin, istemci tarafından yapılan asenkron (AJAX) istekleri doğrudan işleyen PHP betiklerini içerir.
-   Genellikle küçük ve atomik işlemler için kullanılır (örn: bir görevi tamamlama, bir veriyi silme).
-   Bu betikler, tam bir sayfa yenilemesi olmadan sunucuyla iletişim kurar ve genellikle JSON formatında yanıt döner.
-   Modern MVC yapısının yanında, daha geleneksel bir yaklaşımla hızlı işlemler için kullanılmaktadır.

## 3. Bağımlılık Yönetimi (Dependency Injection)

Proje, sınıflar arasındaki bağımlılıkları yönetmek için bir **Bağımlılık Enjeksiyon (DI) Konteyneri** (`app/Core/Container.php`) kullanır. `app/container_bindings.php` dosyası, arayüzlerin (interface) hangi somut sınıflara (concrete class) karşılık geleceğini tanımlar. Bu, bileşenler arasındaki bağımlılığı azaltır ve kodun daha esnek ve test edilebilir olmasını sağlar.