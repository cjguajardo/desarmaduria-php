<?php

namespace App\Helpers;

class Links
{

  private $links = [
    1 => [
      [
        'title' => 'Accesorios',
        'href' => 'index.php?section=accesorios',
        'sublinks' => [
          ['title' => 'Listado', 'href' => '#listado'],
          ['title' => 'Agregar', 'href' => '#agregar'],
        ]
      ],
      [
        'title' => 'Repuestos',
        'href' => 'index.php?section=repuestos',
        'sublinks' => [
          ['title' => 'Listado', 'href' => '#listado'],
          ['title' => 'Agregar', 'href' => '#agregar'],
        ]
      ],
      [
        'title' => 'Vehículos',
        'href' => 'index.php?section=vehiculos',
        'sublinks' => [
          ['title' => 'Ingresar', 'href' => '#ingresar'],
          ['title' => 'Listado', 'href' => '#listado']
        ]
      ],
      [
        'title' => 'Ventas',
        'href' => 'index.php?section=ventas',
        'sublinks' => [
          ['title' => 'Generar Venta', 'href' => '#venta'],
          ['title' => 'Listado de Ventas', 'href' => '#listado'],
          ['title' => 'Reportes', 'href' => '#reportes'],
        ],
      ]
    ],
    2 => [
      [
        'title' => 'Accesorios',
        'href' => 'index.php?section=accesorios',
        'sublinks' => [
          ['title' => 'Listado', 'href' => '#listado'],
        ]
      ],
      [
        'title' => 'Repuestos',
        'href' => 'index.php?section=repuestos',
        'sublinks' => [
          ['title' => 'Listado', 'href' => '#listado'],
        ]
      ],
      [
        'title' => 'Ventas',
        'href' => 'index.php?section=ventas',
        'sublinks' => [
          ['title' => 'Generar Venta', 'href' => '#venta'],
          ['title' => 'Listado de Ventas', 'href' => '#listado'],
        ],
      ],
    ]
  ];

  public function getLinks($rol): array
  {
    return $this->links[$rol] ?? [];
  }
}

/*
<!-- Barra lateral -->
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light">
      <div class="position-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#listado" id="listado">
              Listado
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#agregar" id="agregar">
              Agregar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#venta" id="venta">
              Venta
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#proveedores" id="proveedores">
              Proveedores
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#reportes" id="reportes">
              Reportes
            </a>
          </li>
        </ul>
      </div>
    </nav>
*/

/*
menus			
			
secretaria			
			
repyaccesorios	buscar-editar		
ventas	ingresar 		
	generar comprobante		
			
			
Administrador	B		
vehiculos	ingresar 		
repyaccesorios	buscar-editar		
ventas	ingresar 		
	generar comprobante		
			
usuarios			
repyaccesorios	buscar xmarca-modelo-año-combustible		
vehiculos	buscarx marca modelo año combustible		
*/