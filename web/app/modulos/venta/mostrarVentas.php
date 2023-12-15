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

?>

<h1 class="text-light">Listado de Ventas</h1>
<hr class="text-light">