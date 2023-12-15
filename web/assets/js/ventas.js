$( document ).ready( function () {
  const parts = window.location.hash.split( '?' );
  const hash = parts[0].replace( '#', '' );

  if ( hash == "venta" ) {
    cargaVista( "/app/modulos/venta/generaVenta.php", "#contenido" );
  } else if ( hash == "listado" ) {
    cargaVista( "/app/modulos/venta/mostrarVentas.php", "#contenido" );
  } else if ( hash == "reportes" ) {
    cargaVista( "/app/modulos/venta/reporte.php", "#contenido" );
  } else if ( hash.startsWith( "comprobante" ) ) {
    // obtener id de la venta para mostrar el comprobante
    // .../index.php?section=ventas#comprobante&id=1
    const id = hash.split( '=' )[1];
    console.log( { id } );
    sessionStorage.setItem( "id_venta", id );
    cargaVista( "/app/modulos/venta/comprobante.php", "#contenido" );
  } else {
    cargaVista( "/app/modulos/venta/mostrarVentas.php", "#contenido" );
  }

  $( "#venta" ).click( function () {
    cargaVista( "/app/modulos/venta/generaVenta.php", "#contenido" );
  } );
  $( "#listado" ).click( function () {
    cargaVista( "/app/modulos/venta/mostrarVentas.php", "#contenido" );
  } );
  $( "#reportes" ).click( function () {
    cargaVista( "/app/modulos/venta/reporte.php", "#contenido" );
  } );
} );