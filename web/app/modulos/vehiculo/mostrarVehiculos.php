<?php
// Incluir el archivo de conexión
include __DIR__ . '/../../db.php';
include __DIR__ . '/../busqueda/formulario.php';


// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT iv.FECHA, 
          v.TIPO, v.MARCA, 
          v.MODELO, v.AGNO, 
          v.TRANSMISION, v.COMBUSTIBLE, 
          v.CILINDRADA
        FROM ingreso_vehiculo iv
        INNER JOIN vehiculo v ON iv.FK_VEHICULO = v.ID";

$where = getFilterParams();
// Agregar parametros de búsqueda en caso de que vengan en la request
if (count($where) > 0) {
  $sql .= " WHERE ";
  foreach ($where as $k => $v) {
    $sql .= " $k = '$v' AND";
  }
  $sql = substr($sql, 0, -3);
}

$vehiculos = [];
if ($result = $conn->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    $vehiculos[] = $row;
  }
}

?>

<h1 class="text-light">Listado de Vehículos</h1>
<hr class="text-light">

<?= renderFormulario('vehiculos'); ?>

<?php if (count($vehiculos) > 0) { ?>
  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Fecha de llegada</th>
        <th>Tipo</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Año</th>
        <th>Transmisión</th>
        <th>Combustible</th>
        <th>Cilindrada</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($vehiculos as $v) { ?>
        <tr>
          <td><?= $v["FECHA"] ?></td>
          <td><?= $v["TIPO"] ?></td>
          <td><?= $v["MARCA"] ?></td>
          <td><?= $v["MODELO"] ?></td>
          <td><?= $v["AGNO"] ?></td>
          <td><?= $v["TRANSMISION"] ?></td>
          <td><?= $v["COMBUSTIBLE"] ?></td>
          <td><?= $v["CILINDRADA"] ?></td>
        </tr>
      <?php } ?>

    </tbody>
  </table>
<?php } else { ?>
  <div class="alert alert-warning">
    <strong>¡Atención!</strong> No se encontraron resultados.
  </div>
<?php } ?>

<?php cerrarConexion(); ?>