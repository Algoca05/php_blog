<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
</head>
<body>
    <!-- Vista para mostrar y editar el perfil del usuario -->
    <form method="post" action="path_to_update_profile">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" value="<?php echo $user->username; ?>">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $user->email; ?>">
        <!-- Más campos para editar el perfil del usuario -->
        <input type="submit" value="Actualizar Perfil">
    </form>
</body>
</html>