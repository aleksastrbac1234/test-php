<?php

namespace App\Core;

use PDO;

class Database
{
    private static $pdo;

    public static function get(): PDO
    {
        if (!self::$pdo) {
            $config = require BASE_PATH . '/config/config.php';
            $db = $config['db'];

            self::$pdo = new PDO(
                "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']};charset=utf8mb4",
                $db['username'],
                $db['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$pdo;
    }
}
