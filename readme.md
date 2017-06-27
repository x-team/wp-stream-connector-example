# Stream Connector - Example

This plugin adds a random post generator which logs Stream entries.

**Contributors:** [x-team](http://profiles.wordpress.org/x-team), [lukecarbis](http://profiles.wordpress.org/lukecarbis)  
**Tags:** [stream](http://wordpress.org/plugins/tags/stream), [connector](http://wordpress.org/plugins/tags/connector)
**Requires at least:** 3.7  
**Tested up to:** 3.9  
**Stable tag:** trunk (master)  
**License:** [GPLv2 or later](http://www.gnu.org/licenses/gpl-2.0.html)  

## Description ##

To get started, copy connectors/example.php into your own plugin, then copy the register_stream_connector() function from stream-example-connector.php and hook it into your own plugin via the plugins_loaded action.

The good stuff is in connectors/example.php - once you've copied out the register_stream_connector() function, you can ignore the rest of this file.

To see this connector in action, activate it from your Plugins screen, and choose Stream Example from the admin menu

## Changelog ##

### 1.0 - April 24, 2014 ###
Initial build.

Maintained by the [developers at x-team](https://www.x-team.com) | [developer blog](https://www.x-team.com/blog/)
