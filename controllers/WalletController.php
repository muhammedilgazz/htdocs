<?php

require_once 'C:/xampp/htdocs/models/Wallet.php';

class WalletController {
    public function index() {
        $wallet_model = new Wallet();

        $city_bank_wallet = $wallet_model->getWalletSummary('city_bank');
        $debit_card_wallet = $wallet_model->getWalletSummary('debit_card');
        $visa_card_wallet = $wallet_model->getWalletSummary('visa_card');
        $cash_wallet = $wallet_model->getWalletSummary('cash');

        $transaction_history = $wallet_model->getTransactionHistory();
        $balance_overtime_data = $wallet_model->getBalanceOvertimeData();

        require_once 'C:/xampp/htdocs/views/wallets/index.php';
    }
}