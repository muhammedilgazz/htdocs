<?php

namespace App\Core;

use PDO;
use PDOException;

class DatabaseConnection {
    protected $pdo;
    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=budget_db;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getConnection() {
        return $this->pdo;
    }
}