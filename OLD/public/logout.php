<?php
session_start();

// Destruir la sesión y redirigir al usuario al login
session_destroy();
header('Location: login.php');
exit();
?>
