<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    header("Location: /blog/index.php");
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

use config\Database;
use models\User;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Bloquear al usuario
    $userModel = new User($conn);
    $query = "UPDATE users SET blocked = 1 WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Usuario bloqueado exitosamente.";
    } else {
        $_SESSION['message'] = "Error al bloquear al usuario.";
    }

    header("Location: eliminated.php");
    exit();
} else {
    header("Location: eliminated.php");
    exit();
}
?>
