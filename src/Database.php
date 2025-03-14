<?php

namespace Pichau\Biblioteca;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private static $pdo;

    private function __construct() {
        // Configurações do banco de dados
        $host = 'localhost';
        $dbname = 'biblioteca';
        $user = 'seu_usuario';
        $pass = 'sua_senha';

        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Defina o modo de fetch padrão
        } catch (PDOException $e) {
            throw new \Exception("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    public static function connect(): PDO {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$pdo;
    }

    // Impede a clonagem da classe
    private function __clone() { }

    // Impede a desserialização da classe
    public function __wakeup()
    {
        throw new \Exception("Não é possível desserializar a classe Database.");
    }
}

