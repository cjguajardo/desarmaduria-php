<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';

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
            VALUES ('$nombreRepuesto', '$observacion', $stock, $precioUnitario, $fkVehiculo, $fkParte)";

  if ($conn->query($sql) === TRUE) {
    $success = 1;
    $message = "Repuesto creado exitosamente.";
  } else {
    $success = 0;
    $message = "Error al crear el repuesto: " . $conn->error;
  }

  // Cerrar la conexión
  $conn->close();

  // Redireccionar al listado
  respond($success, $message, '../repuestos.php');
} else {
  // redireccionar a la pagina de error
  respond(0, 'Ha ocurrido un error inesperado.', '../repuestos.php');
}
