<?php
// Register Custom Blog Widget
function register_custom_blog_widget() {
    register_widget( 'Custom_Blog_Widget' );
}
add_action( 'widgets_init', 'register_custom_blog_widget' );

// Custom Blog Widget Class
class Custom_Blog_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'custom_blog_widget', // Base ID
            'Custom Blog Widget', // Name
            array( 'description' => __( 'A custom widget to display blog posts.', 'text_domain' ), ) // Args
        );
    }

    // Widget Frontend
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Widget Content
        // Example code to display recent blog posts
        $recent_posts = wp_get_recent_posts();
        echo '<ul>';
        foreach( $recent_posts as $post ){
            echo '<li><a href="' . get_permalink($post['ID']) . '">' . $post['post_title'].'</a></li>';
        }
        echo '</ul>';
        
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

} // Class Custom_Blog_Widget ends here
