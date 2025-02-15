<?php
require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Crear la base de datos
        $pdo->exec("CREATE DATABASE IF NOT EXISTS mi_base");

        // Conectarse a la nueva base de datos
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Crear la tabla usuarios
        $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            profile_picture VARCHAR(255) DEFAULT NULL
        )");

        // Redirigir a index.php para que el usuario pueda empezar a usar la app
        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración</title>
</head>
<body>
    <h2>Configuración de la Base de Datos</h2>
    <form method="POST">
        <button type="submit">Crear Base de Datos y Tabla</button>
    </form>
    <p><?= $message ?></p>
</body>
</html>
