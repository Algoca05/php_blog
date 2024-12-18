<?php
namespace models;

use PDO;

class EliminatedComments {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Save deleted comment
    public function saveDeletedComment($comment) {
        $query = "INSERT INTO deleted_comments (id, post_id, user_id, content, created_at, deleted_at) VALUES (:id, :post_id, :user_id, :content, :created_at, :deleted_at)";
        $stmt = $this->conn->prepare($query);
        $deletedAt = date('Y-m-d H:i:s');
        $stmt->bindParam(':id', $comment['id']);
        $stmt->bindParam(':post_id', $comment['post_id']);
        $stmt->bindParam(':user_id', $comment['user_id']);
        $stmt->bindParam(':content', $comment['content']);
        $stmt->bindParam(':created_at', $comment['created_at']);
        $stmt->bindParam(':deleted_at', $deletedAt);
        return $stmt->execute();
    }
}
