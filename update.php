<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $newUsername = $_POST['new_username'];
    $stmt = $pdo->prepare("UPDATE usuarios SET username = ? WHERE username = ?");
    if ($stmt->execute([$newUsername, $_SESSION['user']])) {
        $_SESSION['user'] = $newUsername;
        echo "<p>Usuario actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar usuario.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuario</title>
</head>
<body>
    <h2>Actualizar Usuario</h2>
    <form method="POST">
        <input type="text" name="new_username" placeholder="Nuevo nombre de usuario" required><br>
        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>
