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

    // GET: Lista todos os livros
    public function listBooks() {
        $stmt = $this->pdo->query("SELECT * FROM livros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // POST: Cria um novo livro
    public function createBook($data) {
        $stmt = $this->pdo->prepare("INSERT INTO books (titulo, autor, isbn, ano_publicacao) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['titulo'], $data['autor'], $data['isbn'], $data['ano_publicacao']]);
        return $this->pdo->lastInsertId();
    }

    // PUT: Atualiza um livro existente
    public function updateBook($data) {
        $stmt = $this->pdo->prepare("UPDATE books SET titulo = ?, autor = ?, isbn = ?, ano_publicacao = ? WHERE id = ?");
        return $stmt->execute([$data['titulo'], $data['autor'], $data['isbn'], $data['ano_publicacao'], $data['id']]);
    }

    // DELETE: Exclui um livro pelo ID
    public function deleteBook($id) {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

