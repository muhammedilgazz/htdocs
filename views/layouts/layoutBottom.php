<?php
if (file_exists(__DIR__ . '/../../config/config.php')) {
    require_once __DIR__ . '/../../config/config.php';
}
if (file_exists(__DIR__ . '/../../bootstrap.php')) {
    require_once __DIR__ . '/../../bootstrap.php';
}
?>

        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <?php include __DIR__ . '/../partials/global_modals.php'; ?>
    <?php include __DIR__ . '/../partials/script.php'; ?>

</body>

</html>