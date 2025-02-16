<?php
require 'config.php';

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $search = "%" . $_GET['query'] . "%";

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT username, foto_perfil FROM usuarios WHERE username LIKE ?");
    $stmt->bind_param("s", $search); // "s" INDICA QUE EL PARAMETRO ES UN STRING.
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Buscar Usuario</h2>
    <form method="GET">
        <input type="text" name="query" placeholder="Buscar usuario" required>
        <button type="submit">Buscar</button>
    </form>
    <ul>
        <?php if (!empty($results)) {
            foreach ($results as $user) {
                $fotoPerfil = $user['foto_perfil'] ? htmlspecialchars($user['foto_perfil']) : 'default.png';
                echo "<li>
                        <img src='$fotoPerfil' width='50' height='50' alt='Foto de perfil'>
                        " . htmlspecialchars($user['username']) . "
                      </li>";
            }
        } ?>
    </ul>
    <a href="index.php">Volver</a>
</body>
</html>
