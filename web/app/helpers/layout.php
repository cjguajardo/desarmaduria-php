<?php

namespace App\Helpers;

require_once __DIR__ . '/links.php';
require_once __DIR__ . '/autenticado.php';

use App\Helpers\Links as Links;
use App\Helpers\Autenticado as Autenticado;

class LayoutHelper
{
  private $template;

  public function __construct()
  {
    $template = file_get_contents(__DIR__ . '/layout.template');
    $this->template = $template;
  }

  public function render(String $title, String $content, String $header = '')
  {
    $this->template = str_replace('{{CONTENT}}', $content, $this->template);
    $this->template = str_replace('{{HEADER}}', $header, $this->template);

    if (!Autenticado::verificarAutenticacion()) {
      $this->template = str_replace('{{TITLE}}', 'Desarmaduría', $this->template);
      $this->template = str_replace('{{SCRIPTS}}', '', $this->template);
      $this->template = str_replace('{{SIDEBAR}}', '', $this->template);
    }

    echo $this->template;
    exit;
  }
  public function renderAuthenticated()
  {
    $section = $_GET['section'] ?? 'index';
    if (stripos($section, '?') !== false) {
      $section = substr($section, 0, stripos($section, '?'));
    }

    if (Autenticado::verificarAutenticacion()) {
      $rol = Autenticado::rol();
      $title = '';
      if ($rol == 1) {
        $title = 'Administrador';
      } else if ($rol == 2) {
        $title = 'Secretaria';
      }
      $this->template = str_replace('{{TITLE}}', $title . ' # ' . strtoupper($section), $this->template);

      // $content = file_get_contents(__DIR__ . '/../' . $section . '.php');
      $this->template = str_replace('{{CONTENT}}', '', $this->template);

      $header = $this->renderHeader($rol);
      $this->template = str_replace('{{HEADER}}', $header, $this->template);

      $sidebar = $this->renderSidebar($rol);
      $this->template = str_replace('{{SIDEBAR}}', $sidebar, $this->template);

      $scripts = '<script src="/assets/js/' . $section . '.js"></script>';

      [$mensaje, $resultado] = Autenticado::obtenerMensaje();
      if ($mensaje != null) {
        $toast = $this->renderToast($mensaje, strtoupper($section), $resultado);
        $this->template = str_replace('{{TOAST}}', $toast, $this->template);
        $scripts .= '<script type="text/javascript">';
        $scripts .= '$(document).ready(function(){$(\'#liveToast\').toast(\'show\');});';
        $scripts .= 'setTimeout(function(){$(\'#liveToast\').toast(\'hide\');}, 5000);';
        $scripts .= '</script>';
      } else {
        $this->template = str_replace('{{TOAST}}', '', $this->template);
      }

      $this->template = str_replace('{{SCRIPTS}}', $scripts, $this->template);
    }

    echo $this->template;
    exit;
  }

  public function renderHeader(int $rol): string
  {
    $links = new Links();
    $links = $links->getLinks($rol);

    $header = '';

    $header .= '<nav class="navbar navbar-expand-sm sticky-top bg-dark border-bottom border-body" data-bs-theme="dark">';
    $header .= '  <div class="container-fluid">';
    $header .= '    <a class="navbar-brand" href="#">';
    $header .= '      <img src="/assets/img/logo.svg" alt="Desarmaduría" width="30" height="24" class="text-light">';
    $header .= '    </a>';
    $header .= '    <ul class="navbar-nav me-auto nav-underline">';

    foreach ($links as $link) {
      $header .= '      <li class="nav-item">';
      $header .= '        <a href="' . $link['href'] . '" class="nav-link">' . $link['title'] . '</a>';
      $header .= '      </li>';
    }

    $header .= '    </ul>';

    if ($rol == 1 || $rol == 2) {
      $header .= '    <form class="d-flex">';
      $header .= '      <a href="/app/auth/logout.php" class="btn btn-primary">Cerrar Sesión</a>';
      $header .= '    </form>';
    } else {
      $header .= '    <form class="d-flex">';
      $header .= '      <a href="/app/auth/login.php" class="btn btn-primary">Ingresar</a>';
      $header .= '    </form>';
    }

    $header .= '  </div>';
    $header .= '</nav>';

    return $header;
  }

  public function renderSidebar(int $rol): string
  {
    $section = $_GET['section'] ?? 'index';

    if ($section == 'index') {
      return '';
    }

    $base = 'index.php?section=' . $section;

    $links = new Links();
    $links = array_values(array_filter($links->getLinks($rol), function ($link) use ($base) {
      return $link['href'] == $base;
    }))[0] ?? [];

    $sidebar = '';

    if (count($links) == 0) {
      return '';
    }
    if (!isset($links['sublinks']) || count($links['sublinks']) == 0) {
      return '';
    }


    $sidebar .= '<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light pe-0">';
    $sidebar .= '  <div class="position-sticky mt-3">';
    $sidebar .= '    <ul class="nav flex-column">';

    foreach ($links['sublinks'] as $link) {
      $sidebar .= '      <li class="nav-item">';
      $sidebar .= '        <a class="nav-link" href="' . $link['href'] . '" id="' . str_replace('#', '', $link['href']) . '">';
      $sidebar .= '          ' . $link['title'];
      $sidebar .= '        </a>';
      $sidebar .= '      </li>';
    }

    $sidebar .= '    </ul>';
    $sidebar .= '  </div>';
    $sidebar .= '</nav>';

    return $sidebar;
  }

  public function renderToast(String $mensaje, String $titulo, String $tipo = 'success'): string
  {
    $toast = '';

    $toast .= '<div class="toast-container position-fixed bottom-0 end-0 p-3">';
    $toast .= '  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">';
    $toast .= '    <div class="toast-header">';
    $toast .= '      <img src="/assets/img/' . $tipo . '.svg" class="rounded me-2" alt="...">';
    $toast .= '      <strong class="me-auto">' . $titulo . '</strong>';
    $toast .= '      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>';
    $toast .= '    </div>';
    $toast .= '    <div class="toast-body">';
    $toast .= '      ' . $mensaje;
    $toast .= '    </div>';
    $toast .= '  </div>';
    $toast .= '</div>';

    return $toast;
  }
}
