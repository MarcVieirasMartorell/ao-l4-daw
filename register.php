<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $foto_perfil = NULL;
    if (!empty($_FILES["foto_perfil"]["name"])) {
        $directorio = "uploads/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid() . "_" . basename($_FILES["foto_perfil"]["name"]);
        $rutaArchivo = $directorio . $nombreArchivo;

        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $rutaArchivo)) {
            $foto_perfil = $rutaArchivo;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, foto_perfil) VALUES (:username, :password, :foto)");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":foto", $foto_perfil);
    
    if ($stmt->execute()) {
        echo "Usuario registrado con éxito. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "Error al registrar usuario.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Registro</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="file" name="foto_perfil" accept="image/*">
        <button type="submit">Registrarse</button>
    </form>

    <a href="index.php">Volver</a>
</body>
</html>
