<?php
if (! class_exists('WP_List_Table')) {
    require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-model.php');
require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

class HandballTeamList extends WP_List_Table
{
    
    private $teamRepo;
    private $saisonRepo;
    private $filterSaison;
    
    public function __construct($args = [])
    {
        parent::__construct($args);
        $this->teamRepo = new HandballTeamRepository();
        $this->saisonRepo = new HandballSaisonRepository();
        
        $saisons = $this->saisonRepo->findAll();
        $defaultSaison = 0;
        foreach ($saisons as $saison) {
            if ($saison->getValue() > $defaultSaison) {
                $defaultSaison = $saison->getValue();
            }
        }
        
        $this->filterSaison = $defaultSaison;
        if (isset($_GET['saison_filter'])) {
            $this->filterSaison = $_GET['saison_filter'];
        }
    }
    
    function get_columns()
    {
        return [
            'team_name' => 'Team',
            'actions' => 'Aktionen'
        ];
    }
    
    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [
            $columns,
            $hidden,
            $sortable
        ];
        $this->items = $this->teamRepo->findAllBySaison(new Saison($this->filterSaison));
    }
    
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'team_id':
                return $item->getTeamId();
            case 'saison':
                return $item->getSaison()->formattedShort();
            case 'team_name':
                $link = $item->getTeamUrl();
                $name = $item->getTeamName() . ' ' . $item->getLeagueShort() . ' (' . $item->getTeamId() . ')';
                $teamName = '';
                if (empty($link)) {
                    $teamName = $name;
                } else {
                    $teamName = '<a href="'.$link.'">' . $name . '</a>';
                }
                return $teamName . '<br />' . $item->getLeagueLong();
            case 'actions':
                return $this->createActionLink($item);
        }
    }
    
    private function createActionLink(Team $team)
    {
        $post = $team->findPost();
        $url  = '/wp-admin/post-new.php?post_type=handball_team&handball_team_id=' . $team->getTeamId();
        $text = 'Team-Seite erstellen';
        if ($post != null) {
            $url = '/wp-admin/post.php?post='.$post->ID.'&action=edit';
            $text = 'Team-Seite aktualisieren';
        }
        return '<a href="'.$url.'">'. $text .'</a>';
    }
    
    function extra_tablenav($which)
    {
        if ($which == "top") {
            $saisons = $this->saisonRepo->findAll();
            $url = add_query_arg('saison_filter', '');
            if (!empty($saisons)){
                ?>
                Saison <select name="saison-filter" class="handball-saison-filter">
                    <?php
                    foreach ($saisons as $saison) {
                        $value = $saison->getValue();
                        $selected = selected($this->filterSaison, $saison->getValue(), false);
                        $display = $saison->formattedShort();
                        ?><option value="<?= $value ?>" <?= $selected ?>><?= $display ?></option><?php
                    }
                    ?>
                </select>
                <?php
            }
            ?>
			<script>
            jQuery(document).ready(function($){
            	$('.handball-saison-filter').change(function(){
                    var saison = $(this).val();
                    document.location.href = '<?= $url ?>=' + saison;
                });
            });
            </script>
            <?php
        }
    }

}