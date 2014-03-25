<?php

/**
 * Constants for SegmentIO integration
 *
 * Contains useful constants such as tracking scripts
 *
 * @verison 3.2
 */

class SegmentIO {

    /**
     * @const Event Tracking JS
     */
    const TRACK_EVENT = <<<EOF
    <script type="text/javascript">analytics.track('{{EVENT}}', {{DATA}});</script>
    EOF;




}
