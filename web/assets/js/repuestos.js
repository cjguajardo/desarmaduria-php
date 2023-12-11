$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "listado" ) {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  } else if ( hash == "agregar" ) {
    cargaVista( "/app/modulos/repuesto/agregarRepuesto.php", "#contenido" );
  } else if ( hash == "venta" ) {
    cargaVista( "/app/modulos/repuesto/ventaRepuestos.php", "#contenido" );
  } else if ( hash == "proveedores" ) {
    $( "#contenido" ).load( "/app/proveedores.php" );
  } else if ( hash == "reportes" ) {
    $( "#contenido" ).load( "/app/modulos/repuesto/reportes.php" );
  } else if ( hash == "comprobante" ) {
    cargaVista( "/app/modulos/repuesto/comprobante.php?id=" + parts[1], "#contenido" );
  } else {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  }

  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  } );
  $( "#agregar" ).click( function () {
    cargaVista( "/app/modulos/repuesto/agregarRepuesto.php", "#contenido" );
  } );
  $( "#venta" ).click( function () {
    cargaVista( "/app/modulos/repuesto/ventaRepuestos.php", "#contenido" );
  } );
  $( "#proveedores" ).click( function () {
    $( "#contenido" ).load( "/app/proveedores.php" );
  } );
  $( "#reportes" ).click( function () {
    $( "#contenido" ).load( "/app/modulos/repuesto/reportes.php" );
  } );
} );