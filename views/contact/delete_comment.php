<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/CommentController.php';
require_once __DIR__ . '/../../models/Comment.php';

use config\Database;
use controllers\CommentController;
use models\Comment;

try {
    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Inicializar el controlador de comentarios
    $commentModel = new Comment($conn);
    $commentController = new CommentController($commentModel);

    // Manejar la eliminación de comentarios
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $comment = $commentController->read($data['id']);
        if ($comment && ($comment['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1)) {
            if ($commentController->delete($data['id'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el comentario']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
?>
