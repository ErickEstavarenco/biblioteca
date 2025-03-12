<?php

namespace Pichau\Biblioteca;

use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function connect() {
        if (!isset(self::$pdo)) {
            try {
                $host = 'localhost';
                $dbname = 'biblioteca';
                $username = 'root';
                $password = '';

                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro de conexão com o banco de dados: " . $e->getMessage();
                die();
            }
        }
        return self::$pdo;
    }
}
