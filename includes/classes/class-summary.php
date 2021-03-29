<?php
/**
 * Summary methods
 *
 * Methods used throughout the plugin for
 * website and network dashboards.
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Content
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Summary {

	/**
	 * Instance of the class
	 *
	 * This method can be used to call an instance
	 * of the class from outside the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns an instance of the class.
	 */
	public static function instance() {
		return new self;
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
	 * @access public
	 * @return array Returns an array of queried post types.
	 */
	public function custom_types_query() {

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
	 * @access public
	 * @return array Returns an array of all public post types.
	 */
	public function public_post_types() {

		// Array of built-in post types.
		$builtin = [ 'post', 'page', 'attachment' ];

		// Custom post types query.
		$query = $this->custom_types_query();

		// Merge the post type arrays.
		$types = array_merge( $builtin, $query );

		// Return the public post types.
		return apply_filters( 'ds_public_post_types', $types );
	}

	/**
	 * Taxonomies query
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried taxonomies.
	 */
	public function taxonomies_query() {

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
	 * @access public
	 * @return mixed Returns unordered list markup.
	 */
	public function post_types_list() {

		// Get all public post types.
		$post_types = $this->public_post_types();

		// Begin the post types list.
		$html = '<ul class="ds-content-list ds-post-types-list">';

		// Conditional list items.
		foreach ( $post_types as $post_type ) {

			$type = get_post_type_object( $post_type );

			// Count the number of posts.
			$get_count = wp_count_posts( $type->name );
			if ( 'attachment' == $post_type ) {
				$count = $get_count->inherit;
			} else {
				$count = $get_count->publish;
			}

			// Get the number of published posts.
			$number = number_format_i18n( $count );

			// Get the plural or single name based on the count.
			$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count ) );

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

			// Supply an edit link if the user can edit posts.
			if ( current_user_can( $type->cap->edit_posts ) ) {
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
	 * @access public
	 * @return mixed Returns unordered list markup.
	 */
	public function taxonomies_list() {

		// Get taxonomies.
		$taxonomies = summary()->taxonomies_query();

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

				// Get the plural or singlular name based on the count.
				$name = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $count ) );

				// Supply an edit link if the user can edit associated post types.
				$edit = get_post_type_object( $types );
				if ( current_user_can( $edit->cap->edit_posts ) ) {

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
	 * @access public
	 * @return mixed Returns unordered list markup.
	 */
	public function taxonomies_icons_list() {

		// Get taxonomies.
		$taxonomies = summary()->taxonomies_query();

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

				// Get the plural or singlular name based on the count.
				$name = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $count ) );

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

				// Supply an edit link if the user can edit associated post types.
				$edit = get_post_type_object( $types );
				if ( current_user_can( $edit->cap->edit_posts ) ) {

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
	 * @access public
	 * @return integer Returns the number of registered users.
	 */
	public static function total_users() {

		// Count the registered users.
		$count = count_users();

		// Return the number of total registered users.
		return intval( $count['total_users'] );
	}

	/**
	 * Get current user comments
	 *
	 * @since  1.0.0
	 * @access public
	 * @return integer Returns the number of comments for the user.
	 */
	public function get_user_comments_count() {

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
	 * @access public
	 * @return string Returns a PHP version notice.
	 */
	public function php_version() {

		// Markup of the notice.
		$output = sprintf(
			'%s <a href="%s">%s</a>',
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
	 * @access public
	 * @global object $wpdb Database access abstraction class.
	 * @return array Returns an array of database results.
	 */
	public function get_database_vars() {

		// Access the wpdb class.
		global $wpdb;

		// Return false if no database results.
		if ( ! $results = $wpdb->get_results( 'SHOW GLOBAL VARIABLES' ) ) {
			return false;
		}

		// Set up an array of database results.
		$mysql_vars = [];

		// For each database result.
		foreach ( $results as $result ) {

			// Result name.
			$mysql_vars[ $result->Variable_name ] = $result->Value;
		}

		// Return an array of database results.
		return $mysql_vars;
	}

	/**
	 * Get database version
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the database name/version or
	 *                "Not available".
	 */
	public function get_database_version() {

		// Get database variables.
		$vars = $this->get_database_vars();

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
	 * Database version notice
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the text of database version notice.
	 */
	public function database_version() {

		// Markup of the notice.
		$output = sprintf(
			'%s %s',
			__( 'The database version is', 'dashboard-summary' ),
			$this->get_database_version()
		);

		// Return the notice. Apply filter for customization.
		return apply_filters( 'ds_database_version_notice', $output );
	}

	/**
	 * Management system
	 *
	 * Defines the name of the management system.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the name of the management system.
	 */
	public function management_system() {

		// Check for ClassicPress.
		if ( function_exists( 'classicpress_version' ) ) {
			$output = __( 'ClassicPress', 'dashboard-summary' );

		// Default to WordPress.
		} else {
			$output = __( 'WordPress', 'dashboard-summary' );
		}

		// Return the system name. Apply filter for customization.
		return apply_filters( 'ds_system_name', $output );
	}

	/**
	 * System notice
	 *
	 * States the management system and version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the link to the management system.
	 */
	public function system_notice() {

		// Get system name.
		$system = $this->management_system();

		// Text for site or network dashboard.
		if ( is_multisite() && is_network_admin() ) {
			$text = __( 'This network is running', 'dashboard-summary' );
		} else {
			$text = __( 'This website is running', 'dashboard-summary' );
		}

		// Check for ClassicPress.
		if ( function_exists( 'classicpress_version' ) ) {

			// Markup of the notice.
			$output = sprintf(
				'%s <a href="%s">%s</a>',
				$text,
				esc_url( 'https://github.com/ClassicPress/ClassicPress-release/releases' ),
				$system . ' ' . get_bloginfo( 'version', 'display' )
			);

		// Default to WordPress.
		} else {

			// Markup of the notice.
			$output = sprintf(
				'%s <a href="%s">%s</a>',
				$text,
				esc_url( 'https://wordpress.org/download/releases/' ),
				$system . ' ' . get_bloginfo( 'version', 'display' )
			);
		}

		// Return the notice. Apply filter for customization.
		return apply_filters( 'ds_system_notice', $output );
	}

	/**
	 * Search engine notice
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed Returns a string if search engines discouraged.
	 *               Returns null if search engines not discouraged.
	 */
	public function search_engines() {

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
			'0' == get_option( 'blog_public' )
		) {
			// Markup of the notice.
			$output = sprintf(
				'<a class="ds-search-engines" href="%s">%s</a>',
				esc_url( admin_url( 'options-reading.php' ) ),
				$text
			);

		// Print nothing if search engines are not discouraged.
		} else {
			$output = null;
		}

		// Return the notice. Apply filter for customization.
		return apply_filters( 'ds_search_engines', $output );
	}

	/**
	 * Active theme URI
	 *
	 * Use `is_null()` to check for a return value.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed Returns the URI for the active theme's website
	 *               or returns null.
	 */
	public function active_theme_uri() {

		// Get theme data.
		$theme     = wp_get_theme();
		$theme_uri = $theme->get( 'ThemeURI' );

		// If the theme header has a URI.
		if ( $theme_uri ) {
			$theme_uri = $theme_uri;

		// Otherwise return nothing.
		} else {
			$theme_uri = null;
		}

		// Return the URI string ot null.
		return $theme_uri;
	}

	/**
	 * Active theme notice
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the text of the active theme notice.
	 */
	public function active_theme() {

		// Get the active theme name.
		$theme_name = wp_get_theme();

		/**
		 * If the theme header has the URI tag then
		 * print the link in the header.
		 */
		if ( ! is_null( $this->active_theme_uri() ) ) {

			// Markup of the notice for network dashboards.
			if ( is_network_admin() ) {
				$theme_name = sprintf(
					'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
					__( 'The active theme of the primary site is', 'dashboard-summary' ),
					$this->active_theme_uri(),
					$theme_name
				);

			// Markup of the notice for site dashboards.
			} else {
				$theme_name = sprintf(
					'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
					__( 'The active theme is', 'dashboard-summary' ),
					$this->active_theme_uri(),
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
	 * @access public
	 * @global string $required_php_version The required PHP version string.
	 * @global string $required_mysql_version The required MySQL version string.
	 * @return void
	 */
	public function update_system_list() {

		// Access global variables.
		global $required_php_version, $required_mysql_version;

		// Get core updates.
		$updates = get_core_updates();

		// // Get core updates data.
		$update_data = wp_get_update_data();

		// Stop here if updates have been disabled.
		if ( 0 == $update_data['counts']['wordpress'] ) {

			// Print the markup for no system updates.
			printf(
				'<p class="response">%s</p>',
				__( 'There are no system updates available.', 'dashboard-summary' )
			);
			return;
		}

		// Get the system version.
		require ABSPATH . WPINC . '/version.php';

		// System name.
		$system = $this->management_system();

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
			$this->available_system_updates( $update );
			echo '</li>';
		}

		// End updates list.
		echo '</ul>';

		// Display dismissed updates.
		$this->dismissed_updates();
	}

	/**
	 * Available system updates
	 *
	 * @since  1.0.0
	 * @access public
	 * @global string $wp_local_package Locale code of the package.
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param  object $update
	 * @return void
	 */
	public function available_system_updates( $update ) {

		// Access global variables.
		global $wp_local_package, $wpdb;
		static $first_pass = true;

		// System name.
		$system = $this->management_system();

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

		// Defualt version string.
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

		// Variables for update messages.
		$submit        = __( 'Update System', 'dashboard-summary' );
		$form_action   = 'update-core.php?action=do-core-upgrade';
		$php_version   = phpversion();
		$mysql_version = $wpdb->db_version();

		// Update manually if a development version is installed.
		if ( 'development' === $update->response ) {
			$message = __( 'You can update to the latest nightly build manually:', 'dashboard-summary' );

		} else {

			if ( $current ) {
				$message     = sprintf( __( 'If you need to re-install version %s, you can do so here:', 'dashboard-summary' ), $version_string );
				$submit      = __( 'Re-install System', 'dashboard-summary' );
				$form_action = 'update-core.php?action=do-core-reinstall';

			} else {

				$php_compat = version_compare( $php_version, $update->php_version, '>=' );

				if ( file_exists( WP_CONTENT_DIR . '/db.php' ) && empty( $wpdb->is_mysql ) ) {
					$mysql_compat = true;
				} else {
					$mysql_compat = version_compare( $mysql_version, $update->mysql_version, '>=' );
				}

				$version_url = sprintf(
					esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
					sanitize_title( $update->current )
				);

				if ( function_exists( 'wp_get_update_php_url' ) ) {
					$php_update_message = '</p><p>' . sprintf(
						__( '<a href="%s">Learn more about updating PHP</a>.' ),
						esc_url( wp_get_update_php_url() )
					);
				} else {
					$php_update_message = '';
				}

				if ( function_exists( 'wp_get_update_php_url' ) ) {
					$annotation = wp_get_update_php_annotation();
				} else {
					$annotation = null;
				}

				if ( $annotation ) {
					$php_update_message .= '</p><p><em>' . $annotation . '</em>';
				}

				if ( ! $mysql_compat && ! $php_compat ) {
					$message = sprintf(
						__( 'You cannot update because <a href="%1$s">%2$s %3$s</a> requires PHP version %4$s or higher and MySQL version %5$s or higher. You are running PHP version %6$s and MySQL version %7$s.', 'dashboard-summary' ),
						$version_url,
						$system,
						$update->current,
						$update->php_version,
						$update->mysql_version,
						$php_version,
						$mysql_version
					) . $php_update_message;

				} elseif ( ! $php_compat ) {
					$message = sprintf(
						__( 'You cannot update because <a href="%1$s">%2$s %3$s</a> requires PHP version %4$s or higher. You are running version %5$s.', 'dashboard-summary' ),
						$version_url,
						$system,
						$update->current,
						$update->php_version,
						$php_version
					) . $php_update_message;

				} elseif ( ! $mysql_compat ) {
					$message = sprintf(
						__( 'You cannot update because <a href="%1$s">%2$s %3$s</a> requires MySQL version %4$s or higher. You are running version %5$s.', 'dashboard-summary' ),
						$version_url,
						$system,
						$update->current,
						$update->mysql_version,
						$mysql_version
					);

				} else {
					$message = sprintf(
						__( 'You can update from  %1$s %2$s to <a href="%3$s">%4$s %5$s</a> manually:', 'dashboard-summary' ),
						$system,
						$current_version,
						$version_url,
						$system,
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

		echo '<p>' . $message .'</p>';

		echo '<form method="post" action="' . $form_action . '" name="upgrade" class="upgrade">';
		wp_nonce_field( 'upgrade-core' );

		echo '<p>';
		echo '<input name="version" value="' . esc_attr( $update->current ) . '" type="hidden"/>';
		echo '<input name="locale" value="' . esc_attr( $update->locale ) . '" type="hidden"/>';
		if ( $show_buttons ) {

			if ( $first_pass ) {
				submit_button( $submit, $current ? '' : 'primary regular', 'upgrade', false );
				$first_pass = false;
			} else {
				submit_button( $submit, '', 'upgrade', false );
			}
		}

		if ( 'en_US' !== $update->locale ) {

			if ( ! isset( $update->dismissed ) || ! $update->dismissed ) {
				submit_button( __( 'Hide this update', 'dashboard-summary' ), '', 'dismiss', false );
			} else {
				submit_button( __( 'Bring back this update', 'dashboard-summary' ), '', 'undismiss', false );
			}
		}
		echo '</p>';

		if ( 'en_US' !== $update->locale && ( ! isset( $wp_local_package ) || $wp_local_package != $update->locale ) ) {
			echo '<p class="hint">' . __( 'This localized version contains both the translation and various other localization fixes.', 'dashboard-summary' ) . '</p>';

		} elseif ( 'en_US' === $update->locale && 'en_US' !== get_locale() && ( ! $update->packages->partial && $wp_version == $update->partial_version ) ) {

			// Partial builds don't need language-specific warnings.
			echo '<p class="hint">' . sprintf(
				__( 'You are about to install WordPress %s <strong>in English (US).</strong> There is a chance this update will break your translation. You may prefer to wait for the localized version to be released.', 'dashboard-summary' ),
				'development' !== $update->response ? $update->current : ''
			) . '</p>';
		}

		echo '</form>';
	}

	/**
	 * Display dismissed updates
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dismissed_updates() {

		$dismissed = get_core_updates(
			[
				'dismissed' => true,
				'available' => false,
			]
		);

		if ( $dismissed ) {

			$show_text = esc_js( __( 'Show hidden updates', 'dashboard-summary' ) );
			$hide_text = esc_js( __( 'Hide hidden updates', 'dashboard-summary' ) );
			?>
		<script type="text/javascript">
			jQuery(function( $ ) {
				$( 'dismissed-updates' ).show();
				$( '#show-dismissed' ).toggle( function() { $( this ).text( '<?php echo $hide_text; ?>' ).attr( 'aria-expanded', 'true' ); }, function() { $( this ).text( '<?php echo $show_text; ?>' ).attr( 'aria-expanded', 'false' ); } );
				$( '#show-dismissed' ).click( function() { $( '#dismissed-updates' ).toggle( 'fast' ); } );
			});
		</script>
			<?php
			echo '<p class="hide-if-no-js"><button type="button" class="button" id="show-dismissed" aria-expanded="false">' . __( 'Show hidden updates', 'dashboard-summary' ) . '</button></p>';
			echo '<ul id="dismissed-updates" class="core-updates dismissed">';
			foreach ( (array) $dismissed as $update ) {
				echo '<li>';
				available_system_updates( $update );
				echo '</li>';
			}
			echo '</ul>';
		}
	}

	/**
	 * Updates data
	 *
	 * @since  1.0.0
	 * @access public
	 * @return integer Returns a number of updates.
	 */
	public function updates( $updates = '' ) {

		// Get update data.
		$data = wp_get_update_data();

		switch ( $updates ) {
			case 'plugins' :
				$output = $data['counts']['plugins'];
				break;
			case 'themes' :
				$output = $data['counts']['themes'];
				break;
			case 'count' :
				$output = $data['counts']['total'];
				break;

			case 'title' :
			default      :
				$output = $data['title'];
				break;
		}

		$output = apply_filters( 'ds_updates', $output, $updates );

		return $output;
	}

	/**
	 * Total update count
	 *
	 * @since  1.0.0
	 * @access public
	 * @return integer Returns the total number of updates available.
	 */
	public function update_total_count() {
		return $this->updates( 'total' );
	}

	/**
	 * Plugins update count
	 *
	 * @since  1.0.0
	 * @access public
	 * @return integer Returns the number of updates available.
	 */
	public function update_plugins_count() {
		return $this->updates( 'plugins' );
	}

	/**
	 * Themes update count
	 *
	 * @since  1.0.0
	 * @access public
	 * @return integer Returns the number of updates available.
	 */
	public function update_themes_count() {
		return $this->updates( 'themes' );
	}

	/**
	 * Plugins update list
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup & text of the list.
	 */
	public function update_plugins_list() {

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
				$data    = get_plugin_data( ABSPATH . 'wp-content/plugins/' . $update->plugin );
				$name    = $data['Name'];

				// Plugin details URL.
				$details = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $update->slug . '&section=changelog&TB_iframe=true&width=600&height=800' );

				// List item for each available update.
				$output .= '<li>';
				$output .= sprintf(
					__( '<strong>There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.</strong>', 'dashboard-summary' ),
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

		// No updates message.
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
	 * @access public
	 * @return string Returns the markup & text of the list.
	 */
	public function update_themes_list() {

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
				$output .= $this->update_themes_list_items( wp_get_theme( $theme ) );
			}
			$output .= '</ul>';

		// No updates message.
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
	 * with the exeption removed for multisite.
	 *
	 * @see wp-admin/includes/theme.php
	 *
	 * @since  1.0.0
	 * @access public
	 * @param WP_Theme $theme WP_Theme object.
	 * @return string|false Returns the markup for the update link or
	 *                      false if invalid info was passed.
	 */
	public function update_themes_list_items( $theme ) {

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
					'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a>.', 'dashboard-summary' ) . '</strong></li>',
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
					'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a>. <em>Automatic update is unavailable for this theme.</em>', 'dashboard-summary' ) . '</strong></li>',
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
					'<li><strong>' . __( 'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.', 'dashboard-summary' ) . '</strong></li>',
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
	 * @access public
	 * @return string Returns the markup of the avatar.
	 */
	public function user_avatar() {

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
	 * @access public
	 * @return string Returns the markup of the intro.
	 */
	public function user_intro() {

		?>
		<div class="ds-user-greeting">
			<?php $this->user_avatar(); ?>

			<div>
				<?php
				$this->user_greeting();
				$this->user_greeting_description();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * User greeting
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the text of the greeting.
	 */
	public function user_greeting() {

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
	 * @access public
	 * @return string Returns the text of the description.
	 */
	public function user_greeting_description() {

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
	 * @access public
	 * @return boolean Returns true if the user can update.
	 */
	public function updates_tab() {

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
}

/**
 * Instance of the class
 *
 * This function is used throughout the plugin files
 * to access class methods. This class is instantiated
 * in the plugin initialization file.
 *
 * @since  1.0.0
 * @access public
 * @return object Summary Returns an instance of the class.
 */
function summary() {
	return Summary :: instance();
}
