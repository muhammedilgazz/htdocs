<?php

namespace App\Repositories;

use App\Interfaces\ExpenseRepositoryInterface;
use PDO;

class ExpenseRepository implements ExpenseRepositoryInterface {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(array $data) {
        $sql = "INSERT INTO expenses (amount, category_type, description, date) VALUES (:amount, :category_type, :description, :date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':amount' => $data['amount'],
            ':category_type' => $data['category_type'],
            ':description' => $data['description'] ?? null,
            ':date' => $data['date'] ?? date('Y-m-d')
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        // Dynamically build the SET part of the query
        $set_parts = [];
        $params = ['id' => $id];
        foreach ($data as $key => $value) {
            $set_parts[] = "$key = :$key";
            $params[$key] = $value;
        }
        $set_sql = implode(', ', $set_parts);

        if (empty($set_sql)) {
            return false; // Nothing to update
        }

        $sql = "UPDATE expenses SET $set_sql WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM expenses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findById(int $id) {
        $sql = "SELECT * FROM expenses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findAll(?string $category_type = null): array {
        $sql = "SELECT * FROM expenses";
        $params = [];
        if ($category_type) {
            $sql .= " WHERE category_type = ?";
            $params[] = $category_type;
        }
        $sql .= " ORDER BY date DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getMonthlyTotal(string $month): float {
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$month]);
        $result = $stmt->fetch();
        return (float) ($result['total'] ?? 0.0);
    }
}