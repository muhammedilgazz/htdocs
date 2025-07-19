<?php

namespace App\Controllers;

use App\Models\AccountCredential;
use App\Models\UIHelper;

class AccountPasswordController {
    public function index() {
        $account_credential_model = new AccountCredential();
        $rows = $account_credential_model->getAll();
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/account_passwords/index.php';
    }
}