<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Database {
    private static $instance = null;
    private $pdo;
    private $cache = [];
    
    private function __construct() {
        // Ensure config.php is loaded to access DB constants
        if (!defined('DB_HOST')) {
            require_once __DIR__ . '/../config/config.php';
        }

        $host = DB_HOST;
        $dbname = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;
        
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch(PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Veritabanı bağlantı hatası");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getPdo() {
        return $this->pdo;
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetchAll($sql, $params = [], $cache_key = null) {
        if ($cache_key && isset($this->cache[$cache_key])) {
            return $this->cache[$cache_key];
        }
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Base table or view not found') !== false) {
                return false;
            }
            throw $e;
        }
        
        if ($cache_key) {
            $this->cache[$cache_key] = $result;
        }
        
        return $result;
    }
    
    public function fetch($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    public function getDbValue($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    public function fetchColumn($sql, $params = []) {
        return $this->getDbValue($sql, $params);
    }
    
    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }
    
    public function commit() {
        return $this->pdo->commit();
    }
    
    public function rollback() {
        return $this->pdo->rollback();
    }
}