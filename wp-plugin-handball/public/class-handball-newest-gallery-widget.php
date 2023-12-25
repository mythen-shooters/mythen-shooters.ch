<?php
require_once (plugin_dir_path(__FILE__) . '../includes/class-handball-repository.php');

class HandballNewestGalleryWidget extends WP_Widget
{
    private $repo;

    public function __construct()
    {
        parent::__construct('handball_newest_gallery_widget', 'Newest Gallery');
        $this->repo= new HandballGalleryRepository();
    }

    public function widget($args, $instance)
    {
        $gallery = $this->repo->findNewest();

        $output = '';
        if ($gallery!= null) {
            $output .= '<h4>' . esc_attr($gallery->getTitle()) . '</h4>';
            $output .= '<a href="'.$gallery->getUrl().'">';
            $output .= '<img src="'.$gallery->getFirstImageUrlInPost().'" />';
            $output .= '</a>';
        }

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        echo '<div class="textwidget">';
        if (empty($output)) {
            echo 'Es gibt noch keine einzige Galerie.';
        } else {
            echo $output;
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}