<?php

include __DIR__ . '/../../db.php';

$vehiculos = [];
$partes = [];

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

$conn->close();
?>

<h1 class="text-light">Agregar Repuesto</h1>
<hr class="text-light">

<!-- Formulario HTML para crear un nuevo repuesto -->
<form method="post" action="/app/modulos/repuesto/create.php">
  <div class="form-group">
    <label class="text-light" for="nombre_repuesto">Nombre del Repuesto:</label>
    <input type="text" name="nombre_repuesto" required class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="observacion">Observación:</label>
    <input type="text" name="observacion" class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="stock">Stock:</label>
    <input type="number" name="stock" required class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="precio_unitario">Precio Unitario:</label>
    <input type="number" name="precio_unitario" step="0.01" required class="form-control">
  </div>

  <!-- Agregado para FK_VEHICULO -->
  <div class="form-group">
    <label class="text-light" for="fk_vehiculo">Vehículo:</label>
    <select name="fk_vehiculo" class="form-select">
      <?php echo implode('', $vehiculos); ?>
    </select>
  </div>

  <!-- Agregado para FK_PARTE -->
  <div class="form-group">
    <label class="text-light" for="fk_parte">Parte:</label>
    <select name="fk_parte" class="form-select">
      <?php echo implode('', $partes); ?>
    </select>
  </div>

  <div class="row justify-content-center mt-4">
    <div class="col-12 col-md-4">
      <button type="submit" class="btn btn-light w-100">Crear Repuesto</button>
    </div>
  </div>
</form>