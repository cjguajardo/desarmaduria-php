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

  $nombre = $_GET['nombre_accesorio'] ?? null;

  // cargar accesorios
  $query = "SELECT 
    r.ID, 
    r.ACCESORIO AS NOMBRE, 
    r.STOCK, 
    r.PRECIO_UNITARIO, 
    p.NOMBRE_PARTE AS PARTE
  FROM accesorio r
  INNER JOIN parte p ON r.FK_PARTE = p.ID
  WHERE r.STOCK > 0";

  if ($nombre) {
    $query .= " AND r.ACCESORIO LIKE '%$nombre%'";
  }

  $accesorios = [];
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $row['TAG'] = md5($row['ID']);
      $accesorios[] = $row;
    }
  }

  echo json_encode($accesorios);
} else {
  echo json_encode([]);
}
