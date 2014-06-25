=== Stream Connector Example ===
Contributors:      X-team, lukecarbis
Tags:              example, connector, stream
Requires at least: 3.7
Tested up to:      3.9
Stable tag:        trunk
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a random post generator which logs Stream entries.

== Description ==

How to use this plugin

This plugin has been made to be copied and changed to suit your own needs.
To get started, copy connectors/example.php into your own plugin, then copy the register_stream_connector() function from stream-example-connector.php and hook it into your own plugin via the plugins_loaded action.

The good stuff is in connectors/example.php - once you've copied out the register_stream_connector() function, you can ignore the rest of this file.

To see this connector in action, activate it from your Plugins screen, and choose Stream Example from the admin menu

== Changelog ==

= 0.1.0 =
Initial concept built.