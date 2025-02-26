<?php
namespace controllers;

use models\Post;
use config\Database;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Post.php';

class PostController {
    private $postModel;

    public function __construct(Post $post) {
        $this->postModel = $post;
    }

    public function create() {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        // Updated: Retrieve user id from the session "user" key.
        $author_id = $_SESSION['user']['id'] ?? null;
        if (!$author_id) {
            die('User not logged in.');
        }
        if ($this->postModel->create($title, $content, $author_id)) {
            header("Location: /blog/views/home/home.php");
            exit();
        } else {
            echo "Error creating post.";
        }
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

// Handle action parameter
if (isset($_GET['action'])) {
    $database = new Database();
    $conn = $database->getConnection();
    $postModel = new Post($conn);
    $postController = new PostController($postModel);

    $action = $_GET['action'];
    if (method_exists($postController, $action)) {
        $postController->$action();
    } else {
        echo "Invalid action.";
    }
}
?>