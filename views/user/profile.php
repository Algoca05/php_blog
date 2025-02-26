<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <?php
    session_start();
    require_once __DIR__ . '/../../config/Database.php';
    require_once __DIR__ . '/../../models/User.php';

    use config\Database;
    use models\User;

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Obtener el usuario actual
    $userModel = new User($conn);
    $user = $userModel->getUserById($_SESSION['user']['id']);
    ?>
    <div class="flex">
        <nav class="bg-gray-800 w-64 min-h-screen p-4 shadow-md fixed">
            <div class="flex flex-col space-y-4">
                <a class="text-xl font-bold" href="../home/home.php"><span class="text-white">Chatter</span><span class="text-yellow-500">Hub</span></a>
                <a class="text-gray-300 hover:text-yellow-500" href="../home/home.php">Inicio</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../contact/contact.php">Contacto</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../user/profile.php">Perfil</a> 
                <a class="text-gray-300 hover:text-yellow-500" href="../post/create_post.php">Crear Post</a>
                <?php if ($_SESSION['user']['role'] == 1): ?>
                    <a class="text-gray-300 hover:text-yellow-500" href="../contact/eliminated.php">Eliminados</a>
                    <a class="text-gray-300 hover:text-yellow-500" href="../user/eliminated.php">Bloqueados</a>
                <?php endif; ?>
                <a class="text-gray-300 hover:text-yellow-500" href="../Auth/logout.php">Cerrar Sesión</a>
            </div>
        </nav>
        <div class="ml-64 container mx-auto mt-10 px-4">
            <h1 class="text-3xl font-bold mb-5">Perfil del Usuario</h1>
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
                    <form method="post" action="/blog/controllers/UserController.php?action=updateProfile">
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium">Nombre de usuario:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium">Correo electrónico:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" required>
                        </div>
                        <!-- Más campos para editar el perfil del usuario -->
                        <button type="submit" class="w-full bg-yellow-500 text-black p-2 rounded font-bold">Actualizar Perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>