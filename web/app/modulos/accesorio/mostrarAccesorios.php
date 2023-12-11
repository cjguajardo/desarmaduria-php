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
  // Mostrar datos en una tabla de Bootstrap
  echo '<table class="table table-bordered">';
  echo '  <thead>';
  echo '    <tr>';
  echo '      <th>Nombre</th>';
  echo '      <th>Marca</th>';
  echo '      <th>Tipo</th>';
  echo '      <th>Descripción</th>';
  echo '      <th>Stock</th>';
  echo '      <th>Precio Unitario</th>';
  echo '      <th>Parte</th>'; // Nuevo encabezado
  echo '      <th>::</th>'; // Opciones
  echo '    </tr>';
  echo '  </thead>';
  echo '  <tbody>';

  // Mostrar datos
  while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row["ACCESORIO"] . '</td>';
    echo '<td>' . $row["MARCA"] . '</td>';
    echo '<td>' . $row["TIPO_ACCESORIO"] . '</td>';
    echo '<td>' . $row["DESCRIPCION"] . '</td>';
    echo '<td>' . $row["STOCK"] . '</td>';
    echo '<td>' . $row["PRECIO_UNITARIO"] . '</td>';
    echo '<td>' . $row["NOMBRE_PARTE"] . '</td>'; // Nueva celda
    echo '<td>' .
      '<button type="button" class="btn btn-warning" onclick="editar(' . $row["ID"] . ');">Editar</button>' .
      '<button type="button" class="btn btn-danger" onclick="eliminar(' . $row["ID"] . ');">Eliminar</button>' .
      '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';
?>

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