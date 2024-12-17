<?php
namespace models;
class Post {
    private $conn;
    public $id;
    public $title;
    public $content;
    // Propiedades del post (id, title, content, etc.)
    public function __construct($db) {
        $this->conn = $db;
    }
    // Métodos CRUD para los posts
    public function create() {
        // Lógica para crear un post
    }

    public function read() {
        // Lógica para leer un post
    }

    public function update() {
        // Lógica para actualizar un post
    }

    public function delete() {
        // Lógica para eliminar un post
    }
}