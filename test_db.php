<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pichau\Biblioteca\Database;

try {
    $pdo = Database::connect();
    echo "Conexão com o banco de dados estabelecida com sucesso!";
} catch (\Exception $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
}
