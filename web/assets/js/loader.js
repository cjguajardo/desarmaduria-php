function cargaVista ( url, id ) {
  // console.log( { search: window.location.search } );
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
    $( id ).load( url, function ( _, status, xhr ) {
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