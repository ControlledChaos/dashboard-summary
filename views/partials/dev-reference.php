<?php
/**
 * Plugin development reference
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

?>
<h4><?php _e( 'Development Hooks & Filters', DS_DOMAIN ); ?></h4>
<p class="description"><?php _e( 'This code reference is provided by the Dashboard Summary plugin for adding content or modifying text.', DS_DOMAIN ); ?></p>

<div class="ds-tabbed-content">

	<ul class="ds-tabs-nav">
		<li class="ds-tabs-state-active"><a href="#dev-reference-hooks"><?php _e( 'Hooks', DS_DOMAIN ); ?></a></li>
		<li><a href="#dev-reference-filters"><?php _e( 'Filters', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="dev-reference-hooks" class="ds-tabs-state-active">

		<h4><?php _e( 'Development Hooks', DS_DOMAIN ); ?></h4>

		<p class="description"><?php _e( 'Following is a list of hooks that can be used to add content to the various widget tabs.', DS_DOMAIN ); ?></p>

		<ul class="dev-reference-list">

			<li>
				<p><code>ds_profile_tab</code><br />
				<?php _e( 'Fires at the end of the profile tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_system_tab</code><br />
				<?php _e( 'Fires at the end of the system tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_updates_tab</code><br />
				<?php _e( 'Fires at the end of the updates tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tab</code><br />
				<?php _e( 'Fires at the end of the site content tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tab</code><br />
				<?php _e( 'Fires at the end of the site users tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tab</code><br />
				<?php _e( 'Fires at the end of the network sites tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tab</code><br />
				<?php _e( 'Fires at the end of the network users tab.', DS_DOMAIN ); ?></p>
			</li>
		</ul>
	</section>

	<section id="dev-reference-filters">

		<h4><?php _e( 'Development Filters', DS_DOMAIN ); ?></h4>

		<p class="description"><?php _e( 'Following is a list of filters that can be used to change text in the various widget tabs.', DS_DOMAIN ); ?></p>

		<p class="description"><?php _e( '<strong>Note:</strong> Many of these also filter the markup as well as the text inside the element so carefully read the filter description.', DS_DOMAIN ); ?></p>

		<h5><?php _e( 'Widget Titles', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_title</code><br />
				<?php _e( 'Filters the text of the site dashboard widget title.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_title</code><br />
				<?php _e( 'Filters the text of the network dashboard widget title.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Colors', DS_DOMAIN ); ?></h5>
		<p class="description"><?php _e( 'See includes/classes/class-user-colors.php.', DS_DOMAIN ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_user_colors</code><br />
				<?php _e( 'Filters an array of color scheme CSS hex codes.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_user_notify_colors</code><br />
				<?php _e( 'Filters an array of color scheme notification CSS hex codes.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Summary Content Methods', DS_DOMAIN ); ?></h5>
		<p class="description"><?php _e( 'See includes/classes/class-site-summary.php.', DS_DOMAIN ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_custom_types_query</code><br />
				<?php _e( 'Filters the query array of custom post types used in the site widget content tab and in the At a Glance widget.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_public_post_types</code><br />
				<?php _e( 'Filters an array of merged built-in post types and custom post types used in the site widget content tab and in the At a Glance widget.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_taxonomies_query</code><br />
				<?php _e( 'Filters an array of queried taxonomies used in the site widget content tab and in the At a Glance widget.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_php_version_notice</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the PHP version notice.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_system_name</code><br />
				<?php _e( 'Filters the name of the content/website management system.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_system_notice</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the content/website management system notice.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_search_engines</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the search engines notice, if discouraged.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_active_theme</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the active theme.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_updates</code><br />
				<?php _e( 'Filters a number of updates.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_user_greeting</code><br />
				<?php _e( 'Filters the <code>&lt;h4&gt;</code> markup & text of the user greeting in the profile tab.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_user_greeting_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the user greeting description in the profile tab.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Profile Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_profile_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the profile tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_account_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h4&gt;</code> markup & text of the profile tab account section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_account_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab account section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_options_heading</code><br />
				<?php _e( 'Filters the text of the profile tab options section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_options_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab options section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_tools_heading</code><br />
				<?php _e( 'Filters the text of the profile tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'System Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_system_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the system tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_info_heading</code><br />
				<?php _e( 'Filters the text of the system tab information section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_info_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab information section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_tools_heading</code><br />
				<?php _e( 'Filters the text of the system tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Updates Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_updates_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the updates tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the updates tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_tools_heading</code><br />
				<?php _e( 'Filters the text of the updates tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_tools_description</code><br />
				<?php _e( 'Filters the text of the updates tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Site Content Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_content_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the site content tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_types_heading</code><br />
				<?php _e( 'Filters the text of the site content tab post types section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_types_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab post types section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_taxes_heading</code><br />
				<?php _e( 'Filters the text of the site content tab taxonomies section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_taxes_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab taxonomies section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tools_heading</code><br />
				<?php _e( 'Filters the text of the site content tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Site Users Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_users_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the site users tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_comments_heading</code><br />
				<?php _e( 'Filters the text of the site users tab comments section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_comments_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab comments section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_registered_heading</code><br />
				<?php _e( 'Filters the text of the site users tab registered users section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_registered_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab registered users section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tools_heading</code><br />
				<?php _e( 'Filters the text of the site users tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Network Sites Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_network_widget_sites_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the network sites tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_sites_heading</code><br />
				<?php _e( 'Filters the text of the network sites tab manage section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_sites_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab manage section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tools_heading</code><br />
				<?php _e( 'Filters the text of the network sites tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab tools section description.', DS_DOMAIN ); ?></p>
			</li>

		</ul>

		<h5><?php _e( 'Network Users Tab', DS_DOMAIN ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_network_widget_users_heading</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the network users tab heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_users_heading</code><br />
				<?php _e( 'Filters the text of the network users tab manage section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_users_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab manage section description.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tools_heading</code><br />
				<?php _e( 'Filters the text of the network users tab tools section heading.', DS_DOMAIN ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tools_description</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab tools section description.', DS_DOMAIN ); ?></p>
			</li>
		</ul>
	</section>
</div>