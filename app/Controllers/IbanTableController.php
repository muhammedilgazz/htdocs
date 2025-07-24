<?php

namespace App\Controllers;

use App\Models\BankAccount;
use App\Models\UIHelper;

class IbanTableController {
    private $bankAccountModel;

    public function __construct(BankAccount $bankAccountModel)
    {
        $this->bankAccountModel = $bankAccountModel;
    }

    public function index() {
        $all_accounts = $this->bankAccountModel->getAll();
        $my_accounts = [];
        $other_accounts = [];

        foreach ($all_accounts as $account) {
            if ($account['account_type'] === 'own') {
                $my_accounts[] = $account;
            } else {
                $other_accounts[] = $account;
            }
        }
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/iban_table/index.php';
    }
}