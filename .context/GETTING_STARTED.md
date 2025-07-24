# Başlangıç Rehberi (Getting Started)

Bu rehber, projeyi yerel geliştirme ortamınıza nasıl kuracağınızı ve çalıştıracağınızı adım adım açıklamaktadır.

## 1. Gereksinimler

Projeyi çalıştırmadan önce sisteminizde aşağıdaki yazılımların kurulu olduğundan emin olun:

-   **XAMPP** (veya benzeri bir WAMP/LAMP/MAMP yığını): Apache web sunucusu, MySQL/MariaDB veritabanı ve PHP'yi içerir.
    -   [XAMPP İndirme Sayfası](https://www.apachefriends.org/index.html)
-   **Composer:** PHP için bir bağımlılık yöneticisi.
    -   [Composer İndirme Sayfası](https://getcomposer.org/download/)
-   **Git:** Versiyon kontrol sistemi.
    -   [Git İndirme Sayfası](https://git-scm.com/downloads)

## 2. Kurulum Adımları

### Adım 1: Projeyi Klonlama

Projeyi yerel makinenize klonlamak için bir terminal veya komut istemcisi açın ve aşağıdaki komutu çalıştırın. Bu komut, projeyi XAMPP'nin web sunucusu tarafından erişilebilen `htdocs` klasörüne klonlayacaktır.

```bash
cd C:/xampp/htdocs/
git clone <proje-git-repo-adresi> .
```

*Not: `<proje-git-repo-adresi>` kısmını projenin gerçek Git deposu adresi ile değiştirin. Eğer projeyi zaten `htdocs` içinde manuel olarak indirdiyseniz bu adımı atlayabilirsiniz.*

### Adım 2: PHP Bağımlılıklarını Yükleme

Projenin kullandığı harici PHP kütüphanelerini (bağımlılıkları) yüklemek için projenin ana dizininde Composer'ı çalıştırın:

```bash
cd C:/xampp/htdocs/
composer install
```

Bu komut, `composer.json` dosyasını okuyacak ve gerekli tüm paketleri `vendor/` dizinine yükleyecektir.

### Adım 3: Veritabanını Kurma

1.  **XAMPP Kontrol Panelini** açın ve **Apache** ile **MySQL** servislerini başlatın.
2.  Web tarayıcınızdan `http://localhost/phpmyadmin` adresine gidin.
3.  Yeni bir veritabanı oluşturun. Veritabanı adı olarak `budget_db` kullanmanız önerilir. Karşılaştırma (collation) ayarını `utf8mb4_general_ci` olarak seçin.
4.  Oluşturduğunuz veritabanını seçin ve **İçe Aktar (Import)** sekmesine tıklayın.
5.  Proje ana dizininde bulunan `budget_db.sql` dosyasını seçerek veritabanı şemasını ve başlangıç verilerini içe aktarın.

### Adım 4: Yapılandırma Dosyasını Ayarlama

1.  Proje ana dizininde bulunan `.env.example` dosyasının bir kopyasını oluşturun ve adını `.env` olarak değiştirin.
2.  `.env` dosyasını bir metin düzenleyici ile açın ve veritabanı bağlantı bilgilerinizi güncelleyin:

```env
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=budget_db
DB_USERNAME=root
DB_PASSWORD=
```

*Not: XAMPP'nin varsayılan ayarlarında kullanıcı adı `root` olup parola boştur. Farklı bir ayar kullanıyorsanız kendi bilgilerinizi girin.*

## 3. Projeyi Çalıştırma

Tüm kurulum adımları tamamlandıktan sonra, projeye web tarayıcınız üzerinden erişebilirsiniz. Tarayıcınızın adres çubuğuna aşağıdaki adresi yazın:

```
http://localhost/
```

Eğer projeyi `htdocs` altında farklı bir klasöre kurduysanız (örneğin `htdocs/projem`), adresi `http://localhost/projem/` olarak değiştirmeniz gerekir.

## 4. Sorun Giderme

-   **500 Internal Server Error:** Genellikle `.htaccess` dosyasıyla veya dosya izinleriyle ilgilidir. Apache'nin `mod_rewrite` modülünün etkin olduğundan emin olun.
-   **Veritabanı Bağlantı Hatası:** `.env` dosyasındaki veritabanı bilgilerinizin doğru olduğunu ve MySQL sunucusunun çalıştığını kontrol edin.
-   **Sınıf Bulunamadı Hatası (Class Not Found):** `composer install` komutunu çalıştırdığınızdan ve `vendor/autoload.php` dosyasının `bootstrap.php` veya `index.php` içinde dahil edildiğinden emin olun.