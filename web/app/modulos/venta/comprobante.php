<?php
include __DIR__ . '/../../db.php';

$idVenta = $_GET['id'];
$sql = "SELECT 
  ID,
  DATE_FORMAT(FECHA,'%d/%m/%Y') AS FECHA, 
  NOMBRE_CLIENTE 
FROM venta 
WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idVenta);
$stmt->execute();

$result = $stmt->get_result();
$venta = $result->fetch_assoc();

$sql = "SELECT 
  r.NOMBRE_REPUESTO AS NOMBRE,
  vr.CANTIDAD,
  vr.PRECIO_UNITARIO,
  vr.TOTAL
FROM venta_repuesto vr INNER JOIN repuesto r ON r.ID=vr.FK_REPUESTO 
WHERE vr.FK_VENTA = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idVenta);
$stmt->execute();

$result = $stmt->get_result();
$repuestos = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT 
  a.ACCESORIO AS NOMBRE,
  va.CANTIDAD,
  va.PRECIO_UNITARIO,
  va.TOTAL
FROM venta_accesorio va INNER JOIN accesorio a ON a.ID=va.FK_ACCESORIO 
WHERE va.FK_VENTA = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idVenta);
$stmt->execute();

$result = $stmt->get_result();
$accesorios = $result->fetch_all(MYSQLI_ASSOC);

$total = 0;
$items = array_merge($repuestos, $accesorios);
?>


<div class="card" id="comprobante">
  <div class="card-body">

    <h1 class="text-dark">Comprobante de Venta</h1>
    <hr class="text-dark">

    <div class="row">

      <div class="col-12 col-md-6">
        <div class="row">
          <div class="col-5 text-start text-dark">Venta</div>
          <div class="col-7 ps-3 text-start"><?= $venta['ID'] ?></div>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="row">
          <div class="col-5 text-start text-dark">Fecha</div>
          <div class="col-7 ps-3 text-start"><?= $venta['FECHA'] ?></div>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="row">
          <div class="col-5 text-start text-dark">Cliente</div>
          <div class="col-7 ps-3 text-start"><?= $venta['NOMBRE_CLIENTE'] ?></div>
        </div>
      </div>

    </div>

    <table class="table table-responsive mt-4">
      <thead>
        <tr>
          <th>Item</th>
          <th>Cantidad</th>
          <th>Precio Unitario</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($items as $item) {
          $total += $item['TOTAL'];
          echo '<tr>';
          echo '<td>' . $item['NOMBRE'] . '</td>';
          echo '<td class="text-center">' . $item['CANTIDAD'] . '</td>';
          echo '<td class="text-end">$ ' . number_format($item['PRECIO_UNITARIO'], 0, ',', '.') . '</td>';
          echo '<td class="text-end">$ ' . number_format($item['TOTAL'], 0, ',', '.') . '</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td class="text-end">NETO</td>
          <td class="text-end fw-bold">$ <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td class="text-end">IVA</td>
          <td class="text-end fw-bold">$ <?= number_format($total * 0.19, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td class="text-end">IVA</td>
          <td class="text-end fw-bold">$ <?= number_format($total * 1.19, 0, ',', '.') ?></td>
        </tr>
      </tfoot>
    </table>

  </div>
</div>

<div class="row justify-content-center mt-2">
  <div class="col-12 col-md-3">
    <button type="button" class="btn btn-light w-100" onclick="imprimir()">Imprimir</button>
  </div>
</div>

<script>
  function imprimir() {
    const comprobante = document.getElementById('comprobante');
    const printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Comprobante de Venta</title>');
    printWindow.document.write('<link rel="stylesheet" href="/assets/css/main.min.css">');
    printWindow.document.write('</head><body >');
    printWindow.document.write(comprobante.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }
</script>