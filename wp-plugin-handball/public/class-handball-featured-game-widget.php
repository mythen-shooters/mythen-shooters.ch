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
        echo "<div style='text-align:center;border:2px solid var(--orange);font-size:18px;background-color:var(--blue);color:white;font-weight:bold;'>";
        $team = $instance['team'] ?? null;
        if ($team == null) {
          echo "Kein Team definiert";
        } else {
          $nextGame = $this->matchRepo->findNextMatch($team);
          $lastGame = $this->matchRepo->findLastMatch($team);
          
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
        if ($postUrl == null) {
          $element = "div";
        }
        
        return "
          <style>
            a.next-match:hover {
                background-color: var(--orange)
            }
          </style>
          
            <".$element." class='next-match' href='".$postUrl."' style='padding:8px;display:block;color:white;'>
            
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
        $postUrl = $game->getPostPreviewUrl();
        $element = "a";
        if ($postUrl == null) {
          $element = "div";
        }

        return "
          <style>
            a.last-match:hover {
                background-color: var(--orange)
            }
          </style>          
            <".$element." class='last-match' href='".$postUrl."' style='color:white;padding:8px;display:block;'>

            <div style='font-size:11px;'>
                Last Game
            </div>

            <div>
            <img style='position:relative;top:3px;margin-right:3px;' src='".$imgUrl."' />"
                    .esc_attr($game->getOpponentTeamName())." ".$game->getTeamAScoreFT() . ':' . $game->getTeamBScoreFT()."

            </div>
            </".$element.">
        ";

    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'text_domain');
        $team = !empty($instance['team']) ? $instance['team'] : esc_html__('', 'text_domain');
        ?>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">

                    <label for="<?php echo esc_attr($this->get_field_id('team')); ?>"><?php esc_attr_e('Team:', 'text_domain'); ?></label>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('team')); ?>" name="<?php echo esc_attr($this->get_field_name('team')); ?>" type="text" value="<?php echo esc_attr($team); ?>">
                </p>
                <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['team'] = (!empty($new_instance['team'])) ? strip_tags($new_instance['team']) : '';
        return $instance;
    }
}
