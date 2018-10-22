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
            add_filter( 'widget_title', array( $this, 'hide_widget_title' ), 10, 2 );
            add_filter( 'widget_display_callback', array( $this, 'widget_display' ), 10, 3 );
            add_action( 'load-widgets.php', array( $this, 'scripts_styles' ) );
            
        }
        
        
        public function add_extra_fields( $widget, $return, $instance ) {
            
            $instance = wp_parse_args( (array) $instance, array( 'ewp' => array(
                            'atts' => array( 'id' => '', 'class' => '' ),
                            'tags' => array( 'wrap' => '', 'title' => '' ),
                            'opts' => array( 'overwrite_class' => '', 'hide_title' => '', 'status' => '' )
                        ) ) );
            $wraptags = array ( 'div', 'section', 'article', 'main', 'aside' );
            $titletags = array ( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' );
            ?>

            <a class="button-primary ewp-toggle" id="<?php echo $widget->get_field_id( 'ewp-toggle' ); ?>" href="#"><?php _e( 'Toggle Parameters', 'ewp' ); ?></a>
            <a class="button ewp-clone" id="<?php echo $widget->get_field_id( 'ewp-clone' ); ?>" href="#"><?php _e( 'Clone', 'ewp' ); ?></a>
            
            <div class="ewp">
            <div class="ewp-top">Parameters</div>
            <div class="widget-inside" style="display: block;">
            
            <p>
                <label for="<?php echo $widget->get_field_id( 'ewp-atts-id' ); ?>"><?php _e( 'ID', 'ewp' ); ?>:</label>
                <input class="widefat" id="<?php echo $widget->get_field_id( 'ewp-atts-id' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[atts][id]' ); ?>" type="text" value="<?php echo $instance['ewp']['atts']['id']; ?>" />
            </p>
            
            <p>
                <label for="<?php echo $widget->get_field_id( 'ewp-atts-class' ); ?>"><?php _e( 'Class', 'ewp' ); ?>:</label>
                <input class="widefat" id="<?php echo $widget->get_field_id( 'ewp-atts-class' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[atts][class]' ); ?>" type="text" value="<?php echo $instance['ewp']['atts']['class']; ?>" />
            </p>
            
            <p>
                <input id="<?php echo $widget->get_field_id( 'ewp-opts-overwrite_class' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[opts][overwrite_class]' ); ?>" type="checkbox"<?php checked( $instance['ewp']['opts']['overwrite_class'] ); ?> />
                <label for="<?php echo $widget->get_field_id( 'ewp-opts-overwrite_class' ); ?>"><?php _e( 'Overwrite Class', 'ewp' ); ?></label>
                <input id="<?php echo $widget->get_field_id( 'ewp-opts-hide_title' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[opts][hide_title]' ); ?>" type="checkbox"<?php checked( $instance['ewp']['opts']['hide_title'] ); ?> />
                <label for="<?php echo $widget->get_field_id( 'ewp-opts-hide_title' ); ?>"><?php _e( 'Hide Title', 'ewp' ); ?></label>
            </p>
            
            <p>
                <label><?php _e( 'Tags', 'ewp' ); ?>:</label>
                <select class="widefat" id="<?php echo $widget->get_field_id( 'ewp-tags-wrap' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[tags][wrap]' ); ?>">
                    <option value="0"><?php _e( '&mdash; Select Wrap Tag &mdash;', 'ewp' ); ?></option>
                    <?php foreach ( $wraptags as $wraptag ) : ?>
                        <option value="<?php echo $wraptag; ?>" <?php selected( $instance['ewp']['tags']['wrap'], $wraptag ); ?>><?php echo $wraptag; ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="widefat" id="<?php echo $widget->get_field_id( 'ewp-tags-title' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[tags][title]' ); ?>"">
                    <option value="0"><?php _e( '&mdash; Select Title Tag &mdash;', 'ewp' ); ?></option>
                    <?php foreach ( $titletags as $titletag ) : ?>
                        <option value="<?php echo $titletag; ?>" <?php selected( $instance['ewp']['tags']['title'], $titletag ); ?>><?php echo $titletag; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            
            <p>
                <label for="<?php echo $widget->get_field_id( 'ewp-opts-status' ); ?>"><?php _e( 'Status', 'ewp' ); ?>:</label>
                <select class="widefat" id="<?php echo $widget->get_field_id( 'ewp-opts-status' ); ?>" name="<?php echo $widget->get_field_name( 'ewp[opts][status]' ); ?>">
                    <option value="0" <?php selected( $instance['ewp']['opts']['status'], 0 ); ?>><?php _e( '&mdash; Published &mdash;', 'ewp' ); ?></option>
                    <option value="1" <?php selected( $instance['ewp']['opts']['status'], 1 ); ?>><?php _e( '&mdash; Unpublished &mdash;', 'ewp' ); ?></option>
                </select>
            </p>
            
            </div>
            </div>
            
            <?php
        }
        
        
        public function save_extra_fields( $instance, $new_instance, $old_instance, $widget ) {
            
            $instance['ewp']['atts']['id'] = apply_filters(
                'widget_attribute_id',
                sanitize_html_class( $new_instance['ewp']['atts']['id'] )
            );
            $instance['ewp']['atts']['class'] = apply_filters(
                'widget_attribute_classes',
                implode(
                    ' ',
                    array_map(
                        'sanitize_html_class',
                        explode( ' ', $new_instance['ewp']['atts']['class'] )
                    )
                )
            );
            $instance['ewp']['opts']['overwrite_class'] = ! empty( $new_instance['ewp']['opts']['overwrite_class'] );
            $instance['ewp']['opts']['hide_title'] = ! empty( $new_instance['ewp']['opts']['hide_title'] );
            $instance['ewp']['opts']['status'] = $new_instance['ewp']['opts']['status'];
            $instance['ewp']['tags']['wrap'] = $new_instance['ewp']['tags']['wrap'];
            $instance['ewp']['tags']['title'] = $new_instance['ewp']['tags']['title'];
            
            return $instance;
            
        }
        
        
        public function apply_extra_fields( $params ) {
            
            global $wp_registered_widgets;
            
            $widget_id  = $params[0]['widget_id'];
            $widget_options = get_option( $wp_registered_widgets[$widget_id]['callback'][0]->option_name );
            $widget_num = $wp_registered_widgets[ $widget_id ]['params'][0]['number'];
            $instance = $widget_options[ $widget_num ];
            
            if ( ! empty( $instance['ewp']['atts']['id'] ) ) {
                $params[0]['before_widget'] = preg_replace( '/id="[^"]+"/', 'id="' . $instance['ewp']['atts']['id'] . '"', $params[0]['before_widget'] );
            }
            
            if ( ! empty( $instance['ewp']['atts']['class'] ) ) {
                if ( ! empty( $instance['ewp']['opts']['overwrite_class'] ) ) {
                    $params[0]['before_widget'] = preg_replace( '/class="[^"]+"/', 'class="' . $instance['ewp']['atts']['class'] . '"', $params[0]['before_widget'] );
                } else {
                    $params[0]['before_widget'] = preg_replace( '/class="([^"]+)"/', 'class="$1 ' . $instance['ewp']['atts']['class'] . '"', $params[0]['before_widget'] );
                }
            }
            
            if ( ! empty( $instance['ewp']['tags']['wrap'] ) ) {
                preg_match( '/<\/([^>]+)>/', $params[0]['after_widget'], $def_wrap );
                $params[0]['before_widget'] = str_replace( $def_wrap[1], $instance['ewp']['tags']['wrap'], $params[0]['before_widget'] );
                $params[0]['after_widget'] = '</' . $instance['ewp']['tags']['wrap'] . '>';
            }
            
            if ( ! empty( $instance['ewp']['tags']['title'] ) ) {
                preg_match( '/<\/([^>]+)>/', $params[0]['after_title'], $def_tag );
                $params[0]['before_title'] = str_replace( $def_tag[1], $instance['ewp']['tags']['title'], $params[0]['before_title'] );
                $params[0]['after_title'] = '</' . $instance['ewp']['tags']['title'] . '>';
            }
            
            return $params;
            
        }
        
        
        public function hide_widget_title( $title, $instance = array() ) {
            
            if ( ! empty( $instance['ewp']['opts']['hide_title'] ) ) {
                $title = '';
            }
            
            return $title;
        }
        
        
        public function widget_display( $instance, $widget, $args ) {
            
            if ( ! empty( $instance['ewp']['opts']['status'] ) ) {
                return false;
            }
            
            return $instance;
            
        }
        
        
        public function scripts_styles() {
            
            wp_enqueue_script( 'jquery-effects-slide' );
            wp_enqueue_style( 'ewp-css', EWP_URL . 'extend-widget-parameters.css', array(), EWP_VERSION, false );
            wp_enqueue_script( 'ewp-js', EWP_URL . 'extend-widget-parameters.js', array( 'jquery-effects-slide' ), EWP_VERSION, true );
            
        }
        
    }
}

// Get the Extend Widget Parameters plugin running
Extend_Widget_Parameters::instance();
