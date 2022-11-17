<?php

/**
 * @link              http://ncs4.usm.edu/
 * @since             1.0.0
 * @package           KnowledgePortal
 *
 * @wordpress-plugin
 * Plugin Name:       NCS4 Knowledge Portal
 * Plugin URI:        http://ncs4.usm.edu/
 * Description:       Plugin to implement knowledge portal for NCS4 Connect
 * Version:           1.0.0
 * Author:            Aayush Gautam, NCS4
 * Author URI:        http://aayushis.fun/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path(__FILE__) . '/includes/activation.php';
require_once plugin_dir_path(__FILE__) . '/knowledgeportal-templates/dashboard.php';

//Initializing required custom post type and adding meta boxes for custom fields
add_action('init', 'ncs4_knowledgeportal_post_type');
add_action( "admin_init", "ncs4_add_post_meta_boxes" );

//Creating a shortcode for Dashboard Display
add_shortcode('ncs4-knowledgeportal-entries-list', 'ncs4_knowledgeportal_entires')

?>