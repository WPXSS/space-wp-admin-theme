jQuery( function( $ ) {

	"use strict";
	$( 'label' ).each( function() {

		var $this = $( this );
		var text = $this.text().trim();
		var $input = $this.children( 'input' ).not( '[type="checkbox"]' );
		if ( ! $input.attr( 'placeholder' ) ) {
			$input.attr( 'placeholder', text );
		}

	} );
	$( '#rememberme' ).prop( 'checked', true );

} );