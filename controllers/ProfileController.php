<?php

require_once 'C:/xampp/htdocs/models/Profile.php';

class ProfileController {
    public function index() {
        $profile_model = new Profile();
        $user_id = $_SESSION['user_id'] ?? null; // Assuming user_id is in session

        $user_profile = $profile_model->getUserProfileData($user_id);
        $city_bank_wallet = $profile_model->getWalletData('city_bank');
        $debit_card_wallet = $profile_model->getWalletData('debit_card');
        $visa_card_wallet = $profile_model->getWalletData('visa_card');
        $cash_wallet = $profile_model->getWalletData('cash');

        $city_bank_chart = $profile_model->getChartData('city_bank');
        $debit_card_chart = $profile_model->getChartData('debit_card');
        $visa_card_chart = $profile_model->getChartData('visa_card');
        $cash_chart = $profile_model->getChartData('cash');

        require_once 'C:/xampp/htdocs/views/profile/index.php';
    }
}