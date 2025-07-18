<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Interfaces\ExpenseServiceInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    /** @var ExpenseServiceInterface $expenseService */
    $expenseService = $container->get(ExpenseServiceInterface::class);
    
    $id = (int)$_POST['id'];
    $months = $_POST['months'];

    if ($expenseService->postponeExpense($id, $months)) {
        json_response(['success' => true, 'message' => 'Gider başarıyla ertelendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Gider ertelenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}