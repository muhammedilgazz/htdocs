<?php

namespace App\Controllers;

use App\Models\DreamGoal;

class DreamGoalController {
    private $dreamGoalModel;

    public function __construct(DreamGoal $dreamGoalModel)
    {
        $this->dreamGoalModel = $dreamGoalModel;
    }

    public function index() {
        $rows = $this->dreamGoalModel->getAll();

        $summary = [
            'personal' => $this->dreamGoalModel->getDreamGoalAmountByOwner('Şahsi'),
            'timdesigners' => $this->dreamGoalModel->getDreamGoalAmountByOwner('Timdesigners'),
            'rentakar' => $this->dreamGoalModel->getDreamGoalAmountByOwner('RentAkar'),
            'total' => $this->dreamGoalModel->getTotalDreamGoalAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/dream_goals/index.php';
    }
}
