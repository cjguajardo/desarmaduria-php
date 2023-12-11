<?php

namespace App\Invitado;

require_once __DIR__ . '/../helpers/layout.php';
require_once __DIR__ . '/../helpers/autenticado.php';

use App\Helpers\LayoutHelper as LayoutHelper;
use App\Helpers\Autenticado as Autenticado;

$layout = new LayoutHelper();
$autenticado = Autenticado::verificarAutenticacion();
$rol = Autenticado::rol();

if (!$autenticado) {
  Autenticado::redireccionar(null);
} else {
  if ($rol == 1) {
    $layout->renderAuthenticated();
  } else {
    Autenticado::redireccionar($rol);
  }
}
