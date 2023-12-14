<?php
// Incluir el archivo de conexión
include __DIR__ . '/../../db.php';
include_once __DIR__ . '/../../helpers/autenticado.php';
include __DIR__ . '/../busqueda/formulario.php';

use App\Helpers\Autenticado;

$estaAutenticado = Autenticado::verificarAutenticacion();

// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT a.*, p.NOMBRE_PARTE, ta.TIPO AS TIPO_ACCESORIO
        FROM accesorio a
        INNER JOIN parte p ON a.FK_PARTE = p.ID
        INNER JOIN tipo_accesorio ta ON a.FK_TIPO_ACCESORIO = ta.ID";

$where = getFilterParams();
// Agregar parametros de búsqueda en caso de que vengan en la request
if (count($where) > 0) {
  $sql .= " WHERE ";
  foreach ($where as $k => $v) {
    $sql .= " $k = '$v' AND";
  }
  $sql = substr($sql, 0, -3);
}

$accesorios = [];
if ($result = $conn->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    $accesorios[] = $row;
  }
}

?>

<h1 class="text-light">Listado de Accesorios</h1>
<hr class="text-light">

<?= renderFormulario2('accesorios', true, false, false, false); ?>

<?php if (count($accesorios) > 0) { ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Stock</th>
        <th>Precio Unitario</th>
        <th>Parte</th>
        <?php if ($estaAutenticado === true) { ?>
          <th>::</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($accesorios as $row) { ?>
        <tr>
          <td><?= $row["ACCESORIO"] ?></td>
          <td><?= $row["MARCA"] ?></td>
          <td><?= $row["TIPO_ACCESORIO"] ?></td>
          <td><?= $row["DESCRIPCION"] ?></td>
          <td><?= $row["STOCK"] ?></td>
          <td><?= $row["PRECIO_UNITARIO"] ?></td>
          <td><?= $row["NOMBRE_PARTE"] ?></td>
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
            <h5 class="modal-title">Editar Accesorio</h5>
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
            <h5 class="modal-title">Eliminar Accesorio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="content_eliminar">
            <form method="post" action="/app/modulos/accesorio/delete.php">
              <input type="hidden" name="accesorioId" value="" id="eliminarAccesorioId">
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
        $("#content_editar").load("/app/modulos/accesorio/editarAccesorio.php?id=" + id);
        $("#modal-editar").modal("show");
      }

      function eliminar(id) {
        $("#eliminarAccesorioId").val(id);
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