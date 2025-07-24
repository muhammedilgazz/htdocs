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

    /**
     * AJAX: İstek listesi öğesi ekleme
     * POST: item_name, wishlist_type, price, product_link, image_url, priority, progress, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'Geçersiz istek veya CSRF token.'];
        }
        if (empty($_POST['item_name'])) {
            return ['success' => false, 'message' => 'Ürün adı boş olamaz.'];
        }
        $data = [
            'item_name' => sanitize_input($_POST['item_name']),
            'wishlist_type' => isset($_POST['wishlist_type']) ? sanitize_input($_POST['wishlist_type']) : 'istek',
            'price' => isset($_POST['price']) && is_numeric($_POST['price']) ? (float)$_POST['price'] : 0,
            'product_link' => isset($_POST['product_link']) ? filter_var($_POST['product_link'], FILTER_SANITIZE_URL) : null,
            'image_url' => isset($_POST['image_url']) ? filter_var($_POST['image_url'], FILTER_SANITIZE_URL) : null,
            'priority' => isset($_POST['priority']) && is_numeric($_POST['priority']) ? (int)$_POST['priority'] : null,
            'progress' => isset($_POST['progress']) && is_numeric($_POST['progress']) ? (int)$_POST['progress'] : 0
        ];
        if ($this->wishlist_model->add($data)) {
            return ['success' => true, 'message' => 'İstek listesi öğesi başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'İstek listesi öğesi eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: İstek listesi öğesi güncelleme
     * POST: id, item_name, wishlist_type, price, product_link, image_url, priority, progress, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'Geçersiz istek veya CSRF token.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'item_name' => sanitize_input($_POST['item_name'] ?? ''),
            'wishlist_type' => sanitize_input($_POST['wishlist_type'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'product_link' => sanitize_input($_POST['product_link'] ?? null),
            'image_url' => sanitize_input($_POST['image_url'] ?? null),
            'priority' => (int)($_POST['priority'] ?? null),
            'progress' => (int)($_POST['progress'] ?? 0)
        ];
        if ($this->wishlist_model->update($id, $data)) {
            return ['success' => true, 'message' => 'İstek listesi öğesi başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'İstek listesi öğesi güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: İstek listesi öğesi silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'Geçersiz istek veya CSRF token.'];
        }
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id > 0) {
            if ($this->wishlist_model->delete($id)) {
                return ['success' => true, 'message' => 'İstek listesi öğesi başarıyla silindi.'];
            } else {
                return ['success' => false, 'message' => 'İstek listesi öğesi silinirken bir hata oluştu.'];
            }
        } else {
            return ['success' => false, 'message' => 'Geçersiz ID.'];
        }
    }

    /**
     * AJAX: İstek listesi öğesi getirme
     * POST: id
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $item = $this->wishlist_model->getById($id);
        if ($item) {
            return ['success' => true, 'data' => $item];
        } else {
            return ['success' => false, 'message' => 'İstek listesi öğesi bulunamadı.'];
        }
    }
}
