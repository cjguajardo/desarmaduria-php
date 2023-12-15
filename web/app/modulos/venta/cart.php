<?php

include __DIR__ . '/../../db.php';
include __DIR__ . '/../../response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // recibe input:hidden items[]
  $items = $_POST['items'];
  $cliente = $_POST['cliente'];

  $fecha = date('Y-m-d');

  // crea venta en tabla venta
  $sql = "INSERT INTO venta (FECHA, NOMBRE_CLIENTE) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss',  $fecha, $cliente);
  $stmt->execute();
  $idVenta = $stmt->insert_id;

  $repuestos = array_filter($items, function ($item) {
    $item = json_decode($item, true);
    return $item['TIPO'] === 'REPUESTO';
  });

  // crea detalle de venta en tabla venta_repuesto
  $sql = "INSERT INTO venta_repuesto (FK_VENTA, FK_REPUESTO, CANTIDAD, PRECIO_UNITARIO, TOTAL) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  foreach ($repuestos as $rep) {
    $rep = json_decode($rep, true);
    $id = $rep['ID'];
    $cantidad = intval($rep['CANTIDAD']);
    $precio_unitario = floatval($rep['PRECIO_UNITARIO']);
    $precio_total = $cantidad * $precio_unitario;

    $stmt->bind_param('iiiid', $idVenta, $id, $cantidad, $precio_unitario, $precio_total);
    $stmt->execute();
  }

  // actualiza stock de repuestos
  $sql = "UPDATE repuesto SET STOCK = (STOCK - ?) WHERE ID = ?";
  $stmt = $conn->prepare($sql);

  foreach ($repuestos as $rep) {
    $rep = json_decode($rep, true);
    $stmt->bind_param('ii', $rep['cantidad'], $rep['id']);
    $stmt->execute();
  }

  $accesorios = array_filter($items, function ($item) {
    $item = json_decode($item, true);
    return $item['TIPO'] === 'ACCESORIO';
  });

  // crea detalle de venta en tabla venta_repuesto
  $sql = "INSERT INTO venta_accesorio (FK_VENTA, FK_ACCESORIO, CANTIDAD, PRECIO_UNITARIO, TOTAL) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  foreach ($accesorios as $acc) {
    $acc = json_decode($acc, true);
    $id = $acc['ID'];
    $cantidad = intval($acc['CANTIDAD']);
    $precio_unitario = floatval($acc['PRECIO_UNITARIO']);
    $precio_total = $cantidad * $precio_unitario;

    $stmt->bind_param('iiiid', $idVenta, $id, $cantidad, $precio_unitario, $precio_total);
    $stmt->execute();
  }

  // actualiza stock de accesorios
  $sql = "UPDATE accesorio SET STOCK = STOCK - ? WHERE ID = ?";
  $stmt = $conn->prepare($sql);

  foreach ($accesorios as $acc) {
    $acc = json_decode($acc, true);
    $stmt->bind_param('ii', $acc['cantidad'], $acc['id']);
    $stmt->execute();
  }

  // http: //localhost:8080/app/administrador/index.php?section=ventas#venta
  // retorna respuesta
  header("Location: /app/administrador/index.php?section=ventas#comprobante&id=$idVenta");
} else {
  // redireccionar a la pagina de error
  respond(0, 'Ha ocurrido un error inesperado.', '../repuestos.php#venta');
}
