<?php

/**
 * @package Extend Widget Parameters
 * @since 0.1.0
 */

/**
 * Plugin Name: Extend Widget Parameters
 * Plugin URI:  https://github.com/kermage/extend-widget-parameters/
 * Author:      Gene Alyson Fortunado Torcende
 * Author URI:  mailto:genealyson.torcende@gmail.com
 * Description: Extend widgets with ability to add custom ID and classes, override widget wrap and title tags, hide the title or the entire widget on the front end, and clone itself with all of its settings.
 * Version:     1.0.0
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ewp
 */

// Accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* ==================================================
Global constants
================================================== */
define( 'EWP_VERSION',  '1.0.0' );
define( 'EWP_FILE',     __FILE__ );
define( 'EWP_URL',      plugin_dir_url( EWP_FILE ) );
define( 'EWP_PATH',     plugin_dir_path( EWP_FILE ) );

// Load the Extend Widget Parameters plugin
require_once EWP_PATH . 'class.' . basename( EWP_FILE );
