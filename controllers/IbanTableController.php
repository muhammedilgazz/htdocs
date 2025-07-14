<?php

require_once 'C:/xampp/htdocs/models/Iban.php';
require_once 'C:/xampp/htdocs/models/UIHelper.php';
require_once 'C:/xampp/htdocs/config/config.php';

class IbanTableController {
    public function index() {
        $iban_model = new Iban();
        $all_ibans = $iban_model->getAll();
        $my_ibans = [];
        $other_ibans = [];

        foreach ($all_ibans as $iban) {
            if ($iban['account_type'] === 'own') {
                $my_ibans[] = $iban;
            } else {
                $other_ibans[] = $iban;
            }
        }
        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/iban_table/index.php';
    }
}