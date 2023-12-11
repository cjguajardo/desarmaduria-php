<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id = $_POST['accesorioId']; // The ID of the accesorio to delete

  // Prepare an SQL statement
  $stmt = $conn->prepare("DELETE FROM accesorio WHERE id = ?");

  // Bind the accesorio ID to the SQL statement
  $stmt->bind_param("i", $id);

  // Execute the SQL statement
  if ($stmt->execute()) {
    $success = 1;
    $message = "Accesorio eliminado exitosamente!";
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
