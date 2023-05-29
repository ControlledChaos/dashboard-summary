<?php
/**
 * Core widget functions
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Core
 * @since      1.0.0
 */

namespace Dashboard_Summary\Core;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Dashboard type
 *
 * Returns the word "website" or "network".
 *
 * @since  1.0.0
 * @return string Returns the text of the dashboard type.
 */
function dashboard_type() {

	// If a network dashboard.
	if ( is_network_admin() ) {
		$dashboard = __( 'network', 'dashboard-summary' );

	// If a site dashboard.
	} else {
		$dashboard = __( 'website', 'dashboard-summary' );
	}

	// Return the filtered word/string.
	return apply_filters( 'ds_dashboard_type', $dashboard );
}

/**
 * Custom post types query
 *
 * The custom post types are here as a separate query
 * for use in the At a Glance widget in which the default,
 * built-in post types already exists and custom post types
 * are added by filter.
 *
 * @since  1.0.0
 * @return array Returns an array of queried post types.
 */
function custom_types_query() {

	// Array of post type query arguments.
	$query = [
		'public'   => true,
		'_builtin' => false
	];

	// Return post types according to above.
	$query = get_post_types( $query, 'names', 'and' );
	return apply_filters( 'ds_custom_types_query', $query );
}

/**
 * Public post types
 *
 * Merges built-in post types and custom post types.
 *
 * @since  1.0.0
 * @return array Returns an array of all public post types.
 */
function public_post_types() {

	// Add attachment post type.
	$builtin = [ 'post', 'page', 'attachment' ];

	// Custom post types query.
	$query = custom_types_query();

	// Merge the post type arrays.
	$types = array_merge( $builtin, $query );

	// Return the public post types.
	return apply_filters( 'ds_public_post_types', $types );
}

/**
 * Taxonomies query
 *
 * @since  1.0.0
 * @return array Returns an array of queried taxonomies.
 */
function taxonomies_query() {

	// Taxonomy query arguments.
	$query = [
		'public'  => true,
		'show_ui' => true
	];

	// Get taxonomies according to above array.
	$query = get_taxonomies( $query, 'object', 'and' );

	// Return the array of taxonomies. Apply filter for customization.
	return apply_filters( 'ds_taxonomies_query', $query );
}

/**
 * Post types list
 *
 * @since  1.0.0
 * @return string Returns unordered list markup.
 */
function post_types_list() {

	// Get all public post types.
	$post_types = public_post_types();

	// Begin the post types list.
	$html = '<ul class="ds-content-list ds-post-types-list">';

	// Conditional list items.
	foreach ( $post_types as $post_type ) {

		$type = get_post_type_object( $post_type );

		// Count the number of posts.
		$get_count = wp_count_posts( $type->name );
		if ( 'attachment' === $post_type ) {
			$count = $get_count->inherit;
		} else {
			$count = $get_count->publish;
		}

		// Get the number of published posts.
		$number = number_format_i18n( $count );

		// Get the plural or single name based on the count.
		$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count ), 'dashboard-summary' );

		// If the icon is data:image/svg+xml.
		if ( 0 === strpos( $type->menu_icon, 'data:image/svg+xml;base64,' ) ) {
			$menu_icon = sprintf(
				'<icon class="ds-cpt-icons" style="%s"></icon>',
				esc_attr( 'background-image: url( "' . esc_html( $type->menu_icon ) . '" );' )
			);

		// If the icon is a Dashicon class.
		} elseif ( 0 === strpos( $type->menu_icon, 'dashicons-' ) ) {
			$menu_icon = '<icon class="dashicons ' . $type->menu_icon . '"></icon>';

		// If the icon is a URL.
		} elseif( 0 === strpos( $type->menu_icon, 'http' ) ) {
			$menu_icon = '<icon class="ds-cpt-icons"><img src="' . esc_url( $type->menu_icon ) . '" /></icon>';

		// Fall back to the default post icon.
		} else {
			$menu_icon = '<icon class="dashicons dashicons-admin-post dashicons-admin-' . $type->menu_icon . '"></icon>';
		}

		// Supply an edit link if media & the user can access the media library.
		if ( 'attachment' === $post_type && current_user_can( 'upload_files' ) ) {
			$html .= sprintf(
				'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
				$type->name,
				$type->name,
				$menu_icon,
				$number,
				$name
			);

		// Supply an edit link if not media & the user can edit posts.
		} elseif ( 'attachment' != $post_type && current_user_can( $type->cap->edit_posts ) ) {
			$html .= sprintf(
				'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
				$type->name,
				$type->name,
				$menu_icon,
				$number,
				$name
			);

		// Otherwise just the count and post type name.
		} else {
			$html .= sprintf(
				'<li class="post-count %s-count">%s %s %s</li>',
				$type->name,
				$menu_icon,
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
 * Taxonomies list
 *
 * @see `taxonomies_icons_list()` for a taxonomies list
 *       that includes icon elements.
 *
 * @since  1.0.0
 * @return string Returns unordered list markup.
 */
function taxonomies_list() {

	// Get taxonomies.
	$taxonomies = taxonomies_query();

	// Prepare an entry for each taxonomy matching the query.
	if ( $taxonomies ) {

		// Begin the taxonomies list.
		$html = '<ul class="ds-content-list ds-taxonomies-list">';

		foreach ( $taxonomies as $taxonomy ) {

			// Get the first supported post type in the array.
			if ( ! empty( $taxonomy->object_type ) ) {
				$types = $taxonomy->object_type[0];
			} else {
				$types = null;
			}

			// Set `post_type` URL parameter for menu highlighting.
			if ( $types && 'post' === $types ) {
				$type = '&post_type=post';
			} elseif ( $types ) {
				$type = '&post_type=' . $types;
			} else {
				$type = '';
			}

			// Count the terms in the taxonomy.
			$count = wp_count_terms( $taxonomy->name );

			// Get the plural or singular name based on the count.
			$name = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $count ), 'dashboard-summary' );

			// Supply an edit link if the user can edit the taxonomy.
			$edit = get_taxonomy( $taxonomy->name );
			if ( current_user_can( $edit->cap->edit_terms ) ) {

				// Print a list item for the taxonomy.
				$html .= sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s</a></li>',
					$taxonomy->name,
					esc_url( admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ) ),
					$count,
					$name
				);

			// List item without link.
			} else {

				// Print a list item for the taxonomy.
				$html .= sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s</a></li>',
					$taxonomy->name,
					$count,
					$name
				);
			}
		}

		// End the taxonomies list.
		$html .= '</ul>';

		// Print the list markup.
		echo $html;
	}
}

/**
 * Taxonomies list with icons
 *
 * Includes icon elements rather than adding
 * icons via CSS.
 *
 * @since  1.0.0
 * @return string Returns unordered list markup.
 */
function taxonomies_icons_list() {

	// Get taxonomies.
	$taxonomies = taxonomies_query();

	// Prepare an entry for each taxonomy matching the query.
	if ( $taxonomies ) {

		// Begin the taxonomies icons list.
		$html = '<ul class="ds-content-list ds-taxonomies-list">';

		foreach ( $taxonomies as $taxonomy ) {

			// Get the first supported post type in the array.
			if ( ! empty( $taxonomy->object_type ) ) {
				$types = $taxonomy->object_type[0];
			} else {
				$types = null;
			}

			// Set `post_type` URL parameter for menu highlighting.
			if ( $types && 'post' === $types ) {
				$type = '&post_type=post';
			} elseif ( $types ) {
				$type = '&post_type=' . $types;
			} else {
				$type = '';
			}

			// Count the terms in the taxonomy.
			$count = wp_count_terms( $taxonomy->name );

			// Get the plural or singular name based on the count.
			$name = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $count ), 'dashboard-summary' );

			// Conditional icon markup.
			if ( 'post_tag' == $taxonomy->name ) {
				$icon = sprintf(
					'<icon class="dashicons dashicons-tag ds-icon-%s"></icon>',
					$taxonomy->name
				);
			} else {
				$icon = sprintf(
					'<icon class="dashicons dashicons-category ds-icon-%s"></icon>',
					$taxonomy->name
				);
			}

			// Supply an edit link if the user can edit the taxonomy.
			$edit = get_taxonomy( $taxonomy->name );
			if ( current_user_can( $edit->cap->edit_terms ) ) {

				// Print a list item for the taxonomy.
				$html .= sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s %s</a></li>',
					$taxonomy->name,
					esc_url( admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ) ),
					$icon,
					$count,
					$name
				);

			// List item without link.
			} else {
				// Print a list item for the taxonomy.
				$html .= sprintf(
					'<li class="at-glance-taxonomy %s">%s %s %s</li>',
					$taxonomy->name,
					$icon,
					$count,
					$name
				);
			}
		}

		// End the taxonomies icons list.
		$html .= '</ul>';

		// Print the list markup.
		echo $html;
	}
}

/**
 * Total of registered users
 *
 * @since  1.0.0
 * @return integer Returns the number of registered users.
 */
function total_users() {

	// Count the registered users.
	$count = count_users();

	// Return the number of total registered users.
	return intval( $count['total_users'] );
}

/**
 * Get current user comments
 *
 * @since  1.0.0
 * @return integer Returns the number of comments for the user.
 */
function get_user_comments_count() {

	// Array of comment arguments.
	$args = [
		'user_id' => get_current_user_id(),
		'count'   => true // Return only the count.
	];

	// Get comments according to the above array.
	$count = get_comments( $args );

	// Return the number of comments.
	return intval( $count );
}

/**
 * PHP version
 *
 * States the version of PHP which is
 * running on the current server.
 *
 * @since  1.0.0
 * @return string Returns a PHP version notice.
 */
function php_version() {

	// Markup of the notice.
	$output = sprintf(
		'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
		__( 'The web server is running', 'dashboard-summary' ),
		esc_url( 'https://www.php.net/releases/index.php' ),
		'PHP ' . phpversion()
	);

	// Return the notice. Apply filter for customization.
	return apply_filters( 'ds_php_version_notice', $output );
}

/**
 * Get database variables
 *
 * @since  1.0.0
 * @global object $wpdb Database access abstraction class.
 * @return array Returns an array of database results.
 */
function get_database_vars() {

	// Access the wpdb class.
	global $wpdb;

	// Return false if no database results.
	if ( ! $results = $wpdb->get_results( 'SHOW GLOBAL VARIABLES' ) ) {
		return false;
	}

	// Set up an array of database results.
	$mysql_vars = [];

	// For each database result.
	if ( is_array( $results ) ) {
		foreach ( $results as $result ) {

			// Result name.
			$mysql_vars[ $result->Variable_name ] = $result->Value;
		}
	}

	// Return an array of database results.
	return $mysql_vars;
}

/**
 * Get database version
 *
 * @since  1.0.0
 * @return string Returns the database name/version or
 *                "Not available".
 */
function get_database_version() {

	// Get database variables.
	$vars = get_database_vars();

	// If the database version is found.
	if ( isset( $vars['version'] ) && ! empty( $vars['version'] ) ) {
		$version = sanitize_text_field( $vars['version'] );

	// If no database version is found.
	} else {
		$version = __( 'not available', 'dashboard-summary' );
	}

	// Return the applicable string.
	return $version;
}

/**
 * Database reference URL
 *
 * @since  1.0.0
 * @return string Returns the escaped, filtered URL.
 */
function database_reference() {

	// Default Wikipedia page.
	$url = esc_url( 'https://en.wikipedia.org/wiki/List_of_relational_database_management_systems' );

	// Return the URL.
	return apply_filters( 'ds_database_reference', $url );
}

/**
 * Database version notice
 *
 * @since  1.0.0
 * @return string Returns the text of database version notice.
 */
function database_version() {

	// Markup of the notice.
	$output = sprintf(
		'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
		__( 'The database version is', 'dashboard-summary' ),
		database_reference(),
		get_database_version()
	);

	// Return the notice. Apply filter for customization.
	return apply_filters( 'ds_database_version_notice', $output );
}

/**
 * Management system
 *
 * Defines the code name of the management system.
 *
 * @since  1.0.0
 * @return string Returns the name of the management system.
 */
function management_system() {

	// Check for ClassicPress.
	if ( function_exists( 'classicpress_version' ) ) {
		$system = 'classicpress';

	// Default to WordPress.
	} else {
		$system = 'wordpress';
	}

	// Return the system. Apply filter for customization.
	return apply_filters( 'ds_system', $system );
}

/**
 * Name of the management system
 *
 * Defines the display name of the management system.
 *
 * @since  1.0.0
 * @return string Returns the name of the management system.
 */
function system_name() {

	// Get the current management system.
	$system = management_system();

	// Check for ClassicPress.
	if ( 'classicpress' === $system ) {
		$name = __( 'ClassicPress', 'dashboard-summary' );

	// Check for WordPress.
	} elseif ( 'wordpress' === $system ) {
		$name = __( 'WordPress', 'dashboard-summary' );

	// Generic name.
	} else {
		$name = __( 'system', 'dashboard-summary' );
	}

	// Return the system name. Apply filter for customization.
	return apply_filters( 'ds_system_name', $name );
}

/**
 * System notice
 *
 * States the management system and version.
 *
 * @since  1.0.0
 * @return string Returns the link to the management system.
 */
function system_notice() {

	// Get the current management system.
	$system = management_system();

	// Get system name.
	$name = system_name();

	// Text for site or network dashboard.
	if ( is_multisite() && is_network_admin() ) {
		$text = __( 'This network is running', 'dashboard-summary' );
	} else {
		$text = __( 'This website is running', 'dashboard-summary' );
	}

	// Check for ClassicPress.
	if ( 'classicpress' === $system ) {

		// Markup of the notice.
		$output = sprintf(
			'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
			$text,
			esc_url( 'https://github.com/ClassicPress/ClassicPress-release/releases' ),
			$name . ' ' . get_bloginfo( 'version', 'display' )
		);

	// Default to WordPress.
	} else {

		// Markup of the notice.
		$output = sprintf(
			'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
			$text,
			esc_url( 'https://wordpress.org/download/releases/' ),
			$name . ' ' . get_bloginfo( 'version', 'display' )
		);
	}

	// Return the notice. Apply filter for customization.
	return apply_filters( 'ds_system_notice', $output );
}

/**
 * Search engine notice
 *
 * @since  1.0.0
 * @return mixed Returns a string if search engines discouraged.
 *               Returns null if search engines not discouraged.
 */
function search_engines() {

	// Text for network dashboards.
	if ( is_multisite() && is_network_admin() ) {
		$text = __( 'Search engines are discouraged for the primary site', 'dashboard-summary' );

	// Text for site dashboards.
	} else {
		$text = __( 'Search engines are discouraged', 'dashboard-summary' );
	}

	// Check if search engines are asked not to index the site.
	if (
		! is_user_admin() &&
		current_user_can( 'manage_options' ) &&
		! get_option( 'blog_public' )
	) {
		// Markup of the notice.
		$output = sprintf(
			'<a class="ds-search-engines discouraged" href="%s">%s</a>',
			esc_url( admin_url( 'options-reading.php' ) ),
			$text
		);

	// Print nothing if search engines are not discouraged.
	} else {
		$output = sprintf(
			'<a class="ds-search-engines allowed" href="%s">%s</a>',
			esc_url( admin_url( 'options-reading.php' ) ),
			__( 'Search engines are allowed', 'dashboard-summary' )
		);
	}

	// Return the notice. Apply filter for customization.
	return apply_filters( 'ds_search_engines', $output );
}

/**
 * Available themes
 *
 * The available & allowed themes notice.
 *
 * @since  1.0.0
 * @return string Returns the markup of the notice.
 */
function available_themes() {

	// Count available & allowed themes.
	$themes = count( wp_get_themes( [ 'allowed' => true ] ) );

	// Begin the markup of the notice.
	$html = '';
	if ( ! empty( $themes ) ) {

		// Conditional text by theme count.
		$before = _n( 'There is', 'There are', intval( $themes ), 'dashboard-summary' );

		if ( is_network_admin() ) {
			$after = _n( 'network enabled theme.', 'network enabled themes.', intval( $themes ), 'dashboard-summary' );
		} else {
			$after = _n( 'available theme.', 'available themes.', intval( $themes ), 'dashboard-summary' );
		}

		// Link to the themes page if the current user can manage themes.
		if ( current_user_can( 'install_themes' ) || current_user_can( 'customize' ) ) {
			$html = sprintf(
				'%s <a href="%s">%s %s</a>',
				$before,
				esc_url( self_admin_url( 'themes.php' ) ),
				$themes,
				$after
			);

		// Otherwise text with no link.
		} else {
			$html = sprintf(
				'%s %s %s',
				$before,
				$themes,
				$after
			);
		}

	// If no allowed themes are found.
	} else {
		$html = sprintf(
			'%s',
			__( 'There are no themes available.', 'dashboard-summary' )
		);
	}

	// Return the markup of the notice.
	return $html;
}

/**
 * Active theme URI
 *
 * Use `is_null()` to check for a return value.
 *
 * @since  1.0.0
 * @return mixed Returns the URI for the active theme's website
 *               or returns null.
 */
function active_theme_uri() {

	// Get theme data.
	$theme     = wp_get_theme();
	$theme_uri = $theme->get( 'ThemeURI' );

	// If the theme header has a URI.
	if ( $theme_uri ) {
		$uri = $theme_uri;
	}

	// Return the URI string ot null.
	return $uri;
}

/**
 * Active theme notice
 *
 * @since  1.0.0
 * @return string Returns the text of the active theme notice.
 */
function active_theme() {

	// Get the active theme name.
	$theme_name = wp_get_theme();

	/**
	 * If the theme header has the URI tag then
	 * print the link in the header.
	 */
	if ( ! is_null( active_theme_uri() ) ) {

		// Markup of the notice for network dashboards.
		if ( is_network_admin() ) {
			$theme_name = sprintf(
				'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
				__( 'The active theme of the primary site is', 'dashboard-summary' ),
				active_theme_uri(),
				$theme_name
			);

		// Markup of the notice for site dashboards.
		} else {
			$theme_name = sprintf(
				'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
				__( 'The active theme is', 'dashboard-summary' ),
				active_theme_uri(),
				$theme_name
			);
		}

	/**
	 * If the theme header does not have the URI tag and
	 * the current user can switch themes then print a
	 * link to the themes management screen.
	 */
	} elseif ( current_user_can( 'switch_themes' ) ) {

		// Markup of the notice for network dashboards.
		if ( is_network_admin() ) {
			$theme_name = sprintf(
				'%s <a href="%s">%s</a>',
				__( 'The active theme of the primary site is', 'dashboard-summary' ),
				esc_url( self_admin_url( 'themes.php' ) ),
				$theme_name
			);

		// Markup of the notice for site dashboards.
		} else {
			$theme_name = sprintf(
				'%s <a href="%s">%s</a>',
				__( 'The active theme is', 'dashboard-summary' ),
				esc_url( admin_url( 'themes.php' ) ),
				$theme_name
			);
		}

	// Default to the theme name with no link.
	} else {
		$theme_name = sprintf(
			'%s %s',
			__( 'The active theme is', 'dashboard-summary' ),
			$theme_name
		);
	}

	// Return the notice. Apply filter for customization.
	return apply_filters( 'ds_active_theme', $theme_name );
}

/**
 * System updates user interface
 *
 * @since  1.0.0
 * @global string $required_php_version The required PHP version string.
 * @global string $required_mysql_version The required MySQL version string.
 * @return void
 */
function update_system_list() {

	// Access global variables.
	global $required_php_version, $required_mysql_version;

	// Get core updates.
	$updates = get_core_updates();

	// // Get core updates data.
	$update_data = wp_get_update_data();

	// System name.
	$system = system_name();

	// Stop here if updates have been disabled.
	if ( 0 == $update_data['counts']['wordpress'] ) {

		// Print the markup for no system updates.
		printf(
			'<p class="response">%s %s %s</p>',
			__( 'There are no', 'dashboard-summary' ),
			$system,
			__( 'updates available.', 'dashboard-summary' )
		);
		return;
	}

	// Get the system version.
	require ABSPATH . WPINC . '/version.php';

	// Check for a development version.
	$is_development_version = preg_match( '/alpha|beta|RC/', $wp_version );

	// If an update is available.
	if ( (isset( $updates[0]->version ) && version_compare( $updates[0]->version, $wp_version, '>' )) || 'latest' != $updates[0]->response ) {

		// Update notice.
		printf(
			'<p class="response">%s %s %s</p>',
			__( 'An updated version of', 'dashboard-summary' ),
			$system,
			__( 'is available.', 'dashboard-summary' )
		);

		// Backup warning.
		printf(
			'<p><strong>%s</strong> %s</p>',
			__( 'Important:', 'dashboard-summary' ),
			__( 'Before updating, please back up your database and files.', 'dashboard-summary' ),
		);

	// If the site or network is running a WordPress development version.
	} elseif ( $is_development_version ) {

		// Development notice.
		printf(
			'<p class="response">%s %s</p>',
			__( 'You are using a development version of', 'dashboard-summary' ),
			$system
		);

	// If the site or network is running a ClassicPress development version.
	} elseif ( function_exists( 'classicpress_is_dev_install' ) && classicpress_is_dev_install() ) {

		// Development notice.
		printf(
			'<p class="response">%s %s</p>',
			__( 'You are using a development version of', 'dashboard-summary' ),
			$system
		);

	// If the system is up to date.
	} else {

		// Latest version notice.
		printf(
			'<p class="response">%s %s</p>',
			__( 'You have the latest version of', 'dashboard-summary' ),
			$system
		);
	}

	// Don't show the maintenance mode notice when only showing a single re-install option.
	if ( $updates && ( count( $updates ) > 1 || 'latest' !== $updates[0]->response ) ) {

		echo '<p>' . __( 'While your site is being updated, it will be in maintenance mode. As soon as your updates are complete, this mode will be deactivated.', 'dashboard-summary' ) . '</p>';

	// If no updates available.
	} elseif ( ! $updates ) {

		// Link to the About page.
		list( $normalized_version ) = explode( '-', $wp_version );
		echo '<p>' . sprintf(
			__( '<a href="%1$s">Learn more about %2$s %3$s</a>.', 'dashboard-summary' ),
			$system,
			esc_url( self_admin_url( 'about.php' ) ),
			$normalized_version
		) . '</p>';
	}

	// Begin updates list.
	echo '<ul class="core-updates">';

	// List entry for each update.
	foreach ( (array) $updates as $update ) {
		echo '<li>';
		available_system_updates( $update );
		echo '</li>';
	}

	// End updates list.
	echo '</ul>';

	// Display dismissed updates.
	dismissed_updates();
}

/**
 * Available system updates
 *
 * @since  1.0.0
 * @global string $wp_local_package Locale code of the package.
 * @global wpdb $wpdb Database abstraction object.
 * @param  object $update
 * @return void
 */
function available_system_updates( $update ) {

	// Access global variables.
	global $wp_local_package, $wpdb;
	static $first_pass = true;

	// Get the current management system.
	$system = management_system();

	// System name.
	$name = system_name();

	// Stop here if updates have been disabled.
	$update_data = wp_get_update_data();
	if ( 0 == $update_data['counts']['wordpress'] ) {
		return;
	}

	// Get system version.
	$wp_version = get_bloginfo( 'version' );
	if ( function_exists( 'classicpress_version' ) ) {
		$current_version = classicpress_version();
	} else {
		$current_version = $wp_version;
	}

	// Default version string.
	$version_string = sprintf( '%s&ndash;<strong>%s</strong>', $update->current, $update->locale );

	// If the language option is set to en_US.
	if ( 'en_US' === $update->locale && 'en_US' === get_locale() ) {
		$version_string = $update->current;

	// Get a language-specific version string if the language option is not set to en_US.
	} elseif ( 'en_US' === $update->locale && $update->packages->partial && $wp_version == $update->partial_version ) {

		$updates = get_core_updates();

		// If the only available update is a partial build it doesn't need a language-specific version string.
		if ( $updates && 1 === count( $updates ) ) {
			$version_string = $update->current;
		}
	}

	// Variable to check for the current version.
	$current = false;
	if ( ! isset( $update->response ) || 'latest' === $update->response ) {
		$current = true;
	}

	// Variables for update notices.
	$submit        = __( 'Update System', 'dashboard-summary' );
	$form_action   = 'update-core.php?action=do-core-upgrade';
	$php_version   = phpversion();
	$mysql_version = $wpdb->db_version();

	// Update manually if a development version is installed.
	if ( 'development' === $update->response ) {
		$notice = __( 'You can update to the latest nightly build manually:', 'dashboard-summary' );

	} else {

		// Re-install notice if current version.
		if ( $current ) {
			$notice     = sprintf( __( 'If you need to re-install version %s, you can do so here:', 'dashboard-summary' ), $version_string );
			$submit      = __( 'Re-install System', 'dashboard-summary' );
			$form_action = 'update-core.php?action=do-core-reinstall';

		// Various notices if not the current version.
		} else {

			// Check required PHP version.
			$php_compat = version_compare( $php_version, $update->php_version, '>=' );

			if ( file_exists( WP_CONTENT_DIR . '/db.php' ) && empty( $wpdb->is_mysql ) ) {
				$mysql_compat = true;
			} else {
				$mysql_compat = version_compare( $mysql_version, $update->mysql_version, '>=' );
			}

			// ClassicPress version URL.
			if ( 'classicpress' === $system ) {
				$version_url = sprintf(
					esc_url( __( 'https://www.classicpress.net/version/%s' ) ),
					$update->current
				);

			// Default to WordPress version URL.
			} else {
				$version_url = sprintf(
					esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
					sanitize_title( $update->current )
				);
			}

			// Link to information on updating a server's PHP version.
			$php_update_notice = sprintf(
				__( '<p><a href="%s" target="_blank" rel="nofollow noreferrer noopener">Learn more about updating PHP</a>.</p>' ),
				update_php_url()
			);

			// PHP & database compatibility notice.
			if ( ! $mysql_compat && ! $php_compat ) {
				$notice = sprintf(
					__( '<p>You cannot update because <a href="%1$s" target="_blank" rel="nofollow noreferrer noopener">%2$s %3$s</a> requires PHP version %4$s or higher and MySQL version %5$s or higher. You are running PHP version %6$s and MySQL version %7$s.</p>', 'dashboard-summary' ),
					$version_url,
					$name,
					$update->current,
					$update->php_version,
					$update->mysql_version,
					$php_version,
					$mysql_version
				);
				$notice .= $php_update_notice;

			// PHP compatibility notice.
			} elseif ( ! $php_compat ) {
				$notice = sprintf(
					__( '<p>You cannot update because <a href="%1$s" target="_blank" rel="nofollow noreferrer noopener">%2$s %3$s</a> requires PHP version %4$s or higher. You are running version %5$s.</p>', 'dashboard-summary' ),
					$version_url,
					$name,
					$update->current,
					$update->php_version,
					$php_version
				);
				$notice .= $php_update_notice;

			// Database compatibility notice.
			} elseif ( ! $mysql_compat ) {
				$notice = sprintf(
					__( '<p>You cannot update because <a href="%1$s" target="_blank" rel="nofollow noreferrer noopener">%2$s %3$s</a> requires MySQL version %4$s or higher. You are running version %5$s.</p>', 'dashboard-summary' ),
					$version_url,
					$name,
					$update->current,
					$update->mysql_version,
					$mysql_version
				);

			// Manual update notice.
			} else {
				$notice = sprintf(
					__( '<p>You can update from  %1$s %2$s to <a href="%3$s" target="_blank" rel="nofollow noreferrer noopener">%4$s %5$s</a> manually:</p>', 'dashboard-summary' ),
					$name,
					$current_version,
					$version_url,
					$name,
					$version_string
				);
			}

			// Variable to show update buttons.
			$show_buttons = true;
			if ( ! $mysql_compat || ! $php_compat ) {
				$show_buttons = false;
			}
		}
	}

	// Print the applicable update notice.
	echo $notice;

	// Begin updates form.
	echo '<form method="post" action="' . $form_action . '" name="upgrade" class="upgrade">';
	wp_nonce_field( 'upgrade-core' );

	// Begin applicable update or dismiss button.
	echo '<p>';
	echo '<input name="version" value="' . esc_attr( $update->current ) . '" type="hidden"/>';
	echo '<input name="locale" value="' . esc_attr( $update->locale ) . '" type="hidden"/>';

	// If update buttons can be shown.
	if ( $show_buttons ) {

		if ( $first_pass ) {
			submit_button( $submit, $current ? '' : 'primary regular', 'upgrade', false );
			$first_pass = false;
		} else {
			submit_button( $submit, '', 'upgrade', false );
		}
	}

	// If the update is not in the default language (en_US).
	if ( 'en_US' !== $update->locale ) {

		if ( ! isset( $update->dismissed ) || ! $update->dismissed ) {
			submit_button( __( 'Hide this update', 'dashboard-summary' ), '', 'dismiss', false );
		} else {
			submit_button( __( 'Bring back this update', 'dashboard-summary' ), '', 'undismiss', false );
		}
	}

	// End applicable update or dismiss button.
	echo '</p>';

	if ( 'en_US' !== $update->locale && ( ! isset( $wp_local_package ) || $wp_local_package != $update->locale ) ) {
		echo '<p class="hint">' . __( 'This localized version contains both the translation and various other localization fixes.', 'dashboard-summary' ) . '</p>';

	} elseif ( 'en_US' === $update->locale && 'en_US' !== get_locale() && ( ! $update->packages->partial && $wp_version == $update->partial_version ) ) {

		// Partial builds don't need language-specific warnings.
		echo '<p class="hint">' . sprintf(
			__( 'You are about to install %s %s <strong>in English (US).</strong> There is a chance this update will break your translation. You may prefer to wait for the localized version to be released.', 'dashboard-summary' ),
			$name,
			'development' !== $update->response ? $update->current : ''
		) . '</p>';
	}

	// End updates form.
	echo '</form>';
}

/**
 * Update PHP URL
 *
 * Link to information on updating a server's PHP version.
 *
 * @since  1.0.0
 * @return string Returns the escaped, filtered URL.
 */
function update_php_url() {
	$url = esc_url( 'https://github.com/ControlledChaos/dashboard-summary/blob/main/includes/docs/update-php-links.md' );
	return apply_filters( 'ds_update_php_url', $url );
}

/**
 * Display dismissed updates
 *
 * @since  1.0.0
 * @return void
 */
function dismissed_updates() {

	// Get dismissed updates.
	$dismissed = get_core_updates(

		// Reverse the default array.
		[
			'dismissed' => true,
			'available' => false,
		]
	);

	// If an update has been dismissed.
	if ( $dismissed ) {
		$show_text = esc_js( __( 'Show hidden updates', 'dashboard-summary' ) );
		$hide_text = esc_js( __( 'Hide hidden updates', 'dashboard-summary' ) );
	?>
	<script type="text/javascript">
		jQuery( function($) {
			$( 'dismissed-updates' ).show();
			$( '#show-dismissed' ).toggle( function() { $(this).text( '<?php echo $hide_text; ?>' ).attr( 'aria-expanded', 'true' ); }, function() { $(this).text( '<?php echo $show_text; ?>' ).attr( 'aria-expanded', 'false' ); } );
			$( '#show-dismissed' ).click( function() { $( '#dismissed-updates' ).toggle( 'fast' ); } );
		});
	</script>
	<?php

	// Show hidden updates message.
	echo '<p class="hide-if-no-js"><button type="button" class="button" id="show-dismissed" aria-expanded="false">' . __( 'Show hidden updates', 'dashboard-summary' ) . '</button></p>';

	// Begin list of dismissed updates.
	echo '<ul id="dismissed-updates" class="core-updates dismissed">';
	foreach ( (array) $dismissed as $update ) {
		echo '<li>';
		available_system_updates( $update );
		echo '</li>';
	}

	// End list of dismissed updates.
	echo '</ul>';

	// End dismissed updates.
	}
}

/**
 * Updates data
 *
 * @since  1.0.0
 * @return integer Returns a number of updates.
 */
function updates( $updates = '' ) {

	// Get update data.
	$data = wp_get_update_data();

	// Switch method cases.
	switch ( $updates ) {

		// Count plugin updates.
		case 'plugins' :
			$output = $data['counts']['plugins'];
			break;

		// Count theme updates.
		case 'themes' :
			$output = $data['counts']['themes'];
			break;

		// Count total updates.
		case 'count' :
			$output = $data['counts']['total'];
			break;

		// Get the updates title, use as default.
		case 'title' :
		default      :
			$output = $data['title'];
			break;
	}

	// Apply a filter for customization.
	return apply_filters( 'ds_updates', $output, $updates );
}

/**
 * Total update count
 *
 * @since  1.0.0
 * @return integer Returns the total number of updates available.
 */
function update_total_count() {
	return updates( 'total' );
}

/**
 * Plugins update count
 *
 * @since  1.0.0
 * @return integer Returns the number of updates available.
 */
function update_plugins_count() {
	return updates( 'plugins' );
}

/**
 * Themes update count
 *
 * @since  1.0.0
 * @return integer Returns the number of updates available.
 */
function update_themes_count() {
	return updates( 'themes' );
}

/**
 * Plugins update list
 *
 * @since  1.0.0
 * @return string Returns the markup & text of the list.
 */
function update_plugins_list() {

	// Get available plugin updates.
	$update_plugins = get_site_transient( 'update_plugins' );

	// Stop here if updates have been disabled.
	$update_data = wp_get_update_data();
	if ( 0 == $update_data['counts']['plugins'] ) {
		return sprintf(
			'<p>%s</p>',
			__( 'There are no plugin updates available.', 'dashboard-summary' )
		);
	}

	// Print the list of updates if available.
	if ( isset( $update_plugins->response ) && is_array( $update_plugins->response ) ) {

		$output = '<ul>';
		foreach ( $update_plugins->response as $update ) {

			// Define the name of the plugin.
			$data = get_plugin_data( ABSPATH . 'wp-content/plugins/' . $update->plugin );
			$name = $data['Name'];

			// Plugin details URL.
			$details = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $update->slug . '&section=changelog&TB_iframe=true&width=600&height=800' );

			// Internal template.
			// $details = DS_URL . 'views/plugin-install.php?tab=plugin-information&plugin=' . $update->slug . '&section=changelog&TB_iframe=true&width=600&height=800';

			// List item for each available update.
			$output .= '<li>';
			$output .= sprintf(
				__( '<strong>There is a new version of %1$s available. <a href="%2$s" target="_blank" rel="nofollow noreferrer noopener" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.</strong>', 'dashboard-summary' ),
				$name,
				esc_url( $details ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr( sprintf(
						__( 'View %1$s version %2$s details', 'dashboard-summary' ),
						$name,
						$update->new_version
					) )
				),
				esc_attr( $update->new_version ),
				wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $update->plugin, 'upgrade-plugin_' . $update->plugin ),
				sprintf(
					'class="update-link" aria-label="%s"',
					esc_attr( sprintf( __( 'Update %s now', 'dashboard-summary' ), $name ) )
				)
			);
			$output .= '</li>';
		}
		$output .= '</ul>';

	// No updates notice.
	} else {
		$output = sprintf(
			'<p>%s</p>',
			__( 'There are no plugin updates available.', 'dashboard-summary' )
		);
	}
	return $output;
}

/**
 * Themes update list
 *
 * @since  1.0.0
 * @return string Returns the markup & text of the list.
 */
function update_themes_list() {

	// Get available theme updates.
	$update_themes = get_site_transient( 'update_themes' );

	// Stop here if updates have been disabled.
	$update_data = wp_get_update_data();

	if ( 0 == $update_data['counts']['themes'] ) {
		return sprintf(
			'<p>%s</p>',
			__( 'There are no theme updates available.', 'dashboard-summary' )
		);
	}

	// Print the list of updates if available.
	if ( isset( $update_themes->response ) && is_array( $update_themes->response ) ) {

		$output = '<ul>';
		foreach ( $update_themes->response as $update ) {

			$theme = $update['theme'];
			$output .= update_themes_list_items( wp_get_theme( $theme ) );
		}
		$output .= '</ul>';

	// No updates notice.
	} else {
		$output = sprintf(
			'<p>%s</p>',
			__( 'There are no theme updates available.', 'dashboard-summary' )
		);
	}
	return $output;
}

/**
 * Theme update list items
 *
 * Returns a list item with links if there is an update available.
 * This is a copy of `get_theme_update_available()`
 * with the exception removed for multisite.
 *
 * @see wp-admin/includes/theme.php
 *
 * @since  1.0.0
 * @param WP_Theme $theme WP_Theme object.
 * @return string|false Returns the markup for the update link or
 *                      false if invalid info was passed.
 */
function update_themes_list_items( $theme ) {

	static $themes_update = null;

	if ( ! current_user_can( 'update_themes' ) ) {
		return false;
	}

	if ( ! isset( $themes_update ) ) {
		$themes_update = get_site_transient( 'update_themes' );
	}

	if ( ! ( $theme instanceof \WP_Theme ) ) {
		return false;
	}

	$stylesheet = $theme->get_stylesheet();
	$html       = '';

	if ( isset( $themes_update->response[ $stylesheet ] ) ) {
		$update      = $themes_update->response[ $stylesheet ];
		$theme_name  = $theme->display( 'Name' );
		$details_url = add_query_arg(
			[
				'TB_iframe' => 'true',
				'width'     => 1024,
				'height'    => 800,
			],
			$update['url']
		);
		$update_url = wp_nonce_url(
			admin_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $stylesheet ) ),
			'upgrade-theme_' . $stylesheet
		);

		if ( ! current_user_can( 'update_themes' ) ) {

			$html = sprintf(
				'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" target="_blank" rel="nofollow noreferrer noopener" %3$s>View version %4$s details</a>.', 'dashboard-summary' ) . '</strong></li>',
				$theme_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr( sprintf( __( 'View %1$s version %2$s details', 'dashboard-summary' ), $theme_name, $update['new_version'] ) )
				),
				$update['new_version']
			);

		} elseif ( empty( $update['package'] ) ) {

			$html = sprintf(
				'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" target="_blank" rel="nofollow noreferrer noopener" %3$s>View version %4$s details</a>. <em>Automatic update is unavailable for this theme.</em>', 'dashboard-summary' ) . '</strong></li>',
				$theme_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr( sprintf( __( 'View %1$s version %2$s details', 'dashboard-summary' ), $theme_name, $update['new_version'] ) )
				),
				$update['new_version']
			);

		} else {

			$html = sprintf(
				'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" target="_blank" rel="nofollow noreferrer noopener" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.', 'dashboard-summary' ) . '</strong></li>',
				$theme_name,
				esc_url( $details_url ),
				sprintf(
					'class="thickbox open-plugin-details-modal" aria-label="%s"',
					esc_attr( sprintf( __( 'View %1$s version %2$s details', 'dashboard-summary' ), $theme_name, $update['new_version'] ) )
				),
				$update['new_version'],
				$update_url,
				sprintf(
					'aria-label="%s" id="update-theme" data-slug="%s"',
					esc_attr( sprintf( __( 'Update %s now', 'dashboard-summary' ), $theme_name ) ),
					$stylesheet
				)
			);
		}
	}
	return $html;
}

/**
 * User avatar
 *
 * @since  1.0.0
 * @return string Returns the markup of the avatar.
 */
function user_avatar() {

	// Get the current user data for the caption & attributes.
	$current_user = wp_get_current_user();
	$user_id      = get_current_user_id();
	$user_name    = $current_user->display_name;
	$avatar       = get_avatar(
		$user_id,
		64,
		'',
		$current_user->display_name,
		[
			'class'         => 'dashboard-panel-avatar alignnone',
			'force_display' => true
			]
	);

	?>
	<figure>
		<a href="<?php echo esc_url( admin_url( 'profile.php' ) ); ?>">
			<?php echo $avatar; ?>
		</a>
		<figcaption class="screen-reader-text"><?php echo $user_name; ?></figcaption>
	</figure>
	<?php
}

/**
 * User intro
 *
 * Used in the profile tab.
 *
 * @since  1.0.0
 * @return string Returns the markup of the intro.
 */
function user_intro() {

	?>
	<div class="ds-user-greeting">
		<?php user_avatar(); ?>

		<div>
			<?php
			user_greeting();
			user_greeting_description();
			?>
		</div>
	</div>
	<?php
}

/**
 * User greeting
 *
 * @since  1.0.0
 * @return string Returns the text of the greeting.
 */
function user_greeting() {

	// Get the current user data for the greeting.
	$current_user = wp_get_current_user();
	$user_id      = get_current_user_id();
	$user_name    = $current_user->display_name;

	echo apply_filters(
		'ds_user_greeting',
		sprintf(
			'<h4>%1s %2s.</h4>',
			esc_html__( 'Hello,', 'dashboard-summary' ),
			$user_name
		)
	);
}

/**
 * User greeting description
 *
 * @since  1.0.0
 * @return string Returns the text of the description.
 */
function user_greeting_description() {

	echo apply_filters(
		'ds_user_greeting_description',
		sprintf(
			'<p class="description">%s</p>',
			__( 'This section provides details about your account.', 'dashboard-summary' )
		)
	);
}

/**
 * Display updates tab
 *
 * Used to display the updates tab in the default
 * widget if the current user can update at least
 * one of the update options.
 *
 * Only display on the network dashboard if the
 * installation is in network mode.
 *
 * @since  1.0.0
 * @return boolean Returns true if the user can update.
 */
function updates_tab() {

	// Exclude the dashboards of network sites.
	if ( is_multisite() && ! is_network_admin() ) {
		return;
	}

	// Return true for certain user capabilities.
	if (
		current_user_can( 'update_core' ) ||
		current_user_can( 'update_plugins' ) ||
		current_user_can( 'update_themes' ) ||
		current_user_can( 'update_languages' )
	) {
		return true;
	}

	// Return false by default.
	return false;
}

/**
 * Plugin information modal button text
 *
 * Filters the text of the "Install Update Now" button.
 *
 * @since  1.0.0
 * @return void
 */
function plugin_modal_button_text( $translated_text, $text, $domain ) {

	if ( 'Install Update Now' === $translated_text ) {
		$translated_text = __( 'Close to Install', 'dashboard-summary' );
	}
	return $translated_text;
}

/**
 * Plugin information modal
 *
 * Displays plugin information content in the
 * modal window opened by updates links.
 *
 * @since  1.0.0
 * @return void
 */
function plugin_info_modal() {

	// Stop here if no plugin request.
	if ( empty( $_REQUEST['plugin'] ) ) {
		return;
	}

	// Check for alternative management systems.
	$classicpress = false;
	if ( 'classicpress' === management_system() ) {
		$classicpress = true;
	}

	// Access the plugins API.
	$api = [];
	if ( function_exists( 'plugins_api' ) ) {
		$api = plugins_api(
			'plugin_information',
			[
				'slug'   => wp_unslash( $_REQUEST['plugin'] ),
				'is_ssl' => is_ssl(),
				'fields' => [
					'banners'         => true,
					'reviews'         => true,
					'downloaded'      => false,
					'active_installs' => true
				]
			]
		);
	} else {

		// Die message.
		$die = sprintf(
			'<h1>%s</h1><p>%s</p>',
			'File Error',
			'Plugin information could not be loaded. Files required to display the information could not be accessed.'
		);
		die( $die );
	}

	// Die message if any error getting data.
	if ( is_wp_error( $api ) ) {
		wp_die( $api );
	}

	/**
	 * HTML elements allowed in the content
	 *
	 * This white list helps to prevent malicious
	 * code (e.g. not allowing the `<script>` tag).
	 */
	$allowed_html = [
		'a' => [
			'href'   => [],
			'title'  => [],
			'target' => [],
		],
		'abbr'    => [
			'title' => []
		],
		'acronym' => [
			'title' => []
		],
		'code'    => [],
		'pre'     => [],
		'em'      => [],
		'strong'  => [],
		'div'     => [
			'class' => []
		],
		'span'    => [
			'class' => []
		],
		'p'       => [],
		'br'      => [],
		'ul'      => [],
		'ol'      => [],
		'li'      => [],
		'h1'      => [],
		'h2'      => [],
		'h3'      => [],
		'h4'      => [],
		'h5'      => [],
		'h6'      => [],
		'img'     => [
			'src'   => [],
			'class' => [],
			'alt'   => [],
		],
		'blockquote' => [
			'cite' => true
		],
	];

	// Array of tabbed section headings.
	$section_heading = [
		'description'  => _x( 'Description', 'Plugin installer section title', 'dashboard-summary' ),
		'installation' => _x( 'Installation', 'Plugin installer section title', 'dashboard-summary' ),
		'faq'          => _x( 'FAQ', 'Plugin installer section title', 'dashboard-summary' ),
		'screenshots'  => _x( 'Screenshots', 'Plugin installer section title', 'dashboard-summary' ),
		'changelog'    => _x( 'Changelog', 'Plugin installer section title', 'dashboard-summary' ),
		'reviews'      => _x( 'Reviews', 'Plugin installer section title', 'dashboard-summary' ),
		'other_notes'  => _x( 'Other Notes', 'Plugin installer section title', 'dashboard-summary' ),
	];

	// Sanitize the allowed HTML.
	foreach ( (array) $api->sections as $section_name => $content ) {
		$api->sections[ $section_name ] = wp_kses( $content, $allowed_html );
	}

	// Entries in the plugin details list.
	foreach ( [ 'version', 'author', 'requires', 'tested', 'homepage', 'downloaded', 'slug' ] as $key ) {

		// Filter text content and strips out disallowed HTML.
		if ( isset( $api->$key ) ) {
			$api->$key = wp_kses( $api->$key, $allowed_html );
		}
	}

	// Default to the Description tab. Do not translate, API returns English.
	if ( isset( $_REQUEST['section'] ) ) {
		$section = wp_unslash( $_REQUEST['section'] );
	} else {
		$section = 'description';
	}

	if ( empty( $section ) || ! isset( $api->sections[ $section ] ) ) {
		$section_heading = array_keys( (array) $api->sections );
		$section         = reset( $section_heading );
	}

	// Print the iframe header with document title.
	iframe_header( __( 'Plugin Information', 'dashboard-summary' ) );

	// Wrapper class if no plugin banner is available.
	$banner_class = 'no-banner';

	// If a plugin banner is available.
	if ( ! empty( $api->banners ) && ( ! empty( $api->banners['low'] ) || ! empty( $api->banners['high'] ) ) ) {

		// Wrapper class if a plugin banner is available.
		$banner_class = 'with-banner';

		// Get low-definition banner.
		if ( empty( $api->banners['low'] ) ) {
			$low = $api->banners['high'];
		} else {
			$low = $api->banners['low'];
		}

		// Get high-definition banner.
		if ( empty( $api->banners['high'] ) ) {
			$high = $api->banners['low'];
		} else {
			$high = $api->banners['high'];
		}
		?>
		<style type="text/css">
			#plugin-information-title.with-banner {
				background-image: url( <?php echo esc_url( $low ); ?> );
			}
			@media only screen and ( -webkit-min-device-pixel-ratio: 1.5 ) {
				#plugin-information-title.with-banner {
					background-image: url( <?php echo esc_url( $high ); ?> );
				}
			}
		</style>
		<?php
	}

	?>
	<div id="plugin-information-scrollable">

		<div id="plugin-information-title" class="<?php echo esc_attr( $banner_class ); ?>">
			<div class='vignette'></div>
			<h2><?php echo $api->name; ?></h2>
		</div>

		<div id="plugin-information-tabs" class="<?php echo esc_attr( $banner_class ); ?>">

			<?php
			foreach ( (array) $api->sections as $section_name => $content ) :

				if ( 'reviews' === $section_name && ( empty( $api->ratings ) || 0 === array_sum( (array) $api->ratings ) ) ) {
					continue;
				}

				if ( isset( $section_heading[ $section_name ] ) ) {
					$title = $section_heading[ $section_name ];
				} else {
					$title = ucwords( str_replace( '_', ' ', $section_name ) );
				}

				$class = ( $section_name === $section ) ? 'current' : 'not-current';
				$href  = add_query_arg(
					[
						'tab'     => 'plugin-information',
						'section' => $section_name,
					]
				);

			?>

			<a href="<?php echo esc_url( $href ); ?>" name="<?php echo esc_attr( $section_name ); ?>" class="<?php echo $class; ?>"><?php echo $title; ?></a>

			<?php endforeach; ?>
		</div>

		<div id="plugin-information-content" class='<?php echo $banner_class; ?>'>
			<div class="fyi">

				<ul>
					<?php if ( ! empty( $api->version ) ) : ?>
						<li><strong><?php _e( 'Version:', 'dashboard-summary' ); ?></strong> <?php echo $api->version; ?></li>
					<?php endif; ?>

					<?php if ( ! empty( $api->author ) ) : ?>
						<li><strong><?php _e( 'Author:', 'dashboard-summary' ); ?></strong> <?php echo links_add_target( $api->author, '_blank' ); ?></li>
					<?php endif; ?>

					<?php if ( ! empty( $api->last_updated ) ) : ?>
						<li><strong><?php _e( 'Last Updated:', 'dashboard-summary' ); ?></strong>
							<?php
							printf(
								__( '%s ago', 'dashboard-summary' ),
								human_time_diff( strtotime( $api->last_updated ) )
							); ?>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $api->requires ) ) : ?>
						<li>
							<strong><?php _e( 'Requires WordPress Version:', 'dashboard-summary' ); ?></strong>
							<?php
							printf(
								__( '%s or higher', 'dashboard-summary' ),
								$api->requires
							);
							?>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $api->tested ) ) : ?>
						<li><strong><?php _e( 'Compatible up to:', 'dashboard-summary' ); ?></strong> <?php echo $api->tested; ?></li>
					<?php endif; ?>

					<?php if ( ! empty( $api->requires_php ) ) : ?>
						<li>
							<strong><?php _e( 'Requires PHP Version:', 'dashboard-summary' ); ?></strong>
							<?php
							printf(
								__( '%s or higher', 'dashboard-summary' ),
								$api->requires_php
							);
							?>
						</li>
					<?php endif; ?>

					<?php if ( isset( $api->active_installs ) ) : ?>
						<li><strong><?php _e( 'Active Installations:', 'dashboard-summary' ); ?></strong>
						<?php

						if ( $api->active_installs >= 1000000 ) {

							$active_installs_millions = floor( $api->active_installs / 1000000 );
							printf(
								_nx( '%s+ Million', '%s+ Million', $active_installs_millions, 'Active plugin installations', 'dashboard-summary' ),
								number_format_i18n( $active_installs_millions )
							);

						} elseif ( 0 == $api->active_installs ) {
							_ex( 'Less Than 10', 'Active plugin installations', 'dashboard-summary' );
						} else {
							echo number_format_i18n( $api->active_installs ) . '+';
						} ?>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $api->slug ) && empty( $api->external ) ) : ?>
						<li><a target="_blank" href="<?php echo __( 'https://wordpress.org/plugins/' ) . $api->slug; ?>/"><?php _e( 'WordPress.org Plugin Page &#187;', 'dashboard-summary' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $api->homepage ) ) : ?>
						<li><a target="_blank" href="<?php echo esc_url( $api->homepage ); ?>"><?php _e( 'Plugin Homepage &#187;', 'dashboard-summary' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $api->donate_link ) && empty( $api->contributors ) ) : ?>
						<li><a target="_blank" href="<?php echo esc_url( $api->donate_link ); ?>"><?php _e( 'Donate to this plugin &#187;', 'dashboard-summary' ); ?></a></li>
					<?php endif; ?>
				</ul>

				<?php if ( ! empty( $api->rating ) ) : ?>

					<h3><?php _e( 'Average Rating', 'dashboard-summary' ); ?></h3>
					<?php
					wp_star_rating(
						array(
							'rating' => $api->rating,
							'type'   => 'percent',
							'number' => $api->num_ratings,
						)
					);
					?>
					<p aria-hidden="true" class="fyi-description">
						<?php
						printf(
							_n( '(based on %s rating)', '(based on %s ratings)', $api->num_ratings, 'dashboard-summary' ),
							number_format_i18n( $api->num_ratings )
						);
						?>
					</p>
					<?php
				endif;

				if ( ! empty( $api->ratings ) && array_sum( (array) $api->ratings ) > 0 ) :

				?>
					<h3><?php _e( 'Reviews', 'dashboard-summary' ); ?></h3>

					<p class="fyi-description"><?php _e( 'Read all reviews on WordPress.org or write your own!', 'dashboard-summary' ); ?></p>

					<?php
					foreach ( $api->ratings as $key => $rate_count ) :

						// Avoid div-by-zero.
						$_rating    = $api->num_ratings ? ( $rate_count / $api->num_ratings ) : 0;
						$aria_label = esc_attr(
							sprintf(
								_n(
									'Reviews with %1$d star: %2$s. Opens in a new tab.',
									'Reviews with %1$d stars: %2$s. Opens in a new tab.',
									$key,
									'dashboard-summary'
								),
								$key,
								number_format_i18n( $rate_count )
							)
						);
						?>
						<div class="counter-container">
								<span class="counter-label">
									<?php
									printf(
										'<a href="%s" target="_blank" rel="nofollow noreferrer noopener" aria-label="%s">%s</a>',
										"https://wordpress.org/support/plugin/{$api->slug}/reviews/?filter={$key}",
										$aria_label,
										sprintf( _n( '%d star', '%d stars', $key, 'dashboard-summary' ), $key )
									);
									?>
								</span>
								<span class="counter-back">
									<span class="counter-bar" style="width: <?php echo 92 * $_rating; ?>px;"></span>
								</span>
							<span class="counter-count" aria-hidden="true"><?php echo number_format_i18n( $rate_count ); ?></span>
						</div>
						<?php
					endforeach;
				endif;

				if ( ! empty( $api->contributors ) ) :
					?>
					<h3><?php _e( 'Contributors', 'dashboard-summary' ); ?></h3>

					<ul class="contributors">
						<?php
						foreach ( (array) $api->contributors as $contributor_username => $contributor_details ) :

							$contributor_name = $contributor_details['display_name'];

							if ( ! $contributor_name ) {
								$contributor_name = $contributor_username;
							}
							$contributor_name    = esc_html( $contributor_name );
							$contributor_profile = esc_url( $contributor_details['profile'] );
							$contributor_avatar  = esc_url( add_query_arg( 's', '36', $contributor_details['avatar'] ) );

							?>
							<li><a href="<?php echo $contributor_profile; ?>" target="_blank" rel="nofollow noreferrer noopener"><img src="<?php echo $contributor_avatar; ?>" alt="<?php echo $contributor_name; ?>-avatar" width="18" height="18"><?php echo $contributor_name; ?></a></li>
						<?php endforeach; ?>
					</ul>

					<?php if ( ! empty( $api->donate_link ) ) : ?>
					<a target="_blank" href="<?php echo esc_url( $api->donate_link ); ?>"><?php _e( 'Donate to this plugin &#187;', 'dashboard-summary' ); ?></a>
					<?php endif; ?>

				<?php endif; ?>
			</div>

			<div id="section-holder">
				<?php

				// Do not check for PHP version in ClassicPress or WordPress less than 5.2.0.
				if ( ! $classicpress || version_compare( get_bloginfo( 'version' ),'5.2.0', '>=' ) ) :

					// Variables for printing notices.
					$requires_php   = isset( $api->requires_php ) ? $api->requires_php : null;
					$compatible_php = is_php_version_compatible( $requires_php );

					// Notice if the required PHP version is not met.
					if ( ! $compatible_php ) :
					?>
						<div class="notice notice-error notice-alt">

							<?php printf(
								__( '<p>This plugin requires PHP version %s and your server is running PHP version %s.</p>', 'dashboard-summary' ),
								$requires_php,
								phpversion()
							); ?>

							<?php if ( current_user_can( 'update_php' ) ) {
								printf(
									' ' . __( '<p><a href="%s" target="_blank" rel="nofollow noreferrer noopener">Click here to learn more about updating PHP</a>.</p>', 'dashboard-summary' ),
									update_php_url()
								);
							} ?>
						</div>
					<?php endif; // if ( ! $compatible_php )
				endif; // if ( ! $classicpress )

				// Notice if the plugin has not been tested with the current system version.
				$requires_app = isset( $api->requires ) ? $api->requires : null;

				$compatible_app = true;
				if ( function_exists( 'is_wp_version_compatible' ) ) {
					$compatible_app = is_wp_version_compatible( $requires_app );
				} elseif ( ! empty( $requires_app ) && version_compare( substr( get_bloginfo( 'version' ), 0, strlen( $requires_app ) ), $requires_app, '<' ) ) {
					$compatible_app = false;
				}

				$tested_app = ( empty( $api->tested ) || version_compare( get_bloginfo( 'version' ), $api->tested, '<=' ) );

				if ( ! $tested_app ) :
				?>
					<div class="notice notice-warning notice-alt">
						<?php printf(
							__( '<p>This plugin has not been tested with your current version of %s.</p>', 'dashboard-summary' ),
							system_name()
						); ?>
					</div>
				<?php

				// Notice if the plugin is not compatible with the current system version.
				elseif ( ! $compatible_app ) :
				?>
					<div class="notice notice-error notice-alt">

						<?php printf(
							__( '<p>This plugin requires a newer version of %s.</p>', 'dashboard-summary' ),
							system_name()
						); ?>

						<?php if ( current_user_can( 'update_core' ) ) {
							printf(
								' ' . __( '<a href="%s" target="_parent">Click here to update %s</a>.', 'dashboard-summary' ),
								self_admin_url( 'update-core.php' ),
								system_name()
							);
						} ?>
					</div>
				<?php endif;

				foreach ( (array) $api->sections as $section_name => $content ) :

					$content = links_add_base_url( $content, 'https://wordpress.org/plugins/' . $api->slug . '/' );
					$content = links_add_target( $content, '_blank' );
					$display = ( $section_name === $section ) ? 'block' : 'none';

					?>
					<div id="<?php echo 'section-' . esc_attr( $section_name ); ?>" class='section' style="display: <?php echo $display; ?>">
						<?php
						// Print the content of the tabbed section.
						echo $content; ?>
					</div>
				<?php endforeach; ?>
			</div><!-- #section-holder -->
		</div><!-- #plugin-information-content -->
	</div><!-- #plugin-information-scrollable -->

	<?php
	iframe_footer();

	/**
	 * Exit to prevent loading extra markup,
	 * such as the admin toolbar.
	 */
	exit;
}
