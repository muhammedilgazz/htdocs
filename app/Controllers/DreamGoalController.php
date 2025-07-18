<?php

namespace App\Controllers;

use App\Models\DreamGoal;

class DreamGoalController {
    public function index() {
        $dream_goal_model = new DreamGoal();
        $rows = $dream_goal_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/dream_goals/index.php';
    }
}
