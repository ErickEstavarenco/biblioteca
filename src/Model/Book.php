<?php

namespace Pichau\Biblioteca\Model;

class Book {
    public $id;
    public $titulo;
    public $autor;
    public $isbn;
    public $ano_publicacao;

    public function __construct($id = null, $titulo, $autor, $isbn, $ano_publicacao) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->ano_publicacao = $ano_publicacao;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'isbn' => $this->isbn,
            'ano_publicacao' => $this->ano_publicacao
        ];
    }
}




