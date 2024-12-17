<?php
namespace models;
class Comment {
    private $conn;
    public $id;
    public $post_id;
    public $content;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        // Lógica para crear un comentario
    }

    public function read() {
        // Lógica para leer un comentario
    }

    public function update() {
        // Lógica para actualizar un comentario
    }

    public function delete() {
        // Lógica para eliminar un comentario
    }
}
