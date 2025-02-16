<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mi_base';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $dbExists = $stmt->fetch();

    if ($dbExists) {
        require 'config.php';
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->exec("CREATE DATABASE $dbname");
        $pdo->exec("USE $dbname");

        $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            foto_perfil VARCHAR(255) DEFAULT NULL
        )");
        

        $message = "Base de datos y tabla creadas correctamente. <a href='index.php'>Ir a la página principal</a>";

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Configuración de la Base de Datos</h2>
    <form method="POST">
        <button type="submit">Crear Base de Datos y Tabla</button>
    </form>
    <p><?= $message ?></p>
</body>
</html>
