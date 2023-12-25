<?php

class HandballPlugin
{
    
    private $loader;
    
    private $pluginName;
    
    private $version;
    
    public function __construct()
    {
        $this->pluginName = 'hcg-match';
        $this->version = '0.0.1';
        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHocks();
        $this->definePublicHocks();
    }
    
    public function run()
    {
        $this->loader->run();
    }
    
    private function loadDependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-handball-plugin-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-handball-admin-plugin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-handball-public-plugin.php';
        $this->loader = new HandballPluginLoader();
    }
    
    private function setLocale()
    {}
    
    private function defineAdminHocks()
    {
        $adminPlugin = new HandballAdminPlugin($this->getPluginName(), $this->getVersion());
        $this->loader->add_action('admin_menu', $adminPlugin, 'createAdminMenu');
        $this->loader->add_action('handball_synchronize_data', $adminPlugin, 'synchronize');
        $this->loader->add_action('admin_init', $adminPlugin, 'createSettingsAdmin');
        $this->loader->add_action('add_meta_boxes', $adminPlugin, 'addMetaBoxForPostTypePost');
        $this->loader->add_action('add_meta_boxes', $adminPlugin, 'addMetaBoxForPostTypeMatch');
        $this->loader->add_action('add_meta_boxes', $adminPlugin, 'addMetaBoxForPostTypeTeam');
        $this->loader->add_action('add_meta_boxes', $adminPlugin, 'addMetaBoxForPostTypeEvent');
        $this->loader->add_action('add_meta_boxes', $adminPlugin, 'addMetaBoxForPostTypeGallery');
        $this->loader->add_action('save_post', $adminPlugin, 'savePostMetaForPost');
        $this->loader->add_action('save_post', $adminPlugin, 'savePostMetaForMatch');
        $this->loader->add_action('save_post', $adminPlugin, 'savePostMetaForTeam');
        $this->loader->add_action('save_post', $adminPlugin, 'savePostMetaForEvent');
        $this->loader->add_action('save_post', $adminPlugin, 'savePostMetaForGallery');
    }
    
    private function definePublicHocks()
    {
        $publicPlugin = new HandballPublicPlugin($this->getPluginName(), $this->getVersion());
        $this->loader->add_action('init', $publicPlugin, 'registerPostTypeMatch');
        $this->loader->add_action('init', $publicPlugin, 'registerPostTypeTeam');
        $this->loader->add_action('init', $publicPlugin, 'registerPostTypeEvent');
        $this->loader->add_action('init', $publicPlugin, 'registerPostTypeGallery');
        $this->loader->add_action('widgets_init', $publicPlugin, 'nextEventWidget');
        $this->loader->add_action('widgets_init', $publicPlugin, 'featuredGameWidget');
        $this->loader->add_action('widgets_init', $publicPlugin, 'newestGalleryWidget');
        $this->loader->add_filter('single_template', $publicPlugin, 'addSingleTeamTemplate');
        
        // CUSTOM TEAM TEMPLATE!
        function handball_rewrite_rules(){
            add_rewrite_rule('^events$', 'index.php?events=upcoming', 'top');
            add_rewrite_rule('^galerie$', 'index.php?galerie=all', 'top');
            flush_rewrite_rules(true);
        }
        add_action('init', 'handball_rewrite_rules');
        
        function handball_query_vars($vars) {
            array_push($vars, 'events');
            array_push($vars, 'galerie');
            return $vars;
        }
        add_action('query_vars', 'handball_query_vars');
        
        function handbalEndsWith($string, $search) {
            $length = strlen($search);
            if ($length == 0) {
                return true;
            }
            return (substr($string, - $length) === $search);
        }
        
        function handball_template_include($template) {
            $queryVar = get_query_var('events');
            if ($queryVar == 'upcoming') {
                $template = WP_PLUGIN_DIR . '/handball/public/views/events.php';
            }
            $queryVar = get_query_var('galerie');
            if ($queryVar == 'all') {
                $template = WP_PLUGIN_DIR . '/handball/public/views/galleries.php';
            }
            if (handbalEndsWith($template, 'home.php')) {
                $template = WP_PLUGIN_DIR . '/handball/public/views/home.php';
            }
            return $template;
        }
        
        
        add_filter('template_include', 'handball_template_include');
    }
    
    
    
    private function getPluginName()
    {
        return $this->pluginName;
    }
    
    private function getVersion()
    {
        return $this->version;
    }
}