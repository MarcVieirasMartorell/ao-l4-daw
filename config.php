<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mi_base';

try {
    // Primero nos conectamos al servidor MySQL sin especificar una base de datos
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Verificar si la base de datos existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $dbExists = $stmt->fetch();

    if (!$dbExists) {
        // Si la base de datos no existe, redirigir a setup.php
        header("Location: setup.php");
        exit();
    }

    // Conectarse a la base de datos ya existente
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
