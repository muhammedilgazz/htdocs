<?php
namespace App\Controllers;
use App\Models\Todo;
require_once __DIR__ . '/../Core/DatabaseConnection.php';
require_once __DIR__ . '/../Models/Todo.php';
class TodoController {
    public function index() {
        $db = (new \App\Core\DatabaseConnection())->getConnection();
        $todoModel = new Todo($db);
        $todos = $todoModel->getAll();
        require ROOT_PATH . '/views/todo_list/index.php';
    }
} 