<?php

namespace Pichau\Biblioteca\Model;

class Book {
    private $id;
    private $titulo;
    private $autor;
    private $isbn;
    private $ano_publicacao;
    private $preco;

    public function __construct($id, $titulo, $autor, $isbn, $ano_publicacao, $preco) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->ano_publicacao = $ano_publicacao;
        $this->preco = $preco;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'isbn' => $this->isbn,
            'ano_publicacao' => $this->ano_publicacao,
            'preco' => $this->preco
        ];
    }
}






