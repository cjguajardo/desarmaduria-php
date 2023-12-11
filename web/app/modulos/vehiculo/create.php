<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

// create.php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener datos del formulario
  $fecha_ingreso = $_POST['fecha_ingreso'];
  $patente = $_POST['patente'];
  $precio = $_POST['precio'];
  $fkVehiculo = $_POST['fk_vehiculo']; // Agregado
  $fkProveedor = $_POST['fk_proveedor']; // Agregado

  // Validar y procesar los datos (puedes agregar más validaciones según tus necesidades)

  // Query para insertar un nuevo repuesto
  $sql = "INSERT INTO ingreso_vehiculo 
    (FECHA, FK_VEHICULO, PATENTE, PRECIO, FK_PROVEEDOR)
  VALUES (?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("sisii", $fecha_ingreso, $fkVehiculo, $patente, $precio, $fkProveedor);

    if ($stmt->execute()) {
      $success = 1;
      $message = "Vehículo ingresado exitosamente.";
    } else {
      $success = 0;
      $message = "Error al crear el registro: " . $stmt->error;
    }

    $stmt->close();
  } else {
    $success = 0;
    $message = "Error al preparar la consulta: " . $conn->error;
  }

  // Cerrar la conexión
  $conn->close();

  // Redireccionar al listado
  respond($success, $message, $referer);
} else {
  // redireccionar a la pagina de error
  respond(0, 'Ha ocurrido un error inesperado.', $referer);
}
