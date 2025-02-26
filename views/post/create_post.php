<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /blog/views/Auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
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
            <h1 class="text-3xl font-bold mb-5">Create a New Post</h1>
            <form action="/blog/controllers/PostController.php?action=create" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="title" class="block text-gray-400">Title:</label>
                    <input type="text" id="title" name="title" required class="w-full p-2 bg-gray-700 text-white rounded">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-400">Content:</label>
                    <textarea id="content" name="content" required class="w-full p-2 bg-gray-700 text-white rounded"></textarea>
                </div>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Create Post</button>
            </form>
        </div>
    </div>
</body>
</html>
