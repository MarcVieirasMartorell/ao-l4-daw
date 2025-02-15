<?php
include 'config.php';
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->close();
?>