<?php
require_once(plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

class HandballMetaBoxTeam
{
    public static function render($post)
    {
        $teamId = get_post_meta($post->ID, 'handball_team_id', true);
        if (empty($teamId) && isset($_GET['handball_team_id'])) {
            $teamId= $_GET['handball_team_id'];
        }
        ?>

        <label for="handball_team_id">Team ID</label>        
		<input readonly type="text" value="<?= $teamId ?>" name="handball_team_id" id="handball_team_id" />
        <br />
	   <?php
    }
}

