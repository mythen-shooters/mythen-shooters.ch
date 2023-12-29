<?php
require_once (WP_PLUGIN_DIR . "/handball/includes/class-handball-helper.php");

class HandballMetaBoxEvent
{
    public static function render($post)
    {
        $startDateTime = get_post_meta($post->ID, 'handball_event_start_datetime', true);
        $endDateTime = get_post_meta($post->ID, 'handball_event_end_datetime', true);

        DateTimeUi::renderDateTime('Start', 'handball_event_start_datetime', $startDateTime);
        echo '<br />';
        DateTimeUi::renderDateTime('Ende', 'handball_event_end_datetime', $endDateTime);
    }

}

