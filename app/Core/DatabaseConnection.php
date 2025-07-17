<?php

namespace App\Core;

use PDO;
use PDOException;

class DatabaseConnection {
    private static $pdo;

    public static function getPDO(): PDO {
        if (self::$pdo === null) {
            if (!defined('DB_HOST')) {
                // This is not ideal, but required for now without a full front controller setup
                require_once __DIR__ . '/../../config/config.php';
            }

            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                // In a real app, you'd have a proper error page
                die("Veritabanı bağlantı hatası. Lütfen logları kontrol edin.");
            }
        }
        return self::$pdo;
    }
}