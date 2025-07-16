<?php

namespace App\Controllers;

use App\Models\Todo;

class TodoListController {
    public function index() {
        $todo_model = new Todo();
        $rows = $todo_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/todo_list/index.php';
    }
}
