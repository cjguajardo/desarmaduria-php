$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "listado" ) {
    cargaVista( "/app/modulos/vehiculo/mostrarVehiculos.php", "#contenido" );
  } else if ( hash == "ingresar" ) {
    cargaVista( "/app/modulos/vehiculo/agregarVehiculo.php", "#contenido" );
  } else {
    cargaVista( "/app/modulos/vehiculo/mostrarVehiculos.php", "#contenido" );
  }

  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/vehiculo/mostrarVehiculos.php", "#contenido" );
  } );
  $( "#ingresar" ).click( function () {
    cargaVista( "/app/modulos/vehiculo/agregarVehiculo.php", "#contenido" );
  } );

} );