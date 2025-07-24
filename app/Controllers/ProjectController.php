<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectController {
    private $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }

    public function index() {
        $rows = $this->projectModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/projects/index.php';
    }
}
