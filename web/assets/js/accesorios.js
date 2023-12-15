$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "listado" ) {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  } else if ( hash == "agregar" ) {
    cargaVista( "/app/modulos/accesorio/agregarAccesorio.php", "#contenido" );
  } else if ( hash == "ingresar" ) {
    cargaVista( "/app/modulos/accesorio/ingresarAccesorio.php", "#contenido" );
  } else {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  }

  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/accesorio/mostrarAccesorios.php", "#contenido" );
  } );
  $( "#agregar" ).click( function () {
    cargaVista( "/app/modulos/accesorio/agregarAccesorio.php", "#contenido" );
  } );
  $( "#ingresar" ).click( function () {
    cargaVista( "/app/modulos/accesorio/ingresarAccesorio.php", "#contenido" );
  } );
} );