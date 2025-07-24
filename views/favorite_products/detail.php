<?php
require_once __DIR__ . '/../layouts/layoutTop.php';

$page_title = "Ürün Detayı";
$page_description = "Ürün detaylarını buradan görüntüleyebilirsiniz.";
$breadcrumb_active = "Ürün Detayı";

// Breadcrumb ve başlık hizalı şekilde
?>
<div class="fav-detail-header container-fluid px-4 px-md-5">
  <div>
    <h1 class="page-title mb-1" style="font-size:1.4rem;font-weight:700;">Ürün Detayı</h1>
    <div class="page-desc text-muted" style="font-size:1rem;">Ürün detaylarını buradan görüntüleyebilirsiniz.</div>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
      <li class="breadcrumb-item"><a href="/favorite-products">Favori Ürünler</a></li>
      <?php if (!empty($product['category_id']) && !empty($product['category_name'])): ?>
        <li class="breadcrumb-item"><a href="/favorite-products?category=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a></li>
      <?php endif; ?>
      <li class="breadcrumb-item active" aria-current="page">Ürün Detayı</li>
    </ol>
  </nav>
</div>
<?php
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <?php if (isset($product) && !empty($product)): ?>
                <div class="fav-detail-box d-flex flex-column flex-md-row align-items-stretch gap-4 p-4 mx-auto">
                    <div class="fav-detail-img-wrap flex-shrink-0">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="fav-detail-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="fav-detail-info w-100 d-flex flex-column justify-content-center">
                        <h1 class="fav-detail-title mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
                        <div class="mb-2">
                            <span class="badge bg-secondary">KATEGORİ: <?php echo htmlspecialchars($product['category_name'] ?? 'Kategorisiz'); ?></span>
                        </div>
                        <div class="fav-detail-actions d-flex flex-wrap gap-2 align-items-center mb-2">
                            <?php if (!empty($product['product_link'])): ?>
                                <a href="<?php echo htmlspecialchars($product['product_link']); ?>" target="_blank" class="btn btn-primary-outline">Ürüne Git</a>
                            <?php endif; ?>
                            <a href="/favorite-products" class="btn btn-primary-outline">Geri Dön</a>
                            <a href="/favorite-products/product/<?php echo $product['id']; ?>/edit" class="btn btn-primary-outline">Düzenle</a>
                            <form action="/favorite-products/product/<?php echo $product['id']; ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                                <button type="submit" class="btn btn-primary">Sil</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php if (!empty($product['description'])): ?>
                <div class="fav-detail-descbox mt-3 p-4">
                    <?php echo $product['description']; ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center">Ürün bulunamadı.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.fav-detail-box {
    background: #fff;
    border-radius: 1.2rem;
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.07);
    border: 1.5px solid #e5e7eb;
    width: 100%;
    margin-bottom: 2rem;
    min-height: 320px;
    transition: box-shadow .18s;
    overflow: hidden;
}
.fav-detail-box:hover {
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.12);
}
.fav-detail-img-wrap {
    width: 340px;
    max-width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f3f3;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04);
}
.fav-detail-img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 1rem;
    background: #f3f3f3;
}
.fav-detail-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #222;
    letter-spacing: 0.01em;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}
.fav-detail-link {
    color: #3b82f6;
    font-size: 1.05rem;
    word-break: break-all;
    text-decoration: underline;
}
.fav-detail-desc {
    font-size: 1.15rem;
    color: #444;
    margin-top: 0.5rem;
}
.fav-detail-actions .btn-primary-outline {
    background: transparent;
    color: #2563eb;
    border: 1.5px solid #2563eb;
    font-weight: 600;
    transition: background .15s, color .15s;
}
.fav-detail-actions .btn-primary-outline:hover {
    background: #2563eb;
    color: #fff;
}
.fav-detail-descbox {
    background: #f8fafc;
    border-radius: 0.7rem;
    border: 1.5px solid #e5e7eb;
    font-size: 1.08rem;
    color: #222;
    min-height: 80px;
    margin-bottom: 2rem;
    word-break: break-word;
    overflow-x: auto;
}
.page-title { font-size: 1.4rem; font-weight: 700; }
.page-desc { font-size: 1rem; color: #6b7280; }
@media (max-width: 768px) {
    .fav-detail-box {
        flex-direction: column;
        padding: 1.2rem;
    }
    .fav-detail-img-wrap {
        width: 100%;
        height: 200px;
    }
    .fav-detail-img {
        height: 200px;
    }
    .fav-detail-title {
        font-size: 1.3rem;
    }
    .page-title { font-size: 1.1rem; }
    .page-desc { font-size: 0.95rem; }
    .breadcrumb { font-size: 0.95rem; }
    .fav-detail-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.7rem;
      margin-bottom: 1.2rem;
    }
    .breadcrumb {
      padding: 0.3rem 0.7rem;
      font-size: 0.97rem;
    }
    .breadcrumb-item + .breadcrumb-item {
      margin-left: 0.5rem;
    }
}
.fav-detail-header {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    gap: 1.2rem;
    min-width: 0;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}
.fav-detail-header .breadcrumb {
    white-space: nowrap;
    overflow-x: auto;
    flex-shrink: 0;
    background: #f8fafc;
    border-radius: 0.5rem;
    font-size: 1.05rem;
    gap: 0.5rem;
    padding: 0.4rem 1.2rem;
    margin-bottom: 0;
}
.fav-detail-header .breadcrumb-item + .breadcrumb-item {
    margin-left: 0.5rem;
}
@media (max-width: 900px) {
  .fav-detail-header {
    padding-left: 0.7rem;
    padding-right: 0.7rem;
  }
}
@media (max-width: 768px) {
  .fav-detail-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.7rem;
    margin-bottom: 1.2rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
  .fav-detail-header .breadcrumb {
    padding: 0.3rem 0.7rem;
    font-size: 0.97rem;
  }
}
</style>

<?php require_once __DIR__ . '/../layouts/layoutBottom.php'; ?>