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
<h4><?php _e( 'Development Hooks & Filters', 'dashboard-summary' ); ?></h4>
<p class="description"><?php _e( 'This code reference is provided by the Dashboard Summary plugin for adding content or modifying text.', 'dashboard-summary' ); ?></p>

<div class="ds-tabbed-content">

	<ul class="ds-tabs-nav">
		<li class="ds-tabs-state-active"><a href="#dev-reference-hooks"><?php _e( 'Hooks', 'dashboard-summary' ); ?></a></li>
		<li><a href="#dev-reference-filters"><?php _e( 'Filters', 'dashboard-summary' ); ?></a></li>
	</ul>

	<section id="dev-reference-hooks" class="ds-tabs-state-active">

		<h4><?php _e( 'Development Hooks', 'dashboard-summary' ); ?></h4>

		<p class="description"><?php _e( 'Following is a list of hooks that can be used to add content to the various widget tabs.', 'dashboard-summary' ); ?></p>

		<ul class="dev-reference-list">

			<li>
				<p><code>ds_profile_tab</code><br />
				<?php _e( 'Fires at the end of the profile tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_system_tab</code><br />
				<?php _e( 'Fires at the end of the system tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_updates_tab</code><br />
				<?php _e( 'Fires at the end of the updates tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tab</code><br />
				<?php _e( 'Fires at the end of the site content tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tab</code><br />
				<?php _e( 'Fires at the end of the site users tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tab</code><br />
				<?php _e( 'Fires at the end of the network sites tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tab</code><br />
				<?php _e( 'Fires at the end of the network users tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_glance_items_one</code><br />
				<?php _e( 'Fires at the beginning of the custom At a Glance items list.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_glance_items_two</code><br />
				<?php _e( 'Fires in the custom At a Glance items list between post types and taxonomies.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_glance_items_three</code><br />
				<?php _e( 'Fires in the custom At a Glance items list between taxonomies and users.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_glance_items_four</code><br />
				<?php _e( 'Fires at the end of the custom At a Glance items list.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>
	</section>

	<section id="dev-reference-filters">

		<h4><?php _e( 'Development Filters', 'dashboard-summary' ); ?></h4>

		<p class="description"><?php _e( 'Following is a list of filters that can be used to change text in the various widget tabs.', 'dashboard-summary' ); ?></p>

		<p class="description"><?php _e( '<strong>Note:</strong> Many of these also filter the markup as well as the text inside the element so carefully read the filter description.', 'dashboard-summary' ); ?></p>

		<h5><?php _e( 'Widget Titles', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_title</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site dashboard widget title.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_title</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the network dashboard widget title.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Script Blocks', 'dashboard-summary' ); ?></h5>
		<p class="description"><?php _e( 'Script block methods include the <code>&lt;script&gt;</code> element tags so include these when replacing JavaScript.', 'dashboard-summary' ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_dashboard_print_scripts</code> | <code>string</code><br />
				<?php _e( 'Filters the general dashboard script block, including modal content and colors for base64 icons.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Style Blocks', 'dashboard-summary' ); ?></h5>
		<p class="description"><?php _e( 'Style block methods include the <code>&lt;style&gt;</code> element tags so include these when replacing CSS.', 'dashboard-summary' ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_dashboard_print_styles</code> | <code>string</code><br />
				<?php _e( 'Filters the general dashboard style block.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_website_print_styles</code> | <code>string</code><br />
				<?php _e( 'Filters the Website Summary style block.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_website_default_print_styles</code> | <code>string</code><br />
				<?php _e( 'Filters the At a Glance style block.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_print_styles</code> | <code>string</code><br />
				<?php _e( 'Filters the Network Summary style block.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_default_print_styles</code> | <code>string</code><br />
				<?php _e( 'Filters the Right Now style block.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Colors', 'dashboard-summary' ); ?></h5>
		<p class="description"><?php _e( 'See includes/users/user-colors.php.', 'dashboard-summary' ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_user_colors</code> | <code>array</code><br />
				<?php _e( 'Filters an array of color scheme CSS hex codes.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_user_notify_colors</code> | <code>array</code><br />
				<?php _e( 'Filters an array of color scheme notification CSS hex codes.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Summary Content Methods', 'dashboard-summary' ); ?></h5>
		<p class="description"><?php _e( 'See includes/core/core.php.', 'dashboard-summary' ); ?></p>

		<ul class="dev-reference-list">
			<li>
				<p><code>ds_custom_types_query</code> | <code>array</code><br />
				<?php _e( 'Filters the query array of custom post types used in the site widget content tab and in the At a Glance widget.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_public_post_types</code> | <code>array</code><br />
				<?php _e( 'Filters an array of merged built-in post types and custom post types used in the site widget content tab and in the At a Glance widget.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_taxonomies_query</code> | <code>array</code><br />
				<?php _e( 'Filters an array of queried taxonomies used in the site widget content tab and in the At a Glance widget.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_php_version_notice</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the PHP version notice.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_database_reference</code> | <code>string</code><br />
				<?php _e( 'Filters the URL of the database reference.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_database_version_notice</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the database version notice.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_system</code> | <code>string</code><br />
				<?php _e( 'Filters the code name of the content/website management system (e.g. wordpress).', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_system_name</code> | <code>string</code><br />
				<?php _e( 'Filters the display name of the content/website management system (e.g. WordPress).', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_system_notice</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the content/website management system notice.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_search_engines</code | <code>string</code>br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the search engines notice, if discouraged.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_active_theme</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;a&gt;</code> markup & text of the active theme.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_updates</code> | <code>integer</code><br />
				<?php _e( 'Filters a number of updates.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_user_greeting</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h4&gt;</code> markup & text of the user greeting in the profile tab.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_user_greeting_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the user greeting description in the profile tab.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Profile Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_profile_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the profile tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_account_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h4&gt;</code> markup & text of the profile tab account section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_account_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab account section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_options_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the profile tab options section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_user_options_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab options section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the profile tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_profile_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the profile tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'System Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_system_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the system tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_info_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the system tab information section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_info_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab information section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the system tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_system_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the system tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_show_health_link</code> | <code>boolean</code><br />
				<?php _e( 'Filters whether to display the button-style link to the Site Health page.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_health_link</code> | <code>string</code><br />
				<?php _e( 'Filters the button-style link to the Site Health page.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_security_access</code> | <code>string</code><br />
				<?php _e( 'Filters the button-style link to the Security page. Use __return_false to remove the link.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Updates Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_widget_updates_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the updates tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the updates tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the updates tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_widget_updates_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the updates tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_update_php_url</code> | <code>string</code><br />
				<?php _e( 'Filters the URL of information on updating a server&#39;s PHP version.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Site Content Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_content_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the site content tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_types_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site content tab post types section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_types_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab post types section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_taxes_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site content tab taxonomies section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_taxes_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab taxonomies section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site content tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_content_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site content tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_display_posts</code> | <code>boolean</code><br />
				<?php _e( 'Filters whether to display the count of default post type.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Site Users Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_site_widget_users_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the site users tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_comments_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site users tab comments section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_comments_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab comments section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_registered_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site users tab registered users section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_registered_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab registered users section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the site users tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_users_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the site users tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Network Sites Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_network_widget_sites_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the network sites tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_sites_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the network sites tab manage section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_sites_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab manage section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the network sites tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_sites_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network sites tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>

		</ul>

		<h5><?php _e( 'Network Users Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_network_widget_users_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;h3&gt;</code> markup & text of the network users tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_users_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the network users tab manage section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_site_widget_manage_users_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab manage section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tools_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the network users tab tools section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_network_widget_users_tools_description</code> | <code>string</code><br />
				<?php _e( 'Filters the <code>&lt;p&gt;</code> markup & text of the network users tab tools section description.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>

		<h5><?php _e( 'Advanced Custom Fields Tab', 'dashboard-summary' ); ?></h5>
		<ul class="dev-reference-list">
			<li>
				<p><code>ds_acf_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF tab heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_description</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF tab description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_display_types_taxes_links</code> | <code>boolean</code><br />
				<?php _e( 'Filters wether to display the button-style links to ACF post types and taxonomies.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acfe_display_types_taxes_links</code> | <code>boolean</code><br />
				<?php _e( 'Filters wether to display the button-style links to ACF: Extended post types and taxonomies.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_types_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF content types section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_types_description</code> | <code>string</code><br />
				<?php _e( 'Filters the conditional text of the ACF content types section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acfe_list_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF: Extended section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acfe_list_description</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF: Extended fields section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acfe_types_description</code> | <code>string</code><br />
				<?php _e( 'Filters the conditional text of the ACF content types section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_fields_heading</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF fields section heading.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_fields_description</code> | <code>string</code><br />
				<?php _e( 'Filters the text of the ACF fields section description.', 'dashboard-summary' ); ?></p>
			</li>
			<li>
				<p><code>ds_acf_link_tools</code> | <code>string</code><br />
				<?php _e( 'Filters the admin URL of the ACF tools screen.', 'dashboard-summary' ); ?></p>
			</li>
		</ul>
	</section>
</div>
