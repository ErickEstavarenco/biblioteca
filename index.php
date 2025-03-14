<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pichau\Biblioteca\Controller\BookController;

header('Content-Type: application/json');

try {
    $controller = new BookController();
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_GET['url'] ?? '/';

    if ($url !== '/' && strpos($url, '/') === 0) {
        $url = substr($url, 1);
    }

    switch ($url) {
        case 'book':
            if ($method === 'POST') {
                try {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $id = $controller->createBook($data);
                    echo json_encode(['id' => $id]);
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Erro ao criar livro: ' . $e->getMessage()]);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
            }
            break;
        case '/':
            if ($method === 'GET') {
                echo json_encode($controller->listBooks());
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro geral: ' . $e->getMessage()]);
}

