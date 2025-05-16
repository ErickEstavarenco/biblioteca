<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

    // Trata pré-requisição CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Sem conteúdo
    exit;
}

    switch ($url) {
        case 'book':
            $inputData = json_decode(file_get_contents('php://input'), true);

            if ($method === 'GET') {
                echo json_encode($controller->listBooks());
            } elseif ($method === 'POST') {
                echo json_encode($controller->createBook($inputData));
            } elseif ($method === 'PUT') {
                echo json_encode($controller->updateBook($inputData));
            } elseif ($method === 'DELETE') {
                $id = $inputData['id'] ?? null;
                echo json_encode($controller->deleteBook($id));
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
