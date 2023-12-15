function cargaVista ( url, id ) {
  // muestra loader mientras carga la vista
  $( id ).html( `
  <div class="d-flex justify-content-center pt-4">
    <div class="spinner-border text-light mt-4" role="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
  </div>
  `);

  try {
    const newURL = new URL( url, window.location.origin );
    newURL.search = window.location.search;
    url = newURL.toString();
    console.log( { url } );
    if ( url.indexOf( "/venta/comprobante.php?" ) > -1 ) {
      const id = sessionStorage.getItem( "id_venta" );
      url += `&id=${id}`;
    }
    $( id ).load( url, function ( _, status, xhr ) {
      if ( status == "error" ) {
        const msg = `Ha ocurrido un error: ${xhr.status} ${xhr.statusText}`;
        muestraError( id, msg );
      }
    } );
  }
  catch ( err ) {
    muestraError( id, err );
  }
}

function muestraError ( id, msg ) {
  $( id ).html( `
      <div class="alert alert-danger" role="alert">
        ${msg}
      </div>
    `);
}