<?php

namespace App\Controllers;

use App\Models\Profile;

class ProfileController {
    private $profileModel;

    public function __construct(Profile $profileModel)
    {
        $this->profileModel = $profileModel;
    }

    public function index() {
        $user_id = $_SESSION['user_id'] ?? null; // Assuming user_id is in session

        if ($user_id) {
            $user_profile = $this->profileModel->getUserProfileData($user_id);
            // Wallet data is no longer directly fetched here as Wallet model is removed
            // You might need to adjust views/profile/index.php accordingly
        } else {
            $user_profile = null;
        }

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/profile/index.php';
    }
}