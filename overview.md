# Proje Genel Bakış (Project Overview)

Bu proje, kişisel finans yönetimi için tasarlanmış kapsamlı bir web uygulamasıdır. Kullanıcıların gelirlerini, giderlerini, borçlarını, istek listelerini ve yapılacaklar listelerini kolayca takip etmelerini sağlar. Uygulama, finansal durumu görselleştirmek, harcamaları kategorize etmek ve hedeflere ulaşmak için çeşitli araçlar sunar.

## Menü Öğeleri (Menu Items)

Uygulamanın ana menüsü, farklı finansal ve kişisel yönetim alanlarına hızlı erişim sağlar:

### Dashboard (Ana Sayfa)
*   `/`
    *   Kullanıcının finansal durumuna genel bir bakış sunar. Gelirler, giderler, bakiyeler ve önemli hatırlatıcılar gibi özet bilgileri içerir.

### Giderler (Expenses)
*   `/giderler?filter=month` (Bu Ay)
    *   Mevcut ay içindeki tüm giderleri listeler ve yönetir.
*   `/giderler?filter=next_month` (Gelecek Ay)
    *   Gelecek ay için planlanan veya gerçekleşen giderleri gösterir.
*   `/giderler?filter=year` (Bu Yıl)
    *   Mevcut yılın tüm giderlerini toplu olarak görüntüler.
*   `/giderler?filter=all` (Tüm Zamanlar)
    *   Uygulamaya girilen tüm gider kayıtlarını listeler.

### Harcamalar (Spendings)
*   `/expense` (Tüm Harcamalar)
    *   Tüm harcama kalemlerini detaylı olarak gösterir.
*   `/fixedexpense` (Sabit Giderler)
    *   Kira, faturalar gibi düzenli ve sabit ödemeleri takip eder.
*   `/variableexpense` (Değişken Giderler)
    *   Aydan aya değişebilen harcamaları (örn. yeme-içme, eğlence) yönetir.
*   `/extraexpense` (Ani/Ekstra Harcamalar)
    *   Beklenmedik veya ek harcamaları kaydeder.
*   `/postponedpayment` (Ertelenen Ödemeler)
    *   Vadesi gelmiş ancak ertelenmiş ödemeleri listeler.

### Alınacaklar (Wishlist)
*   `/wishlist-all.php` (Tüm Alınacaklar)
    *   Tüm kategorilerdeki istek listesi öğelerini bir arada gösterir.
*   `/wishlist-ihtiyac.php` (İhtiyaçlar)
    *   Temel ihtiyaçlar kategorisindeki alınacakları listeler.
*   `/wishlist-istek.php` (İstekler)
    *   Arzu edilen ancak zorunlu olmayan öğeleri takip eder.
*   `/wishlist-hayal.php` (Hayaller)
    *   Uzun vadeli veya büyük hedeflere yönelik istekleri içerir.
*   `/wishlist-favori.php` (Favoriler)
    *   Özel olarak işaretlenmiş veya sıkça bakılan istekleri gösterir.

### Market & Gıda (Market & Food)
*   `/market`
    *   Market ve gıda harcamalarını özel olarak takip etmek için kullanılır.

### Tüm Borçlar (All Debts)
*   `/tax` (Vergi)
    *   Vergi borçlarını ve ödemelerini yönetir.
*   `/sgk` (SGK)
    *   Sosyal Güvenlik Kurumu ile ilgili borçları ve ödemeleri takip eder.
*   `/bank` (Banka)
    *   Banka kredileri, kredi kartı borçları gibi bankacılıkla ilgili borçları listeler.
*   `/execution` (İcralar)
    *   Yasal takipteki borçları ve icra durumlarını gösterir.
*   `/individualdebt` (Şahıslara Borçlar)
    *   Bireylerden alınan veya bireylere verilen borçları kaydeder.

### Yapılacaklar (To-Dos)
*   `/project` (Projeler)
    *   Kişisel veya finansal projeleri yönetir.
*   `/task` (Görevler)
    *   Tamamlanması gereken bireysel görevleri listeler.
*   `/note` (Notlar)
    *   Önemli notları ve hatırlatıcıları saklar.
*   `/todolist` (To-Do List)
    *   Günlük veya genel yapılacaklar listesini tutar.

### Hesaplar & Şifreler (Accounts & Passwords)
*   `/accountpassword`
    *   Çeşitli online hesapların kullanıcı adı ve şifre bilgilerini güvenli bir şekilde saklar.

### Banka Hesapları (Bank Accounts)
*   `/bankaccount`
    *   Kullanıcının banka hesaplarını ve bakiyelerini yönetir.

### Xtreme AI
*   `/xtremeai`
    *   Yapay zeka destekli özelliklere erişim sağlar (detayları uygulamaya göre değişebilir).

### Ayarlar (Settings)
*   `/settings`
    *   Uygulamanın genel ayarlarını, tercihlerini ve yapılandırmalarını düzenler.

### Profil (Profile)
*   `/profile`
    *   Kullanıcı profil bilgilerini görüntüler ve düzenler.

### Destek (Support)
*   `/support`
    *   Yardım ve destek kaynaklarına erişim sağlar.

### Referans Programı (Affiliate Program)
*   `/affiliate`
    *   Uygulamanın referans programı hakkında bilgi verir.

### Çıkış Yap (Logout)
*   `/signin?logout=1`
    *   Kullanıcının oturumunu sonlandırır ve çıkış yapar.