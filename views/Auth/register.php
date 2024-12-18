<?php
require_once '../../autoload.php';

use config\Database; // Agrega esta línea para importar la clase Database
use models\User;
use controllers\UserController;


$database = new Database(); // Crea una nueva instancia de Database
$db = $database->getConnection(); // Obtén la conexión a la base de datos
$userController = new UserController(new User($db)); // Pasa la conexión de la base de datos a la clase User
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $userController->register(); // Capture errors from the register method
    if (empty($errors)) {
        // Log in the user automatically
        $_SESSION['user_id'] = $userController->getUser()->getId();
        header('Location: /blog/views/home.php'); // Update the redirection URL to home page
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - ChatterHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <?php if (!empty($errors)): ?>
        <div class="absolute top-0 left-0 m-4 p-4 bg-red-500 text-white rounded">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold mb-6 text-center">Registro</h2>
            <form method="post">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Nombre:</label>
                    <input type="text" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" id="name" name="name" required>
                    <?php if (isset($errors['name'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['name'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Correo Electrónico:</label>
                    <input type="email" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" id="email" name="email" required>
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Contraseña:</label>
                    <input type="password" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" id="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="w-full bg-yellow-500 text-black p-2 rounded font-bold">Registrarse</button>
                <p class="mt-4 text-center">¿Ya tienes una cuenta? <a href="/blog/views/Auth/login.php" class="text-yellow-500">Inicia sesión aquí</a></p>
            </form>
        </div>
    </div>
</body>
</html>
