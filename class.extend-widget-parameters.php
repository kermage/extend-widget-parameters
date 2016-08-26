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
            add_filter( 'widget_update_callback', array( $this, 'save_extra_fields' ), 10, 4 );
            add_filter( 'dynamic_sidebar_params', array( $this, 'apply_extra_fields' ) );
            
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
        
        
        public static function save_extra_fields( $instance, $new_instance, $old_instance, $widget ) {
            
            $instance['widget-id'] = apply_filters(
                'widget_attribute_id',
                sanitize_html_class( $new_instance['widget-id'] )
            );
            $instance['widget-class'] = apply_filters(
                'widget_attribute_classes',
                implode(
                    ' ',
                    array_map(
                        'sanitize_html_class',
                        explode( ' ', $new_instance['widget-class'] )
                    )
                )
            );
            
            return $instance;
            
        }
        
        
        public static function apply_extra_fields( $params ) {
            
            global $wp_registered_widgets;
            
            $widget_id  = $params[0]['widget_id'];
            $widget_options = get_option( $wp_registered_widgets[$widget_id]['callback'][0]->option_name );
            $widget_num = $wp_registered_widgets[ $widget_id ]['params'][0]['number'];
            $instance = $widget_options[ $widget_num ];
            
            if ( ! empty( $instance['widget-id'] ) ) {
                $params[0]['before_widget'] = preg_replace( '/id="[^"]+"/', 'id="' . $instance['widget-id'] . '"', $params[0]['before_widget'] );
            }
            
            if ( ! empty( $instance['widget-class'] ) ) {
                $params[0]['before_widget'] = preg_replace( '/class="([^"]+)"/', 'class="$1 ' . $instance['widget-class'] . '"', $params[0]['before_widget'] );
            }
            
            return $params;
            
        }
        
    }
}

// Get the Extend Widget Parameters plugin running
Extend_Widget_Parameters::instance();
