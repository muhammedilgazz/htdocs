<?php

namespace App\Controllers;

use App\Models\BankAccount;

class BankAccountController {
    private $bankAccountModel;

    public function __construct(BankAccount $bankAccountModel)
    {
        $this->bankAccountModel = $bankAccountModel;
    }

    public function index() {
        $all_accounts = $this->bankAccountModel->getAll();
        
        $own_accounts = [];
        $other_accounts = [];

        if (is_array($all_accounts)) {
            foreach ($all_accounts as $account) {
                if ($account['account_type'] === 'own') {
                    $own_accounts[] = $account;
                } else {
                    $other_accounts[] = $account;
                }
            }
        }
        
        $csrf_token = generate_csrf_token();
        
        require_once ROOT_PATH . '/views/bank_account/index.php';
    }
}