<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController {
    public function index() {
        $task_model = new Task();
        $rows = $task_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/tasks/index.php';
    }
}
