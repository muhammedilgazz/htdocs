<?php

namespace App\Controllers;

use App\Models\Todo;
use App\Models\Database; // Database sınıfını dahil et

class TodoListController {
    public function index() {
        $db = Database::getInstance(); // Veritabanı bağlantı nesnesini al
        $todo_model = new Todo($db); // Todo modelini veritabanı nesnesiyle başlat
        $rows = $todo_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/todo_list/index.php';
    }
}
