<?php

include __DIR__ . '/../../db.php';

$vehiculos = [];
$proveedores = [];

// Obtén y muestra los vehículos disponibles con más información
$query = "SELECT ID, MARCA, MODELO, AGNO, TRANSMISION, COMBUSTIBLE, CILINDRADA FROM vehiculo";
$result = $conn->query($query);

while ($rowVehiculo = $result->fetch_assoc()) {
  $infoVehiculo = $rowVehiculo['MARCA'] . ' ' . $rowVehiculo['MODELO'] . ' ' . $rowVehiculo['AGNO'] . ' ' . $rowVehiculo['TRANSMISION'] . ' ' . $rowVehiculo['COMBUSTIBLE'] . ' ' . $rowVehiculo['CILINDRADA'];
  $vehiculos[] = '<option value="' . $rowVehiculo['ID'] . '">' . $infoVehiculo . '</option>';
}

$query = "SELECT ID,	RUT,	RAZON_SOCIAL,	DIRECCION,	COMUNA,	REGION,	CONTACTO,	TELEFONO 
      FROM proveedor";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
  $proveedores[] = '<option value="' . $row['ID'] . '">' . $row['RAZON_SOCIAL'] . '</option>';
}

$conn->close();
?>

<h1 class="text-light">Ingresar Vehículo</h1>
<hr class="text-light">

<!-- Formulario HTML para crear un nuevo repuesto -->
<form method="post" action="/app/modulos/vehiculo/create.php">

  <div class="form-group">
    <label class="text-light" for="fecha_ingreso">Fecha ingreso:</label>
    <input type="date" name="fecha_ingreso" class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="patente">Patente:</label>
    <input type="text" name="patente" required class="form-control" maxlength="6">
  </div>

  <div class="form-group">
    <label class="text-light" for="precio">Precio:</label>
    <input type="number" name="precio" required class="form-control">
  </div>

  <div class="form-group">
    <label class="text-light" for="fk_proveedor">Proveedor:</label>
    <select name="fk_proveedor" class="form-select">
      <?php echo implode('', $proveedores); ?>
    </select>
  </div>

  <!-- Agregado para FK_VEHICULO -->
  <div class="form-group">
    <label class="text-light" for="fk_vehiculo">Vehículo:</label>
    <select name="fk_vehiculo" class="form-select">
      <?php echo implode('', $vehiculos); ?>
    </select>
  </div>

  <div class="row justify-content-center mt-4">
    <div class="col-12 col-md-4">
      <button type="submit" class="btn btn-light w-100">Crear Repuesto</button>
    </div>
  </div>
</form>