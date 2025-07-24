<?php
require_once __DIR__ . '/../layouts/layoutTop.php';
// Gerekli modelleri ve yardımcıları dahil et
// Örnek: use App\Models\FavoriteProduct;

$page_title = "Favori Ürünler";
$page_description = "Favori ürünlerinizi buradan yönetebilirsiniz.";
$breadcrumb_active = "Favori Ürünler";

require_once __DIR__ . '/../partials/page_header.php';
?>
<!-- Vintage/Neo-brutalism tema için ek CSS (kendi temanızın yolunu ekleyin) -->
<!-- <link rel="stylesheet" href="/superdesign/design_iterations/favorite_products_theme_1.css"> -->

<div class="favorite-products-grid-container mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-start category-tab-bar">
        <a href="/favorite-products" class="btn btn-tab-filter<?php echo !isset($_GET['category']) ? ' active' : ''; ?>">Tüm Ürünler</a>
        <?php foreach ($categories as $category): ?>
            <a href="/favorite-products?category=<?php echo $category['id']; ?>" class="btn btn-tab-filter<?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? ' active' : ''; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="favorite-products-grid-container">
    <div class="favorite-products-grid">
        <?php if (empty($products)): ?>
            <div class="col-12"><p class="text-center text-muted">Bu kategoride favori ürün bulunmamaktadır.</p></div>
        <?php else: ?>
            <?php foreach (array_slice($products, 0, 36) as $product): ?>
                <div class="favorite-product-item">
                    <?php if (!empty($product['product_link'])): ?>
                        <a href="<?php echo htmlspecialchars($product['product_link']); ?>" target="_blank" class="d-block">
                    <?php endif; ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="favorite-product-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if (!empty($product['product_link'])): ?>
                        </a>
                    <?php endif; ?>
                    <div class="favorite-product-info">
                        <div class="favorite-product-title"><?php
                          $name = htmlspecialchars($product['name']);
                          echo mb_strlen($name) > 25 ? mb_substr($name, 0, 25) . '…' : $name;
                        ?></div>
                        <div class="favorite-product-meta">
                            <span class="badge bg-secondary">Kategori: <?php echo htmlspecialchars($product['category_name'] ?? 'Kategorisiz'); ?></span>
                        </div>
                        <div class="favorite-product-actions">
                            <form action="/favorite-products/product/<?php echo $product['id']; ?>/update-category" method="post" class="d-inline">
                                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">Kategori Seç</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo ($product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                            <a href="/favorite-products/detail/<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">İncele</a>
                            <form action="/favorite-products/product/<?php echo $product['id']; ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                                <button type="submit" class="btn btn-primary btn-sm">Sil</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- Sayfalama Kontrolleri -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center vintage-pagination">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $categoryId ? '&category=' . $categoryId : ''; ?>">Önceki</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $categoryId ? '&category=' . $categoryId : ''; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $categoryId ? '&category=' . $categoryId : ''; ?>">Sonraki</a>
            </li>
        </ul>
    </nav>
</div>

<?php require_once __DIR__ . '/../layouts/layoutBottom.php'; ?>

<style>
.category-tab-bar {
    border-bottom: 2.5px solid var(--border);
    padding-bottom: 0.5rem;
    margin-bottom: 0.5rem;
    background: var(--card);
    border-radius: 0.5rem 0.5rem 0 0;
    width: 100%;
    box-sizing: border-box;
}
.btn-tab-filter {
    border: none;
    background: transparent;
    color: var(--primary);
    font-weight: 600;
    font-size: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    padding: 0.5rem 1.2rem;
    transition: background .15s, color .15s;
    margin-bottom: -2.5px;
    box-shadow: none;
    position: relative;
}
.btn-tab-filter.active, .btn-tab-filter:hover {
    background: var(--accent);
    color: var(--accent-foreground);
    border-bottom: 2.5px solid var(--primary);
    z-index: 2;
}
.favorite-products-grid-container {
    width: 100%;
    margin: 0 auto;
    padding: 0 2.5rem;
    overflow-x: hidden;
}
.favorite-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem 1.5rem;
    margin: 0;
}
.favorite-product-item {
    background: none;
    border: none;
    box-shadow: none;
    border-radius: 1rem;
    padding: 0.5rem 0.2rem 1.2rem 0.2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: background .12s;
}
.favorite-product-img-wrap {
  position: relative;
  width: 100%;
  height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.favorite-product-img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 0.7rem;
  margin-bottom: 0.7rem;
  background: #f3f3f3;
}
.favorite-product-info {
    width: 100%;
    text-align: left;
    padding: 0 0.2rem;
}
.favorite-product-title {
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 0.2rem;
    color: var(--foreground);
    min-height: 2.2em;
}
.favorite-product-desc {
    font-size: 0.95rem;
    color: var(--muted-foreground);
    margin-bottom: 0.3rem;
    min-height: 2.2em;
}
.favorite-product-meta {
    margin-bottom: 0.5rem;
}
.favorite-product-actions {
    display: flex;
    gap: 0.4rem;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 0.2rem;
}
@media (max-width: 1200px) {
  .favorite-products-grid-container {
    padding: 0 1.2rem;
  }
}
@media (max-width: 768px) {
  .favorite-products-grid-container {
    padding: 0 0.5rem;
  }
}
</style>
