<?php

require_once 'C:/xampp/htdocs/models/DreamGoal.php';

class DreamGoalController {
    public function index() {
        $dream_goal_model = new DreamGoal();
        $rows = $dream_goal_model->getAll();

        require_once 'C:/xampp/htdocs/views/dream_goals/index.php';
    }
}