<?php

include __DIR__ . '/../../db.php';
include_once __DIR__ . '/../../helpers/autenticado.php';

use App\Helpers\Autenticado;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $estaAutenticado = Autenticado::verificarAutenticacion();

  if (!$estaAutenticado) {
    echo json_encode([]);
    exit;
  }

  $nombreRepuesto = $_GET['nombre_repuesto'] ?? null;

  // cargar repuestos
  $query = "SELECT 
    r.ID, 
    r.NOMBRE_REPUESTO AS NOMBRE, 
    r.OBSERVACION, 
    r.STOCK, 
    r.PRECIO_UNITARIO, 
    p.NOMBRE_PARTE AS PARTE
  FROM repuesto r
  INNER JOIN parte p ON r.FK_PARTE = p.ID
  WHERE r.STOCK > 0";

  if ($nombreRepuesto) {
    $query .= " AND r.NOMBRE_REPUESTO LIKE '%$nombreRepuesto%'";
  }

  $repuestos = [];
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $row['TAG'] = md5($row['ID']);
      $repuestos[] = $row;
    }
  }

  echo json_encode($repuestos);
} else {
  echo json_encode([]);
}
