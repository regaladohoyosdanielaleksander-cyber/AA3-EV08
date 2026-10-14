<?php
$host = getenv("DB_HOST") ?: "localhost";
$nombreBaseDatos = getenv("DB_NAME") ?: "sistema_inventario";
$usuario = getenv("DB_USER") ?: "root";
$contrasena = getenv("DB_PASSWORD") ?: "";

$conexion = new PDO(
    "mysql:host={$host};dbname={$nombreBaseDatos};charset=utf8mb4",
    $usuario,
    $contrasena,
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    )
);
?>
