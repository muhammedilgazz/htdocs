# UI/UX Standartları ve Tasarım Sistemi

Bu doküman, uygulama genelinde tutarlı, modern ve kullanıcı dostu bir arayüz sağlamak için uyulması gereken temel UI/UX standartlarını ve tasarım sistemini tanımlar. Amaç, bileşenlerin yeniden kullanılabilirliğini artırmak, geliştirme sürecini hızlandırmak ve görsel bütünlüğü korumaktır.

## 1. Temel Felsefe

Tüm yeni arayüz geliştirmeleri ve mevcut arayüz güncellemeleri, `assets/css/modern-design-system.css` dosyasında tanımlanan **tasarım token'larını (design tokens)** temel almalıdır. Legacy `style.css` ve diğer özel CSS dosyalarındaki stiller, zamanla bu yeni sisteme taşınacaktır.

## 2. Tasarım Token'ları

Tasarım token'ları, CSS özel değişkenleri (custom properties) olarak tanımlanmıştır ve tutarlılığı sağlamanın temelini oluşturur.

### 2.1. Renk Paleti

Renkler, anlamlarına göre (semantik) ve tonlarına göre gruplandırılmıştır.

*   **Ana Renk (Primary):** Markanın ana rengidir. Eylem çağrıları (CTA), aktif menü öğeleri ve önemli vurgular için kullanılır.
    *   `--primary-500`: `#6366f1` (Ana)
    *   `--primary-600`: `#4f46e5` (Hover/Koyu)

*   **Semantik Renkler:** Durum bildirimleri için kullanılır.
    *   **Başarı (Success):** `--success-500` (#22c55e)
    *   **Uyarı (Warning):** `--warning-500` (#f59e0b)
    *   **Hata (Error):** `--error-500` (#ef4444)
    *   **Bilgi (Info):** `--info-500` (#3b82f6)

*   **Nötr Renkler (Gray Scale):** Metinler, arka planlar, sınırlar ve genel arayüz elemanları için kullanılır.
    *   **Arka Planlar:** `--bg-primary` (en açık), `--bg-secondary`, `--bg-tertiary` (en koyu).
    *   **Metinler:** `--text-primary` (en koyu), `--text-secondary`, `--text-tertiary` (en açık).
    *   **Sınırlar (Borders):** `--border-primary`, `--border-secondary`.

### 2.2. Tipografi

*   **Yazı Tipi Ailesi:**
    *   `--font-family-primary`: 'Inter', sans-serif (Genel metinler için)
    *   `--font-family-mono`: Monospace (Kod veya sayısal veri gösterimi için)
*   **Yazı Tipi Boyutları (Akışkan):** Ekran boyutuna göre ölçeklenen `--text-xs` ile `--text-4xl` arası değişkenler kullanılmalıdır.
*   **Yazı Tipi Kalınlıkları:** `--font-normal` (400), `--font-medium` (500), `--font-semibold` (600), `--font-bold` (700).

### 2.3. Boşluklar (Spacing)

Tüm `margin`, `padding` ve `gap` değerleri için `--space-1` (0.25rem) ile `--space-32` (8rem) arasındaki boşluk token'ları kullanılmalıdır. Bu, arayüzdeki tüm elemanlar arasında tutarlı bir ritim ve boşluk hiyerarşisi sağlar.

### 2.4. Köşe Yarıçapı (Border Radius)

Elemanların köşelerini yuvarlatmak için `--radius-sm` ile `--radius-full` arasındaki token'lar kullanılmalıdır.
*   `--radius-lg` (0.5rem): Genel kartlar ve büyük elemanlar için.
*   `--radius-xl` (0.75rem): Butonlar ve input'lar için.
*   `--radius-full`: Tam yuvarlak elemanlar (avatarlar, etiketler) için.

### 2.5. Gölgeler (Shadows)

Arayüze derinlik katmak için `--shadow-sm` (hafif) ile `--shadow-xl` (belirgin) arasındaki gölge token'ları kullanılmalıdır.

## 3. Bileşen Standartları

### 3.1. Butonlar (`.btn`)
*   **Birincil Eylem:** `.btn-primary` sınıfını kullanır. Her sayfada genellikle bir adet bulunur.
*   **İkincil Eylem:** `.btn-secondary` sınıfını kullanır. Daha az önemli eylemler için.
*   **Hayalet (Ghost):** `.btn-ghost` sınıfını kullanır. En az dikkat çekmesi gereken eylemler için.

### 3.2. Kartlar (`.card-modern`)
*   Tüm bilgi blokları, widget'lar ve gruplandırılmış içerikler için standart `.card-modern` yapısı kullanılmalıdır.
*   Kart başlığı, içeriği ve altbilgisi için standart HTML yapıları korunmalıdır.

### 3.3. Form Elemanları
*   Tüm formlar `.form-modern` sarmalayıcısı içinde olmalıdır.
*   Etiket ve input alanları `.form-group` ile gruplanmalıdır.
*   Etiketler için `.form-label`, input'lar için `.form-input` sınıfları kullanılmalıdır. Bu, tutarlı bir görünüm ve odak (focus) davranışı sağlar.

## 4. Sayfa Düzeni (Layout)

*   **Ana Şablon:** Tüm sayfalar, `views/layouts/layoutTop.php` ve `views/layouts/layoutBottom.php` dosyalarını içeren ana şablonu kullanmalıdır. Bu, header, sidebar ve footer'ın tutarlı olmasını sağlar.
*   **Hizalama:** Elemanları hizalamak için `.grid-modern` veya flexbox yardımcı sınıfları (`.flex`, `.items-center`, `.justify-between` vb.) tercih edilmelidir.
*   **Boşluklar:** Sayfa içi genel boşluklar ve bileşenler arası mesafeler için `gap-*` veya `m-*`, `p-*` gibi boşluk token'larını kullanan yardımcı sınıflar kullanılmalıdır.

## 5. UI Tutarlılığı İçin Kurallar

1.  **Yeni Stil Yazmaktan Kaçının:** Yeni bir bileşen veya sayfa oluştururken, mevcut tasarım token'larını ve bileşen sınıflarını kullanın. Özel, tek seferlik CSS yazmaktan kaçının.
2.  **Mevcutları Dönüştürün:** Mevcut bir sayfada veya bileşende değişiklik yaparken, eski CSS sınıflarını (örn. `style.css` içindekiler) yeni `.card-modern`, `.btn-modern` gibi standartlarla değiştirmek için küçük bir efor sarf edin.
3.  **Renkleri Anlamıyla Kullanın:** Renk paletindeki renkleri (success, error, warning) sadece amaçlarına uygun durumlarda kullanın.
4.  **Boşluk Hiyerarşisine Uyun:** Elemanlar arasındaki boşlukları, anlamsal ilişkilerine göre belirleyin. Birbirine ait elemanlar daha yakın (`--space-2`, `--space-4`), farklı gruplar daha uzak (`--space-6`, `--space-8`) olmalıdır.
- Tablo içeren tüm bölümler `.card modern-card` ile sarmalanmalıdır. Böylece tablo ve veri kartları görsel olarak tutarlı olur.