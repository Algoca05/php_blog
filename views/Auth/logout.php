<?php
session_start();
session_destroy();
echo "Sesión cerrada exitosamente.";
header("Location: /blog/index.php");
exit();
?>
