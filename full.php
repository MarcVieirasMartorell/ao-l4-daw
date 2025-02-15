<?php
// config.php - Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'mi_base';
$username = 'root';
$password = '';

// Conexión con MySQLi
$mysqli = new mysqli($host, $username, $password);
if ($mysqli->connect_error) {
    die("Error de conexión MySQLi: " . $mysqli->connect_error);
}

// Crear base de datos si no existe
$mysqli->query("CREATE DATABASE IF NOT EXISTS mi_base");
$mysqli->close();

// Conexión con PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}

// setup.php - Creación de la tabla USUARIOS
$pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)");

echo "Base de datos y tabla configuradas correctamente.";

// register.php - Registro de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar usuario.";
    }
}

// login.php - Inicio de sesión
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        echo "Inicio de sesión exitoso.";
    } else {
        echo "Credenciales incorrectas.";
    }
}

// dashboard.php - Panel de usuario
if (!isset($_SESSION['user'])) {
    die("Acceso denegado. Inicia sesión primero.");
}
echo "Bienvenido, " . $_SESSION['user'];

// update.php - Actualizar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $newUsername = $_POST['new_username'];
    $stmt = $pdo->prepare("UPDATE usuarios SET username = ? WHERE username = ?");
    if ($stmt->execute([$newUsername, $_SESSION['user']])) {
        $_SESSION['user'] = $newUsername;
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar usuario.";
    }
}

// delete.php - Eliminar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE username = ?");
    if ($stmt->execute([$_SESSION['user']])) {
        session_destroy();
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar usuario.";
    }
}

// search.php - Búsqueda de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $search = "%" . $_GET['query'] . "%";
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username LIKE ?");
    $stmt->execute([$search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}

// logout.php - Cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    echo "Sesión cerrada correctamente.";
}
