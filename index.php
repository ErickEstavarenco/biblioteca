<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pichau\Biblioteca\Controller\BookController;

header('Content-Type: application/json');

try {
    $controller = new BookController();
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_GET['url'] ?? '';

    if ($url !== '' && strpos($url, '/') === 0) {
        $url = substr($url, 1);
    }

    switch ($url) {
        case 'book':
            switch ($method) {
                case 'GET':
                    echo json_encode($controller->listBooks());
                    break;
                
                case 'POST':
                    try {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $id = $controller->createBook($data);
                        echo json_encode(['id' => $id]);
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['error' => 'Erro ao criar livro: ' . $e->getMessage()]);
                    }
                    break;
                
                case 'PUT':
                    try {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $updated = $controller->updateBook($data);
                        echo json_encode(['updated' => $updated]);
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['error' => 'Erro ao atualizar livro: ' . $e->getMessage()]);
                    }
                    break;

                case 'DELETE':
                    try {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $deleted = $controller->deleteBook($data['id']);
                        echo json_encode(['deleted' => $deleted]);
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['error' => 'Erro ao deletar livro: ' . $e->getMessage()]);
                    }
                    break;
                
                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Method Not Allowed']);
                    break;
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
