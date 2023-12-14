<?php
// Incluir el archivo de conexión
include __DIR__ . '/../../db.php';
include_once __DIR__ . '/../../helpers/autenticado.php';
include __DIR__ . '/../busqueda/formulario.php';

use App\Helpers\Autenticado;

$estaAutenticado = Autenticado::verificarAutenticacion();

// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT 
        r.ID, r.NOMBRE_REPUESTO, 
        r.OBSERVACION, r.STOCK, 
        r.PRECIO_UNITARIO, 
        p.NOMBRE_PARTE,
        v.MARCA, v.MODELO, v.AGNO, v.COMBUSTIBLE
        FROM repuesto r
        INNER JOIN parte p ON r.FK_PARTE = p.ID
        INNER JOIN vehiculo v ON v.ID = r.FK_VEHICULO";

$where = getFilterParams();
// Agregar parametros de búsqueda en caso de que vengan en la request
if (count($where) > 0) {
  $sql .= " WHERE ";
  foreach ($where as $k => $v) {
    $sql .= " $k = '$v' AND";
  }
  $sql = substr($sql, 0, -3);
}

$result = $conn->query($sql);

$repuestos = [];
if ($result = $conn->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    $repuestos[] = $row;
  }
}

?>

<h1 class="text-light">Listado de Repuestos</h1>
<hr class="text-light">

<?= renderFormulario('repuestos'); ?>

<?php if (count($repuestos) > 0) { ?>
  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Repuesto</th>
        <th>Observación</th>
        <th>Stock</th>
        <th>Precio Unitario</th>
        <th>Parte</th>
        <th>Vehículo</th>
        <?php if ($estaAutenticado === true) { ?>
          <th>::</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($repuestos as $row) { ?>
        <tr>
          <td><?= $row["NOMBRE_REPUESTO"] ?></td>
          <td><?= $row["OBSERVACION"] ?></td>
          <td><?= $row["STOCK"] ?></td>
          <td><?= $row["PRECIO_UNITARIO"] ?></td>
          <td><?= $row["NOMBRE_PARTE"] ?></td>
          <td>
            <span>
              <?= $row["MARCA"] ?>
            </span>
            <span>
              <?= $row["MODELO"] ?>
            </span>
            <span>
              <?= $row["AGNO"] ?>
            </span>
            <span>
              <?= $row["COMBUSTIBLE"] ?>
            </span>
          </td>
          <?php if ($estaAutenticado === true) { ?>
            <td>
              <button type="button" class="btn btn-warning" onclick="editar('<?= $row['ID'] ?>');">Editar</button>
              <button type="button" class="btn btn-danger" onclick="eliminar('<?= $row['ID'] ?>');">Eliminar</button>
            </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php if ($estaAutenticado === true) { ?>
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
  <?php } ?>

<?php } else { ?>
  <div class="alert alert-warning">
    <strong>¡Atención!</strong> No se encontraron resultados.
  </div>
<?php } ?>

<?php cerrarConexion(); ?>