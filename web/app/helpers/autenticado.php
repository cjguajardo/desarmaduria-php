<?php

namespace App\Helpers;

session_start();

class Autenticado
{

  public static function verificarAutenticacion(): bool
  {
    $rut = isset($_SESSION['rut']) ? $_SESSION['rut'] : null;
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
    $autenticado = $rut != null && $rol != null;

    return $autenticado;
  }

  public static function rol()
  {
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
    return $rol;
  }

  public static function verificarRol($rol)
  {
    $rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
    $autenticado = Autenticado::verificarAutenticacion();

    if (!$autenticado) {
      return false;
    }

    if ($rolUsuario != $rol) {
      return false;
    }

    // get the current page
    $currentPage = $_SERVER['REQUEST_URI'];
    echo $currentPage;
  }

  public static function redireccionar($rol)
  {
    $autenticado = Autenticado::verificarAutenticacion();

    if (!$autenticado) {
      header('Location: /index.php');
      exit;
    }

    if ($rol === 1) { // Administrador
      // redirects to the admin page
      header('Location: /app/administrador/index.php');
      exit;
    } else if ($rol === 2) { // Secretaria
      // redirects to the secretary page
      header('Location: /app/secretaria/index.php');
      exit;
    } else { // No se reconoce el rol
      // remove all url params and hashes
      $_SERVER['QUERY_STRING'] = '';
      $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '?');
      $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '#');

      header('Location: /index.php');
      exit;
    }
  }

  public static function obtenerMensaje()
  {
    $mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
    $resultado = isset($_SESSION['resultado']) ? $_SESSION['resultado'] : 'info';
    if ($mensaje != null) {
      unset($_SESSION['mensaje']);
    }
    if ($resultado != null) {
      unset($_SESSION['resultado']);
    }
    return [$mensaje, $resultado];
  }
}
