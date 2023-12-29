<?php
require_once (WP_PLUGIN_DIR . "/handball/includes/class-handball-helper.php");

class HandballMetaBoxGallery
{

    public static function render($post)
    {
        $dateAttribute = 'handball_gallery_date';
        $date = get_post_meta($post->ID, $dateAttribute, true);
        DateTimeUi::renderDate('Datum', $dateAttribute, $date);
    }
}
