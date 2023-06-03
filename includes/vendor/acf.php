<?php
/**
 * Advanced Custom Fields compatibility
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Vendor
 * @since      1.0.0
 */

namespace Dashboard_Summary\ACF;

/**
 * ACF active
 *
 * Looks for Advanced Custom Fields class.
 *
 * Not using `is_plugin_active()` because
 * ACF can be bundled with themes & plugins.
 */
function acf_active() {
	if ( class_exists( 'acf' ) ) {
		return true;
	}
	return false;
}

/**
 * ACF PRO active
 *
 * Looks for Advanced Custom Fields PRO class.
 *
 * Not using `is_plugin_active()` because
 * ACF can be bundled with themes & plugins.
 */
function acf_pro_active() {
	if ( class_exists( 'acf_pro' ) ) {
		return true;
	}
	return false;
}

/**
 * ACFE active
 *
 * Looks for Advanced Custom Fields: Extended class.
 *
 * Not using `is_plugin_active()` because
 * ACF can be bundled with themes & plugins.
 */
function acfe_active() {
	if ( class_exists( 'acfe' ) ) {
		return true;
	}
	return false;
}

/**
 * ACFE PRO active
 *
 * Looks for Advanced Custom Fields: Extended PRO class.
 *
 * Not using `is_plugin_active()` because
 * ACF can be bundled with themes & plugins.
 */
function acfe_pro_active() {
	if ( class_exists( 'acfe_pro' ) ) {
		return true;
	}
	return false;
}

/**
 * Display ACF content types links
 *
 * Whether to display links to ACF custom post
 * types and custom taxonomies.
 *
 * Versions of ACF lower than 6.1.0 do not have
 * his feature, and forks of ACF prior to this
 * version may not.
 */
function acf_display_types_taxes_links() {

	if ( ! function_exists( 'acf_get_setting' ) ) {
		return;
	}

	$links = false;
	if ( acf_get_setting( 'version' ) >= '6.1.0' ) {
		$links = true;
	}
	return apply_filters( 'ds_acf_display_types_taxes_links', $links );
}

/**
 * Display ACFE content types links
 *
 * Whether to display the custom post types
 * and custom taxonomies feature added by
 * the Advanced Custom Fields: Extended plugin.
 */
function acfe_display_types_taxes_links() {

	$links = false;
	if ( acfe_active() ) {
		$links =  true;
	}
	return apply_filters( 'ds_acfe_display_types_taxes_links', $links );
}

/**
 * ACF Post types
 *
 * @since  1.0.0
 * @return string Returns unordered list markup.
 */
function acf_post_types() {

	$post_types = [
		'acf-field-group',
		'acf-field'
	];

	if ( acf_display_types_taxes_links() ) {
		$acf_types_taxes = [
			'acf-post-type',
			'acf-taxonomy'
		];
		$post_types = array_merge( $post_types, $acf_types_taxes );
	}

	// Begin the post types list.
	$html = '<ul class="ds-content-list ds-post-types-list">';

	// Conditional list items.
	foreach ( $post_types as $post_type ) {

		$type = get_post_type_object( $post_type );

		// Count the number of posts.
		$get_count = wp_count_posts( $type->name );
		$count     = $get_count->publish;

		// Get the number of published posts.
		$number = number_format_i18n( $count );

		$icon = 'dashicons-admin-generic';

		// Get the plural or single name based on the count.
		$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count ), 'dashboard-summary' );

		if ( 'acf-field-group' == $post_type ) {
			$icon = 'dashicons-welcome-widgets-menus';
		} elseif ( 'acf-field' == $post_type ) {
			$icon  = 'dashicons-forms';
			$name .= __( ' (private)', 'dashboard-summary' );
		} elseif ( 'acf-post-type' == $post_type ) {
			$icon = 'dashicons-admin-post';
		} elseif ( 'acf-taxonomy' == $post_type ) {
			$icon = 'dashicons-category';
		}

		if ( 'acf-field' == $post_type ) {
			$html .= sprintf(
				'<li class="post-count %s-count"><icon class="dashicons %s"></icon> %s %s</li>',
				$type->name,
				$icon,
				$number,
				$name
			);
		} else {
			$html .= sprintf(
				'<li class="post-count %s-count"><a href="edit.php?post_type=%s"><icon class="dashicons %s"></icon> %s %s</a></li>',
				$type->name,
				$type->name,
				$icon,
				$number,
				$name
			);
		}
	}

	// End the post types list.
	$html .= '</ul>';

	// Print the list markup.
	echo $html;
}

/**
 * Field groups category list item
 *
 * Used in the ACFE post types list.
 *
 * @since  1.0.0
 * @return string Returns list item markup.
 */
function acfe_fields_category() {

	$taxonomies = get_taxonomies( [ 'name' => 'acf-field-group-category'], 'object', 'and' );

	if ( $taxonomies ) {
		foreach ( $taxonomies as $taxonomy ) {

			$type  = '&post_type=acf-field-group';
			$count = wp_count_terms( $taxonomy->name );
			$name  = _n( __( 'Fields Category', 'dashboard-summary' ), __( 'Fields Categories', 'dashboard-summary' ), intval( $count ), 'dashboard-summary' );

			$html = sprintf(
				'<li class="at-glance-taxonomy %s"><a href="%s"><icon class="dashicons dashicons-archive"></icon> %s %s</a></li>',
				$taxonomy->name,
				esc_url( admin_url( 'edit-tags.php?taxonomy=acf-field-group-category' ) ),
				$count,
				$name
			);
		}
		return $html;
	}
	return '';
}

/**
 * ACF: Extended Post types
 *
 * @since  1.0.0
 * @return string Returns unordered list markup.
 */
function acfe_post_types() {

	if ( ! acfe_display_types_taxes_links() ) {
		return null;
	}

	$post_types = [
		'acfe-dop',
		'acfe-dpt',
		'acfe-dt',
		'acfe-form',
		'acfe-dbt'
	];

	if ( acfe_pro_active() ) {
		$acfe = [
			'acfe-template'
		];
		$post_types = array_merge( $post_types, $acfe );
	}

	$html  = '<hr />';
	$html .= apply_filters(
		'ds_acfe_heading_list',
		sprintf(
			'<h4>%s</h4>',
			__( 'Advanced Custom Fields: Extended', 'dashboard-summary' )
		)
	);

	$html .= apply_filters(
		'ds_acfe_description_list',
		sprintf(
			'<p class="description">%s</p>',
			__( 'Enhancements to Advanced Custom Fields.', 'dashboard-summary' )
		)
	);

	// Begin the post types list.
	$html .= '<ul class="ds-content-list ds-post-types-list">';

	// Count field groups category.
	$html .= acfe_fields_category();

	// Conditional list items.
	foreach ( $post_types as $post_type ) {

		$type = get_post_type_object( $post_type );

		// Count the number of posts.
		$get_count = wp_count_posts( $type->name );
		$count     = $get_count->publish;

		// Get the number of published posts.
		$number = number_format_i18n( $count );

		$icon = 'dashicons-admin-generic';

		// Get the plural or single name based on the count.
		$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count ), 'dashboard-summary' );

		if ( 'acfe-dpt' == $post_type ) {
			$icon = 'dashicons-admin-post';
		} elseif ( 'acfe-dt' == $post_type ) {
			$icon = 'dashicons-category';
		} elseif ( 'acfe-form' == $post_type ) {
			$icon = 'dashicons-edit';
		} elseif ( 'acfe-dbt' == $post_type ) {
			$icon = 'dashicons-block-default';
		} elseif ( 'acfe-dop' == $post_type ) {
			$icon = 'dashicons-admin-page';
		} elseif ( 'acfe-template' == $post_type ) {
			$icon = 'dashicons-migrate';
		}

		$html .= sprintf(
			'<li class="post-count %s-count"><a href="edit.php?post_type=%s"><icon class="dashicons %s"></icon> %s %s</a></li>',
			$type->name,
			$type->name,
			$icon,
			$number,
			$name
		);
	}

	// End the post types list.
	$html .= '</ul>';

	// Print the list markup.
	echo $html;
}
