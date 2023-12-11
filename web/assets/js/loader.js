function cargaVista ( url, id ) {
  try {
    $( id ).load( url, function ( response, status, xhr ) {
      if ( status == "error" ) {
        var msg = "Ha ocurrido un error: ";
        $( id ).html(
          `<div class="alert alert-danger" role="alert">
              ${msg} ${xhr.status} ${xhr.statusText}
          </div>`
        );
      }
    } );
  }
  catch ( err ) {
    console.log( err );
  }
}