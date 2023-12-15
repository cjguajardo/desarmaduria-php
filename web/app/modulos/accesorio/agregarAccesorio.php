<?php

include __DIR__ . '/../../db.php';

$tipos = [];
$partes = [];

// Obtén y muestra los vehículos disponibles con más información
$query = "SELECT ID, TIPO FROM tipo_accesorio";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
  $tipos[] = '<option value="' . $row['ID'] . '">' . $row['TIPO'] . '</option>';
}

// Obtén y muestra las partes disponibles
$query = "SELECT ID, NOMBRE_PARTE FROM parte";
$result = $conn->query($query);

while ($rowParte = $result->fetch_assoc()) {
  $partes[] = '<option value="' . $rowParte['ID'] . '">' . $rowParte['NOMBRE_PARTE'] . '</option>';
}

$conn->close();
?>

<h1 class="text-light">Crear Accesorio</h1>
<hr class="text-light">

<!-- Formulario HTML para crear un nuevo repuesto -->
<form method="post" action="/app/modulos/accesorio/create.php">
  <div class="form-group">
    <label class="text-light" for="nombre_repuesto">Accesorio:</label>
    <input type="text" name="accesorio" required class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="observacion">Marca:</label>
    <input type="text" name="marca" class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="observacion">Descripción:</label>
    <input type="text" name="descripcion" class="form-control">
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
    <label class="text-light" for="fk_vehiculo">Tipo:</label>
    <select name="fk_tipo_accesorio" class="form-select">
      <?php echo implode('', $tipos); ?>
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
      <button type="submit" class="btn btn-light w-100">Crear Accesorio</button>
    </div>
  </div>
</form>