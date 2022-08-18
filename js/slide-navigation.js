/**
 * File slide-navigation.js.
 *
 * Handles the big slidy boy of the nav. Use inconjunction with some tasty CSS.
 */
 ( function() {
	const siteNavigation = document.getElementById( 'main-nav-wrapper' );

	// Return early if the navigation don't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = document.getElementById( 'main-nav-button' );

	// Return early if the button don't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}


	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'nav-open' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );
    
}() );
