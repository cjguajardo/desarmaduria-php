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
  $nombre = $_POST['accesorio'];
  $descripcion = $_POST['descripcion'];
  $marca = $_POST['marca'];
  $stock = $_POST['stock'];
  $precioUnitario = $_POST['precio_unitario'];
  $fkTipoAccesorio = $_POST['fk_tipo_accesorio']; // Agregado
  $fkParte = $_POST['fk_parte']; // Agregado

  // Validar y procesar los datos (puedes agregar más validaciones según tus necesidades)

  // Query para insertar un nuevo accesorio
  $sql = "INSERT INTO accesorio (ACCESORIO, DESCRIPCION, MARCA, STOCK, PRECIO_UNITARIO, FK_TIPO_ACCESORIO, FK_PARTE) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("sssiiii", $nombre, $descripcion, $marca, $stock, $precioUnitario, $fkTipoAccesorio, $fkParte);

    if ($stmt->execute()) {
      $success = 1;
      $message = "Accesorio creado exitosamente.";
    } else {
      $success = 0;
      $message = "Error al crear el accesorio: " . $stmt->error;
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
