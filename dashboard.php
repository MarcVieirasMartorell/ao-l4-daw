<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    die("<p>Acceso denegado. Inicia sesión primero.</p>");
}

$stmt = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE username = :username");
$stmt->bindParam(":username", $_SESSION['user']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$fotoPerfil = $usuario['foto_perfil'] ? htmlspecialchars($usuario['foto_perfil']) : 'default.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user']) ?></h2>
    <img src="<?= $fotoPerfil ?>" width="150" height="150" alt="Foto de perfil">
    <br>
    <a href="index.php">Volver</a>
</body>
</html>
