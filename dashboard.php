<?php
require 'config.php';
session_start(); 
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirigir a login si no hay sesión
    exit();
}

$stmt = $pdo->prepare("SELECT id, username, profile_picture FROM usuarios WHERE username = ?");
$stmt->execute([$_SESSION['user']]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

echo "<h2>Bienvenido, {$user->username}</h2>";
echo "<p>Tu ID de usuario es: {$user->id}</p>";

if ($user->profile_picture) {
    echo "<img src='{$user->profile_picture}' alt='Imagen de perfil' width='150'>";
} else {
    echo "<p>No tienes imagen de perfil.</p>";
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
</head>
<body>
    <h2>Bienvenido, <?= $_SESSION['user'] ?></h2>
    <a href="index.php">Volver</a>
</body>
</html>
