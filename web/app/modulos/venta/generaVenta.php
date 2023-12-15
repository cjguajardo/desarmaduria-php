<?php

include __DIR__ . '/../../db.php';
include_once __DIR__ . '/../../helpers/autenticado.php';
include_once __DIR__ . '/../../helpers/layout.php';
include __DIR__ . '/../busqueda/formulario.php';

use App\Helpers\Autenticado;
use App\Helpers\LayoutHelper;

$estaAutenticado = Autenticado::verificarAutenticacion();

if (!$estaAutenticado) {
  $layout = new LayoutHelper();
  echo $layout->renderNoAutenticado();
  exit;
}

$clientes = [];
$query = "SELECT DISTINCT NOMBRE_CLIENTE FROM venta";
$result = $conn->query($query);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
  }
}

?>

<h1 class="text-light">Generar Venta</h1>
<hr class="text-light">

<div class="card mb-3">
  <div class="card-body">

    <!-- CLIENTE -->
    <div class="form-group">
      <label for="" class="text-dark">Cliente</label>
      <input type="text" id="nombre_cliente" list="clientes" class="form-control" value="">
      <datalist id="clientes">
        <?php foreach ($clientes as $cliente) : ?>
          <option value="<?= $cliente['NOMBRE_CLIENTE'] ?>" />
        <?php endforeach; ?>
      </datalist>
      <div class="text-danger fw-bold small" id="err_nombre_cliente"></div>
    </div>

    <!-- REPUESTO -->
    <div class="card mt-3">
      <div class="card-header">
        <div class="form-group">
          <label for="buscar_repuesto">Repuesto</label>
          <input type="text" name="buscar_repuesto" id="buscar_repuesto" class="form-control" />
        </div>
      </div>
      <div class="card-body" id="listado_repuestos">
        <!-- RESULTADO -->
      </div>
    </div>

    <!-- ACCESORIO -->
    <div class=" card mt-3">
      <div class="card-header">
        <div class="form-group">
          <label for="buscar_accesorio">Accesorio</label>
          <input type="text" name="buscar_accesorio" id="buscar_accesorio" class="form-control" />
        </div>
      </div>
      <div class="card-body" id="listado_accesorios">
        <!-- RESULTADOS -->
      </div>
    </div>
  </div>
</div>

<div class=" card">
  <div class="card-header">Carrito</div>
  <div class="card-body">
    <table class="table table-responsive" id="tabla-carrito">
      <thead>
        <tr>
          <th>Item</th>
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
      </tfoot>
    </table>
  </div>
  <div class="card-footer">
    <div class="row justify-content-center">
      <div class="col-12 col-md-3">
        <form action="/app/modulos/venta/cart.php" method="post" id="cart">
          <input type="hidden" name="cliente" id="cliente" />
          <button type="submit" class="btn btn-primary w-100" disabled>Generar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
  const cliente = sessionStorage.getItem('cliente') || '';
  $(document).ready(function() {
    const $buscarRepuesto = $('#buscar_repuesto');
    const $buscarAccesorio = $('#buscar_accesorio');
    const $listadoRepuestos = $('#listado_repuestos');
    const $listadoAccesorios = $('#listado_accesorios');
    const $listadoCarrito = $('#listado-carrito');
    const $totalCarrito = $('#total-carrito');
    const $cliente = $('#nombre_cliente');
    const $inputCliente = $("#cliente")
    const $form = $('#cart');

    if (carrito.length > 0) {
      carrito.forEach(function(item) {
        $listadoCarrito.append(creaItemCarrito(item));

        // generar input hidden en form
        const input = document.createElement('input');
        input.type = 'hidden';
        input.dataset.id = `${item.TIPO}_${item.ID}`;
        input.name = 'items[]';
        input.value = JSON.stringify(item);
        $form.prepend(input);
      });
      $totalCarrito.html(`$ ${calcularTotal()}`);
    }

    if (cliente.length > 0) {
      $cliente.val(cliente);
      $cliente.attr('value', cliente)
      $inputCliente.val(cliente);
      $inputCliente.attr('value', cliente);
      calcularTotal();
    }

    $buscarRepuesto.on('keyup', function() {
      const nombreRepuesto = $(this).val();

      $.ajax({
        url: '/app/modulos/repuesto/buscar.php',
        method: 'GET',
        data: {
          nombre_repuesto: nombreRepuesto
        },
        success: function(items) {
          $listadoRepuestos.html('');
          items.forEach(function(item) {
            $listadoRepuestos.append(creaItemBusqueda({
              ...item,
              TIPO: 'REPUESTO'
            }));
          });
        }
      });
    });

    $buscarAccesorio.on('keyup', function() {
      const nombreAccesorio = $(this).val();

      $.ajax({
        url: '/app/modulos/accesorio/buscar.php',
        method: 'GET',
        data: {
          nombre_accesorio: nombreAccesorio
        },
        success: function(items) {
          console.log(items);
          $listadoAccesorios.html('');
          items.forEach(function(item) {
            $listadoAccesorios.append(creaItemBusqueda({
              ...item,
              TIPO: 'ACCESORIO'
            }));
          });
        }
      });
    });

    $cliente.on('change', function() {
      const $this = $(this);
      const nombre = $this.val();
      sessionStorage.setItem('cliente', nombre);
      $inputCliente.val(nombre);
      $inputCliente.attr('value', nombre);

      calcularTotal();
    });

    function creaItemBusqueda({
      TAG,
      ID,
      NOMBRE,
      STOCK,
      PRECIO_UNITARIO,
      TIPO
    }) {
      const item = `
        <form class="row" id="IT_${TAG}">
          <input type="hidden" name="ID" value="${ID}" />
          <input type="hidden" name="TIPO" value="${TIPO}" />
          <div class="col-4">
            <div class="form-control" name="NOMBRE">
              ${NOMBRE}
            </div>
          </div>
          <div class="col-3">
            <div class="input-group">
              <span class="input-group-text">${STOCK} / </span>
              <input type="number" class="form-control" min="1" max="${parseInt(STOCK)-1}" name="CANTIDAD" placeholder="Cantidad" value="1" />
            </div>
          </div>
          <div class="col-3">
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" readonly name="PRECIO_UNITARIO" class="form-control" value="${PRECIO_UNITARIO}" />
            </div>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-primary w-100" onclick="agregar('${TAG}')">Agregar</button>
          </div>
        </form>
      `;

      return item;
    }

  });


  function agregar(tag) {
    const $listadoCarrito = $('#listado-carrito');
    const $totalCarrito = $('#total-carrito');
    const $item = $(`#IT_${tag}`);
    const $cantidad = $item.find('[name="CANTIDAD"]');
    const $precioUnitario = $item.find('[name="PRECIO_UNITARIO"]');
    const $id = $item.find('[name="ID"]');
    const $tipo = $item.find('[name="TIPO"]').val();
    const $nombre = $item.find('[name="NOMBRE"]').html();

    const cantidad = parseInt($cantidad.val());
    const precioUnitario = parseInt($precioUnitario.val());
    const id = parseInt($id.val());
    const $form = $('#cart');

    const item = {
      ID: id,
      NOMBRE: $nombre.trim(),
      CANTIDAD: cantidad,
      PRECIO_UNITARIO: precioUnitario,
      TIPO: $tipo,
    };

    // buscar item en carrito
    const index = carrito.findIndex(function(item) {
      return item.ID === id && item.TIPO === $tipo;
    });
    if (index > -1) {
      carrito[index].CANTIDAD += cantidad;
      const tr = $listadoCarrito.find(`tr[data-id="${item.ID}"][data-tipo="${item.TIPO}"]`);
      tr.find('td').eq(1).html(carrito[index].CANTIDAD);
      tr.find('td').eq(3).html(`$ ${carrito[index].CANTIDAD * carrito[index].PRECIO_UNITARIO}`);
      $item.remove();
      $totalCarrito.html(`$ ${calcularTotal()}`);
      // actualizar carrito en session storage
      sessionStorage.setItem('carrito', JSON.stringify(carrito));

      // actualizar input hidden en form
      const input = $form.find(`input[data-id="${item.TIPO}_${item.ID}"]`);
      input.val(JSON.stringify(carrito[index]));

      return;
    }

    carrito.push(item);
    // guardar carrito en session storage
    sessionStorage.setItem('carrito', JSON.stringify(carrito));

    // generar input hidden en form
    const input = document.createElement('input');
    input.type = 'hidden';
    input.dataset.id = `${item.TIPO}_${item.ID}`;
    input.name = 'items[]';
    input.value = JSON.stringify(item);
    $form.prepend(input);

    $item.remove();

    $listadoCarrito.append(creaItemCarrito(item));

    $totalCarrito.html(`$ ${calcularTotal()}`);
  }

  function eliminar(button) {
    const tr = $(button.parentElement.parentElement);
    const tipo = tr.data('tipo');
    const id = tr.data('id');

    const index = carrito.findIndex(function(item) {
      return item.ID === id && item.TIPO === tipo;
    });

    if (index > -1) {
      carrito.splice(index, 1);
      tr.remove();
      $('#total-carrito').html(`$ ${calcularTotal()}`);
      sessionStorage.setItem('carrito', JSON.stringify(carrito));
      $(`#cart input[data-id="${tipo}_${id}"]`).remove();
    }
  }

  function creaItemCarrito({
    ID,
    NOMBRE,
    CANTIDAD,
    PRECIO_UNITARIO,
    TIPO
  }) {
    const item = `
    <tr role="${TIPO}" data-id="${ID}" data-tipo="${TIPO}">
      <td>
        <span class="flex-inline small text-info me-3">${TIPO === 'REPUESTO' ? 'R' : 'A'}</span>
        ${NOMBRE}
      </td>
      <td>${CANTIDAD}</td>
      <td>$ ${PRECIO_UNITARIO}</td>
      <td role="precio">$ ${CANTIDAD * PRECIO_UNITARIO}</td>
      <td>
        <button type="button" class="btn btn-danger" onclick="eliminar(this)">Eliminar</button>
      </td>
    </tr>
    `;

    return item;
  }

  function calcularTotal() {
    const total = carrito.reduce(function(total, item) {
      return total + (item.CANTIDAD * item.PRECIO_UNITARIO);
    }, 0);

    if (total > 0) {
      const $cliente = $('#nombre_cliente');
      if ($cliente.val().length == 0) {
        $('#err_nombre_cliente').html('Debe ingresar un cliente');
      } else {
        $('#err_nombre_cliente').html('');
      }

      $('#cliente').val($cliente.val());
      if ($cliente.val().length == 0) {
        $('#cart button').attr('disabled', 'disabled');
      } else {
        $('#cart button').removeAttr('disabled');
      }
    } else {
      $('#cart button').attr('disabled', 'disabled');
    }

    return total;
  }
</script>