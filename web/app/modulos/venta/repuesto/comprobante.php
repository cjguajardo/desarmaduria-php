<?php
include __DIR__ . '/../../db.php';

$idVenta = $_GET['id'];
$sql = "SELECT * FROM venta WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idVenta);
$stmt->execute();

$result = $stmt->get_result();
$venta = $result->fetch_assoc();

$sql = "SELECT * FROM venta_repuesto INNER JOIN repuesto ON repuesto.ID=FK_REPUESTO WHERE FK_VENTA = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idVenta);
$stmt->execute();

$result = $stmt->get_result();
$repuestos = $result->fetch_all(MYSQLI_ASSOC);

$total = 0;

?>
<h1 class="text-light">Comprobante de Venta</h1>
<hr class="text-light">

<div class="row">
  <div class="col-12 col-md-6">
    <div class="form-group">
      <label for="" class="text-light">Fecha</label>
      <div class="form-control"><?= $venta['FECHA'] ?></div>
    </div>
  </div>

  <div class="col-12 col-md-6">
    <div class="form-group">
      <label for="" class="text-light">Cliente</label>
      <div class="form-control"><?= $venta['NOMBRE_CLIENTE'] ?></div>
    </div>
  </div>
</div>

<table class="table table-responsive">
  <thead>
    <tr>
      <th>Repuesto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($repuestos as $repuesto) {
      $total += $repuesto['TOTAL'];
      echo '<tr>';
      echo '<td>' . $repuesto['NOMBRE_REPUESTO'] . '</td>';
      echo '<td>' . $repuesto['CANTIDAD'] . '</td>';
      echo '<td>' . $repuesto['PRECIO_UNITARIO'] . '</td>';
      echo '<td>' . $repuesto['PRECIO_UNITARIO'] * $repuesto['CANTIDAD'] . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3"></td>
      <td><?= $total ?></td>
    </tr>
  </tfoot>
</table>