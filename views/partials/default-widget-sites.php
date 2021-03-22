<?php
/**
 * Default widget: sites tab
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Sites section heading
 */
$heading_sites = apply_filters(
	'ds_default_widget_heading_sites',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Network Overview', DS_DOMAIN )
	)
);

// Sites section description.
$description_sites = apply_filters(
	'ds_default_widget_description_sites',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This section provides an overview of the network.', DS_DOMAIN )
	)
);

$sites_count = get_blog_count();
$sites_text  = sprintf(
	_n(
		'<strong>%s</strong> website',
		'<strong>%s</strong> websites',
		$sites_count
	),
	number_format_i18n( $sites_count )
);

?>
<?php echo $heading_sites; ?>
<?php echo $description_sites; ?>

<div class="ds-widget-divided-section ds-widget-sites-section">

	<h4><?php _e( 'Network Sites', DS_DOMAIN ); ?></h4>

	<p><?php printf( __( 'This network consists of %1$s.', DS_DOMAIN ), $sites_text ); ?></p>

	<form action="<?php echo network_admin_url( 'sites.php' ); ?>" method="get">
		<p>
			<label class="screen-reader-text" for="search-sites"><?php _e( 'Search Sites', DS_DOMAIN ); ?></label>
			<input type="search" name="s" value="" size="30" autocomplete="off" id="search-sites"/>
			<?php submit_button( __( 'Search Sites', DS_DOMAIN ), '', false, false, [ 'id' => 'submit_sites' ] ); ?>
		</p>
	</form>
</div>

<p class="ds-wdget-link-button">
	<a class="button button-primary" href="<?php echo network_admin_url( 'sites.php' ); ?>">
		<?php _e( 'Manage Sites', DS_DOMAIN ); ?>
	</a>
	<a class="button button-primary" href="<?php echo network_admin_url( 'site-new.php' ); ?>">
		<?php _e( 'New Site', DS_DOMAIN ); ?>
	</a>
</p>

<?php

// Development hook.
do_action( 'ds_sites_tab' );
