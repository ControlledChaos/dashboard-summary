<?php
/**
 * Site summary
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

class Site_Summary {

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

		// Post type query arguments.
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

		// Built-in post types.
		$builtin = [ 'post', 'page', 'attachment' ];

		// Custom post types query.
		$query = $this->custom_types_query();

		// Merge the post types.
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

		// Return taxonomies according to above.
		$query = get_taxonomies( $query, 'object', 'and' );
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

		echo '<ul class="ds-content-list ds-post-types-list">';

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

			} else {
				$menu_icon = '<icon class="dashicons dashicons-admin-post dashicons-admin-' . $type->menu_icon . '"></icon>';
			}

			// Supply an edit link if the user can edit posts.
			if ( current_user_can( $type->cap->edit_posts ) ) {
				printf(
					'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
					$type->name,
					$type->name,
					$menu_icon,
					$number,
					$name
				);

			// Otherwise just the count and post type name.
			} else {
				printf(
					'<li class="post-count %s-count">%s %s %s</li>',
					$type->name,
					$menu_icon,
					$number,
					$name
				);

			}
		}
		echo '</ul>';
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

			echo '<ul class="ds-content-list ds-taxonomies-list">';

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

				// Print a list item for the taxonomy.
				echo sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s</a></li>',
					$taxonomy->name,
					admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ),
					$count,
					$name
				);
			}

			echo '</ul>';
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

			echo '<ul class="ds-content-list ds-taxonomies-list">';

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

				// Print a list item for the taxonomy.
				echo sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s %s</a></li>',
					$taxonomy->name,
					admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ),
					$icon,
					$count,
					$name
				);
			}

			echo '</ul>';
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
		$count = count_users();
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
		$args = [
			'user_id' => get_current_user_id(),
			'count'   => true // Return only the count.
		];
		$count = get_comments( $args );

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
	 * @return string Returns a PHP version statement.
	 */
	public function php_version() {

		$output = sprintf(
			'%s <a href="%s">%s</a>',
			__( 'The web server is running', DS_DOMAIN ),
			esc_url( 'https://www.php.net/releases/index.php' ),
			'PHP ' . phpversion()
		);

		return apply_filters( 'ds_php_version_statement', $output );
	}

	/**
	 * Management system
	 *
	 * Defines the name of the management system.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a PHP version statement.
	 */
	public function management_system() {

		// Check for ClassicPress.
		if ( function_exists( 'classicpress_version' ) ) {
			$output = __( 'ClassicPress', DS_DOMAIN );
		} else {
			$output = __( 'WordPress', DS_DOMAIN );
		}

		return apply_filters( 'ds_system_name', $output );
	}

	/**
	 * System notice
	 *
	 * States the management system and version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a PHP version statement.
	 */
	public function system_notice() {

		// Get system name.
		$system = $this->management_system();

		// Check for ClassicPress.
		if ( function_exists( 'classicpress_version' ) ) {
			$output = sprintf(
				'%s <a href="%s">%s</a>',
				__( 'This website is running', DS_DOMAIN ),
				esc_url( 'https://github.com/ClassicPress/ClassicPress-release/releases' ),
				$system . ' ' . get_bloginfo( 'version', 'display' )
			);
		} else {
			$output = sprintf(
				'%s <a href="%s">%s</a>',
				__( 'This website is running', DS_DOMAIN ),
				esc_url( 'https://wordpress.org/download/releases/' ),
				$system . ' ' . get_bloginfo( 'version', 'display' )
			);
		}

		return apply_filters( 'ds_system_notice', $output );
	}

	/**
	 * Search engine statement
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed Returns a string if search engines discouraged.
	 *               Returns null if search engines not discouraged.
	 */
	public function search_engines() {

		// Check if search engines are asked not to index this site.
		if (
			! is_network_admin() &&
			! is_user_admin() &&
			current_user_can( 'manage_options' ) &&
			'0' == get_option( 'blog_public' )
		) {
			$output = sprintf(
				'<a class="ds-search-engines" href="%s">%s</a>',
				admin_url( 'options-reading.php' ),
				__( 'Search engines are discouraged', DS_DOMAIN )
			);
		} else {
			$output = null;
		}

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
		return $theme_uri;
	}

	/**
	 * Active theme statement
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the text of the active theme statement.
	 */
	public function active_theme() {

		$theme_name = wp_get_theme();
		if ( ! is_null( $this->active_theme_uri() ) && current_user_can( 'switch_themes' ) ) {
			$theme_name = sprintf(
				'%s <a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
				__( 'The active theme is', DS_DOMAIN ),
				$this->active_theme_uri(),
				$theme_name
			);
		} elseif ( current_user_can( 'switch_themes' ) ) {
			$theme_name = sprintf(
				'%s <a href="%s">%s</a>',
				__( 'The active theme is', DS_DOMAIN ),
				admin_url( 'themes.php' ),
				$theme_name
			);
		} else {
			$theme_name = sprintf(
				'%s %s',
				__( 'The active theme is', DS_DOMAIN ),
				$theme_name
			);
		}

		return apply_filters( 'ds_active_theme', $theme_name );
	}

	/**
	 * Display upgrade WordPress for downloading latest or upgrading automatically form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global string $required_php_version The required PHP version string.
	 * @global string $required_mysql_version The required MySQL version string.
	 * @return void
	 */
	public function core_updates() {

		// Access global variables.
		global $required_php_version, $required_mysql_version;

		$updates = get_core_updates();

		// Get the system version.
		require ABSPATH . WPINC . '/version.php';

		// System name.
		if ( function_exists( 'classicpress_version' ) ) {
			$system = __( 'ClassicPress', DS_DOMAIN );
		} else {
			$system = __( 'WordPress', DS_DOMAIN );
		}

		$is_development_version = preg_match( '/alpha|beta|RC/', $wp_version );

		if ( isset( $updates[0]->version ) && version_compare( $updates[0]->version, $wp_version, '>' ) ) {

			printf(
				'<p class="response">%s %s %s</p>',
				__( 'An updated version of', DS_DOMAIN ),
				$system,
				__( 'is available.', DS_DOMAIN )
			);

			printf(
				'<p><strong>%s</strong> %s</p>',
				__( 'Important:', DS_DOMAIN ),
				__( 'Before updating, please back up your database and files.', DS_DOMAIN ),
			);

		} elseif ( $is_development_version ) {
			printf(
				'<p class="response">%s %s</p>',
				__( 'You are using a development version of', DS_DOMAIN ),
				$system
			);

		} else {
			printf(
				'<p class="response">%s %s</p>',
				__( 'You have the latest version of', DS_DOMAIN ),
				$system
			);
		}

		// Don't show the maintenance mode notice when we are only showing a single re-install option.
		if ( $updates && ( count( $updates ) > 1 || 'latest' !== $updates[0]->response ) ) {

			echo '<p>' . __( 'While your site is being updated, it will be in maintenance mode. As soon as your updates are complete, this mode will be deactivated.', DS_DOMAIN ) . '</p>';

		} elseif ( ! $updates ) {

			list( $normalized_version ) = explode( '-', $wp_version );
			echo '<p>' . sprintf(
				__( '<a href="%1$s">Learn more about WordPress %2$s</a>.', DS_DOMAIN ),
				esc_url( self_admin_url( 'about.php' ) ),
				$normalized_version
			) . '</p>';
		}

		echo '<ul class="core-updates">';
		foreach ( (array) $updates as $update ) {
			echo '<li>';
			$this->list_core_update( $update );
			echo '</li>';
		}
		echo '</ul>';

		$this->dismissed_updates();
	}

	/**
	 * Lists available core updates.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global string $wp_local_package Locale code of the package.
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param  object $update
	 * @return void
	 */
	public function list_core_update( $update ) {

		// Access global variables.
		global $wp_local_package, $wpdb;
		static $first_pass = true;

		$wp_version     = get_bloginfo( 'version' );
		$version_string = sprintf( '%s&ndash;<strong>%s</strong>', $update->current, $update->locale );

		if ( 'en_US' === $update->locale && 'en_US' === get_locale() ) {
			$version_string = $update->current;

		} elseif ( 'en_US' === $update->locale && $update->packages->partial && $wp_version == $update->partial_version ) {

			$updates = get_core_updates();

			if ( $updates && 1 === count( $updates ) ) {

				// If the only available update is a partial builds, it doesn't need a language-specific version string.
				$version_string = $update->current;
			}
		}

		$current = false;
		if ( ! isset( $update->response ) || 'latest' === $update->response ) {
			$current = true;
		}

		$submit        = __( 'Update System', DS_DOMAIN );
		$form_action   = 'update-core.php?action=do-core-upgrade';
		$php_version   = phpversion();
		$mysql_version = $wpdb->db_version();
		$show_buttons  = true;

		if ( 'development' === $update->response ) {
			$message = __( 'You can update to the latest nightly build manually:', DS_DOMAIN );

		} else {

			if ( $current ) {
				$message     = sprintf( __( 'If you need to re-install version %s, you can do so here:', DS_DOMAIN ), $version_string );
				$submit      = __( 'Re-install System', DS_DOMAIN );
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

				$php_update_message = '</p><p>' . sprintf(
					__( '<a href="%s">Learn more about updating PHP</a>.' ),
					esc_url( wp_get_update_php_url() )
				);

				$annotation = wp_get_update_php_annotation();

				if ( $annotation ) {
					$php_update_message .= '</p><p><em>' . $annotation . '</em>';
				}

				if ( ! $mysql_compat && ! $php_compat ) {
					$message = sprintf(
						/* translators: 1: URL to WordPress release notes, 2: WordPress version number, 3: Minimum required PHP version number, 4: Minimum required MySQL version number, 5: Current PHP version number, 6: Current MySQL version number. */
						__( 'You cannot update because <a href="%1$s">WordPress %2$s</a> requires PHP version %3$s or higher and MySQL version %4$s or higher. You are running PHP version %5$s and MySQL version %6$s.', DS_DOMAIN ),
						$version_url,
						$update->current,
						$update->php_version,
						$update->mysql_version,
						$php_version,
						$mysql_version
					) . $php_update_message;
				} elseif ( ! $php_compat ) {
					$message = sprintf(
						/* translators: 1: URL to WordPress release notes, 2: WordPress version number, 3: Minimum required PHP version number, 4: Current PHP version number. */
						__( 'You cannot update because <a href="%1$s">WordPress %2$s</a> requires PHP version %3$s or higher. You are running version %4$s.', DS_DOMAIN ),
						$version_url,
						$update->current,
						$update->php_version,
						$php_version
					) . $php_update_message;
				} elseif ( ! $mysql_compat ) {
					$message = sprintf(
						/* translators: 1: URL to WordPress release notes, 2: WordPress version number, 3: Minimum required MySQL version number, 4: Current MySQL version number. */
						__( 'You cannot update because <a href="%1$s">WordPress %2$s</a> requires MySQL version %3$s or higher. You are running version %4$s.', DS_DOMAIN ),
						$version_url,
						$update->current,
						$update->mysql_version,
						$mysql_version
					);
				} else {
					$message = sprintf(
						/* translators: 1: Installed WordPress version number, 2: URL to WordPress release notes, 3: New WordPress version number, including locale if necessary. */
						__( 'You can update from WordPress %1$s to <a href="%2$s">WordPress %3$s</a> manually:', DS_DOMAIN ),
						$wp_version,
						$version_url,
						$version_string
					);
				}

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
				submit_button( __( 'Hide this update', DS_DOMAIN ), '', 'dismiss', false );
			} else {
				submit_button( __( 'Bring back this update', DS_DOMAIN ), '', 'undismiss', false );
			}
		}
		echo '</p>';

		if ( 'en_US' !== $update->locale && ( ! isset( $wp_local_package ) || $wp_local_package != $update->locale ) ) {
			echo '<p class="hint">' . __( 'This localized version contains both the translation and various other localization fixes.', DS_DOMAIN ) . '</p>';

		} elseif ( 'en_US' === $update->locale && 'en_US' !== get_locale() && ( ! $update->packages->partial && $wp_version == $update->partial_version ) ) {

			// Partial builds don't need language-specific warnings.
			echo '<p class="hint">' . sprintf(
				__( 'You are about to install WordPress %s <strong>in English (US).</strong> There is a chance this update will break your translation. You may prefer to wait for the localized version to be released.', DS_DOMAIN ),
				'development' !== $update->response ? $update->current : ''
			) . '</p>';
		}

		echo '</form>';
	}

	/**
	 * Display dismissed updates.
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

			$show_text = esc_js( __( 'Show hidden updates', DS_DOMAIN ) );
			$hide_text = esc_js( __( 'Hide hidden updates', DS_DOMAIN ) );
			?>
		<script type="text/javascript">
			jQuery(function( $ ) {
				$( 'dismissed-updates' ).show();
				$( '#show-dismissed' ).toggle( function() { $( this ).text( '<?php echo $hide_text; ?>' ).attr( 'aria-expanded', 'true' ); }, function() { $( this ).text( '<?php echo $show_text; ?>' ).attr( 'aria-expanded', 'false' ); } );
				$( '#show-dismissed' ).click( function() { $( '#dismissed-updates' ).toggle( 'fast' ); } );
			});
		</script>
			<?php
			echo '<p class="hide-if-no-js"><button type="button" class="button" id="show-dismissed" aria-expanded="false">' . __( 'Show hidden updates', DS_DOMAIN ) . '</button></p>';
			echo '<ul id="dismissed-updates" class="core-updates dismissed">';
			foreach ( (array) $dismissed as $update ) {
				echo '<li>';
				list_core_update( $update );
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
	 * @return string Returns the text of the notice.
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
	public function update_plugins_list( $file = '', $plugin_data = [] ) {

		// Get available plugin updates.
		$update_plugins = get_site_transient( 'update_plugins' );

		// Print the list of updates if available.
		if ( $update_plugins->response ) {

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
					__( '<strong>There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.</strong>', DS_DOMAIN ),
					$name,
					esc_url( $details ),
					sprintf(
						'class="thickbox open-plugin-details-modal" aria-label="%s"',
						esc_attr( sprintf(
							__( 'View %1$s version %2$s details', DS_DOMAIN ),
							$name,
							$update->new_version
						) )
					),
					esc_attr( $update->new_version ),
					wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $update->plugin, 'upgrade-plugin_' . $update->plugin ),
					sprintf(
						'class="update-link" aria-label="%s"',
						esc_attr( sprintf( __( 'Update %s now', DS_DOMAIN ), $name ) )
					)
				);
				$output .= '</li>';
			}
			$output .= '</ul>';

		// No updates message.
		} else {
			$output = sprintf(
				'<p>%s</p>',
				__( 'There are no plugin updates available.', DS_DOMAIN )
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

		// Print the list of updates if available.
		if ( $update_themes->response ) {

			$output = '<ul>';
			foreach ( $update_themes->response as $update ) {

				$theme = $update['theme'];
				$output .= get_theme_update_available( wp_get_theme( $theme ) );
			}
			$output .= '</ul>';

		// No updates message.
		} else {
			$output = sprintf(
				'<p>%s</p>',
				__( 'There are no theme updates available.', DS_DOMAIN )
			);
		}

		return $output;
	}
}

/**
 * Instance of the class
 *
 * @since  1.0.0
 * @access public
 * @return object Site_Summary Returns an instance of the class.
 */
function summary() {
	return Site_Summary :: instance();
}
