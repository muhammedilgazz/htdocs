<?php require_once 'C:/xampp/htdocs/views/partials/head.php'; ?>

<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container py-3">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <h2 class="mb-0">Profil</h2>
                                <div>Kullanıcı profil bilgilerinizi görüntüleyin ve yönetin.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-name text-center">
                                    <img src="assets/images/avatar/default.jpg" alt="Profil Resmi" class="rounded-circle mb-3" width="100" height="100">
                                    <h4 class="mb-0"><?= htmlspecialchars($user_profile['full_name']) ?></h4>
                                    <p><?= htmlspecialchars($user_profile['email']) ?></p>
                                </div>
                                <div class="profile-reg text-center mt-4">
                                    <div class="registered mb-2">
                                        <h5><?= htmlspecialchars($user_profile['registered_date']) ?></h5>
                                        <p>Kayıt Tarihi</p>
                                    </div>
                                    <div class="rank">
                                        <h5><?= htmlspecialchars($user_profile['referral_count']) ?></h5>
                                        <p>Referans Sayısı</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Profil Bilgileri</h4>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="fullName" class="form-label">Tam Adınız</label>
                                        <input type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($user_profile['full_name']) ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-posta</label>
                                        <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($user_profile['email']) ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registeredDate" class="form-label">Kayıt Tarihi</label>
                                        <input type="text" class="form-control" id="registeredDate" value="<?= htmlspecialchars($user_profile['registered_date']) ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="referralCount" class="form-label">Referans Sayısı</label>
                                        <input type="text" class="form-control" id="referralCount" value="<?= htmlspecialchars($user_profile['referral_count']) ?>" readonly>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'C:/xampp/htdocs/views/partials/script.php'; ?>

</body>
</html>
