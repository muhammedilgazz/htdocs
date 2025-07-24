# API Mimarisi ve Endpoint'ler

Bu doküman, projenin asenkron (AJAX) işlemler için kullandığı merkezi API yapısını açıklamaktadır.

## 1. Merkezi API Yapısı

Tüm AJAX işlemleri, tek bir giriş noktası (entry point) olan `ajax.php` dosyası üzerinden yönetilir. Bu yapı, kod tekrarını önler, güvenliği merkezileştirir ve bakımı kolaylaştırır.

-   **URL:** Tüm AJAX istekleri `http://localhost/ajax.php` adresine gönderilir.
-   **Metot:** Genellikle `POST` HTTP metodu kullanılır.
-   **Veri Formatı:** İstekler `application/x-www-form-urlencoded` formatında gönderilir.
-   **Temel Parametre:** Hangi işlemin yapılacağını belirtmek için `action` adında bir parametre gönderilmesi **zorunludur**.
-   **Yanıt Formatı:** Sunucu yanıtları her zaman `JSON` formatındadır. (`{"status": "success", ...}` veya `{"status": "error", ...}`).

## 2. Action (Eylem) Parametresi

`action` parametresi, çağrılacak olan Controller ve metodu belirler. Format `controller_metot` şeklindedir.

**Örnek:**
*   `action=todo_add`: Bu istek, `TodoController` sınıfının içindeki `ajax_add()` metodunu çalıştırır.
*   `action=expense_delete`: Bu istek, `ExpenseController` sınıfının içindeki `ajax_delete()` metodunu çalıştırır.

## 3. Ana Eylemler (Actions)

Aşağıda, modüllere göre gruplandırılmış bazı önemli eylemler ve bekledikleri parametreler yer almaktadır.

---

### Gider (Expense) Yönetimi

-   **Action:** `expense_add`
-   **Açıklama:** Yeni bir gider ekler.
-   **Parametreler:**
    -   `amount`, `category_type`, `description`, `date`

-   **Action:** `expense_delete`
-   **Açıklama:** Belirtilen bir gideri siler.
-   **Parametreler:**
    -   `id`: Silinecek giderin ID'si.

---

### Gelir (Income) Yönetimi

-   **Action:** `income_add`
-   **Açıklama:** Yeni bir gelir kaydı oluşturur.
-   **Parametreler:** (Gelirle ilgili alanlar)

-   **Action:** `income_get`
-   **Açıklama:** Belirli bir gelirin detaylarını getirir.
-   **Parametreler:**
    -   `id`: Getirilecek gelirin ID'si.

---

### Yapılacaklar Listesi (Todo List)

-   **Action:** `todo_add`
-   **Açıklama:** Yapılacaklar listesine yeni bir görev ekler.
-   **Parametreler:**
    -   `task`: Görev açıklaması (String).
    -   `due_date` (opsiyonel): Bitiş tarihi (Date, 'YYYY-MM-DD').
-   **Örnek Yanıt:** `{"status": "success", "message": "Görev başarıyla eklendi."}`

-   **Action:** `todo_update`
-   **Açıklama:** Bir görevin durumunu günceller.
-   **Parametreler:**
    -   `id`: Güncellenecek görevin ID'si.

-   **Action:** `todo_delete`
-   **Açıklama:** Bir görevi listeden siler.
-   **Parametreler:**
    -   `id`: Silinecek görevin ID'si.

---

**Not:** Bu liste, projedeki tüm eylemleri kapsamamaktadır. Yeni bir AJAX işlemi eklendiğinde, ilgili Controller'a `ajax_` önekiyle bir metot eklenmeli ve bu doküman güncellenmelidir.