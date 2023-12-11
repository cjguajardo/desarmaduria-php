<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $repuestoId = $_POST['repuestoId']; // The ID of the repuesto to update
  $nombre_repuesto = $_POST['nombre_repuesto'];
  $observacion = $_POST['observacion'];
  $stock = $_POST['stock'];
  $precio_unitario = $_POST['precio_unitario'];
  $fk_vehiculo = $_POST['fk_vehiculo'];
  $fk_parte = $_POST['fk_parte'];

  // Check if the repuesto exists
  $stmt = $conn->prepare("SELECT * FROM repuesto WHERE id = ?");
  $stmt->bind_param("i", $repuestoId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo "Error: No repuesto found with ID " . $repuestoId;
    $stmt->close();
    $conn->close();
    exit();
  }

  $stmt->close();

  // Prepare an SQL statement to update the repuesto
  $stmt = $conn->prepare("UPDATE repuesto SET 
    FK_VEHICULO=?,	
    NOMBRE_REPUESTO=?,	
    OBSERVACION=?,	
    STOCK=?,	
    PRECIO_UNITARIO=?,	
    FK_PARTE=? 
    WHERE id = ?");
  $stmt->bind_param("issiiii", $fk_vehiculo, $nombre_repuesto, $observacion, $stock, $precio_unitario, $fk_parte, $repuestoId);

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

  respond($success, $message, '../repuestos.php');
} else {
  respond(0, 'Ha ocurrido un error inesperado.', '../repuestos.php');
}
