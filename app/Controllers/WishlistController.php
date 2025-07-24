<?php

namespace App\Controllers;

use App\Models\Wishlist;

class WishlistController {
    private $wishlist_model;

    public function __construct(Wishlist $wishlist_model)
    {
        $this->wishlist_model = $wishlist_model;
    }

    public function index() {
        // Redirect to a default wishlist type, e.g., 'all'
        header('Location: /wishlist-all.php');
        exit();
    }

    public function ihtiyac() {
        $rows = $this->wishlist_model->getByType('ihtiyac');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/ihtiyac.php';
    }

    public function hayal() {
        $rows = $this->wishlist_model->getByType('hayal');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/hayal.php';
    }

    public function favori() {
        $rows = $this->wishlist_model->getByType('favori');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/favori.php';
    }

    public function istek() {
        $rows = $this->wishlist_model->getByType('istek');
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/istek.php';
    }

    public function all() {
        $rows = $this->wishlist_model->getAll();
        $csrf_token = generate_csrf_token();
        require_once ROOT_PATH . '/views/wishlist/all.php';
    }

    public function ajax_add_from_link()
    {
        try {
            $data = [
                'item_name' => sanitize_input($_POST['productName']),
                'wishlist_type' => 'alinacak', // Varsayılan olarak 'alinacak'
                'price' => (float)$_POST['productPrice'] ?? 0,
                'product_link' => sanitize_input($_POST['productLink']) ?? null,
                'image_url' => sanitize_input($_POST['productImage']) ?? null,
                'priority' => null, // Varsayılan olarak null
                'progress' => 0 // Varsayılan olarak 0
            ];

            if ($this->wishlist_model->add($data)) {
                return ['status' => 'success', 'message' => 'Ürün linkten başarıyla eklendi.'];
            } else {
                return ['status' => 'error', 'message' => 'Ürün eklenirken bir hata oluştu.'];
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return ['status' => 'error', 'message' => 'Sunucu hatası: ' . $e->getMessage()];
        }
    }
}
