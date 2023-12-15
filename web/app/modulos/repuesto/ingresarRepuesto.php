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


$repuestos = [];
$query = "SELECT * FROM repuesto";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $repuestos[] = $row;
  }
}

$vehiculos = [];
$query = "SELECT iv.ID,
	DATE_FORMAT(iv.FECHA, '%d/%m/%Y') AS FECHA,
	CONCAT_WS(', ', v.TIPO, v.MARCA, v.MODELO, v.AGNO, v.CILINDRADA) AS VEHICULO
FROM ingreso_vehiculo iv INNER JOIN vehiculo v ON iv.FK_VEHICULO = v.ID ;";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $vehiculos[] = $row;
  }
}

$conn->close();
?>

<h1 class="text-light">Ingresar Repuesto</h1>
<hr class="text-light">

<!-- Formulario HTML para crear un nuevo repuesto -->
<form method="post" action="/app/modulos/repuesto/stock.php">
  <input type="hidden" id="fk_repuesto" name="fk_repuesto" />
  <input type="hidden" id="fk_ingreso_vehiculo" name="fk_ingreso_vehiculo" />

  <div class="row justify-content-center">
    <div class="col-12 col-md-6">
      <div class="form-group">
        <label class="text-light" for="nombre_repuesto">Nombre del Repuesto:</label>
        <input type="text" id="nombre_repuesto" name="nombre_repuesto" list="repuestos" required class="form-control">
        <datalist id="repuestos">
          <?php foreach ($repuestos as $repuesto) : ?>
            <option value="<?= $repuesto['NOMBRE_REPUESTO'] ?>"></option>
          <?php endforeach; ?>
        </datalist>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-12 col-md-6">
      <div class="form-group">
        <label class="text-light" for="codigo_ingreso_vehiculo">Código Ingreso Vehículo:</label>
        <input type="text" list="vehiculos" id="codigo_ingreso_vehiculo" name=" codigo_ingreso_vehiculo" class="form-control">
        <datalist id="vehiculos">
          <?php foreach ($vehiculos as $vehiculo) : ?>
            <option value="#<?= $vehiculo['ID'] . ' - ' . $vehiculo['FECHA'] . ' - ' . $vehiculo['VEHICULO'] ?>" />
          <?php endforeach; ?>
        </datalist>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="form-group">
        <label class="text-light" for="stock">Cantidad:</label>
        <input type="number" name="cantidad" required class="form-control">
      </div>
    </div>
  </div>

  <div class="row justify-content-center mt-4">
    <div class="col-12 col-md-4">
      <button type="submit" class="btn btn-light w-100">Ingresar Repuesto</button>
    </div>
  </div>
</form>

<script>
  var repuestos = <?= json_encode($repuestos) ?>;
  var vehiculos = <?= json_encode($vehiculos) ?>;
  $(document).ready(function() {
    $('#nombre_repuesto').change(function() {
      const nombre_repuesto = $(this).val();
      const repuesto = repuestos.find(repuesto => repuesto.NOMBRE_REPUESTO === nombre_repuesto);
      if (repuesto) {
        $('#fk_repuesto').attr('value', repuesto.ID);
        $('#fk_repuesto').val(repuesto.ID);
      } else {
        $('#fk_repuesto').val('');
      }
    });
    $('#codigo_ingreso_vehiculo').change(function() {
      const codigo_ingreso_vehiculo = $(this).val();
      const vehiculo = vehiculos.find(vehiculo => {
        const codigo = `#${vehiculo.ID} - ${vehiculo.FECHA} - ${vehiculo.VEHICULO}`;
        return codigo === codigo_ingreso_vehiculo
      });
      console.log({
        vehiculo
      });
      if (vehiculo) {
        $('#fk_ingreso_vehiculo').attr('value', vehiculo.ID);
        $('#fk_ingreso_vehiculo').val(vehiculo.ID);
      } else {
        $('#fk_ingreso_vehiculo').val('');
      }
    });
  });
</script>