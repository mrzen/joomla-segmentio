# Joomla SegmentIO

This extension is for integrating your Joomla site with [Segment.IO][segment]

This extension provodides:

* Page Analytics and Tracking
* User Profiling
* App-server Tracking

## Installation:

* Install from URL or upload the [Installer][download]

* Enter your application's key in the options

## Options

* RUM (Real User Monitoring): Toggles the activation of the tracking JS
* User Tracking: Toggles weather or not actions will be tracked against logged in users
* Server Tracking: Toggles weather or not analytics can be called from the server side.


## Custom Tracking

Once set up, you can use both the [analytics.js][analyticsjs] and [PHP][analytics-php] libraries as per usual.

If you want to use [PHP][analytics-php] tracking, you'll need to import the library with:

    jimport('segmentio.analytics');

Before calling any methods on `Analytics`

[segment]: https://segment.io/
[analyticsjs]: https://segment.io/libraries/analytics.js
[analytics-php]: https://segment.io/libraries/php
[download]: http://updates.mrzen.com/segmentio/segmentio-latest.zip
