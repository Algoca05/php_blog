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

    use config\Database;

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Obtener las publicaciones de la base de datos
    $sql = "SELECT id, title, content FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $posts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    ?>
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="#"><span class="text-white">Chatter</span><span class="text-yellow-500">Hub</span></a>
            <div class="flex space-x-4">
                <a class="text-gray-300 hover:text-yellow-500" href="#">Inicio</a>
                <a class="text-gray-300 hover:text-yellow-500" href="#">Contacto</a>
                <a class="text-gray-300 hover:text-yellow-500" href="../Auth/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Bienvenido a ChatterHub</h1>
        <p class="mb-5">Esta es la página de inicio de Mi Blog. Utiliza la barra de navegación para explorar el sitio.</p>
        <section>
            <h2 class="text-2xl font-bold mb-3">Publicaciones Recientes</h2>
            <ul class="list-disc pl-5">
                <?php
                // Asegúrate de que $recentPosts esté definido
                if (!isset($recentPosts) || !is_array($recentPosts)) {
                    $recentPosts = [];
                }
                foreach ($recentPosts as $post): ?>
                    <li class="mb-2">
                        <a href="/post/<?php echo $post['id']; ?>" class="text-yellow-500 hover:underline">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
       
    </div>
</body>
</html>
