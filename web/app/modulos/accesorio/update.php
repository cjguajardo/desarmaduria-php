<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';
include __DIR__ . '/../../helpers/server.php';

use App\Helpers\Server;

$referer = Server::getReferer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['accesorioId']; // The ID of the accesorio to update
  $accesorio = $_POST['accesorio'];
  $descripcion = $_POST['descripcion'];
  $marca = $_POST['marca'];
  $stock = $_POST['stock'];
  $precio_unitario = $_POST['precio_unitario'];
  $fk_tipo_accesorio = $_POST['fk_tipo_accesorio'];
  $fk_parte = $_POST['fk_parte'];

  // Check if the accesorio exists
  $stmt = $conn->prepare("SELECT * FROM accesorio WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo "Error: No accesorio found with ID " . $id;
    $stmt->close();
    $conn->close();
    exit();
  }

  $stmt->close();

  // Prepare an SQL statement to update the accesorio
  $stmt = $conn->prepare("UPDATE accesorio SET 
    FK_TIPO_ACCESORIO=?,	
    ACCESORIO=?,
    MARCA=?,	
    DESCRIPCION=?,	
    STOCK=?,	
    PRECIO_UNITARIO=?,	
    FK_PARTE=? 
    WHERE id = ?");
  $stmt->bind_param("isssiiii", $fk_tipo_accesorio, $accesorio, $marca, $descripcion, $stock, $precio_unitario, $fk_parte, $id);

  // Execute the SQL statement
  if ($stmt->execute()) {
    $success = 1;
    $message = "Repuesto actualizado correctamente!";
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
