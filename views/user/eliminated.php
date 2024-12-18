<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1 || $_SESSION['user']['blocked'] == 1) {
    header("Location: /blog/index.php");
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

use config\Database;
use models\User;

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Obtener todos los usuarios bloqueados
$userModel = new User($conn);
$query = "SELECT * FROM users WHERE blocked = 1 ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$blockedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Bloqueados</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="../home/home.php"><span class="text-white">Chatter</span><span class="text-yellow-500">Hub</span></a>
            <div class="flex space-x-4">
                <a class="text-gray-300 hover:text-yellow-500" href="../home/home.php">Inicio</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../contact/contact.php">Contacto</a>
                <?php if ($_SESSION['user']['role'] == 1): ?>
                    <a class="text-gray-300 hover:text-yellow-500" href="../contact/eliminated.php">Eliminados</a>
                    <a class="text-gray-300 hover:text-yellow-500" href="../user/eliminated.php">Bloqueados</a>
                <?php endif; ?>
                <a class="text-gray-300 hover:text-yellow-500" href="../Auth/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Usuarios Bloqueados</h1>
        <section>
            <h2 class="text-2xl font-bold mb-3">Lista de Usuarios Bloqueados</h2>
            <ul class="list-disc pl-5">
                <?php foreach ($blockedUsers as $user): ?>
                    <div class="mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                        <p class="text-white-400">ID: <?php echo htmlspecialchars($user['id']); ?></p>
                        <p class="text-white-400">Nombre: <?php echo htmlspecialchars($user['username']); ?></p>
                        <p class="text-white-400">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="text-white-400">Fecha de Registro: <?php echo htmlspecialchars($user['created_at']); ?></p>
                        <form method="POST" action="unblock_user.php" class="mt-2">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Desbloquear Usuario</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</body>
</html>
