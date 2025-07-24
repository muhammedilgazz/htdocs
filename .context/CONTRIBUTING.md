# Katkıda Bulunma Rehberi (Contributing)

Projeye katkıda bulunmak istediğiniz için teşekkür ederiz! Bu rehber, projeye tutarlı ve organize bir şekilde katkı sağlamanıza yardımcı olmak için hazırlanmıştır.

## 1. Davranış Kuralları (Code of Conduct)

Tüm katılımcıların, projenin [Davranış Kuralları](CODE_OF_CONDUCT.md) belgesine uyması beklenmektedir. Lütfen bu belgeyi okuyarak herkes için saygılı ve işbirlikçi bir ortam sağlamaya yardımcı olun.

## 2. Nasıl Katkıda Bulunabilirsiniz?

-   **Hata Bildirimi:** Bir hata bulursanız, lütfen GitHub Issues üzerinden detaylı bir rapor oluşturun.
-   **Özellik Talebi:** Yeni bir özellik veya geliştirme öneriniz varsa, bunu da GitHub Issues üzerinden "feature request" olarak etiketleyerek paylaşabilirsiniz.
-   **Kod Katkısı:** Hataları düzeltmek veya yeni özellikler eklemek için kod katkısında bulunabilirsiniz.

## 3. Kod Katkısı Süreci

### Adım 1: Issue (Görev) Oluşturma

Yapacağınız değişikliği (yeni özellik, hata düzeltmesi vb.) tartışmak için öncelikle bir **issue** (görev) oluşturmanız önerilir. Bu, aynı konu üzerinde başka birinin çalışmasını engeller ve yapacağınız değişikliğin projenin hedefleriyle uyumlu olduğundan emin olmanızı sağlar.

### Adım 2: Projeyi Fork'lama ve Klonlama

1.  Projenin ana deposunu kendi GitHub hesabınıza **fork'layın**.
2.  Fork'ladığınız depoyu yerel makinenize klonlayın:
    ```bash
    git clone https://github.com/KULLANICI_ADINIZ/proje-adi.git
    ```

### Adım 3: Yeni Bir Branch (Dal) Oluşturma

Yapacağınız her değişiklik için yeni bir dal oluşturun. Dal isimleriniz, yapacağınız değişikliği özetler nitelikte olmalıdır.

-   **Özellikler için:** `feature/yeni-ozellik-adi` (örn: `feature/kullanici-profil-resmi-ekleme`)
-   **Hata düzeltmeleri için:** `fix/hata-tanimi` (örn: `fix/gider-ekleme-formu-dogrulama`)
-   **Diğer değişiklikler için:** `chore/degisiklik-tanimi` (örn: `chore/readme-guncellemesi`)

```bash
git checkout -b feature/yeni-ozellik-adi
```

### Adım 4: Değişiklikleri Yapma ve Commit'leme

-   Kodunuzu yazarken projenin **kodlama standartlarına** uyun.
-   Değişikliklerinizi mantıksal ve küçük parçalara ayırarak commit'leyin.
-   Commit mesajlarınızı anlaşılır ve standartlara uygun yazın.

**Commit Mesajı Formatı:**

```
tip(kapsam): Değişikliğin kısa açıklaması

Değişikliğin nedenini ve nasıl yapıldığını açıklayan daha detaylı bilgi (isteğe bağlı).

İlgili Issue numarasını belirtin (isteğe bağlı). Örn: Fixes #123
```

-   **tip:** `feat` (yeni özellik), `fix` (hata düzeltmesi), `docs` (dokümantasyon), `style` (kod stili), `refactor` (yeniden düzenleme), `test` (test ekleme/düzeltme), `chore` (diğer değişiklikler).
-   **kapsam:** Değişikliğin yapıldığı modül (örn: `auth`, `expense`, `database`).

**Örnek Commit Mesajı:**

```
feat(profile): Kullanıcıların profil fotoğrafı yüklemesine izin ver
```

### Adım 5: Pull Request (Çekme İsteği) Oluşturma

1.  Değişikliklerinizi fork'ladığınız depoya gönderin:
    ```bash
    git push origin feature/yeni-ozellik-adi
    ```
2.  GitHub üzerinden projenin ana deposuna bir **Pull Request (PR)** oluşturun.
3.  PR açıklamasında yaptığınız değişiklikleri, nedenlerini ve ilgili issue numarasını açıkça belirtin.
4.  PR'ınız, proje yöneticileri tarafından incelenecek ve geri bildirimde bulunulacaktır. Gerekli düzenlemeleri yaptıktan sonra PR'ınız kabul edilip ana dalla birleştirilecektir.

## 4. Kodlama Standartları

-   **PHP:** [PSR-12](https://www.php-fig.org/psr/psr-12/) kodlama standartlarına uyun.
-   **JavaScript:** Modern JavaScript (ES6+) özelliklerini kullanın ve tutarlı bir stil izleyin.
-   **Değişken ve Fonksiyon İsimleri:** Anlaşılır ve `camelCase` formatında olmalıdır.
-   **Sınıf İsimleri:** `PascalCase` formatında olmalıdır.
-   **Yorumlar:** Karmaşık veya anlaşılması zor kod blokları için açıklayıcı yorum satırları ekleyin.