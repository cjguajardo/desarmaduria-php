<?php

include __DIR__ . '/../../db.php';


// load all repuestos from the database
$sql = "SELECT repuesto.ID, repuesto.NOMBRE_REPUESTO, repuesto.OBSERVACION, repuesto.STOCK, repuesto.PRECIO_UNITARIO, parte.NOMBRE_PARTE
        FROM repuesto
        INNER JOIN parte ON repuesto.FK_PARTE = parte.ID
        WHERE repuesto.STOCK > 0";

$result = $conn->query($sql);

?>

<h1 class="text-light">Venta de Repuestos</h1>
<hr class="text-light">

<div class="row justify-content-center">
  <div class="col-12 col-md-5">
    <div class="form-group">
      <label for="" class="text-light">Repuesto</label>
      <select class="form-select" name="repuesto" id="repuesto">
        <option value="">Seleccione un repuesto</option>
        <?php
        while ($row = $result->fetch_assoc()) {
          echo '<option value="' . $row["ID"] . '" ' .
            'data-precio="' . $row['PRECIO_UNITARIO'] . '"' .
            'data-stock="' . $row['STOCK'] . '"' .
            '>' . $row["NOMBRE_REPUESTO"] . '</option>';
        }
        ?>
      </select>
    </div>
  </div>

  <div class="col-12 col-md-5">
    <div class="form-group">
      <label for="" class="text-light">Cantidad</label>
      <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad">
    </div>
  </div>

  <div class="col-12 col-md-2">
    <button type="button" class="btn btn-light" onclick="agregar()">Agregar</button>
  </div>
</div>

<table class="table table-responsive mt-4 d-none" id="tabla-carrito">
  <thead>
    <tr>
      <th>Repuesto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Total</th>
      <th>::</th>
    </tr>
  </thead>
  <tbody id="listado-carrito"></tbody>
  <tfoot>
    <tr>
      <td colspan="3"></td>
      <td colspan="2" id="total-carrito"></td>
    </tr>
    <tr>
      <td colspan="5">
        <form action="repuesto/cart.php" method="post" id="cart-repuestos">
          <div class="form-group">
            <label for="" class="text-dark">Cliente</label>
            <input type="text" name="cliente" id="cliente" class="form-control">
          </div>
          <button type="submit" class="btn btn-success" disabled>Enviar</button>
        </form>
      </td>
    </tr>
  </tfoot>
</table>

<script>
  function agregar() {
    const repuestoId = $('#repuesto').val();
    const respuestoStock = $('#repuesto option:selected').data('stock');
    const repuestoPrecio = $('#repuesto option:selected').data('precio');
    const cantidad = $('#cantidad').val();

    if (repuestoId === '') {
      alert('Debe seleccionar un repuesto');
      return;
    }

    if (cantidad === '') {
      alert('Debe ingresar una cantidad');
      return;
    }

    if (cantidad > respuestoStock) {
      alert('No hay suficiente stock');
      return;
    }

    const repuesto = {
      id: repuestoId,
      cantidad: cantidad,
      precio_unitario: repuestoPrecio,
      precio_total: cantidad * repuestoPrecio
    };

    // crea un nuevo input:hidden en cart-repuestos para enviar el repuesto al servidor
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'repuestos[]';
    input.value = JSON.stringify(repuesto);

    $('#cart-repuestos').append(input);

    // actualizar listado-carrito
    const listadoCarrito = $('#listado-carrito');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td role="repuesto" data-id="${repuestoId}">${$('#repuesto option:selected').text()}</td>
      <td>${cantidad}</td>
      <td>${repuestoPrecio}</td>
      <td role="precio">${cantidad * repuestoPrecio}</td>
      <td>
        <button type="button" class="btn btn-danger" onclick="eliminar(this)">Eliminar</button>
      </td>
    `;
    listadoCarrito.append(tr);

    // mustra la tabla
    $('#tabla-carrito').removeClass('d-none');

    // calcula el total del carrito
    const totalCarrito = $('#total-carrito');
    const totales = listadoCarrito.find('td[role="precio"]');
    let total = 0;
    for (let i = 0; i < totales.length; i++) {
      total += parseInt(totales[i].innerText);
    }
    totalCarrito.text(total + ' CLP');

    // limpia los campos
    $('#repuesto').val('');
    $('#cantidad').val('');

    // si el total es mayor a 0, habilita el botón de enviar
    if (total > 0) {
      // solo si el cliente ha sido ingresado se habilita el botón
      if ($('#cliente').val() !== '') {
        $('#cart-repuestos button[type="submit"]').prop('disabled', false);
      } else $('#cart-repuestos button[type="submit"]').prop('disabled', true);
    } else $('#cart-repuestos button[type="submit"]').prop('disabled', true);
  }

  function eliminar(button) {
    const tr = button.parentElement.parentElement;
    const precio = tr.querySelector('td[role="precio"]').innerText;
    const totalCarrito = $('#total-carrito');
    const total = parseInt(totalCarrito.text().replace(' CLP', ''));
    totalCarrito.text((total - parseInt(precio)) + ' CLP');
    tr.remove();

    //elimina el input:hidden del repuesto
    const repuestoId = tr.querySelector('td[role="repuesto"]').dataset.id;
    const input = document.querySelector(`input[name="repuestos[]"][value*="${repuestoId}"]`);
    input.remove();

    // si el total es 0, deshabilita el botón de enviar
    if (total - parseInt(precio) === 0) {
      if ($('#cliente').val() !== '') {
        $('#cart-repuestos button[type="submit"]').prop('disabled', false);
      } else $('#cart-repuestos button[type="submit"]').prop('disabled', true);
    } else $('#cart-repuestos button[type="submit"]').prop('disabled', true);
  }
</script>