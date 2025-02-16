<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE username = ?");
    if ($stmt->execute([$_SESSION['user']])) {
        session_destroy();
        echo "<p>Usuario eliminado correctamente.</p>";
    } else {
        echo "<p>Error al eliminar usuario.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Cuenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Eliminar Cuenta</h2>
    <form method="POST">
        <button type="submit">Eliminar mi cuenta</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>
