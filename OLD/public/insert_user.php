<?php

require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertar el usuario en la base de datos con una consulta preparada
        $stmt = $mysqli->prepare("INSERT INTO USUARIOS (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Todos los campos son obligatorios.";
    }
}

?>