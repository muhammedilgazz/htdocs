<?php
// Gerekli değişkenlerin tanımlı olup olmadığını kontrol et
$page_title = $page_title ?? 'Sayfa Başlığı';
$page_description = $page_description ?? 'Sayfa açıklaması burada yer alacak.';
$breadcrumb_active = $breadcrumb_active ?? $page_title;
$show_title_section = $show_title_section ?? true; // New flag
?>
<div class="container-fluid py-1" style="background:#f7f9fb;">
    <div class="d-flex <?= $show_title_section ? 'justify-content-between' : 'justify-content-end' ?> align-items-center flex-wrap">
        <?php if ($show_title_section): ?>
        <div>
            <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;"><?= htmlspecialchars($page_title) ?></h2>
            <div style="color:#7b8ab8; font-size:1rem;"><?= htmlspecialchars($page_description) ?></div>
        </div>
        <?php endif; ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background:transparent;">
                <li class="breadcrumb-item"><a href="/" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;"><?= htmlspecialchars($breadcrumb_active) ?></li>
            </ol>
        </nav>
    </div>
</div>