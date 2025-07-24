<?php

namespace App\Controllers;

use App\Models\AccountCredential;
use App\Models\UIHelper;

class AccountPasswordController {
    private $accountCredentialModel;

    public function __construct(AccountCredential $accountCredentialModel)
    {
        $this->accountCredentialModel = $accountCredentialModel;
    }

    public function index() {
        $rows = $this->accountCredentialModel->getAll();
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/account_passwords/index.php';
    }
}