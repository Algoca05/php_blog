<?php
namespace controllers;

use models\Post;

class PostController {
    private $postModel;

    public function __construct(Post $post) {
        $this->postModel = $post;
    }

    public function create($title, $content) {
        return $this->postModel->create($title, $content);
    }

    public function read($id) {
        return $this->postModel->read($id);
    }

    public function update($id, $title, $content) {
        return $this->postModel->update($id, $title, $content);
    }

    public function delete($id) {
        return $this->postModel->delete($id);
    }

    public function getAllPosts() {
        $query = "SELECT id, title, content, author_id, created_at FROM posts";
        $result = $this->postModel->executeQuery($query);
        $posts = $result->fetchAll();

        foreach ($posts as &$post) {
            $post['author'] = $this->postModel->getAuthorName($post['author_id']);
        }

        return $posts;
    }
}