<?php

require_once 'C:/xampp/htdocs/models/Account.php';
require_once 'C:/xampp/htdocs/models/UIHelper.php';
require_once 'C:/xampp/htdocs/config/config.php';

class AccountPasswordController {
    public function index() {
        $account_model = new Account();
        $rows = $account_model->getAll();
        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/account_passwords/index.php';
    }
}