<?php
session_start();
session_destroy();
header("Location: index.php");
exit(); // IMPORTANTE: Evita que el script siga ejecutándose

?>
