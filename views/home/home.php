<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['blocked'] == 1) {
    header("Location: /blog/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <?php
    require_once __DIR__ . '/../../config/Database.php';
    require_once __DIR__ . '/../../controllers/PostController.php';
    require_once __DIR__ . '/../../models/Post.php';

    use config\Database;
    use controllers\PostController;
    use models\Post;

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Obtener las publicaciones de la base de datos
    $postModel = new Post($conn);
    $postController = new PostController($postModel);
    $posts = $postController->getAllPosts();
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
            <h1 class="text-3xl font-bold mb-5">Bienvenido a ChatterHub, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>
            <p class="mb-5">Esta es la página de inicio de Mi Blog.</p>
            <section>
                <h2 class="text-2xl font-bold mb-3">Publicaciones Recientes</h2>
                <ul class="list-disc pl-5">
                    <?php foreach ($posts as $post): ?>
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <li class="mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                            <p class="text-gray-400"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <small class="text-gray-500">Autor: <?php echo htmlspecialchars($post['author']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
