# Dashboard Summary

![Minimum PHP version 7.4](https://img.shields.io/badge/PHP_minimum-7.4-8892bf.svg?style=flat-square)
![WordPress tested on version 5.7](https://img.shields.io/badge/WordPress_tested-5.7-2271b1.svg?style=flat-square)
![ClassicPress tested on version 1.2.0](https://img.shields.io/badge/ClassicPress_tested-1.2.0-03768e.svg?style=flat-square)

Improves the At a Glance dashboard widget and offers replacement widgets with more detailed website and network information. Integrates seamlessly into the native administration design. Compatible with multisite installations and with ClassicPress.

![Dashboard Summary Plugin Cover Image](https://github.com/ControlledChaos/dashboard-summary/raw/main/assets/images/cover.jpg)

## Website Summary Widget

The Website Summary dashboard widget by default replaces the native At a Glance dashboard widget, however both widgets can be displayed. The content of the widget is organized as follows by a responsive tabbed/accordion interface.

### Account Tab

The user account tab, or profile tab, is displayed to all registered users. It provides details of the current user, including the following.

* User Name
* Display Name
* Avatar
* User Roles
* Bio/Description
* Email & Website
* Interface Options

### Content Tab

The content tab provides a more comprehensive overview of website content than the native At a Glance widget. Display varies by user capabilities.

* Posts & pages counts with edit links.
* Media (attachment post type) counts with edit links.
* Custom post type counts with edit links & the associated menu icons.
* Category & tag counts with edit links.
* Custom taxonomy counts with edit links.

Content tools are available by user capability.

* Content search, same as frontend search, is displayed to all users.
* Media search is displayed to users who can manage the media library.
* Import & export links are displayed to users who can conduct these operations.

### Users Tab

The users tab provides an overview of registered users and user discussion.

#### User Discussion

Content coming.

#### Registered Users

Content coming.

### System Tab

Content coming.

### User Roles for the Website Summary Widget

There are no settings to display the Website Summary widget by user role however the content of the widget is regulated by current user capabilities.

## At a Glance Widget

The native At a Glance widget is improved by this plugin.

A setting provides the ability to remove the At a Glance widget for all users, including the entry in the Screen Options section.

## Network Summary Widget

The Network Summary dashboard widget by default replaces the native Right Now dashboard widget, however both widgets can be displayed.

### User Roles for the Network Summary Widget

There are no settings to display the Network Summary widget by user role since the network dashboard, by default, is restricted to one user role. It is presumed that custom user roles with access to the network dashboard also have the cababilities to employ all of the content of this widget.

## Right Now Widget

This plugin does not modify the Right Now widget. A setting provides the ability to remove the Right Now widget for all users, including the entry in the Screen Options section.

## Design

The two widgets provided by this plugin, the Website Summay and the Network Summary, integrate seamlessly into the native administration design, as with modifications to the At a Glance and \[network\] Right Now widgets. No branding or special colors. No links or upsells. It's your dashboard, not ours.

### Admin Color Schemes

There are a few features of the widgets which require custom styles to fully integrate with the dashboard. In some instances these features could conflict with the admin color scheme set in user preferences or by custom admin themes. Every effort has been made, however, to accomodate admin schemes other than the default scheme.

For instance, the update count bubbles that appear in the admin menu and in the user toolbar vary in color by user preference. The update bubbles that appear in the Updates tab of the summary widgets match the bubbles of the current user scheme.

Widget styles also integrate with use of the [Admin Color Schemes](https://wordpress.org/plugins/admin-color-schemes/) plugin. Filters have been applied for developers to add their own styles for custom admin themes.

## Requirements & Tests

Requires PHP version 7.4 or higher.
Requires WordPress version 3.8 or higher, or any version of ClassicPress.

Tested up to WordPress version 5.7, standard and multisite installations.
Tested up to ClassicPress version 1.2.0, standard and multisite installations.

## Settings

Settings to use the Website Summary widget and to use the At a Glance widget are located on the General Settings screen, whether a standard, single-site installation or a multisite installation. Settings to use the Network Summary widget and to use the Right Now widget are located on the Network Settings screen of multisite installations.

## Credits

Cover image by Dawid Zawiła [on Unsplash](https://unsplash.com/@davealmine).
