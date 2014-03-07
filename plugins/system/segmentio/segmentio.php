<?php

/**
 * Segment.IO Integration for Joomla
 *
 * @package MrZen\Integraiton\Tracking
 * @license GNU GPL v3
 * @since 3.2
 */


jimport('joomla.plugin.plugin');
jimport('segmentio.analytics');

/**
 * Segment.IO Integration Plugin for Joomla
 *
 * @package MrZen\Integration\Tracking
 */
class plgSystemSegmentIO extends JPlugin {

    /**
     * @const Tracking JS
     */
    const TRACKING_SCRIPT = <<<EOF

window.analytics||(window.analytics=[]),window.analytics.methods=["identify","track","trackLink","trackForm","trackClick","trackSubmit","page","pageview","ab","alias","ready","group","on","once","off"],window.analytics.factory=function(t){return function(){var a=Array.prototype.slice.call(arguments);return a.unshift(t),window.analytics.push(a),window.analytics}};for(var i=0;window.analytics.methods.length>i;i++){var method=window.analytics.methods[i];window.analytics[method]=window.analytics.factory(method)}window.analytics.load=function(t){var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=("https:"===document.location.protocol?"https://":"http://")+"d2dq2ahtl5zl1z.cloudfront.net/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(a,n)},window.analytics.SNIPPET_VERSION="2.0.8",
window.analytics.load("{{ANALYTICS_KEY}}");
window.analytics.page();

EOF;


    /**
     * @const Identification JS
     */
    const IDENTIFY_SCRIPT = <<<EOF
analytics.identify("{{ANALYTICS_KEY}}", {{DATA}});
EOF;
    
    /**
     * Set up server-side tracking
     *
     * @since 3.2
     */
    public function onAfterInitialise() {
        
        /* Check Server-size tracking is enabled */
        if($this->params->get('enable_apptrack','0') === '1' && $this->haveAnalyticsKey()) {
            $analytics_key = $this->params->get('analytics_key');

            Analytics::init($analytics_key, array(

                "debug" => JDEBUG,
                "ssl" => true,

                "on_error" => function($code, $message) {
                    error_log("Segment.IO Error [$code]: $message");
                },
            
            ));

        }

        define('SEGMENTIO', true);

        return;
    }

    /**
     * Add tracking script
     *
     * Adds the tracking script to the document <head>
     * If RUM (Real User Monitoring) is enabled
     *
     *
     * @since 3.2
     */
    public function onBeforeRender() {

        /* Check RUM is enabled. */
        if($this->params->get('enable_rum','0') === '1' && $this->haveAnalyticsKey()) {
            $analytics_key = $this->params->get('analytics_key');
            $document =& JFactory::getDocument();
            $tracking_code = str_replace("{{ANALYTICS_KEY}}", $analytics_key, self::TRACKING_SCRIPT);

            $document->addScriptDeclaration($tracking_code);


            /* Check if User monitoring is enabled */
            if($this->params->get('enable_usertrack','0') === '1') {
                $user = JFactory::getUser();

                /* Check the user is not a guest */
                if(!$user->guest) {

                    /* Attach the tracking to the user */
                    $user_data = array(
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => $user->email
                    );

                    /* Do the RUM */
                    $ident_code = str_replace("{{ANALYTICS_KEY}}" , $analytics_key, self::IDENTIFY_SCRIPT);
                    $ident_code = str_replace("{{DATA}}" , json_encode($user_data), $ident_code);
                    $document->addScriptDeclaration($ident_code);

                    /* App-tracking */
                    if($this->params->get('enable_apptrack','0'))
                        Analytics::identify($analytics_key, $user_data);

                }
            }
        }

        return;
    }


    /**
     * Check we have an analytics key
     *
     * @return bool Have an analytics key
     */
    private function haveAnalyticsKey() {
        return strlen($this->params->get('analytics_key','')) > 0;
    }

}


