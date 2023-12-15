<?php

namespace App\Helpers;

require_once __DIR__ . '/links.php';
require_once __DIR__ . '/autenticado.php';

use App\Helpers\Links as Links;
use App\Helpers\Autenticado as Autenticado;

class LayoutHelper
{
  private $template;
  private $toast;
  private $sidebar;
  private $sidebaritem;

  public function __construct()
  {
    $template = file_get_contents(__DIR__ . '/layout.template');
    $this->template = $template;

    $toast = file_get_contents(__DIR__ . '/toast.template');
    $this->toast = $toast;

    $sidebar = file_get_contents(__DIR__ . '/sidebar.template');
    $this->sidebar = $sidebar;

    $sidebaritem = file_get_contents(__DIR__ . '/sidebaritem.template');
    $this->sidebaritem = $sidebaritem;
  }

  public function render(String $title, String $content, String $header = '')
  {
    $this->template = str_replace('{{CONTENT}}', $content, $this->template);
    $this->template = str_replace('{{HEADER}}', $header, $this->template);
    $this->template = str_replace('{{TOAST}}', '', $this->template);

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
      } else {
        $this->template = str_replace('{{TOAST}}', '', $this->template);
      }

      $this->template = str_replace('{{SCRIPTS}}', $scripts, $this->template);
    }

    echo $this->template;
    exit;
  }
  public function renderGuest()
  {
    $section = $_GET['section'] ?? 'index';
    if (stripos($section, '?') !== false) {
      $section = substr($section, 0, stripos($section, '?'));
    }

    $rol = 0;

    $title = 'Invitado';
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
      $header .= '      <a href="/app/auth/index.php" class="btn btn-primary">Ingresar</a>';
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

    if (count($links) == 0) {
      return '';
    }
    if (!isset($links['sublinks']) || count($links['sublinks']) == 0) {
      return '';
    }

    $sidebar = $this->sidebar;
    $sidebarItems = '';

    foreach ($links['sublinks'] as $link) {
      $sidebarItems .= $this->renderSidebarItem($link['href'], $link['title']);
    }

    $sidebar = str_replace('{{ITEMS}}', $sidebarItems, $sidebar);

    return $sidebar;
  }

  private function renderSidebarItem(String $href, String $title): string
  {
    $sidebaritem = $this->sidebaritem;
    $sidebaritem = str_replace('{{LINK}}', $href, $sidebaritem);
    $sidebaritem = str_replace('{{TITLE}}', $title, $sidebaritem);
    $sidebaritem = str_replace('{{ID}}', str_replace('#', '', $href), $sidebaritem);

    return $sidebaritem;
  }

  public function renderToast(String $mensaje, String $titulo, String $tipo = 'success'): string
  {
    switch (strtolower($tipo)) {
      case 'success':
      case 'error':
      case 'info':
        break;
      default:
        $tipo = 'info';
        break;
    }

    $id = 'toast_' . md5($mensaje . $titulo . $tipo);

    $html = $this->toast;
    $html = str_replace('{{ID}}', $id, $html);
    $html = str_replace('{{ICON}}', $tipo, $html);
    $html = str_replace('{{TITLE}}', $titulo, $html);
    $html = str_replace('{{CONTENT}}', $mensaje, $html);

    return $html;
  }

  public function renderNoAutenticado(): string
  {
    $html = '<div class="alert alert-danger" role="alert">';
    $html .= 'No tienes permisos para acceder a esta página';
    $html .= '</div>';

    return $html;
  }
}
