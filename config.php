<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mi_base';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $dbExists = $stmt->fetch();

    if (!$dbExists) {
        sleep(1); 
    
        $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
        $dbExists = $stmt->fetch();
    
        if (!$dbExists) {
            if (basename($_SERVER['PHP_SELF']) !== 'setup.php') {
                die("La base de datos no existe. <a href='setup.php'>Haz clic aquí para configurarla.</a>");
            }
        }
        
        
        
    }
    

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
