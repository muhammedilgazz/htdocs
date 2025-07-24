<?php

namespace App\Controllers;

use App\Models\FavoriteProduct;
use App\Models\FavoriteProductCategory;
use App\Models\Auth;

class FavoriteProductController
{
    private $favoriteProductModel;
    private $categoryModel;
    private $userId;

    public function __construct()
    {
        $auth = new Auth();
        if (!($auth)->isLoggedIn()) {
            header('Location: /signin');
            exit;
        }
        $this->userId = $_SESSION['user_id'];
        $this->favoriteProductModel = new FavoriteProduct();
        $this->categoryModel = new FavoriteProductCategory();
    }

    public function index()
    {
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 36; // Sayfa başına 36 ürün
        $offset = ($page - 1) * $limit;

        $products = $this->favoriteProductModel->getPaginatedProducts($this->userId, $categoryId, $limit, $offset);
        $totalProducts = $this->favoriteProductModel->getTotalProductsCount($this->userId, $categoryId);
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getAllByUserId($this->userId);

        // View'a veri gönderme
        require_once __DIR__ . '/../../views/favorite_products/index.php';
    }

    // Kategori Ekleme, Düzenleme, Silme
    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            if (!empty($name)) {
                $this->categoryModel->create($name, $description, $this->userId);
            }
        }
        header('Location: /favorite-products');
    }

    public function updateCategory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            if (!empty($name)) {
                $this->categoryModel->update($id, $name, $description, $this->userId);
            }
        }
        header('Location: /favorite-products');
    }

    public function deleteCategory($id)
    {
        $this->categoryModel->delete($id, $this->userId);
        header('Location: /favorite-products');
    }

    // Ürün Kategori Değiştirme
    public function updateProductCategory($productId)
    {
        if (isset($_POST['category_id'])) {
            $categoryId = (int)$_POST['category_id'];
            $this->favoriteProductModel->updateCategory($productId, $categoryId, $this->userId);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    // Ürün Silme
    public function deleteProduct($productId)
    {
        $this->favoriteProductModel->delete($productId, $this->userId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function detail($productId)
    {
        $product = $this->favoriteProductModel->find($productId, $this->userId);
        // Kategori adı eklenmemişse, kategori adını çek
        if ($product && isset($product['category_id']) && $product['category_id']) {
            $category = $this->categoryModel->getById($product['category_id'], $this->userId);
            $product['category_name'] = $category['name'] ?? null;
        }
        require_once __DIR__ . '/../../views/favorite_products/detail.php';
    }
}