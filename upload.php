<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    die("Acceso denegado. Inicia sesión primero.");
}

$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $file_name = uniqid() . "_" . basename($file["name"]);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file["tmp_name"], $file_path)) {
        // Guardar la ruta de la imagen en la base de datos
        $stmt = $pdo->prepare("UPDATE usuarios SET profile_picture = ? WHERE username = ?");
        if ($stmt->execute([$file_path, $_SESSION['user']])) {
            echo "Imagen subida y guardada en el perfil.";
        } else {
            echo "Error al guardar la imagen en la base de datos.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
</head>
<body>
    <h2>Subir Imagen de Perfil</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_picture" required>
        <button type="submit">Subir</button>
    </form>
</body>
</html>
