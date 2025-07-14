<?php

require_once __DIR__ . '/Database.php';

class Profile {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserProfileData($user_id) {
        // In a real application, this would fetch user data from the database
        // For now, we'll return some dummy data or rely on session data
        return [
            'full_name' => $_SESSION['full_name'] ?? 'John Doe',
            'email' => $_SESSION['email'] ?? 'john.doe@example.com',
            'registered_date' => '25 June 2024',
            'referral_count' => '05'
        ];
    }

    public function getWalletData($wallet_type) {
        // In a real application, this would fetch wallet data from the database
        // For now, return dummy data
        return [
            'spend' => '1458.30',
            'budget' => '1458.30',
            'progress' => '25'
        ];
    }

    public function getChartData($chart_type) {
        // In a real application, this would fetch chart data from the database
        // For now, return dummy data
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [12000, 19000, 15000, 25000, 22000, 30000]
        ];
    }
}
