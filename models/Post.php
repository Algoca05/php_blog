<?php
namespace models;

use \PDO;

class Post {
    private $conn;
    public $id;
    public $title;
    public $content;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new post
    public function create($title, $content, $author_id) {
        $query = "INSERT INTO posts (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read a post by ID
    public function read($id) {
        $query = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a post by ID
    public function update($id, $title, $content) {
        $query = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a post by ID
    public function delete($id) {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function executeQuery($query) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAuthorName($author_id) {
        $query = "SELECT username FROM users WHERE id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['username'] : 'Desconocido';
    }
}