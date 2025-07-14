<?php

require_once __DIR__ . '/Database.php';

class Wallet {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getWalletSummary($wallet_type) {
        // This is placeholder data. In a real application, this would query the database.
        $data = [
            'city_bank' => [
                'total_balance' => '221,478',
                'personal_funds' => '32,500.28',
                'credit_limits' => '2500.00',
                'card_number' => '1234 5678 7890 9875',
                'card_holder' => 'Saiful Islam',
                'exp_date' => '12/21',
                'status' => 'Active',
                'currency' => 'USD',
                'credit_limit_amount' => '2000'
            ],
            'debit_card' => [
                'total_balance' => '221,478',
                'personal_funds' => '32,500.28',
                'credit_limits' => '2500.00',
                'card_number' => '1234 5678 7890 9875',
                'card_holder' => 'Saiful Islam',
                'exp_date' => '12/21',
                'status' => 'Active',
                'currency' => 'USD',
                'credit_limit_amount' => '2000'
            ],
            'visa_card' => [
                'total_balance' => '221,478',
                'personal_funds' => '32,500.28',
                'credit_limits' => '2500.00',
                'card_number' => '1234 5678 7890 9875',
                'card_holder' => 'Saiful Islam',
                'exp_date' => '12/21',
                'status' => 'Active',
                'currency' => 'USD',
                'credit_limit_amount' => '2000'
            ],
            'cash' => [
                'total_balance' => '221,478',
                'personal_funds' => '32,500.28',
                'credit_limits' => '2500.00',
                'card_number' => '1234 5678 7890 9875',
                'card_holder' => 'Saiful Islam',
                'exp_date' => '12/21',
                'status' => 'Active',
                'currency' => 'USD',
                'credit_limit_amount' => '2000'
            ]
        ];
        return $data[$wallet_type] ?? [];
    }

    public function getTransactionHistory() {
        // This is placeholder data. In a real application, this would query the database.
        return [
            ['category' => 'Beauty', 'date' => '12.12.2023', 'description' => 'Grocery Items and Beverage soft drinks', 'amount' => '-32.20', 'currency' => 'USD'],
            ['category' => 'Bills & Fees', 'date' => '12.12.2023', 'description' => 'Grocery Items and Beverage soft drinks', 'amount' => '-32.20', 'currency' => 'USD'],
            ['category' => 'Car', 'date' => '12.12.2023', 'description' => 'Grocery Items and Beverage soft drinks', 'amount' => '-32.20', 'currency' => 'USD'],
            ['category' => 'Education', 'date' => '12.12.2023', 'description' => 'Grocery Items and Beverage soft drinks', 'amount' => '-32.20', 'currency' => 'USD'],
            ['category' => 'Entertainment', 'date' => '12.12.2023', 'description' => 'Grocery Items and Beverage soft drinks', 'amount' => '-32.20', 'currency' => 'USD'],
        ];
    }

    public function getBalanceOvertimeData() {
        // This is placeholder data. In a real application, this would query the database.
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [12000, 19000, 15000, 25000, 22000, 30000]
        ];
    }
}
