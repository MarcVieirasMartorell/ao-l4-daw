<?php
include 'config.php';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre LIKE ?");
$buscar = "%Juan%";
$stmt->execute([$buscar]);
$usuarios_assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
$file = fopen("usuarios.txt", "w");
foreach ($usuarios_assoc as $usuario) {
    fwrite($file, "Nombre: " . $usuario['nombre'] . " - Email: " . $usuario['email'] . "\n");
}
fclose($file);
$pdo = null;
?>