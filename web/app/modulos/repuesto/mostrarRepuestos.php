<?php
// Incluir el archivo de conexión
include __DIR__ . '/../../db.php';

// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT repuesto.ID, repuesto.NOMBRE_REPUESTO, repuesto.OBSERVACION, repuesto.STOCK, repuesto.PRECIO_UNITARIO, parte.NOMBRE_PARTE
        FROM repuesto
        INNER JOIN parte ON repuesto.FK_PARTE = parte.ID";

$result = $conn->query($sql);

?>

<h1 class="text-light">Listado de Repuestos</h1>
<hr class="text-light">

<?php

// Verificar si hay resultados
if ($result->num_rows > 0) {
  // Mostrar datos en una tabla de Bootstrap
?>
  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Nombre del Repuesto</th>
        <th>Observación</th>
        <th>Stock</th>
        <th>Precio Unitario</th>
        <th>Nombre de la Parte</th>
        <th>::</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Mostrar datos
      while ($row = $result->fetch_assoc()) {
      ?>
        <tr>
          <td><?= $row["NOMBRE_REPUESTO"] ?></td>
          <td><?= $row["OBSERVACION"] ?></td>
          <td><?= $row["STOCK"] ?></td>
          <td><?= $row["PRECIO_UNITARIO"] ?></td>
          <td><?= $row["NOMBRE_PARTE"] ?></td>
          <td>
            <button type="button" class="btn btn-warning" onclick="editar('<?= $row['ID'] ?>');">Editar</button>
            <button type="button" class="btn btn-danger" onclick="eliminar('<?= $row['ID'] ?>');">Eliminar</button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="modal" tabindex="-1" id="modal-editar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Repuesto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="content_editar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="modal-eliminar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Repuesto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="content_eliminar">
          <form method="post" action="/app/modulos/repuesto/delete.php">
            <input type="hidden" name="repuestoId" value="" id="eliminarRepuestoId">
            <div class="form-group">
              <label for="">Estás seguro de elimiar el registro?</label>
            </div>
            <button type="submit" class="btn btn-danger">SI</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function editar(id) {
      $("#content_editar").load("/app/modulos/repuesto/editarRepuesto.php?id=" + id);
      $("#modal-editar").modal("show");
    }

    function eliminar(id) {
      $("#eliminarRepuestoId").val(id);
      $("#modal-eliminar").modal("show");
    }
  </script>

<?php
} else {
  echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>