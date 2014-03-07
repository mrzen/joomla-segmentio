<?php

/**
 * Plugin to track user actions 
 *
 * @version 3.2
 * @author Mr.Zen Ltd.
 * @license GNU GPL v3
 */

jimport('joomla.plugin.plugin');
jimport('segmentio.analytics');


/**
 * Track user actions to Segment.IO
 */
class plgUserSegmentIO extends JPlugin {

    /**
     * @const Event Tracking Code
     */
    const TRACK_EVENT = <<<EOF
analytics.track('{{EVENT}}','{{DATA}}')
EOF;

    /**
     * @const User login event name
     */
    const USER_LOGIN_EVENT = 'User Login';

    /**
     * @const User login failure event name
     */
    const USER_LOGIN_FAILURE_EVENT = 'User Login Failure';

    /**
     * @const User logout event
     */
    const USER_LOGOUT_EVENT = 'User Logout';

    /**
     * @const User save event
     */
    const USER_SAVE_EVENT = 'User Save';
    
    /**
     * Track a login event
     */
    public function onUserLogin() {
        $this->trackEvent(self::USER_LOGIN_EVENT);
    }


    /**
     * Track a login failure event
     */
    public function onUserLoginFailure() {
        $this->trackEvent(self::USER_LOGIN_FAILURE_EVENT);
    }

    /**
     * Track a  user logout event
     */
    public function onUserLogout() {
        $this->trackEvent(self::USER_LOGOUT_EVENT);
    }

    /**
     * Track a user save event
     */
    public function onUserAfterSave() {
        $this->trackEvent(self::USER_SAVE_EVENT);
    }

    
    /**
     * Track a user event
     *
     * @param string $event_name Name of the event to track
     */
    private function trackEvent($event_name) {
        if(defined('SEGMENTIO_USER')) {
            $event_code = str_replace('{{EVENT}}', $event_name, $event_code);
            $event_code = str_replace('{{DATA}}' , $this->getUserData(JFactory::getUser()), $event_code);

            $document =& JFactory::getDocument();
            $document->addScriptDeclaration($event_code);
        }
    }

    /**
     * Get the data to be tracked
     *
     * @return string json of user data
     */
    private function getTrackingData($user) {

        return json_encode(array('is_real' => false));
    }

}

