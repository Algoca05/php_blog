<?php
require_once '../../autoload.php';

use config\Database; // Add this line to import the Database class
use models\User;
use controllers\UserController;

$database = new Database(); // Create a new Database instance
$db = $database->getConnection(); // Get the database connection
$userController = new UserController(new User($db)); // Pass the database connection to the User class
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->login(); // Directly call the login method
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - ChatterHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold mb-6 text-center">Inicio de Sesión</h2>
            <form method="post">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Correo Electrónico:</label>
                    <input type="email" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" id="email" name="email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Contraseña:</label>
                    <input type="password" class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded" id="password" name="password" required>
                </div>
                <button type="submit" class="w-full bg-yellow-500 text-black p-2 rounded font-bold">Iniciar Sesión</button>
                <p class="mt-4 text-center">¿No tienes una cuenta? <a href="/blog/views/Auth/register.php" class="text-yellow-500">Regístrate aquí</a></p>
            </form>
        </div>
    </div>
</body>
</html>
