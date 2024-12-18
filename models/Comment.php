<?php
namespace models;

use PDO;
use models\EliminatedComments;

class Comment {
    private $conn;
    public $id;
    public $post_id;
    public $user_id;
    public $content;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new comment
    public function create($post_id, $user_id, $content) {
        $query = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', $content);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read a comment by ID
    public function read($id) {
        $query = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a comment by ID
    public function update($id, $content) {
        $query = "UPDATE comments SET content = :content WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':content', $content);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a comment by ID
    public function delete($id) {
        // Get the comment before deleting
        $comment = $this->read($id);
        if ($comment) {
            // Save the comment to deleted_comments table
            require_once __DIR__ . '/EliminatedComments.php';
            $eliminatedCommentsModel = new EliminatedComments($this->conn);
            $eliminatedCommentsModel->saveDeletedComment($comment);

            // Delete the comment from comments table
            $query = "DELETE FROM comments WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
        return false;
    }

    // Execute a query
    public function executeQuery($query) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get comments by post_id
    public function getCommentsByPostId($post_id) {
        $query = "SELECT comments.*, users.username AS author FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = :post_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get the last inserted comment
    public function getLastInsertedComment() {
        $query = "SELECT * FROM comments ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
