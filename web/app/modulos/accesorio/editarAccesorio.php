<?php

include __DIR__ . '/../../db.php';

$tipos = [];
$partes = [];

$id = $_GET['id']; // The ID of the accesorio to update

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

// Obtén y muestra los datos del accesorio a editar
$query = "SELECT * FROM accesorio WHERE ID = $id";
$result = $conn->query($query);
$accesorio = $result->fetch_assoc();


$conn->close();
?>

<!-- Formulario HTML para crear un nuevo accesorio -->
<form method="post" action="/app/modulos/accesorio/update.php">
  <input type="hidden" name="accesorioId" value="<?= $id ?>">
  <div class="form-group">
    <label class="text-dark" for="accesorio">Accesorio:</label>
    <input type="text" name="accesorio" required class="form-control" value="<?= $accesorio['ACCESORIO'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" class="form-control" value="<?= $accesorio['DESCRIPCION'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="marca">Marca:</label>
    <input type="text" name="marca" class="form-control" value="<?= $accesorio['MARCA'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="stock">Stock:</label>
    <input type="number" name="stock" required class="form-control" value="<?= $accesorio['STOCK'] ?>">
  </div>

  <div class="form-group">
    <label class="text-dark" for="precio_unitario">Precio Unitario:</label>
    <input type="number" name="precio_unitario" step="0.01" required class="form-control" value="<?= $accesorio['PRECIO_UNITARIO'] ?>">
  </div>

  <!-- Agregado para FK_VEHICULO -->
  <div class="form-group">
    <label class="text-dark" for="fk_tipo_accesorio">Tipo:</label>
    <select name="fk_tipo_accesorio" class="form-select">
      <?php echo implode('', $tipos); ?>
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
      <button type="submit" class="btn btn-light w-100">Actualizar</button>
    </div>
  </div>
</form>