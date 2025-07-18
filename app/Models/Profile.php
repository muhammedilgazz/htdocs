<?php

namespace App\Models;

use App\Models\Database;

class Profile {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserProfileData($user_id) {
        $sql = "SELECT full_name, email, created_at FROM users WHERE id = ?";
        $user_data = $this->db->fetch($sql, [$user_id]);

        if ($user_data) {
            return [
                'full_name' => $user_data['full_name'] ?? 'N/A',
                'email' => $user_data['email'] ?? 'N/A',
                'registered_date' => date('d F Y', strtotime($user_data['created_at'])) ?? 'N/A',
                'referral_count' => '05' // Placeholder, as no referral table exists
            ];
        } else {
            return [
                'full_name' => 'Misafir Kullanıcı',
                'email' => 'misafir@example.com',
                'registered_date' => 'N/A',
                'referral_count' => '00'
            ];
        }
    }

    // Wallet ve Chart verileri için placeholder metodlar (yeni şemada karşılıkları yok)
    public function getWalletData($wallet_type) {
        return [
            'spend' => '0.00',
            'budget' => '0.00',
            'progress' => '0'
        ];
    }

    public function getChartData($chart_type) {
        return [
            'labels' => ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz'],
            'data' => [0, 0, 0, 0, 0, 0]
        ];
    }
}
