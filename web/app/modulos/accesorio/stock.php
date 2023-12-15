<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fk_accesorio = $_POST['fk_accesorio'];
  $fk_ingreso_vehiculo = $_POST['fk_ingreso_vehiculo'];
  $cantidad = $_POST['cantidad'];

  // Check if the accesorio exists
  $stmt = $conn->prepare("SELECT * FROM accesorio WHERE id = ?");
  $stmt->bind_param("i", $fk_accesorio);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo "Error: No accesorio found with ID " . $fk_accesorio;
    $stmt->close();
    $conn->close();
    exit();
  }

  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO ingreso_accesorio 
  (FK_INGRESO_VEHICULO, FK_ACCESORIO, CANTIDAD, FECHA) 
  VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("iii", $fk_ingreso_vehiculo, $fk_accesorio, $cantidad);

  // Execute the SQL statement
  if ($stmt->execute()) {
    $success = 1;
    $message = "Registro actualizado correctamente!";
  } else {
    $success = 0;
    $message = "Error al actualizar el registro: " . $stmt->error;
  }

  $stmt = $conn->prepare("UPDATE accesorio SET STOCK = STOCK + ? WHERE ID = ?");
  $stmt->bind_param("ii", $cantidad, $fk_accesorio);

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
