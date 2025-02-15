<?php
require 'config.php';

// Conexión con MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Error de conexión MySQLi: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $search = "%" . $mysqli->real_escape_string($_GET['query']) . "%";
    $stmt = $mysqli->prepare("SELECT id, username FROM usuarios WHERE username LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Usuario</title>
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
                echo "<li>" . htmlspecialchars($user['username']) . "</li>";
            }
        } ?>
    </ul>
    <a href="index.php">Volver</a>
</body>
</html>
