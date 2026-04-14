/**
 * Luminary Navigation
 *
 * Handles mobile menu toggle and keyboard accessibility.
 * Vanilla JS — no jQuery dependency.
 *
 * @package Clarion
 * @since   1.0.0
 */

( function () {
	'use strict';

	var toggle  = document.querySelector( '.menu-toggle' );
	var nav     = document.querySelector( '.primary-navigation' );
	var header  = document.querySelector( '.site-header' );

	if ( ! toggle || ! nav ) {
		return;
	}

	/**
	 * Opens the mobile menu.
	 */
	function openMenu() {
		toggle.setAttribute( 'aria-expanded', 'true' );
		nav.classList.add( 'is-open' );
		document.body.style.overflow = 'hidden';
		// Move focus to first menu item
		var firstLink = nav.querySelector( 'a' );
		if ( firstLink ) {
			firstLink.focus();
		}
	}

	/**
	 * Closes the mobile menu.
	 */
	function closeMenu() {
		toggle.setAttribute( 'aria-expanded', 'false' );
		nav.classList.remove( 'is-open' );
		document.body.style.overflow = '';
	}

	/**
	 * Toggle menu on button click.
	 */
	toggle.addEventListener( 'click', function () {
		var isExpanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
		if ( isExpanded ) {
			closeMenu();
		} else {
			openMenu();
		}
	} );

	/**
	 * Close menu on Escape key.
	 */
	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
			closeMenu();
			toggle.focus();
		}
	} );

	/**
	 * Close menu when clicking outside.
	 */
	document.addEventListener( 'click', function ( event ) {
		if (
			nav.classList.contains( 'is-open' ) &&
			! nav.contains( event.target ) &&
			! toggle.contains( event.target )
		) {
			closeMenu();
		}
	} );

	/**
	 * Close menu when window resizes past mobile breakpoint.
	 */
	window.addEventListener( 'resize', function () {
		if ( window.innerWidth > 768 && nav.classList.contains( 'is-open' ) ) {
			closeMenu();
		}
	} );

	/**
	 * Trap focus within open mobile menu for accessibility.
	 */
	nav.addEventListener( 'keydown', function ( event ) {
		if ( ! nav.classList.contains( 'is-open' ) ) {
			return;
		}

		var focusableElements = nav.querySelectorAll(
			'a, button, input, [tabindex]:not([tabindex="-1"])'
		);
		var firstFocusable = focusableElements[ 0 ];
		var lastFocusable  = focusableElements[ focusableElements.length - 1 ];

		if ( event.key === 'Tab' ) {
			if ( event.shiftKey ) {
				if ( document.activeElement === firstFocusable ) {
					event.preventDefault();
					lastFocusable.focus();
				}
			} else {
				if ( document.activeElement === lastFocusable ) {
					event.preventDefault();
					firstFocusable.focus();
				}
			}
		}
	} );

} )();
