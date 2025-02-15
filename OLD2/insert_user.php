<?php
include 'config.php';
$conn = new mysqli($host, $user, $password, $dbname);
$password_hash = password_hash("clave123", PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $password_hash);
$nombre = "Juan Pérez";
$email = "juan@example.com";
$stmt->execute();
$stmt->close();
$conn->close();
?>