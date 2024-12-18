<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/CommentController.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../models/Post.php';

use config\Database;
use controllers\CommentController;
use models\Comment;
use models\Post;

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Inicializar el controlador de comentarios
$commentModel = new Comment($conn);
$commentController = new CommentController($commentModel);

// Crear un post especial para el chat si no existe
$postModel = new Post($conn);
$chatPost = $postModel->read(1); // Usar un ID específico para el post del chat
if (!$chatPost) {
    $postModel->create('Chat', 'Este es el post para el chat.');
    $chatPost = $postModel->read(1);
}

// Manejar el envío de nuevos comentarios
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['content']) && trim($data['content']) !== '') {
    $user_id = $_SESSION['user']['id'];
    $content = $data['content'];
    if ($commentController->create($chatPost['id'], $user_id, $content)) {
        $comment = $commentModel->getLastInsertedComment();
        $comment['author'] = $_SESSION['user']['username'];
        echo json_encode(['success' => true, 'comment' => $comment]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear el comentario']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Contenido no proporcionado o vacío']);
}
?>
