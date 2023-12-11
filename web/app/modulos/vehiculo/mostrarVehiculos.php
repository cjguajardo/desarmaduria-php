<?php
// Incluir el archivo de conexión
include 'db.php';

// Query para obtener datos (puedes personalizarla según tus necesidades)
$sql = "SELECT ingreso_vehiculo.FECHA, vehiculo.TIPO, vehiculo.MARCA, vehiculo.MODELO, vehiculo.AGNO, vehiculo.TRANSMISION, vehiculo.COMBUSTIBLE, vehiculo.CILINDRADA
        FROM ingreso_vehiculo
        INNER JOIN VEHICULO ON ingreso_vehiculo.FK_VEHICULO = vehiculo.ID";

$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Mostrar datos en una tabla de Bootstrap
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Fecha de llegada</th>';
    echo '<th>Tipo</th>';
    echo '<th>Marca</th>';
    echo '<th>Modelo</th>';
    echo '<th>Año</th>';
    echo '<th>Transmisión</th>';
    echo '<th>Combustible</th>';
    echo '<th>Cilindrada</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Mostrar datos
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["FECHA"] . '</td>';
        echo '<td>' . $row["TIPO"] . '</td>';
        echo '<td>' . $row["MARCA"] . '</td>';
        echo '<td>' . $row["MODELO"] . '</td>';
        echo '<td>' . $row["AGNO"] . '</td>';
        echo '<td>' . $row["TRANSMISION"] . '</td>';
        echo '<td>' . $row["COMBUSTIBLE"] . '</td>';
        echo '<td>' . $row["CILINDRADA"] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>
