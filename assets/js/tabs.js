/**
 * Tabbed & accordion content
 *
 * @package    Dashboard_Summary
 * @subpackage Assets
 * @category   JavaScript
 */

$( '.ds-tab-content' ).hide();
$( '.ds-tab-content:first' ).show();

// If in tab mode.
$( 'ul.tabs li' ).click(function() {

	$( '.ds-tab-content' ).hide();
	var activeTab = $(this).attr( 'rel' );
	$( '#' + activeTab ).fadeIn();

	$( 'ul.tabs li' ).removeClass( 'active' );
	$(this).addClass( 'active' );

	$( '.ds-tab-drawer-heading' ).removeClass( 'd_active' );
	$( '.ds-tab-drawer-heading[rel^="' + activeTab + '"]' ).addClass( 'd_active' );

});

// If in accordion mode.
$( '.ds-tab-drawer-heading' ).click(function() {

	$( '.ds-tab-content' ).hide();
	var d_activeTab = $(this).attr( 'rel' );
	$( '#' + d_activeTab ).fadeIn();

	$( '.ds-tab-drawer-heading' ).removeClass( 'd_active' );
	$(this).addClass( 'd_active' );

	$( 'ul.tabs li' ).removeClass( 'active' );
	$( 'ul.tabs li[rel^="' + d_activeTab + '"]' ).addClass( 'active' );
});


// Extra class "tab_last" to add border to right side of last tab.
$( 'ul.tabs li' ).first().addClass( 'tab_first' );
$( 'ul.tabs li' ).last().addClass( 'tab-last' );
