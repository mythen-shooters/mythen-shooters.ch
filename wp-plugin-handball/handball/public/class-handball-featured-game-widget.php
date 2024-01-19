<?php
require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

class HandballFeaturedGameWidget extends WP_Widget
{
    private $matchRepo;

    public function __construct()
    {
        parent::__construct('handball_featured_game_widget', 'Feature Game');
        $this->matchRepo = new HandballMatchRepository();
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
          echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        echo "<div style='text-align:center;border:5px solid var(--orange);border-radius:10px;font-size:18px;background-color:var(--blue);color:white;font-weight:bold;'>";
        $teamId = $instance['teamId'] ?? null;;
        if ($teamId == null) {
          echo "Kein Team definiert";
        } else {
          $nextGame = $this->matchRepo->findNextMatch($teamId);
          $lastGame = $this->matchRepo->findLastMatch($teamId);
          
          if ($nextGame == null) {
            //echo "<div style='height:40px;padding-top:10px;font-size:16px;'>Kein Spiel angesetzt</div>";
          } else {
            echo $this->renderNextMatch($nextGame);
          }

          if ($nextGame != null && $lastGame != null) {
            echo "<div style='border-top:2px solid var(--orange)'></div>";
          }

          if ($lastGame != null) {
            echo $this->renderLastMatch($lastGame);
          }
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    private function renderNextMatch(Game $game): string {
        $imgUrl = $game->getOpponentTeamImageUrl("60");
        $postUrl = $game->getPostPreviewUrl();
        $element = "a";
        $report = "<img style='float:right;width:15px;position:relative;bottom:2px;left:2px;' src='/wp-content/themes/shooters/images/icons/standard.svg' />";
        if ($postUrl == null) {
          $element = "div";
          $report = "";
        }
        
        return "
          <style>
            a.next-match:hover {
                background-color: var(--light-orange)
            }
          </style>
          
            <".$element." class='next-match' href='".$postUrl."' style='padding:8px;display:block;color:white;'>
            
            ".$report."
            <div> 
            <img src='".$imgUrl."' />
            </div>
                <div>
                    <span style='color:white;'>".esc_attr($game->getOpponentTeamName())."</span>
                </div>
                <div>
                    <span style='font-size:14px;color:white;'>".esc_attr($game->getGameDateTimeFormattedLong())." Uhr in ".$game->getVenueShort()."</span>

                </div>
            </".$element.">
        ";
    }

    private function renderLastMatch(Game $game): string {
        $imgUrl = $game->getOpponentTeamImageUrl("18");
        $postUrl = $game->getPostReportUrl();
        $element = "a";
        $report = "<img style='float:right;width:15px;position:relative;bottom:2px;left:2px;' src='/wp-content/themes/shooters/images/icons/standard.svg' />";
        if ($postUrl == null) {
          $element = "div";
          $report = "";
        }

        return "
          <style>
            a.last-match {
              background-color:var(--orange)
            }
            div.last-match {
              background-color:var(--orange)
            }
            a.last-match:hover {
              background-color: var(--light-orange)
            }
          </style>          
            <".$element." class='last-match' href='".$postUrl."' style='color:white;padding:8px;display:block;overflow:hidden;'>

            <div style='font-size:11px;'>
                Last Game
                ". $report . "
                <div class='clearfix'></div>
            </div>
 
            <div>
              <img style='position:relative;top:3px;margin-right:3px;' src='".$imgUrl."' />"
                
                . esc_attr($game->getOpponentTeamName())
                //. " "
                //. $game->getTeamAScoreFT()
                //. ':'
                //. $game->getTeamBScoreFT()           
                . "
            </div>


            </".$element.">
        ";

    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'text_domain');
        $teamId = !empty($instance['teamId']) ? $instance['teamId'] : esc_html__('', 'text_domain');
        ?>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">

                    <label for="<?php echo esc_attr($this->get_field_id('teamId')); ?>"><?php esc_attr_e('Team ID:', 'text_domain'); ?></label>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('teamId')); ?>" name="<?php echo esc_attr($this->get_field_name('teamId')); ?>" type="text" value="<?php echo esc_attr($teamId); ?>">
                </p>
                <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['teamId'] = (!empty($new_instance['teamId'])) ? strip_tags($new_instance['teamId']) : '';
        return $instance;
    }
}
