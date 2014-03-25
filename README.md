# Joomla SegmentIO

This extension is for integrating your Joomla site with [Segment.IO][segment]

This extension provodides:

* Page Analytics and Tracking
* User Profiling
* App-server Tracking

## Installation:

* Install from URL or upload the [Installer][download]
* Enter your application's key in the options
* Enable all the options (usually)

## Options

* RUM (Real User Monitoring): Toggles the activation of the tracking JS
* User Tracking: Toggles weather or not actions will be tracked against logged in users
  Requres RUM to be enabled
* Server Tracking: Toggles weather or not analytics can be called from the server side.

## Plugins

### Segment.IO System
Main system plugin that sets up your analytics -- Must be enabled for any others to work

Defines the following constants based on its parameters:

* `SEGMENTIO_APP` If Application Tracking is enabled
* `SEGMENTIO_RUM` If RUM is enabled
* `SEGMENTIO_USER` If user tracking is enabled

### Segment.IO Content
Content plugin to track content viewing
Sends information about articles being viewed using RUM.

_Reuquires RUM to be enalbed_

### Segment.IO User (_Unfinished_)
Plugin to track user events, such as login and logout.

_Requires RUM and User Monitoring to be enabled_


## Custom Tracking

Once set up, you can use both the [analytics.js][analyticsjs] and [PHP][analytics-php] libraries as per usual.

If you want to use [PHP][analytics-php] tracking, you'll need to import the library with:

    jimport('segmentio.analytics');

Before calling any methods on `Analytics`.
It is recommended that you wrap your tracking code in a plugin, and check for the constants defined by the system plugin.

[segment]: https://segment.io/
[analyticsjs]: https://segment.io/libraries/analytics.js
[analytics-php]: https://segment.io/libraries/php
[download]: http://updates.mrzen.com/segmentio/segmentio-latest.zip
