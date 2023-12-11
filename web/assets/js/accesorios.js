$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "listado" ) {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  } else if ( hash == "agregar" ) {
    cargaVista( "/app/modulos/accesorio/agregarAccesorio.php", "#contenido" );
  } else if ( hash == "venta" ) {
    cargaVista( "/app/modulos/accesorio/ventaAccesorios.php", "#contenido" );
  } else if ( hash == "proveedores" ) {
    $( "#contenido" ).load( "/app/proveedores.php" );
  } else if ( hash == "reportes" ) {
    $( "#contenido" ).load( "/app/modulos/accesorio/reportes.php" );
  } else if ( hash == "comprobante" ) {
    cargaVista( "/app/modulos/accesorio/comprobante.php?id=" + parts[1], "#contenido" );
  } else {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  }

  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  } );
  $( "#agregar" ).click( function () {
    cargaVista( "/app/modulos/accesorio/agregarAccesorio.php", "#contenido" );
  } );
  $( "#venta" ).click( function () {
    cargaVista( "/app/modulos/accesorio/ventaAccesorios.php", "#contenido" );
  } );
  $( "#proveedores" ).click( function () {
    $( "#contenido" ).load( "/app/proveedores.php" );
  } );
  $( "#reportes" ).click( function () {
    $( "#contenido" ).load( "/app/modulos/accesorio/reportes.php" );
  } );
} );