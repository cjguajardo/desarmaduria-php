<?php
$servername = "mysqldb";
$username = "root";
$password = "csEPvC9ybfXCp9Eq";
$database = "desarmaduria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


