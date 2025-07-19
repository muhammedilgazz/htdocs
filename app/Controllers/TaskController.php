<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController {
    public function index() {
        $task_model = new Task();
        $rows = $task_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/tasks/index.php';
    }
}
