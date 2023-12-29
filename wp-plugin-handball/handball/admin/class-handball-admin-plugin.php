<?php

class HandballAdminPlugin
{
    
    private $pluginName;
    
    private $version;
    
    public function __construct($pluginName, $version)
    {
        $this->pluginName = $pluginName;
        $this->version = $version;
    }
    
    public function synchronize()
    {
        require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-shv-synchronizer.php');
        
        $apiUrl = get_option('HANDBALL_API_URL');
        $apiUsername = get_option('HANDBALL_API_USERNAME');
        $apiPassword = get_option('HANDBALL_API_PASSWORD');
        $clubId = get_option('HANDBALL_SYNCHRONIZE_CLUB_ID');
        
        $synchronizer = new HandballShvSynchronizer($apiUrl, $apiUsername, $apiPassword, $clubId);
        $synchronizer->start();
    }
    
    public function addMetaBoxForPostTypePost()
    {
        require_once('class-handball-meta-box-post.php');
        add_meta_box('handball_metabox_post', 'Beitrag', 'HandballMetaBoxPost::render', 'post');
    }
    
    public function addMetaBoxForPostTypeMatch()
    {
        require_once('class-handball-meta-box-match.php');
        add_meta_box('handball_metabox_match', 'Match', 'HandballMetaBoxMatch::render', 'handball_match');
    }
    
    public function addMetaBoxForPostTypeTeam()
    {
        require_once('class-handball-meta-box-team.php');
        add_meta_box('handball_metabox_team', 'Team', 'HandballMetaBoxTeam::render', 'handball_team');
    }
    
    public function addMetaBoxForPostTypeEvent()
    {
        require_once('class-handball-meta-box-event.php');
        add_meta_box('handball_metabox_event', 'Event', 'HandballMetaBoxEvent::render', 'handball_event');
    }
    
    public function addMetaBoxForPostTypeGallery()
    {
        require_once('class-handball-meta-box-gallery.php');
        add_meta_box('handball_metabox_event', 'Galerie', 'HandballMetaBoxGallery::render', 'handball_gallery');
    }
    
    public function savePostMetaForPost($postId)
    {
        $isNewsKey = 'handball_is_news';
        if (array_key_exists($isNewsKey, $_POST)) {
            update_post_meta($postId, $isNewsKey, 1);
        } else {
            update_post_meta($postId, $isNewsKey, 0);
        }
    }
    
    public function savePostMetaForMatch($postId)
    {
        $gameIdKey = 'handball_game_id';
        if (array_key_exists($gameIdKey, $_POST)) {
            $id = $_POST[$gameIdKey];
            if (intval($id)) {
                update_post_meta($postId, $gameIdKey, $id);
            }
        }
        $reportTypeKey = 'handball_game_report_type';
        if (array_key_exists($reportTypeKey, $_POST)) {
            update_post_meta($postId, $reportTypeKey, $_POST[$reportTypeKey]);
        }
        $isNewsKey = 'handball_is_news';
        if (array_key_exists($isNewsKey, $_POST)) {
            update_post_meta($postId, $isNewsKey, 1);
        } else {
            update_post_meta($postId, $isNewsKey, 0);
        }
    }
    
    public function savePostMetaForTeam($postId)
    {
        $teamIdKey = 'handball_team_id';
        if (array_key_exists($teamIdKey, $_POST)) {
            $id = $_POST[$teamIdKey];
            if (intval($id)) {
                update_post_meta($postId, $teamIdKey, $id);
            }
        }
    }
    
    public function savePostMetaForEvent($postId)
    {
        $key = 'handball_event_start_datetime';
        if (array_key_exists($key, $_POST)) {
            $dateTime = $_POST[$key];
            if (self::isDateTimeString($dateTime)) {
                $dateTime= self::dateTimeStringToTimestamp($dateTime);
            }
            update_post_meta($postId, $key, $dateTime);
        }
        $key= 'handball_event_end_datetime';
        if (array_key_exists($key, $_POST)) {
            $dateTime = $_POST[$key];
            if (self::isDateTimeString($dateTime)) {
                $dateTime = self::dateTimeStringToTimestamp($dateTime);
            }
            update_post_meta($postId, $key, $dateTime);
        }
    }
    
    public function savePostMetaForGallery($postId)
    {
        $key = 'handball_gallery_date';
        if (array_key_exists($key, $_POST)) {
            $date = $_POST[$key];
            if (self::isDateTimeString($date)) {
                $date = self::dateStringToTimestamp($date);
            }
            update_post_meta($postId, $key, $date);
        }
    }
    
    private static function isDateTimeString($string)
    {
        return strpos($string, '-') !== false;
    }
    
    private static function dateTimeStringToTimestamp($dateTimeString)
    {
        $arr = explode('-', $dateTimeString);
        return mktime($arr[3], $arr[4], 0, $arr[1], $arr[0], $arr[2]);
    }
    
    private static function dateStringToTimestamp($dateString)
    {
        $arr = explode('-', $dateString);
        return mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
    }
    
    public function createSettingsAdmin() {
        require_once('class-handball-settings.php');
        HandballSettings::registerSettings();
    }
    
    public function createAdminMenu() {
        $capability = 'edit_posts'; // TODO Create own capability
        
        add_menu_page(
            'Handball',
            'Handball',
            $capability,
            'handball_match',
            null,
            'dashicons-awards',
            20
            );
        
        add_submenu_page(
            'handball_match',
            'Spiele',
            'Spiele',
            $capability,
            'handball_match',
            function () {
                include(plugin_dir_path(__FILE__) . 'views/match-overview.php');
            }
            );
        
        add_submenu_page(
            'handball_match',
            'Teams',
            'Teams',
            $capability,
            'handball_team',
            function () {
                include(plugin_dir_path(__FILE__) . 'views/team-overview.php');
            }
            );
    }
    
}