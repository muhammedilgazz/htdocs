<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController {
    private $taskModel;

    public function __construct(Task $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function index() {
        $rows = $this->taskModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/tasks/index.php';
    }
}
