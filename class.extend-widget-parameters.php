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
            
            
        }
        
    }
}

// Get the Extend Widget Parameters plugin running
Extend_Widget_Parameters::instance();
