<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // recibe input:hidden repuestos[]
  $repuestos = $_POST['repuestos'];
  $cliente = $_POST['cliente'];

  $fecha = date('Y-m-d');

  // get the last id from the database
  $sql = "SELECT ID FROM venta ORDER BY ID DESC LIMIT 1";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  try {
    $idVenta = $row['ID'] + 1;
  } catch (Exception $e) {
    $idVenta = 1;
  }

  // crea venta en tabla venta
  $sql = "INSERT INTO venta (ID, FECHA, NOMBRE_CLIENTE) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iss', $idVenta, $fecha, $cliente);
  $stmt->execute();

  // obtiene id de venta
  // $idVenta = $stmt->insert_id;

  // crea detalle de venta en tabla venta_repuesto
  $sql = "INSERT INTO venta_repuesto (FK_VENTA, FK_REPUESTO, CANTIDAD, PRECIO_UNITARIO, TOTAL) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  foreach ($repuestos as $strRepuesto) {
    $repuesto = json_decode($strRepuesto, true);
    $idRepuesto = $repuesto['id'];
    $cantidad = $repuesto['cantidad'];
    $precio_unitario = $repuesto['precio_unitario'];
    $precio_total = $repuesto['precio_total'];

    $stmt->bind_param('iiiid', $idVenta, $idRepuesto, $cantidad, $precio, $precio_total);
    $stmt->execute();
  }

  // actualiza stock de repuestos
  $sql = "UPDATE repuesto SET STOCK = STOCK - ? WHERE ID = ?";
  $stmt = $conn->prepare($sql);

  foreach ($repuestos as $strRepuesto) {
    $repuesto = json_decode($strRepuesto, true);
    $idRepuesto = $repuesto['id'];
    $cantidad = $repuesto['cantidad'];

    $stmt->bind_param('ii', $cantidad, $idRepuesto);
    $stmt->execute();
  }

  // retorna respuesta
  header("Location: ../repuestos.php#comprobante?id=$idVenta");
} else {
  // redireccionar a la pagina de error
  respond(0, 'Ha ocurrido un error inesperado.', '../repuestos.php#venta');
}
