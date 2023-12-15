<?php

include __DIR__ . '/../../db.php';
include_once __DIR__ . '/../../helpers/autenticado.php';
include_once __DIR__ . '/../../helpers/layout.php';
include __DIR__ . '/../busqueda/formulario.php';

use App\Helpers\Autenticado;
use App\Helpers\LayoutHelper;

$estaAutenticado = Autenticado::verificarAutenticacion();

if (!$estaAutenticado) {
  $layout = new LayoutHelper();
  echo $layout->renderNoAutenticado();
  exit;
}

$query = "SELECT 
  ID,
  DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA,
  NOMBRE_CLIENTE
FROM venta
ORDER BY FECHA DESC";
$ventas = [];
if ($result = $conn->query($query)) {
  while ($row = $result->fetch_assoc()) {
    $subquery = "SELECT
    (SELECT SUM(TOTAL) FROM venta_accesorio va WHERE va.FK_VENTA = {$row['ID']}) + 
    (SELECT SUM(TOTAL) FROM venta_repuesto va WHERE va.FK_VENTA = {$row['ID']}) AS total";

    $row['TOTAL'] = 0;
    if ($result2 = $conn->query($subquery)) {
      while ($row2 = $result2->fetch_assoc()) {
        $row['TOTAL'] = $row2['total'];
      }
    }
    $ventas[] = $row;
  }
}

?>

<h1 class="text-light">Listado de Ventas</h1>
<hr class="text-light">

<div class="card">
  <div class="card-body">
    <table class="table table-responsive">
      <thead>
        <tr>
          <th>#</th>
          <th>FECHA</th>
          <th>CLIENTE</th>
          <th>TOTAL</th>
          <th>::</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ventas as $venta) : ?>
          <tr>
            <td><?php echo $venta['ID']; ?></td>
            <td><?php echo $venta['FECHA']; ?></td>
            <td><?php echo $venta['NOMBRE_CLIENTE']; ?></td>
            <td>$ <?php echo number_format($venta['TOTAL'], 0, ',', '.'); ?></td>
            <td>
              <a href="/app/administrador/index.php?section=ventas#comprobante&id=<?php echo $venta['ID']; ?>" target="_blank" class="btn btn-sm btn-outline-info">Ver</a>
              <!-- <a href="editarVenta.php?id=<?php echo $venta['ID']; ?>" class="btn btn-sm btn-outline-warning">Editar</a> -->
              <!-- <a href="eliminarVenta.php?id=<?php echo $venta['ID']; ?>" class="btn btn-sm btn-outline-danger">Eliminar</a> -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>