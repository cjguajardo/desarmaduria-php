<?php

include __DIR__ . '/../../db.php';

$vehiculos = [];
$partes = [];

$repuestoId = $_GET['id']; // The ID of the repuesto to update

// Obtén y muestra los vehículos disponibles con más información
$sqlVehiculos = "SELECT ID, MARCA, MODELO, AGNO, TRANSMISION, COMBUSTIBLE, CILINDRADA FROM vehiculo";
$resultVehiculos = $conn->query($sqlVehiculos);

while ($rowVehiculo = $resultVehiculos->fetch_assoc()) {
  $infoVehiculo = $rowVehiculo['MARCA'] . ' ' . $rowVehiculo['MODELO'] . ' ' . $rowVehiculo['AGNO'] . ' ' . $rowVehiculo['TRANSMISION'] . ' ' . $rowVehiculo['COMBUSTIBLE'] . ' ' . $rowVehiculo['CILINDRADA'];
  $vehiculos[] = '<option value="' . $rowVehiculo['ID'] . '">' . $infoVehiculo . '</option>';
}

// Obtén y muestra las partes disponibles
$sqlPartes = "SELECT ID, NOMBRE_PARTE FROM parte";
$resultPartes = $conn->query($sqlPartes);

while ($rowParte = $resultPartes->fetch_assoc()) {
  $partes[] = '<option value="' . $rowParte['ID'] . '">' . $rowParte['NOMBRE_PARTE'] . '</option>';
}

// Obtén y muestra los datos del repuesto a editar
$sqlRepuesto = "SELECT * FROM repuesto WHERE ID = $repuestoId";
$resultRepuesto = $conn->query($sqlRepuesto);
$repuesto = $resultRepuesto->fetch_assoc();


$conn->close();
?>

<!-- Formulario HTML para crear un nuevo repuesto -->
<form method="post" action="repuesto/update.php">
  <input type="hidden" name="repuestoId" value="<?= $repuestoId ?>">
  <div class="form-group">
    <label class="text-dark" for="nombre_repuesto">Nombre del Repuesto:</label>
    <input type="text" name="nombre_repuesto" required class="form-control" value="<?= $repuesto['NOMBRE_REPUESTO'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="observacion">Observación:</label>
    <input type="text" name="observacion" class="form-control" value="<?= $repuesto['OBSERVACION'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="stock">Stock:</label>
    <input type="number" name="stock" required class="form-control" value="<?= $repuesto['STOCK'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="precio_unitario">Precio Unitario:</label>
    <input type="number" name="precio_unitario" step="0.01" required class="form-control" value="<?= $repuesto['PRECIO_UNITARIO'] ?>">
  </div>

  <!-- Agregado para FK_VEHICULO -->
  <div class="form-group">
    <label class="text-dark" for="fk_vehiculo">Vehículo:</label>
    <select name="fk_vehiculo" class="form-select">
      <?php echo implode('', $vehiculos); ?>
    </select>
  </div>

  <!-- Agregado para FK_PARTE -->
  <div class="form-group">
    <label class="text-dark" for="fk_parte">Parte:</label>
    <select name="fk_parte" class="form-select">
      <?php echo implode('', $partes); ?>
    </select>
  </div>

  <div class="row justify-content-center mt-4">
    <div class="col-12 col-md-4">
      <button type="submit" class="btn btn-light w-100">Actualizar Repuesto</button>
    </div>
  </div>
</form>