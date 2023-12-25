<?php

class HandballPublicPlugin
{
    
    private $pluginName;
    
    private $version;
    
    public function __construct($pluginName, $version)
    {
        $this->pluginName = $pluginName;
        $this->version = $version;
    }
    
    public function registerPostTypeMatch()
    {
        register_post_type('handball_match', [
            'labels' => [
                'name' => __('Berichte'),
                'singular_name' => __('Bericht')
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => [
                'slug' => 'berichte'
            ]
        ]);
    }
    
    public function registerPostTypeTeam()
    {
        register_post_type('handball_team', [
            'labels' => [
                'name' => __('Teams'),
                'singular_name' => __('Team')
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => [
                'slug' => 'teams'
            ]
        ]);
    }
    
    public function registerPostTypeEvent()
    {
        register_post_type('handball_event', [
            'labels' => [
                'name' => __('Events'),
                'singular_name' => __('Event')
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => [
                'slug' => 'events'
            ]
        ]);
    }
    
    public function registerPostTypeGallery()
    {
        register_post_type('handball_gallery', [
            'labels' => [
                'name' => __('Galerien'),
                'singular_name' => __('Galerie')
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => [
                'slug' => 'galerie'
            ]
        ]);
    }    
    
    public function nextEventWidget()
    {
        require_once ('class-handball-next-event-widget.php');
        register_widget('HandballNextEventWidget');
    }

    public function featuredGameWidget()
    {
        require_once ('class-handball-featured-game-widget.php');
        register_widget('HandballFeaturedGameWidget');
    }
    
    public function newestGalleryWidget()
    {
        require_once ('class-handball-newest-gallery-widget.php');
        register_widget('HandballNewestGalleryWidget');
    }
    
    public function addSingleTeamTemplate($singleTemplate)
    {
        global $post;
        $file = PLUGINDIR . '/handball/public/templates/single-' . $post->post_type . '.php';
        if (file_exists($file)) {
            return $file;
        }
        return $singleTemplate;
    }
    
}