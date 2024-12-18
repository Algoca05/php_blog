<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    header("Location: /blog/index.php");
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/EliminatedComments.php';

use config\Database;
use models\EliminatedComments;

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Obtener todos los comentarios eliminados
$eliminatedCommentsModel = new EliminatedComments($conn);
$query = "SELECT * FROM deleted_comments ORDER BY deleted_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$deletedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="../home/home.php"><span class="text-white">Chatter</span><span class="text-yellow-500">Hub</span></a>
            <div class="flex space-x-4">
                <a class="text-gray-300 hover:text-yellow-500" href="../home/home.php">Inicio</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../contact/contact.php">Contacto</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../Auth/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Comentarios Eliminados</h1>
        <section>
            <h2 class="text-2xl font-bold mb-3">Historial de Comentarios Eliminados</h2>
            <ul class="list-disc pl-5">
                <?php foreach ($deletedComments as $comment): ?>
                    <div class="mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                        <p class="text-white-400"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <small class="text-gray-500">Usuario ID: <?php echo htmlspecialchars($comment['user_id']); ?> | Fecha de Creación: <?php echo htmlspecialchars($comment['created_at']); ?> | Fecha de Eliminación: <?php echo htmlspecialchars($comment['deleted_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</body>
</html>
