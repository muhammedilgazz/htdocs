<?php

namespace App\Controllers;

class ReportController {
    public function index() {
        // Tarih aralığına göre ay/yıl belirle
        $today = (int)date('j');
        $year = (int)date('Y');
        $month = (int)date('m');
        if ($today >= 8) {
            // Gelecek ay
            $month++;
            if ($month > 12) {
                $month = 1;
                $year++;
            }
        }
        $month_str = sprintf('%04d-%02d', $year, $month);

        $personal_debt_model = new \App\Models\PersonalDebt();
        $bank_account_model = new \App\Models\BankAccount();
        $expense_model = new \App\Models\Expense();
        $income_model = new \App\Models\Income();
        $wishlist_model = new \App\Models\Wishlist();

        $debts = $personal_debt_model->getByMonth($year, $month);
        foreach ($debts as &$debt) {
            $ibans = $bank_account_model->getByAccountHolder($debt['to_whom'] ?? '');
            $debt['ibans'] = array_column(array_slice($ibans, 0, 2), 'iban_number');
        }
        unset($debt);

        // Sabit giderler
        $fixed_expenses = array_filter($expense_model->getAll('sabit_gider'), function($row) use ($month_str) {
            return strpos($row['date'], $month_str) === 0;
        });
        // Ani, değişken ve ani_ekstra giderler
        $other_expenses = array_merge(
            array_filter($expense_model->getAll('ani_harcama'), function($row) use ($month_str) {
                return strpos($row['date'], $month_str) === 0;
            }),
            array_filter($expense_model->getAll('degisken_gider'), function($row) use ($month_str) {
                return strpos($row['date'], $month_str) === 0;
            }),
            array_filter($expense_model->getAll('ani_ekstra'), function($row) use ($month_str) {
                return strpos($row['date'], $month_str) === 0;
            })
        );

        // Kur bilgisini oku
        $exchange_rate = 1;
        $exchange_rate_file = ROOT_PATH . '/cache/exchange_rate.json';
        if (file_exists($exchange_rate_file)) {
            $json = json_decode(file_get_contents($exchange_rate_file), true);
            if (isset($json['rate']) && $json['rate'] > 0) {
                $exchange_rate = (float)$json['rate'];
            }
        }
        $total_income_tl = $income_model->getTotalTLForMonth($year, $month, $exchange_rate);

        $alinacaklar = $wishlist_model->getAll('ihtiyac');

        // Planlanan Gider ve Açık hesaplama
        $total_fixed = array_sum(array_column($fixed_expenses, 'amount'));
        $total_other = array_sum(array_column($other_expenses, 'amount'));
        $total_alinacak = is_array($alinacaklar) ? array_sum(array_column($alinacaklar, 'price')) : 0;
        $total_debt = array_sum(array_column($debts, 'amount'));
        $planlanan_gider = $total_fixed + $total_other + $total_alinacak + $total_debt;
        $aylik_acik = $total_income_tl - $planlanan_gider;

        // Raporun ait olduğu ay/yıl (hem veri hem başlık için TEK KAYNAK)
        $today = (int)date('j');
        $report_year = (int)date('Y');
        $report_month = (int)date('n');
        if ($today >= 8) {
            $report_month++;
            if ($report_month > 12) {
                $report_month = 1;
                $report_year++;
            }
        }
        $GLOBALS['report_month'] = $report_month;
        $GLOBALS['report_year'] = $report_year;
        require ROOT_PATH . '/views/report/index.php';
    }
} 