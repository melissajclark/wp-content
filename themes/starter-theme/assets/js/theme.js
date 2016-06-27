// theme js
jQuery(function($) {

	/**
	*
	* Fit Vid any videos
	*
	**/

	$("#page").fitVids();


	/**
	 * 
	 * Source: https://underscores.me
	 *
	 * Handles toggling the navigation menu for small screens 
	 *
	 */
	( function() {
		var container, button, menu, links, subMenus, i, len;

		container = document.getElementById( 'siteNavigation' );
		if ( ! container ) {
			return;
		}

		button = container.getElementsByTagName( 'button' )[0];
		if ( 'undefined' === typeof button ) {
			return;
		}

		menu = container.getElementsByTagName( 'ul' )[0];

		// Hide menu toggle button if menu is empty and return early.
		if ( 'undefined' === typeof menu ) {
			button.style.display = 'none';
			return;
		}

		menu.setAttribute( 'aria-expanded', 'false' );
		if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
			menu.className += ' nav-menu';
		}

		button.onclick = function() {
			if ( -1 !== container.className.indexOf( 'siteNavigation--Toggled' ) ) {
				container.className = container.className.replace( ' siteNavigation--Toggled', '' );
				button.setAttribute( 'aria-expanded', 'false' );
				menu.setAttribute( 'aria-expanded', 'false' );
			} else {
				container.className += ' siteNavigation--Toggled';
				button.setAttribute( 'aria-expanded', 'true' );
				menu.setAttribute( 'aria-expanded', 'true' );
			}
		};
	} )();


	/**
	 *
	 * Primary Navigation Settings
	 *
	 * Accessible navigation via Terri Thompson: 
	 * http://terrillthompson.com/blog/474
	 * http://terrillthompson.com/tests/menus/accessible-mega-menu/test.html
	 *
	 */
	
	$(".siteNavigation--Main").accessibleMegaMenu({
	    /* prefix for generated unique id attributes, which are required 
	       to indicate aria-owns, aria-controls and aria-labelledby */
	    uuidPrefix: "accessible-megamenu",

	    /* css class used to define the megamenu styling */
	    menuClass: "nav-menu",

	    /* css class for a top-level navigation item in the megamenu */
	    topNavItemClass: "menu-item",

	    /* css class for a megamenu panel */
	    panelClass: "sub-menu",

	    /* css class for a group of items within a megamenu panel */
	    panelGroupClass: "sub-nav-group",

	    /* css class for the hover state */
	    hoverClass: "hover",

	    /* css class for the focus state */
	    focusClass: "focus",

	    /* css class for the open state */
	    openClass: "open"
	});

 
}); // end doc ready