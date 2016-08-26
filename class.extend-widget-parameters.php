<?php

/**
 * @package Extend Widget Parameters
 * @since 0.1.0
 */

if ( ! class_exists( 'Extend_Widget_Parameters' ) ) {
    class Extend_Widget_Parameters {
        
        private static $instance;
        
        
        public static function instance() {
            
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self();
            }
            
            return self::$instance;
            
        }
        
        
        private function __construct() {
            
            add_action( 'in_widget_form', array( $this, 'add_extra_fields' ), 10, 3 );
            
        }
        
        
        public static function add_extra_fields( $widget, $return, $instance ) {
            
            $instance = wp_parse_args( (array) $instance, array( 'widget-id' => '', 'widget-class' => '' ) );
            ?>
            
            <p>
                <label for="<?php echo $widget->get_field_id( 'widget-id' ); ?>"><?php _e( 'ID', 'ewp' ); ?>:</label>
                <input class="widefat" id="<?php echo $widget->get_field_id( 'widget-id' ); ?>" name="<?php echo $widget->get_field_name( 'widget-id' ); ?>" type="text" value="<?php echo $instance['widget-id']; ?>" />
            </p>
            
            <p>
                <label for="<?php echo $widget->get_field_id( 'widget-class' ); ?>"><?php _e( 'Class', 'ewp' ); ?>:</label>
                <input class="widefat" id="<?php echo $widget->get_field_id( 'widget-class' ); ?>" name="<?php echo $widget->get_field_name( 'widget-class' ); ?>" type="text" value="<?php echo $instance['widget-class']; ?>" />
            </p>
            
            <?php
        }
        
    }
}

// Get the Extend Widget Parameters plugin running
Extend_Widget_Parameters::instance();
