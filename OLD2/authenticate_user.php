<?php
include 'config.php';
$conn = new mysqli($host, $user, $password, $dbname);
$email = "juan@example.com";
$password_ingresada = "clave123";
$stmt = $conn->prepare("SELECT password FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (password_verify($password_ingresada, $user['password'])) {
    echo "Autenticación exitosa";
} else {
    echo "Contraseña incorrecta";
}
$stmt->close();
$conn->close();
?>