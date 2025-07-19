<?php

namespace App\Controllers;

use App\Models\Profile;

class ProfileController {
    public function index() {
        $profile_model = new Profile();
        $user_id = $_SESSION['user_id'] ?? null; // Assuming user_id is in session

        $user_profile = $profile_model->getUserProfileData($user_id);
        // Wallet data is no longer directly fetched here as Wallet model is removed
        // You might need to adjust views/profile/index.php accordingly

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/profile/index.php';
    }
}