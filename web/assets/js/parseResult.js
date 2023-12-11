$( document ).ready( function () {
  const params = new URLSearchParams( window.location.search );
  const hash = window.location.hash.split( '?' )[0]?.replace( '#', '' );

  if ( params ) {
    const success = params.get( 'success' );
    const message = params.get( 'message' );
    console.log( { success, message } );
    if ( success == "1" ) {
      if ( message ) {
        setTimeout( () => { alert( message ); }, 300 );
      } else {
        if ( params.has( 'muestra-comprobante' ) ) {
          // load comprobante
          const comprobante = params.get( 'muestra-comprobante' );
          console.log( { comprobante } );
          setTimeout( () => { window.open( `/src/comprobante.php?id=${comprobante}`, '_blank' ); }, 300 );
        }
      }
      // clear url params success and message except for #hash
      window.history.replaceState( {}, document.title, "/src/repuestos.php#" + hash );
    } else if ( success == "0" ) {
      setTimeout( () => { alert( message ); }, 300 );
      window.history.replaceState( {}, document.title, "/src/repuestos.php" );
    }
  }

  // get ?section= from url
  var section = window.location.search.substring( 1 ).split( '=' )[1];
  // set active class to section
  $( 'li.nav-item>a[href*="' + section + '"]' ).addClass( 'active' );
} );