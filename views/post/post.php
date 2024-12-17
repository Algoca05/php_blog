<?php 
$posts = $posts ?? []; // Ensure $posts is defined and is an array
if (is_array($posts)):
    foreach ($posts as $post): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
        <!-- Más código para mostrar cada post -->
    <?php endforeach;
endif; ?>