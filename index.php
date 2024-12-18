<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatterHub - Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
        <a class="text-xl font-bold" href="../home/home.php"><span class="text-white">Chatter</span><span class="text-yellow-500">Hub</span></a>
        <div class="flex space-x-4">
                <a class="text-gray-300 hover:text-yellow-500" href="../home/home.php">Inicio</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../contact/contact.php">Contacto</a>
                <a class="text-gray-300 hover:text-yellow-500" href="views/Auth/register.php">Registro</a>
                <a class="text-gray-300 hover:text-yellow-500" href="views/Auth/login.php">Login</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Bienvenido a ChatterHub</h1>
        <p class="mb-5">Esta es la página de inicio de ChatterHub, tu sitio de blogs. Si quieres postear blogs inicia sesion.</p>
        <?php
        require_once __DIR__ . '/config/Database.php';
        require_once __DIR__ . '/controllers/PostController.php';
        require_once __DIR__ . '/models/Post.php';

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
        <section></section>
            <h2 class="text-2xl font-bold mb-3">Publicaciones Recientes</h2>
            <ul class="list-disc pl-5">
            <?php foreach ($posts as $post): ?>
                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <li class="mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                        <p class="text-gray-400"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</body>
</html>
