# Dashboard Summary

![Minimum PHP version 7.4](https://img.shields.io/badge/PHP_minimum-7.4-8892bf.svg?style=flat-square)
![WordPress tested on version 6.2.2](https://img.shields.io/badge/WordPress_tested-6.2.2-2271b1.svg?style=flat-square)
![ClassicPress tested on version 2.0.0](https://img.shields.io/badge/ClassicPress_tested-2.0.0-03768e.svg?style=flat-square)
![ACF Ready](https://img.shields.io/badge/ACF-Ready-00d3ae.svg?style=flat-square)

Improves the At a Glance dashboard widget and offers replacement widgets with more detailed website and network information. Integrates seamlessly into the native administration design. Compatible with multisite installations and with ClassicPress.

![Dashboard Summary Plugin Cover Image](https://github.com/ControlledChaos/dashboard-summary/raw/main/assets/images/cover.jpg)

## Website Summary Widget

The Website Summary dashboard widget by default replaces the native At a Glance dashboard widget, however both widgets can be displayed. The content of the widget is organized as follows by a responsive tabbed/accordion interface.

### Website Summary Account Tab

The user account tab, or profile tab, is displayed to all registered users. It provides details of the current user, including the following.

#### Account Information

* Username.
* Display name.
* User avatar.
* User roles.
* Bio/description displayed in a modal window.

#### Account Options

* Email & website.
* Admin color scheme.
* Toolbar showing on the front end.

### Website Summary Content Tab

The content tab provides a more comprehensive overview of website content than the native At a Glance widget. Display varies by user capabilities.

* Posts & pages counts with manage links.
* Media (attachment post type) count with manage link.
* Custom post type counts with manage links & the associated menu icons.
* Category & tag counts with manage links.
* Custom taxonomy counts with manage links.

Content tools are available by user capability.

* Content search, same as frontend search, is displayed to all users.
* Media search is displayed to users who can manage the media library.
* Import & export links are displayed to users who can conduct these operations.

### Website Summary Users Tab

The users tab provides an overview of registered users and user discussion. Display varies by user capabilities.

#### User Discussion

* Comment counts of the various statuses with manage links.
* Comment count by current user with manage link.

#### Registered Users

* Registered users count with manage links.
* User search form.

#### User tools

* Link to manage users.
* Link to add a new user.

### Website Summary Updates Tab

The updates tab lists available updates with applicable links. All update links only enact one update at a time. For bulk updates a link to the Updates page is provided.

#### Website Summary System Updates

The system updates section provides update information regarding the management system (WordPress or ClassicPress).

#### Website Summary Plugin Updates

The plugin updates section lists available plugin updates with modal content links to plugin changelog and other details, similar to the details view on the Plugins page.

#### Website Summary Theme Updates

The theme updates section lists available theme updates with modal content links to theme details, similar to the details view on the Themes page.

#### Update Tools

* Link to the updates page.

### Advanced Custom Fields Tab

Tab included if the Advanced Custom Fields plugin is active. Additional content if the Advanced Custom Fields: Extended plugin is active.

#### ACF Content

* List of content counts with links to manage:
  * Field groups
  * Post types
  * Taxonomies
* Button links to manage ACF content.

#### ACFE Content

* List of content counts with links to manage:
  * Post types
  * Taxonomies
  * Forms
  * Options pages
  * Block types
  * Templates (ACFE Pro)
  * Fields categories
* Button links to manage ACFE content.

### Website Summary System Tab

The system tab provides technical details about the website, some action links, and development reference.

#### System Information

* PHP version running on the server.
* Database version running on the server.
* Management system (WordPress or ClassicPress) and the current version.
* Count of installed themes.
* The active theme and link to the theme URL.

#### System Tools

* Link to the Site Health page, if WordPress & applicable.
* Link to the Security page, if ClassicPress.
* Link to the options (All Settings) page.

#### Widget Development

This plugin provides an internal reference of hooks and filters available for adding content and changing text. This reference displays in a modal window linked from the widget development section, and is only available to administrators and other users with the manage_options capability.

### User Roles for the Website Summary Widget

There are no settings to display the Website Summary widget by user role however the content of the widget is regulated by current user capabilities.

## At a Glance Widget

The native At a Glance widget is improved by this plugin. Display varies by user capabilities.

* Posts & pages counts with manage links.
* Media (attachment post type) count with manage link.
* Custom post type counts with manage links & the associated menu icons.
* Category & tag counts with manage links.
* Custom taxonomy counts with manage links.
* Registered users count with manage link.
* PHP version running on the server.
* Database version running on the server.
* Management system (WordPress or ClassicPress) and the current version.
* Count of installed themes with link to the Themes page.
* The active theme and link to the theme URL.

A setting provides the ability to remove the At a Glance widget for all users, including the entry in the Screen Options section.

## Network Summary Widget

The Network Summary dashboard widget is displayed only on the network dashboard of multisite installations. By default it replaces the native Right Now dashboard widget, however both widgets can be displayed. The content of the widget is organized as follows by a responsive tabbed/accordion interface.

### Network Shared Tabs

The Network Summary widget shares three tabs in common with the Website Summary widget.

* The account tab is included as described here in the [Website Summary Account Tab](#website-summary-account-tab) section.
* The updates tab is included as described here in the [Website Summary Updates Tab](#website-summary-updates-tab) section, with the addition of a link to the Upgrade Network page.
* The system tab is included as described here in the [Website Summary System Tab](#website-summary-system-tab) section, with the addition of a link to the Network Settings page.

### Network Summary Sites Tab

The sites tab provides an overview of websites in the multisite network.

#### Network Sites

* Count of websites in the network with manage link.
* Site search form.

#### Network Tools

* Link to manage sites.
* Link to add a new site.

### Network Summary Users Tab

The users tab provides an overview of users in the multisite network.

#### Network Users

* Count of users in the network with manage link.
* User search form.

#### Users Tools

* Link to manage users.
* Link to add a new user.

### User Roles for the Network Summary Widget

There are no settings to display the Network Summary widget by user role since the network dashboard, by default, is restricted to one user role. It is presumed that custom user roles with access to the network dashboard also have the capabilities to employ all of the content of this widget.

## Right Now Widget

This plugin adds system information to the Right Now widget.

* PHP version running on the server.
* Database version running on the server.
* Management system (WordPress or ClassicPress) and the current version.
* Count of network-enabled themes with link to the network Themes page.
* The active theme of the primary site and link to the theme URL.

A setting provides the ability to remove the Right Now widget for all users, including the entry in the Screen Options section.

## Design

The two widgets provided by this plugin, the Website Summary and the Network Summary, integrate seamlessly into the native administration design, as with modifications to the At a Glance and \[network\] Right Now widgets. No branding or special colors. No links or upsells. It's your dashboard, not ours.

### Admin Color Schemes

There are a few features of the widgets which require custom styles to fully integrate with the dashboard. In some instances these features could conflict with the admin color scheme set in user preferences or by custom admin themes. Every effort has been made, however, to accommodate admin schemes other than the default scheme.

For instance, the update count bubbles that appear in the admin menu and in the user toolbar vary in color by user preference. The update bubbles that appear in the Updates tab of the summary widgets match the bubbles of the current user scheme.

Widget styles also integrate with use of the [Admin Color Schemes](https://wordpress.org/plugins/admin-color-schemes/) plugin. Filters have been applied for developers to add their own styles for custom admin themes.

## Requirements & Tests

Requires PHP version 5.4 or higher to activate, version 7.4 or higher to be functional.
Requires WordPress version 3.8 or higher, or any version of ClassicPress.

Tested up to WordPress version 5.7, standard and multisite installations.
Tested up to ClassicPress version 1.2.0, standard and multisite installations.

## Settings

Settings to use the Website Summary widget and to use the At a Glance widget are located on the General Settings screen, whether a standard, single-site installation or a multisite installation. Settings to use the Network Summary widget and to use the Right Now widget are located on the Network Settings screen of multisite installations.

## Development

This plugin provides an internal reference of hooks and filters available for adding content and changing text. This reference displays in a modal window linked from the widget development section of the system tab, and is only available to administrators and other users with the manage_options capability.

## Credits

* Cover image by Dawid Zawiła [on Unsplash](https://unsplash.com/@davealmine).
