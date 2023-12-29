<?php
if (! current_user_can('edit_posts')) { // TODO Create own capability
    return;
}

require_once(plugin_dir_path(__FILE__) . '../../admin/class-handball-match-list.php');

$page = $_GET['subpage'] ?? 'recent';

echo '<div class="wrap"><h1>Spiele</h1>';

echo '<a href="'.add_query_arg('subpage', 'recent').'">Aktuelle Spiele</a>';
echo ' | ';
echo '<a href="'.add_query_arg('subpage', 'all').'">Alle Spiele</a>';

if ($page == 'all') {
    echo '<h2>Alle Spiele</h2>';
    $matchList = new HandballMatchList();
    $matchList->prepare_items(false, false);
    $matchList->display();
} else {
    echo '<h2>Vergangene Spiele</h2>';
    $matchList = new HandballMatchList();
    $matchList->prepare_items(false, true);
    $matchList->display();

    echo '<h2>Kommende Spiele</h2>';
    $matchList = new HandballMatchList();
    $matchList->prepare_items(true, false);
    $matchList->display();
}

echo '</div>';
?>

<style type="text/css">
    .column-datetime { width:60px !important; overflow:hidden }
    .column-league { width:60px !important; overflow:hidden }
    .column-actions { width:100px !important; overflow:hidden }
</style>