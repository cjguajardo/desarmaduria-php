$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "listado" ) {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  } else if ( hash == "agregar" ) {
    cargaVista( "/app/modulos/repuesto/agregarRepuesto.php", "#contenido" );
  } else if ( hash == "ingresar" ) {
    cargaVista( "/app/modulos/repuesto/ingresarRepuesto.php", "#contenido" );
  } else {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  }

  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/repuesto/mostrarRepuestos.php", "#contenido" );
  } );
  $( "#agregar" ).click( function () {
    cargaVista( "/app/modulos/repuesto/agregarRepuesto.php", "#contenido" );
  } );
  $( "#ingresar" ).click( function () {
    cargaVista( "/app/modulos/repuesto/ingresarRepuesto.php", "#contenido" );
  } );
} );