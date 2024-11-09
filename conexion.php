<?php
// Datos de conexión
$host = 'localhost';
$dbname = 'universe_arcade_db';
$user = 'root';
$password = '';

// Crear conexión
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
