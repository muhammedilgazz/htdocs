<?php

/**
 * Currency Helper Functions
 */

/**
 * Convert amount to TL using current exchange rates
 * @param float $amount
 * @param string $currency
 * @return float
 */
function convertToTL($amount, $currency) {
    if ($currency == 'TRY') {
        return $amount;
    }
    
    $exchange_data = json_decode(file_get_contents(ROOT_PATH . '/cache/exchange_rate.json'), true);
    $usd_rate = $exchange_data['rate'] ?? 40.4;
    
    switch ($currency) {
        case 'USD':
            return $amount * $usd_rate;
        case 'EUR':
            return $amount * ($usd_rate * 0.92); // EUR/USD yaklaşık 0.92
        case 'GBP':
            return $amount * ($usd_rate * 0.79); // GBP/USD yaklaşık 0.79
        default:
            return $amount;
    }
}

/**
 * Format amount with currency display
 * @param float $amount
 * @param string $currency
 * @return string
 */
function formatAmountWithCurrency($amount, $currency) {
    if ($currency == 'TRY') {
        return '₺' . number_format($amount, 2, ',', '.');
    }
    
    $tl_amount = convertToTL($amount, $currency);
    $currency_symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£'
    ];
    
    $symbol = $currency_symbols[$currency] ?? $currency;
    return number_format($amount, 2, ',', '.') . ' ' . $currency . '<br><small class="text-muted">₺' . number_format($tl_amount, 2, ',', '.') . '</small>';
}

/**
 * Get total amount in TL from array of incomes
 * @param array $incomes
 * @return float
 */
function getTotalInTL($incomes) {
    $total = 0;
    foreach ($incomes as $income) {
        $total += convertToTL($income['amount'], $income['currency']);
    }
    return $total;
} 