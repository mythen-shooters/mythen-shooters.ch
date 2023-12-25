<?php
if (! class_exists('WP_List_Table')) {
    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-model.php');
require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

if (isset($_GET['deleteMatch'])) {
    $gameId= $_GET['deleteMatch'];
    $repo = new HandballMatchRepository();
    $repo->delete($gameId);
}

class HandballMatchList extends WP_List_Table
{
    
    private $matchRepo;
    
    public function __construct($args = [])
    {
        parent::__construct($args);
        $this->matchRepo = new HandballMatchRepository();
    }
    
    function get_columns()
    {
        return [
            'datetime' => 'Datum',
            'league' => 'Liga',
            'encounter' => 'Begegnung',
            'venue' => 'Ort',
            'actions'  => 'Aktionen',
        ];
    }
    
    function prepare_items($nextWeek = false, $lastWeek = false)
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = [];
        $this->_column_headers = [
            $columns,
            $hidden,
            $sortable
        ];
        
        if ($nextWeek) {
            $this->items = $this->matchRepo->findMatchesNextWeek();
        } else if ($lastWeek) {
            $this->items = $this->matchRepo->findMatchesLastWeek();
        } else {
            $this->items = $this->matchRepo->findAll();
        }
    }
    
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'game_id':
                return $item->getGameId();
            case 'game_nr':
                return $item->getGameNr();
            case 'datetime':
                return $item->getGameDateTimeFormattedShort();
            case 'league':
                return $item->getLeagueShort();
            case 'encounter':
                return $item->getEncounter() . '<br />' . $item->getScore();
            case 'venue':
                return $item->getVenue();
            case 'actions':
                return
                $this->createActionLink($item, 'preview')
                . '<br />'
                    . $this->createActionLink($item, 'report')
                    . '<br />'
                        . $this->createDeleteLink($item);
        }
    }
    
    private function createDeleteLink($match): string
    {
        $id = $match->getGameId();
        $url = '/wp-admin/admin.php?page=handball_match&deleteMatch=' . $id;
        return '<a class="wp-menu-image dashicons-before dashicons-trash" onclick="return confirm(\'Match wirklich l&ouml;schen?\')" href="'.$url.'">L&ouml;schen</a>';
    }
    
    private function createActionLink($match, $gameReportType)
    {
        $type = null;
        $post = null;
        if ($gameReportType == 'preview') {
            $type = 'Vorschau';
            $post = $match->getPostPreview();
        } else {
            $type = 'Bericht';
            $post = $match->getPostReport();
        }
        
        $icon = 'plus';
        $url  = '/wp-admin/post-new.php?post_type=handball_match&handball_game_report_type=' . $gameReportType . '&handball_game_id=' . $match->getGameId();
        if ($post != null) {
            $icon = 'edit';
            $url = '/wp-admin/post.php?post='.$post->ID.'&action=edit';
        }
        
        return '<a class="wp-menu-image dashicons-before dashicons-'.$icon.'" href="'.$url.'">'.$type .'</a>';
    }
}