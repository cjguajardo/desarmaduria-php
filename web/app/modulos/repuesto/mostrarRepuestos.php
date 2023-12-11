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
  echo '<table class="table table-bordered table-responsive">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Nombre del Repuesto</th>';
  echo '<th>Observación</th>';
  echo '<th>Stock</th>';
  echo '<th>Precio Unitario</th>';
  echo '<th>Nombre de la Parte</th>'; // Nuevo encabezado
  echo '<th>::</th>'; // Opciones
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  // Mostrar datos
  while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row["NOMBRE_REPUESTO"] . '</td>';
    echo '<td>' . $row["OBSERVACION"] . '</td>';
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