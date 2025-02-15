<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (!empty($email) && !empty($password)) {
        // Consulta preparada para buscar el usuario
        $stmt = $mysqli->prepare("SELECT id, password FROM USUARIOS WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                
                // Si el usuario quiere ser recordado, guardar en cookies
                if ($remember) {
                    setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 30 días
                }
                
                header('Location: welcome.php');
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "No se encontró una cuenta con ese correo electrónico.";
        }
        
        $stmt->close();
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
