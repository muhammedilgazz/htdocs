<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/Controllers/WishlistController.php';
use App\Controllers\WishlistController;

$controller = new WishlistController();
$controller->istek();
?>