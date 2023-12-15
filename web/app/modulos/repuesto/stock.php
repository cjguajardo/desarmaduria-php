<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fk_repuesto = $_POST['fk_repuesto'];
  $fk_ingreso_vehiculo = $_POST['fk_ingreso_vehiculo'];
  $cantidad = $_POST['cantidad'];

  // Check if the repuesto exists
  $stmt = $conn->prepare("SELECT * FROM repuesto WHERE id = ?");
  $stmt->bind_param("i", $fk_repuesto);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo "Error: No repuesto found with ID " . $fk_repuesto;
    $stmt->close();
    $conn->close();
    exit();
  }

  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO ingreso_repuesto 
  (FK_INGRESO_VEHICULO, FK_REPUESTO, CANTIDAD, FECHA) 
  VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("iii", $fk_ingreso_vehiculo, $fk_repuesto, $cantidad);

  // Execute the SQL statement
  if ($stmt->execute()) {
    $success = 1;
    $message = "Registro actualizado correctamente!";
  } else {
    $success = 0;
    $message = "Error al actualizar el registro: " . $stmt->error;
  }

  $stmt = $conn->prepare("UPDATE repuesto SET STOCK = STOCK + ? WHERE ID = ?");
  $stmt->bind_param("ii", $cantidad, $fk_repuesto);

  if ($stmt->execute()) {
    $success = 1;
    $message = "Registro actualizado correctamente!";
  } else {
    $success = 0;
    $message = "Error al actualizar el registro: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();

  respond($success, $message, $referer);
} else {
  respond(0, 'Ha ocurrido un error inesperado.', $referer);
}
