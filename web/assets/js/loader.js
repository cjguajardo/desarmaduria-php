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
    $( id ).load( url, function ( response, status, xhr ) {
      if ( status == "error" ) {
        var msg = `Ha ocurrido un error: ${xhr.status} ${xhr.statusText}`;
        $( id ).html(
          `<div class="alert alert-danger" role="alert">
            ${msg}
          </div>`
        );
      }
    } );
  }
  catch ( err ) {
    console.log( err );
    $( id ).html( `
      <div class="alert alert-danger" role="alert">
        ${err}
      </div>
    `);
  }
}