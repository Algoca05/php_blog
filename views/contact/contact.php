<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['blocked'] == 1) {
    header("Location: /blog/index.php");
    exit();
}

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/CommentController.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../models/Post.php';

use config\Database;
use controllers\CommentController;
use models\Comment;
use models\Post;

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Inicializar el controlador de comentarios
$commentModel = new Comment($conn);
$commentController = new CommentController($commentModel);

// Crear un post especial para el chat si no existe
$postModel = new Post($conn);
$chatPost = $postModel->read(1); // Usar un ID específico para el post del chat
if (!$chatPost) {
    $postModel->create('Chat', 'Este es el post para el chat.');
    $chatPost = $postModel->read(1);
}

// Obtener todos los comentarios
$comments = $commentController->getAllComments($chatPost['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Chat</title>
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
        <h1 class="text-3xl font-bold mb-5">Chat de la Comunidad</h1>
        <div class="mb-5">
            <form id="commentForm">
                <textarea name="content" id="content" rows="3" class="w-full p-2 bg-gray-800 text-white rounded-lg" placeholder="Escribe tu mensaje..."></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-yellow-500 text-white rounded-lg">Enviar</button>
            </form>
        </div>
        <section>
            <h2 class="text-2xl font-bold mb-3">Mensajes Recientes</h2>
            <ul id="commentsList" class="list-disc pl-5">
                <?php foreach ($comments as $comment): ?>
                    <div class="mb-6 p-4 bg-gray-800 rounded-lg shadow-md" data-comment-id="<?php echo $comment['id']; ?>">
                        <p class="text-white-400"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <small class="text-gray-500">Usuario: <?php echo htmlspecialchars($comment['author']); ?> | Fecha: <?php echo htmlspecialchars($comment['created_at']); ?></small>
                        <?php if ($comment['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] == 1): ?>
                            <button class="delete-comment mt-2 px-4 py-2 bg-red-500 text-white rounded-lg">Eliminar</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
    </div>

    <script>
        document.getElementById('commentForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const content = document.getElementById('content').value.trim();
            if (content === '') {
                alert('El mensaje no puede estar vacío');
                return;
            }
            const response = await fetch('submit_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: content })
            });
            const result = await response.json();
            if (result.success) {
                const commentsList = document.getElementById('commentsList');
                const newComment = document.createElement('div');
                newComment.classList.add('mb-6', 'p-4', 'bg-gray-800', 'rounded-lg', 'shadow-md');
                newComment.setAttribute('data-comment-id', result.comment.id);
                newComment.innerHTML = `
                    <p class="text-white-400">${result.comment.content}</p>
                    <small class="text-gray-500">Usuario: ${result.comment.author} | Fecha: ${result.comment.created_at}</small>
                    <button class="delete-comment mt-2 px-4 py-2 bg-red-500 text-white rounded-lg">Eliminar</button>
                `;
                commentsList.prepend(newComment);
                document.getElementById('content').value = '';
            } else {
                alert(result.message || 'Error al enviar el comentario');
            }
        });

        document.getElementById('commentsList').addEventListener('click', async function(event) {
            if (event.target.classList.contains('delete-comment')) {
                const commentElement = event.target.closest('[data-comment-id]');
                const commentId = commentElement.getAttribute('data-comment-id');
                try {
                    const response = await fetch('delete_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: commentId })
                    });
                    const result = await response.json();
                    if (result.success) {
                        commentElement.remove();
                    } else {
                        alert(result.message || 'Error al eliminar el comentario');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al eliminar el comentario');
                }
            }
        });
    </script>
</body>
</html>