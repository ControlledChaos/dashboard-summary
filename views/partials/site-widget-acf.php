<?php
/**
 * Default widget: Advanced Custom Fields tab
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes,
	Dashboard_Summary\Core    as Core,
	Dashboard_Summary\ACF     as ACF;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Advanced Custom Fields section heading
 *
 * The HTML is included here because of the
 * screen-reader-text class, which may need
 * to be filtered out.
 */
$tab_heading = apply_filters(
	'ds_acf_heading',
	__( 'Advanced Custom Fields', 'dashboard-summary' )
);

// Content section description.
$tab_description = apply_filters(
	'ds_acf_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Custom content types and custom content edit fields.', 'dashboard-summary' )
	)
);

// ACF types & taxes section heading.
$acf_heading_types = apply_filters(
	'ds_acf_types_heading',
	sprintf(
		'<h4>%s</h4>',
		__( 'Manage Custom Content Types', 'dashboard-summary' )
	)
);

// ACF types & taxes section description.
if ( ACF\acfe_display_types_taxes_links() ) {
	$acf_description_types = sprintf(
		'<p class="description">%s</p>',
		__( 'Manage via Advanced Custom Fields.', 'dashboard-summary' )
	);
} else {
	$acf_description_types = sprintf(
		'<p class="description">%s</p>',
		__( 'Manage custom post types and custom taxonomies.', 'dashboard-summary' )
	);
}
$acf_description_types = apply_filters( 'ds_acf_types_description', $acf_description_types );

$acfe_description_types = apply_filters(
	'ds_acfe_types_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Manage via Advanced Custom Fields: Extended.', 'dashboard-summary' )
	)
);

// ACF fields section heading.
$acf_fields_heading = apply_filters(
	'ds_acf_fields_heading',
	__( 'Manage Custom Fields', 'dashboard-summary' )
);

// ACF fields section description.
$acf_fields_description = apply_filters(
	'ds_acf_fields_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Add, edit, import, and export custom field groups.', 'dashboard-summary' )
	)
);

// Fields tools link.
$acf_link_tools = apply_filters(
	'ds_acf_link_tools',
	'edit.php?post_type=acf-field-group&page=acf-tools'
);

?>
<?php echo "<h3>$tab_heading</h3>"; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-content-types">
	<?php ACF\acf_post_types(); ?>
	<?php ACF\acfe_post_types(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-acf-links">

	<?php

	if ( ACF\acf_display_types_taxes_links() ) :

	?>
	<?php echo $acf_heading_types; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'edit.php?post_type=acf-post-type' ); ?>">
			<?php _e( 'Post Types', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo self_admin_url( 'edit.php?post_type=acf-taxonomy' ); ?>">
			<?php _e( 'Taxonomies', 'dashboard-summary' ); ?>
		</a>
	</p>
	<?php echo $acf_description_types; ?>

	<?php endif; ?>

	<?php if ( ACF\acfe_display_types_taxes_links() ) : ?>

	<hr />

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'edit.php?post_type=acfe-dpt' ); ?>">
			<?php _e( 'Post Types', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo self_admin_url( 'edit.php?post_type=acfe-dt' ); ?>">
			<?php _e( 'Taxonomies', 'dashboard-summary' ); ?>
		</a>
	</p>
	<?php echo $acfe_description_types; ?>

	<hr />
	<?php endif; ?>

	<h4><?php echo $acf_fields_heading; ?></h4>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'edit.php?post_type=acf-field-group' ); ?>">
			<?php _e( 'Field Groups', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo self_admin_url( $acf_link_tools ); ?>">
			<?php _e( 'Field Tools', 'dashboard-summary' ); ?>
		</a>
	</p>
	<?php echo $acf_fields_description; ?>
</div>

<?php

// Development hook.
do_action( 'ds_site_widget_acf_tab' );
