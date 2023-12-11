<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $repuestoId = $_POST['repuestoId']; // The ID of the repuesto to delete

  // Prepare an SQL statement
  $stmt = $conn->prepare("DELETE FROM repuesto WHERE id = ?");

  // Bind the repuesto ID to the SQL statement
  $stmt->bind_param("i", $repuestoId);

  // Execute the SQL statement
  if ($stmt->execute()) {
    $success = 1;
    $message = "Repuesto eliminado exitosamente!";
  } else {
    $success = 0;
    $message = "Error al intentar eliminar el registro: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();

  respond($success, $message, $referer);
} else {
  respond(0, 'Ha ocurrido un error inesperado.', $referer);
}
