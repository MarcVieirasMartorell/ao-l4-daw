<?php

require 'includes/config.php';

// Crear la base de datos si no existe
$mysqli->query("CREATE DATABASE IF NOT EXISTS mi_proyecto");
$mysqli->select_db("mi_proyecto");

// Crear la tabla USUARIOS
$tablaUsuarios = "CREATE TABLE IF NOT EXISTS USUARIOS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($mysqli->query($tablaUsuarios) === TRUE) {
    echo "Tabla USUARIOS creada correctamente.";
} else {
    echo "Error al crear la tabla: " . $mysqli->error;
}

?>
