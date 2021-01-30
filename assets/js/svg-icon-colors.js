/**
 * SVG icon colors
 *
 * Used to fill base64/SVG background images with colors
 * corresponding to current user's color scheme preference.
 *
 * Forked from the WordPress SVG Painter used in the admin menu.
 *
 * @package    Dashboard_Summary
 * @subpackage Assets
 * @category   JavaScript
 * @since      1.0.0
 */

window.scp = window.scp || {};

scp.dashboard_svg_icons = ( function( $, window, document, undefined ) {
	'use strict';
	var selector, base64, painter,
		colorscheme = {},
		elements    = [];

	$(document).ready( function() {
		scp.dashboard_svg_icons.init();
	});

	return {
		init: function() {
			painter  = this;
			selector = $( '.ds-content-list .ds-cpt-icons, #dashboard_right_now .at-glance-cpt-icons' );

			this.setColors();
			this.findElements();
			this.paint();
		},

		setColors: function( scheme ) {
			if ( typeof scheme === 'undefined' && typeof window._dashboard_svg_icons !== 'undefined' ) {
				scheme = window._dashboard_svg_icons;
			}

			if ( scheme && scheme.colors && scheme.colors.link && scheme.colors.hover && scheme.colors.focus ) {
				colorscheme = scheme.colors;
			}
		},

		findElements: function() {
			selector.each( function() {
				var $this = $(this), bgImage = $this.css( 'background-image' );

				if ( bgImage && bgImage.indexOf( 'data:image/svg+xml;base64' ) != -1 ) {
					elements.push( $this );
				}
			});
		},

		paint: function() {

			// Loop through all elements.
			$.each( elements, function( index, $element ) {
				var $glance_item = $element;

				// Paint icon in base color.
				painter.paintElement( $element, 'link' );

				// Set hover callbacks.
				$glance_item.parent().hover(
					function() {
						painter.paintElement( $element, 'hover' );
					},
					function() {
						painter.paintElement( $element, 'link' );
					}
				);

				// Set focus callbacks.
				$glance_item.parent().focus(
					function() {
						painter.paintElement( $element, 'focus' );
					}
				);
			});
		},

		paintElement: function( $element, colorType ) {
			var xml, encoded, color;

			if ( ! colorType || ! colorscheme.hasOwnProperty( colorType ) ) {
				return;
			}

			color = colorscheme[ colorType ];

			// Only accept hex colors: #101 or #101010.
			if ( ! color.match( /^(#[0-9a-f]{3}|#[0-9a-f]{6})$/i ) ) {
				return;
			}

			xml = $element.data( 'wp-ui-svg-' + color );

			if ( xml === 'none' ) {
				return;
			}

			if ( ! xml ) {
				encoded = $element.css( 'background-image' ).match( /.+data:image\/svg\+xml;base64,([A-Za-z0-9\+\/\=]+)/ );

				if ( ! encoded || ! encoded[1] ) {
					$element.data( 'wp-ui-svg-' + color, 'none' );
					return;
				}

				try {
					if ( 'atob' in window ) {
						xml = window.atob( encoded[1] );
					} else {
						xml = base64.atob( encoded[1] );
					}
				} catch ( error ) {}

				if ( xml ) {
					// Replace `fill` attributes.
					xml = xml.replace( /fill="(.+?)"/g, 'fill="' + color + '"');

					// Replace `style` attributes.
					xml = xml.replace( /style="(.+?)"/g, 'style="fill:' + color + '"');

					// Replace `fill` properties in `<style>` tags.
					xml = xml.replace( /fill:.*?;/g, 'fill: ' + color + ';');

					if ( 'btoa' in window ) {
						xml = window.btoa( xml );
					} else {
						xml = base64.btoa( xml );
					}

					$element.data( 'wp-ui-svg-' + color, xml );
				} else {
					$element.data( 'wp-ui-svg-' + color, 'none' );
					return;
				}
			}

			$element.attr( 'style', 'background-image: url("data:image/svg+xml;base64,' + xml + '") !important;' );
		}
	};

})( jQuery, window, document );
