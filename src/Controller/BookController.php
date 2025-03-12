<?php

namespace Pichau\Biblioteca\Controller;

use Pichau\Biblioteca\Database;
use Pichau\Biblioteca\Model\Book;
use PDO;

class BookController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function listBooks() {
        $stmt = $this->pdo->query("SELECT * FROM livros");
        $books = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $book = new Book(
                $data['id'],
                $data['titulo'],
                $data['autor'],
                $data['isbn'],
                $data['ano_publicacao']
            );
            $books[] = $book->toArray();
        }
        return $books;
    }

    public function getBookById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM livros WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $book = new Book(
                $data['id'],
                $data['titulo'],
                $data['autor'],
                $data['isbn'],
                $data['ano_publicacao']
            );
            return $book->toArray();
        }
        return null;
    }

    public function createBook($data) {
        $stmt = $this->pdo->prepare("INSERT INTO livros (titulo, autor, isbn, ano_publicacao) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['titulo'], $data['autor'], $data['isbn'], $data['ano_publicacao']]);
        return $this->pdo->lastInsertId();
    }

    public function updateBook($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE livros SET titulo = ?, autor = ?, isbn = ?, ano_publicacao = ? WHERE id = ?");
        $stmt->execute([$data['titulo'], $data['autor'], $data['isbn'], $data['ano_publicacao'], $id]);
        return $stmt->rowCount();
    }

    public function deleteBook($id) {
        $stmt = $this->pdo->prepare("DELETE FROM livros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
