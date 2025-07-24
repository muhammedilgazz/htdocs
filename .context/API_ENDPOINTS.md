# API Endpointleri

Bu doküman, projenin sunduğu temel API endpoint'lerini, özellikle de `ajax/` dizini altında yönetilen asenkron (AJAX) işlemleri açıklamaktadır. Bu endpoint'ler, istemci tarafının sunucuyla sayfa yenilemeden iletişim kurmasını sağlar.

## 1. Genel Yapı

-   **URL:** Tüm AJAX endpoint'leri `http://localhost/ajax/` altında yer alır.
-   **Metot:** Çoğu işlem `POST` HTTP metodu kullanılarak gerçekleştirilir.
-   **Veri Formatı:** İstekler genellikle `application/x-www-form-urlencoded` veya `multipart/form-data` (dosya yüklemeleri için) formatında gönderilir.
-   **Yanıt Formatı:** Sunucu yanıtları genellikle `JSON` formatındadır. Başarılı işlemlerde `{"status": "success", ...}` gibi bir yanıt dönerken, hatalı işlemlerde `{"status": "error", "message": "Hata açıklaması"}` gibi bir yanıt döner.

## 2. Ana Endpoint'ler

Aşağıda, modüllere göre gruplandırılmış bazı önemli endpoint'ler yer almaktadır.

---

### Gider (Expense) Yönetimi

-   **Endpoint:** `ajax/add_expense.php`
-   **Metot:** `POST`
-   **Açıklama:** Yeni bir gider ekler.
-   **Parametreler:**
    -   `amount`: Gider tutarı (Decimal).
    -   `category_type`: Gider kategorisi ('sabit_gider', 'degisken_gider', vb.).
    -   `description`: Açıklama (String).
    -   `date`: Gider tarihi (Date, 'YYYY-MM-DD').
-   **Örnek Yanıt:** `{"status": "success", "message": "Gider başarıyla eklendi."}`

-   **Endpoint:** `ajax/delete_expense.php`
-   **Metot:** `POST`
-   **Açıklama:** Belirtilen bir gideri siler.
-   **Parametreler:**
    -   `id`: Silinecek giderin ID'si (Integer).
-   **Örnek Yanıt:** `{"status": "success", "message": "Gider başarıyla silindi."}`

---

### Gelir (Income) Yönetimi

-   **Endpoint:** `ajax/add_income.php`
-   **Metot:** `POST`
-   **Açıklama:** Yeni bir gelir kaydı oluşturur.
-   **Parametreler:**
    -   (Parametreler `add_expense`'e benzer şekilde, gelirle ilgili alanları içerir.)
-   **Örnek Yanıt:** `{"status": "success"}`

-   **Endpoint:** `ajax/get_income.php`
-   **Metot:** `POST`
-   **Açıklama:** Belirli bir gelirin detaylarını getirir.
-   **Parametreler:**
    -   `id`: Getirilecek gelirin ID'si (Integer).
-   **Örnek Yanıt:** `{"status": "success", "data": {"id": 1, "amount": 5000, ...}}`

---

### Yapılacaklar Listesi (Todo List)

-   **Endpoint:** `ajax/add_todo.php`
-   **Metot:** `POST`
-   **Açıklama:** Yapılacaklar listesine yeni bir görev ekler.
-   **Parametreler:**
    -   `task`: Görev açıklaması (String).
-   **Örnek Yanıt:** `{"status": "success", "task": {"id": 12, "task": "Yeni görev", "completed": 0}}`

-   **Endpoint:** `ajax/update_todo.php`
-   **Metot:** `POST`
-   **Açıklama:** Bir görevin durumunu günceller (tamamlandı/tamamlanmadı).
-   **Parametreler:**
    -   `id`: Güncellenecek görevin ID'si (Integer).
-   **Örnek Yanıt:** `{"status": "success"}`

-   **Endpoint:** `ajax/delete_todo.php`
-   **Metot:** `POST`
-   **Açıklama:** Bir görevi listeden siler.
-   **Parametreler:**
    -   `id`: Silinecek görevin ID'si (Integer).
-   **Örnek Yanıt:** `{"status": "success"}`

---

### Borç Yönetimi (Debts)

Projedeki her borç türü (`tax`, `sgk`, `execution`, `bank`, `personal`) için benzer `add`, `update`, `delete`, `get` endpoint'leri bulunmaktadır.

-   **Örnek Endpoint:** `ajax/add_tax_debt.php`
-   **Metot:** `POST`
-   **Açıklama:** Yeni bir vergi borcu ekler.
-   **Parametreler:**
    -   `owner`: Borçlu (String).
    -   `period`: Borç dönemi (String).
    -   `principal`: Anapara (Decimal).
    -   `total`: Toplam borç (Decimal).
    -   `payment_due`: Son ödeme tarihi (Date).

---

### Diğer Endpoint'ler

-   **`ajax/add_account_credential.php`**: Yeni bir hesap bilgisi ekler.
-   **`ajax/add_market_product.php`**: Yeni bir market ürünü ekler.
-   **`ajax/add_note.php`**: Yeni bir not ekler.
-   **`ajax/get_exchange_rate.php`**: Güncel döviz kurunu getirir.

Bu liste, projedeki tüm endpoint'leri kapsamamaktadır ancak en sık kullanılan ve temel işlemleri gerçekleştirenleri özetlemektedir. Yeni bir endpoint eklenmesi veya mevcut olanın değiştirilmesi durumunda bu dokümanın güncellenmesi önemlidir.