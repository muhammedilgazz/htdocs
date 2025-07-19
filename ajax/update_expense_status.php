<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Expense.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $expense_model = new Expense();
    
    $id = (int)$_POST['id'];
    $status = sanitize_input($_POST['status']); // Assuming status is directly passed

    // Validate status against allowed enum values if necessary
    // For 'expenses' table, category_type is an enum, not status.
    // If you meant to update the category_type, the form/JS needs to send that.
    // Assuming 'status' here refers to a conceptual status, not a DB column.
    // If there's no 'status' column in 'expenses' table, this needs re-evaluation.
    // For now, I'll assume you want to update the category_type based on a 'status' input.
    // This is a potential mismatch between old and new schema usage.
    
    // Re-evaluating based on the new schema: 'expenses' table has 'category_type' enum.
    // There is no 'status' column in 'expenses' table.
    // This AJAX call likely needs to be re-purposed or removed if it's for a status that no longer exists.
    
    // Given the context of 'update_expense_status.php', it likely intended to update a status.
    // Since 'expenses' table doesn't have a 'status' column, this file is problematic.
    // I will remove this file as its functionality is not directly supported by the new schema.
    // If a status is needed for expenses, a new column should be added to the 'expenses' table.

    json_response(['success' => false, 'message' => 'Bu işlem yeni veritabanı şemasıyla uyumlu değil. Giderler tablosunda durum sütunu bulunmamaktadır.'], 500);

} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}