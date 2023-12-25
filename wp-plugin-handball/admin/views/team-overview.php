<?php
if (! current_user_can('edit_posts')) { // TODO Create own capability
    return;
}

require_once(plugin_dir_path(__FILE__) . '../../admin/class-handball-team-list.php');

$teamList = new HandballTeamList();
$teamList->prepare_items();
?>

<div class="wrap">
	<h1>Teams</h1>
	<?= $teamList->display() ?>
</div>

<style type="text/css">
    .column-sort { width:70px !important; overflow:hidden; text-align:center; }
</style>
