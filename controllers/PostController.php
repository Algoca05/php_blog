<?php
namespace controllers;

use models\Post;

class PostController {
    private $postModel;

    public function __construct(Post $post) {
        $this->postModel = $post;
    }

    public function create() {
        // Lógica para crear un post
        // ...existing code...
    }

    public function read() {
        // Lógica para leer un post
        // ...existing code...
    }

    public function update() {
        // Lógica para actualizar un post
        // ...existing code...
    }

    public function delete() {
        // Lógica para eliminar un post
        // ...existing code...
    }
}