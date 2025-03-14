<?php

namespace Pichau\Biblioteca\Controller;

use Pichau\Biblioteca\Database;
use Pichau\Biblioteca\Model\Book;
use PDO;
use Exception;

class BookController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    // 🔹 LISTAR TODOS OS LIVROS (GET)
    public function listBooks() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM livros");
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $books;
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Erro ao buscar livros: ' . $e->getMessage()];
        }
    }

    // 🔹 CRIAR UM NOVO LIVRO (POST)
    public function createBook($data) {
        if (!isset($data['titulo'], $data['autor'], $data['isbn'], $data['ano_publicacao'], $data['preco'])) {
            http_response_code(400);
            return ['error' => 'Todos os campos são obrigatórios'];
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO livros (titulo, autor, isbn, ano_publicacao, preco) VALUES (:titulo, :autor, :isbn, :ano_publicacao, :preco)");
            $stmt->execute([
                ':titulo' => $data['titulo'],
                ':autor' => $data['autor'],
                ':isbn' => $data['isbn'],
                ':ano_publicacao' => $data['ano_publicacao'],
                ':preco' => $data['preco']
            ]);
            return ['id' => $this->pdo->lastInsertId()];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Erro ao criar livro: ' . $e->getMessage()];
        }
    }

    // 🔹 ATUALIZAR UM LIVRO (PUT)
    public function updateBook($data) {
        $id = $data['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            return ['error' => 'ID do livro é obrigatório'];
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE livros SET titulo = :titulo, autor = :autor, isbn = :isbn, ano_publicacao = :ano_publicacao, preco = :preco WHERE id = :id");
            $stmt->execute([
                ':id' => $id,
                ':titulo' => $data['titulo'],
                ':autor' => $data['autor'],
                ':isbn' => $data['isbn'],
                ':ano_publicacao' => $data['ano_publicacao'],
                ':preco' => $data['preco']
            ]);

            return ['message' => 'Livro atualizado com sucesso'];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Erro ao atualizar livro: ' . $e->getMessage()];
        }
    }

    // 🔹 DELETAR UM LIVRO (DELETE)
    public function deleteBook($id) {
        if (!$id) {
            http_response_code(400);
            return ['error' => 'ID do livro é obrigatório'];
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM livros WHERE id = :id");
            $stmt->execute([':id' => $id]);

            return ['message' => 'Livro deletado com sucesso'];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Erro ao deletar livro: ' . $e->getMessage()];
        }
    }
}


