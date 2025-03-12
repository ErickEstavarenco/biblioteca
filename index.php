<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pichau\Biblioteca\Controller\BookController;

header('Content-Type: application/json');

$controller = new BookController();
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

try {
    switch ($path) {
        case '/':
            if ($method === 'GET') {
                echo json_encode($controller->listBooks());
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
            }
            break;
        case '/book':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $id = $controller->createBook($data);
                echo json_encode(['id' => $id]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
            }
            break;
        default:
            if (preg_match('/\/book\/(\d+)/', $path, $matches)) {
                $id = (int) $matches[1];
                switch ($method) {
                    case 'GET':
                        $book = $controller->getBookById($id);
                        if ($book) {
                            echo json_encode($book);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Book Not Found']);
                        }
                        break;
                    case 'PUT':
                        $data = json_decode(file_get_contents('php://input'), true);
                        $result = $controller->updateBook($id, $data);
                        if ($result > 0) {
                            echo json_encode(['updated' => true]);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Book Not Found']);
                        }
                        break;
                    case 'DELETE':
                        $result = $controller->deleteBook($id);
                        if ($result > 0) {
                            echo json_encode(['deleted' => true]);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Book Not Found']);
                        }
                        break;
                    default:
                        http_response_code(405);
                        echo json_encode(['error' => 'Method Not Allowed']);
                        break;
                }
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not Found']);
            }
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}


