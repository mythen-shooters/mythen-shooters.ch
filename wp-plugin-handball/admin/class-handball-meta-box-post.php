<?php

class HandballMetaBoxPost
{
    public static function render($post)
    {
        $isNewsKey = 'handball_is_news';
        $isNews = get_post_meta($post->ID, $isNewsKey, true);
        if (empty($isNews)) {
            $isNews = false;
        }
        ?>
        <label for="handball_is_news">Als News anzeigen</label>
        <br />
        <?php 
            $checked = $isNews ? 'checked' : '';
        ?>
        <input type="checkbox" name="handball_is_news" id="handball_is_news" <?= $checked ?>/>
        <?php
    }
}

