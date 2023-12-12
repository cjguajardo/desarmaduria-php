<?php
// Incluir el archivo de conexión
include __DIR__ . '/../../db.php';


// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT accesorio.*, parte.NOMBRE_PARTE, ta.TIPO AS TIPO_ACCESORIO
        FROM accesorio
        INNER JOIN parte ON accesorio.FK_PARTE = parte.ID
        INNER JOIN tipo_accesorio ta ON accesorio.FK_TIPO_ACCESORIO = ta.ID";

$result = $conn->query($sql);

?>

<h1 class="text-light">Listado de Accesorios</h1>
<hr class="text-light">

<?php

// Verificar si hay resultados
if ($result->num_rows > 0) {
?>
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
        <th>::</th>
      </tr>
    </thead>
    <tbody>

      <?php
      while ($row = $result->fetch_assoc()) {
      ?>
        <tr>
          <td><?= $row["ACCESORIO"] ?></td>
          <td><?= $row["MARCA"] ?></td>
          <td><?= $row["TIPO_ACCESORIO"] ?></td>
          <td><?= $row["DESCRIPCION"] ?></td>
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

<?php
} else {
  echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>