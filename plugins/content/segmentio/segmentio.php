<?php

/**
 * Segment.IO Tracking on Content
 *
 * @package MrZen\Integration\Tracking
 * @license GNU GPL v3
 * @since 3.2
 */

jimport('joomla.plugin.plugin');

/**
 * Segment.IO Content Tracking
 *
 */
class plgContentSegmentIO extends JPlugin {

    /**
     * JS Template for tracking an event
     * @const Event Tracking JS
     */
    const TRACK_EVENT = <<<EOF
<script type="text/javascript">analytics.track('{{EVENT}}', {{DATA}});</script>
EOF;


    /**
     * Event name for an article view
     * @const Article viewing event name
     */
    const ARTICLE_VIEW_EVENT = "Viewed an Article";

    /**
     * Track an article view
     * 
     * Places event tracking code under the article.
     *
     * @param string $context Context of passed content (e.g. com_content.article)
     * @param \JArticle $article Article being parts (or content)
     * @param \JRegistry $params Content paramters
     * @param int $limitstart Page number
     *
     * @return string Tracking code
     */
    public function onContentAfterDisplay($context , &$article, &$params, $limitstart) {
        $data = array(
            'article_id'       => $article->id,
            'article_title'    => $article->title,
            'article_author'   => $article->author,
            'article_featured' => $article->featured,
        );

        $tracking_code = self::TRACK_EVENT;
        $tracking_code = str_replace('{{EVENT}}' , self::ARTICLE_VIEW_EVENT, $tracking_code);
        $tracking_code = str_replace('{{DATA}}'  , json_encode($data), $tracking_code);

        return $tracking_code;
    }

}
 