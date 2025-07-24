# Proje Modülleri ve Sorumlulukları

Bu doküman, bütçe yönetim sistemini oluşturan ana işlevsel modülleri ve her bir modülün temel sorumluluklarını, ilgili dosya ve klasörlerle birlikte tanımlar.

## 1. Çekirdek Modüller (Core)

Bu modüller, uygulamanın genel altyapısını ve temel işlevlerini sağlar.

### 1.1. Kimlik Doğrulama ve Yetkilendirme (Auth)
*   **Sorumluluk:** Kullanıcı girişi, çıkışı, kayıt olma ve oturum güvenliğini yönetir. Yetkisiz erişimleri engeller.
*   **İlgili Dosyalar:**
    *   `app/Models/Auth.php`: Ana kimlik doğrulama mantığı.
    *   `signin.php`, `signup.php`, `logout.php` (dolaylı olarak `Auth` modelini kullanır).
    *   `bootstrap.php`: Session güvenliği ve başlatma.

### 1.2. Yönlendirme ve Kontrol (Routing & Control)
*   **Sorumluluk:** Gelen HTTP isteklerini uygun kontrolcülere yönlendirir.
*   **İlgili Dosyalar:**
    *   `index.php`: Temel yönlendirme mantığı.
    *   `app/Controllers/`: Tüm kontrolcü sınıfları.

### 1.3. Veritabanı Erişimi (Database Access)
*   **Sorumluluk:** Veritabanı bağlantısı kurar ve sorgu çalıştırma arayüzü sağlar.
*   **İlgili Dosyalar:**
    *   `app/Models/Database.php`: Singleton veritabanı sınıfı.
    *   `app/Core/DatabaseConnection.php`: (Artık kullanılmıyor gibi görünüyor, `Database.php` tercih ediliyor).
    *   `config/config.php`: Veritabanı bağlantı bilgileri.

## 2. İşlevsel Modüller (Functional Modules)

Bu modüller, uygulamanın son kullanıcıya sunduğu ana özellikleri içerir.

### 2.1. Gösterge Paneli (Dashboard)
*   **Sorumluluk:** Kullanıcıya genel bir bakış sunar: bakiye, son işlemler, gider/gelir özeti.
*   **İlgili Dosyalar:**
    *   `app/Controllers/DashboardController.php`
    *   `app/Models/Dashboard.php`
    *   `views/dashboard.php`

### 2.2. Gider Yönetimi (Expense Management)
*   **Sorumluluk:** Sabit, değişken ve ekstra giderlerin takibini sağlar.
*   **İlgili Dosyalar:**
    *   Kontrolcüler: `ExpenseController`, `FixedExpenseController`, `VariableExpenseController`, `ExtraExpenseController`.
    *   Model: `app/Models/Expense.php`
    *   Servis/Repository: `ExpenseService`, `ExpenseRepository`
    *   Görünümler: `views/expenses/`, `views/fixed_expenses/`, vb.
    *   AJAX: `add_expense.php`, `delete_expense.php`, `update_expense.php`

### 2.3. Gelir Yönetimi (Income Management)
*   **Sorumluluk:** Maaş, ek gelir gibi gelir kalemlerinin kaydını tutar.
*   **İlgili Dosyalar:**
    *   `app/Controllers/IncomeController.php`
    *   `app/Models/Income.php`
    *   `views/incomes/`
    *   AJAX: `add_income.php`, `delete_income.php`, `get_income.php`

### 2.4. Borç Yönetimi (Debt Management)
*   **Sorumluluk:** Vergi, SGK, banka, icra ve kişisel borçların ayrı ayrı takibini yapar.
*   **İlgili Dosyalar:**
    *   Kontrolcüler: `TaxController`, `SgkController`, `BankController`, `ExecutionController`, `IndividualDebtController`.
    *   Modeller: `TaxDebt.php`, `SgkDebt.php`, `BankDebt.php`, `ExecutionDebt.php`, `PersonalDebt.php`.
    *   Görünümler: `views/tax/`, `views/sgk/`, vb.
    *   AJAX: İlgili borç türleri için `add_...`, `delete_...`, `update_...` betikleri.

### 2.5. Varlık ve Hesap Yönetimi (Asset & Account Management)
*   **Sorumluluk:** Banka hesapları, IBAN bilgileri ve diğer platformlardaki hesap şifrelerinin kaydını tutar.
*   **İlgili Dosyalar:**
    *   Kontrolcüler: `BankAccountController`, `AccountPasswordController`, `IbanTableController`.
    *   Modeller: `BankAccount.php`, `AccountCredential.php`.
    *   Görünümler: `views/bank_account/`, `views/account_passwords/`.

### 2.6. Planlama ve Hedefler (Planning & Goals)
*   **Sorumluluk:** Kullanıcıların hedeflerini, yapılacaklar listesini, projelerini, görevlerini ve notlarını yönetir.
*   **İlgili Dosyalar:**
    *   Kontrolcüler: `DreamGoalController`, `TodoListController`, `ProjectController`, `TaskController`, `NoteController`.
    *   Modeller: `DreamGoal.php`, `Todo.php`, `Project.php`, `Task.php`, `Note.php`.
    *   Görünümler: İlgili modül klasörleri.

### 2.7. Alışveriş ve Ürünler (Shopping & Products)
*   **Sorumluluk:** Alışveriş listesi (wishlist), favori ürünler ve market ürünlerinin takibini sağlar.
*   **İlgili Dosyalar:**
    *   Kontrolcüler: `WishlistController`, `FavoriteProductController`, `MarketController`.
    *   Modeller: `Wishlist.php`, `FavoriteProduct.php`, `MarketProduct.php`.
    *   Görünümler: İlgili modül klasörleri.

### 2.8. Ayarlar ve Profil (Settings & Profile)
*   **Sorumluluk:** Kullanıcı profili, genel uygulama ayarları, güvenlik ve oturum yönetimi gibi işlevleri barındırır.
*   **İlgili Dosyalar:**
    *   `app/Controllers/SettingsController.php`
    *   `app/Controllers/ProfileController.php`
    *   `views/settings/`, `views/profile/`