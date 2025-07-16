<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectController {
    public function index() {
        $project_model = new Project();
        $rows = $project_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/projects/index.php';
    }
}
