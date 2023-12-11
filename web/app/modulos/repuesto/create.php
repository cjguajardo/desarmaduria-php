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
  $nombreRepuesto = $_POST['nombre_repuesto'];
  $observacion = $_POST['observacion'];
  $stock = $_POST['stock'];
  $precioUnitario = $_POST['precio_unitario'];
  $fkVehiculo = $_POST['fk_vehiculo']; // Agregado
  $fkParte = $_POST['fk_parte']; // Agregado

  // Validar y procesar los datos (puedes agregar más validaciones según tus necesidades)

  // Query para insertar un nuevo repuesto
  $sql = "INSERT INTO repuesto (NOMBRE_REPUESTO, OBSERVACION, STOCK, PRECIO_UNITARIO, FK_VEHICULO, FK_PARTE) 
            VALUES (?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("ssiiii", $nombreRepuesto, $observacion, $stock, $precioUnitario, $fkVehiculo, $fkParte);

    if ($stmt->execute()) {
      $success = 1;
      $message = "Repuesto creado exitosamente.";
    } else {
      $success = 0;
      $message = "Error al crear el repuesto: " . $stmt->error;
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
