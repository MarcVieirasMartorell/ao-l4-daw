<?php

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'mi_proyecto';
$username = 'root';
$password = '';

// Conexión con MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Error de conexión MySQLi: " . $mysqli->connect_error);
}

// Conexión con PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}

?>
