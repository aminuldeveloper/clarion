/**
 * Luminary Customizer Live Preview
 *
 * Binds JS handlers to make Theme Customizer preview
 * reload changes asynchronously.
 *
 * @package Clarion
 * @since   1.0.0
 */

( function ( $ ) {
	'use strict';

	// Accent color.
	wp.customize( 'clarion_accent_color', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--color-accent', newval );
		} );
	} );

	// Body background color.
	wp.customize( 'clarion_body_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--color-bg', newval );
		} );
	} );

	// Text color.
	wp.customize( 'clarion_text_color', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--color-text', newval );
		} );
	} );

	// Heading color.
	wp.customize( 'clarion_heading_color', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--color-heading', newval );
		} );
	} );

	// Footer credit text.
	wp.customize( 'clarion_footer_credit', function ( value ) {
		value.bind( function ( newval ) {
			var el = document.querySelector( '.copyright__credit' );
			if ( el ) {
				el.textContent = newval;
			}
		} );
	} );

} )( jQuery );
