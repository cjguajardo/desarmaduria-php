<?php

namespace App;

require_once __DIR__ . '/app/helpers/layout.php';
require_once __DIR__ . '/app/helpers/autenticado.php';

use App\Helpers\LayoutHelper as LayoutHelper;
use App\Helpers\Autenticado as Autenticado;

$layout = new LayoutHelper();
$autenticado = Autenticado::verificarAutenticacion();
$rol = Autenticado::rol();


if ($autenticado === true) {
  if ($rol == 1) { // Administrador
    //redirects to the admin page
    header('Location: /app/administrador/index.php');
    exit;
  } else if ($rol == 2) { // Secretaria
    // redirects to the secretary page
    header('Location: /app/secretaria/index.php');
    exit;
  } else { // No se reconoce el rol

  }
} else {
  header('Location: /app/invitado/index.php');
  exit;
}
