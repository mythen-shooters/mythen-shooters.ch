<?php
require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

class HandballNextEventWidget extends WP_Widget
{
    private $eventRepo;
    
    public function __construct()
    {
        parent::__construct('handball_next_event_widget', 'Next Event');
        $this->eventRepo= new HandballEventRepository();
    }
	
    public function widget($args, $instance)
    {   
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo "
        <style>
        .next-event {
            border:2px solid var(--orange);
            padding-left:60px;
            font-size:20px;
            background-color: var(--blue);
            color: white;
            font-weight:bold;
        }
        .next-event-link {
            display:block;
            color:white;
            font-weight:bold;                
            width:40px;
            text-align:center;
            height:58px;
            padding-top:18px;
            float:right;
            background-color: var(--orange)
        }
        .next-event-link:hover {
            background-color: var(--light-orange);                
        }
        </style>";

        $events = $this->eventRepo->findUpComingEvents();
        $eventsToShow = intval($instance['eventsToShow']);
        if ($eventsToShow != -1) {
		    $events = array_slice($events, 0, $eventsToShow);
        }
        if (empty($events)) {
            echo 'Momentan stehen keine Events an.';
        } else {
            foreach ($events as $event) {
                echo $this->renderEvent($event);
            }
        }
        echo $args['after_widget'];
    }
    
    private function renderEvent(Event $event): string {        
        $hidden = "display:none;";
        if ($event->hasContent()) {
            $hidden = '';
        }
        return "<div style='margin-bottom:10px;'>
            <div class='background-orange' style='width:50px;height:60px;text-align:center;padding-top:8px;float:left;font-weight:bold;color:white;text-transform:uppercase;'>
                <div>
                    <span style='font-size:24px;'>".esc_attr($event->getDay())."</span>
                </div>
                <div>
                    <span style='font-size:14px;'>".esc_attr($event->getMonth())."</span>
                </div>
            </div>

            <div class='next-event clearfix'>
               <a class='next-event-link' style='".$hidden.";color:white;' href='".$event->getUrl()."'>></a>
               <div style='padding-top:18px;padding-right:5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;'>
                ".esc_attr($event->getTitle())."
                </div>
            </div>
        </div>
        ";
    }
    
    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $eventsToShow = ! empty( $instance['eventsToShow'] ) ? $instance['eventsToShow'] : esc_html__( '', 'text_domain' );        
        ?>
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

            <label for="<?php echo esc_attr($this->get_field_id('eventsToShow')); ?>"><?php esc_attr_e('Events to show:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('eventsToShow')); ?>" name="<?php echo esc_attr($this->get_field_name('eventsToShow')); ?>" type="text" value="<?php echo esc_attr($eventsToShow); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['eventsToShow'] = (!empty($new_instance['eventsToShow'])) ? strip_tags($new_instance['eventsToShow']) : '';
        return $instance;
    }
}
