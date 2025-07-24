<?php

namespace App\Services;

use App\Interfaces\ExpenseRepositoryInterface;
use App\Interfaces\ExpenseServiceInterface;
use DateTime;
use Exception;

class ExpenseService implements ExpenseServiceInterface {
    private $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository) {
        $this->expenseRepository = $expenseRepository;
    }

    public function listAllExpenses(?string $category_type = null): array {
        return $this->expenseRepository->findAll($category_type);
    }

    public function createNewExpense(array $data) {
        // Here you could add validation or other business logic before creating
        return $this->expenseRepository->create($data);
    }

    public function getExpenseById(int $id) {
        return $this->expenseRepository->findById($id);
    }

    public function updateExistingExpense(int $id, array $data): bool {
        // Add validation logic here if needed
        return $this->expenseRepository->update($id, $data);
    }

    public function deleteExpenseById(int $id): bool {
        return $this->expenseRepository->delete($id);
    }

    public function postponeExpense(int $id, $months): bool {
        $expense = $this->getExpenseById($id);
        if (!$expense) {
            return false; // Or throw an exception
        }

        try {
            $current_date = new DateTime($expense['date']);

            if ($months === 'later') {
                // Business logic: 'later' means 10 years in the future
                $current_date->modify('+10 year');
            } else {
                $current_date->modify('+' . (int)$months . ' month');
            }
    
            $update_data = [
                'date' => $current_date->format('Y-m-d'),
                'category_type' => 'ertelenmis'
            ];
    
            return $this->expenseRepository->update($id, $update_data);

        } catch (Exception $e) {
            // Log the exception
            error_log("Error in postponeExpense: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Geriye dönük uyumluluk için: Belirli bir kategori tipine göre giderleri döndürür
     * @param string $category_type
     * @return array
     */
    public function getAllExpensesByType(string $category_type): array {
        return $this->listAllExpenses($category_type);
    }
}