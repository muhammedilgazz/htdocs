# Proje Bağlamı (Context)

Bu doküman, projenin amacını, hedeflerini, kapsamını ve kullanılan temel teknolojileri açıklamaktadır.

## 1. Projenin Amacı ve Hedefleri

Bu proje, kullanıcıların kişisel finanslarını etkin bir şekilde yönetmelerini sağlayan kapsamlı bir bütçe yönetimi uygulamasıdır. Temel amaç, kullanıcıların gelir ve giderlerini kolayca takip etmelerine, borçlarını yönetmelerine, tasarruf hedefleri belirlemelerine ve finansal durumları hakkında genel bir bakış açısı kazanmalarına yardımcı olmaktır.

**Ana Hedefler:**

-   **Gelir ve Gider Takibi:** Kullanıcıların tüm gelir kaynaklarını ve harcamalarını tek bir yerden yönetmesini sağlamak.
-   **Borç Yönetimi:** Banka, vergi, SGK ve kişisel borçlar gibi farklı türdeki borçların takibini kolaylaştırmak.
-   **Bütçe Planlama:** Aylık veya yıllık bütçeler oluşturarak harcamaları kontrol altında tutmaya yardımcı olmak.
-   **Hedef Belirleme:** Kullanıcıların birikim ve yatırım hedefleri (örneğin, bir ev almak, araba almak) belirlemesini ve bu hedeflere yönelik ilerlemelerini izlemesini sağlamak.
-   **Raporlama ve Analiz:** Finansal verileri görsel grafikler ve detaylı raporlarla sunarak kullanıcıların harcama alışkanlıklarını anlamalarına olanak tanımak.
-   **Veri Güvenliği:** Kullanıcıların finansal bilgilerini güvenli bir şekilde saklamak.

## 2. Projenin Kapsamı

Proje, aşağıdaki ana modülleri ve işlevleri kapsamaktadır:

-   **Kullanıcı Yönetimi:** Kayıt olma, giriş yapma, profil yönetimi ve güvenlik ayarları.
-   **Panel (Dashboard):** Finansal duruma genel bakış, son işlemler, yaklaşan ödemeler ve hedefler.
-   **Gelir/Gider Yönetimi:** Sabit, değişken ve ek gelir/giderlerin eklenmesi, düzenlenmesi ve kategorize edilmesi.
-   **Borçlar Modülü:** Farklı türdeki borçların (kredi, vergi vb.) takibi ve ödeme planlarının yönetimi.
-   **Varlıklar ve Hesaplar:** Banka hesapları, IBAN bilgileri ve diğer finansal varlıkların yönetimi.
-   **Hayal ve Hedefler (Wishlist/Goals):** Kullanıcıların birikim hedeflerini oluşturması ve yönetmesi.
-   **Raporlama:** Gelir-gider dengesi, kategori bazında harcamalar ve borç durumu gibi konularda detaylı raporlar.
-   **Notlar ve Görevler (Notes/Todos):** Finansal notlar ve yapılacaklar listesi.
-   **Ayarlar:** Kategori, para birimi ve diğer uygulama ayarlarının yönetimi.

## 3. Temel Teknolojiler

Proje, standart bir web sunucusu yığını üzerinde çalışmaktadır.

-   **Backend:** PHP
-   **Frontend:** HTML, CSS, JavaScript (jQuery ve diğer kütüphanelerle desteklenmiş)
-   **Veritabanı:** MySQL / MariaDB
-   **Sunucu:** Apache (XAMPP ile yerel geliştirme ortamı)
-   **Paket Yöneticisi:** Composer (PHP bağımlılıkları için)