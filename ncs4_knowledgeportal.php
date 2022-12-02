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

if ( ! class_exists('knowledgePortal') ): 

final class knowledgePortal {


    /** Singleton *************************************************************/

	/**
	 * Main knowledgePortal Instance
	 *
	 * knowledgePortal is fun
	 * Please load it only one time
	 * For this, we thank you
	 *
	 * Insures that only one instance of knowledgePortal exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.0 knowledgePortal (r3757)
	 *
	 * @staticvar object $instance
	 * @see knowledgeportal()
	 * @return knowledgePortal The one true knowledgePortal
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) {
			$instance = new knowledgePortal();
			$instance->setup_environment();
			$instance->includes();
			// $instance->setup_variables();
			$instance->setup_actions();
		}

		// Always return the instance
		return $instance;
	}
    
	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor to prevent knowledgePortal from being loaded more than once.
	 *
	 * @since 2.0.0 knowledgePortal (r2464)
	 *
	 * @see knowledgePortal::instance()
	 * @see knowledgePortal();
	 */
	private function __construct() { /* Do nothing here */ }

    /**
	 * Setup the environment variables to allow the rest of knowledgePortal to function
	 * more easily.
	 *
	 * @since 2.0.0 knowledgePortal (r2626)
	 *
	 * @access private
	 */
	private function setup_environment() {

		/** Versions **********************************************************/

		$this->version    = '1.0.0';
		$this->db_version = '1';

		/** Paths *************************************************************/

		// File & base
		$this->file         = __FILE__;
		$this->basename     = apply_filters( 'kp_plugin_basename', str_replace( array( 'build/', 'src/' ), '', plugin_basename( $this->file ) ) );
		$this->basepath     = apply_filters( 'kp_plugin_basepath', trailingslashit( dirname( $this->basename ) ) );

		// Path and URL
		$this->plugin_dir   = apply_filters( 'kp_plugin_dir_path', plugin_dir_path( $this->file ) );
		$this->plugin_url   = apply_filters( 'kp_plugin_dir_url',  plugin_dir_url ( $this->file ) );

		// Includes
		$this->includes_dir = apply_filters( 'kp_includes_dir', trailingslashit( $this->plugin_dir . 'includes'  ) );
		$this->includes_url = apply_filters( 'kp_includes_url', trailingslashit( $this->plugin_url . 'includes'  ) );

		// Templates
		$this->themes_dir   = apply_filters( 'kp_themes_dir',   trailingslashit( $this->plugin_dir . 'templates' ) );
		$this->themes_url   = apply_filters( 'kp_themes_url',   trailingslashit( $this->plugin_url . 'templates' ) );
	}

    /**
	 * Smart defaults to many knowledgePortal specific class variables.
	 *
	 * @since 1.0.0 knowledgePortal (r6330)
	 */
	private function setup_variables() {

	}

    
	/**
	 * Include required files
	 *
	 * @since 1.0.0 knowledgePortal (r1616)
	 *
	 * @access private
	 */
	private function includes() {
         
        require plugin_dir_path(__FILE__) . '/includes/kp-registerposttype.php';
        require plugin_dir_path(__FILE__) . '/templates/dashboard.php';
	}

	/**
	 * Setup the default hooks and actions
	 *
	 * @since 1.0.0 knowledgePortal (r2644)
	 *
	 * @access private
	 */
	private function setup_actions() {
		
        /**
         * Initializing required custom post type and taxonomy
         * Function located in kp-registerposttype in includes
         */
        add_action('init', 'ncs4_knowledgeportal_register_post_type');
        add_action( 'init', 'ncs4_knowledgeportal_register_taxonomy' );

        /**
         * Initializing required meta boxes for the custom post type Knowledge Portal Entries 
         * Function located in kp-registerposttype in includes
         */
        add_action( 'admin_init', 'ncs4_add_post_meta_boxes' );
        add_action( 'save_post', 'ncs4_save_post_meta_boxes' );

        /**
         * Creating shortcode so that the perotal can be displayed anywhere in the site
         * Function located in the dashboard.php file in templates
         */
        add_shortcode('ncs4-knowledgeportal-entries-list', 'ncs4_knowledgeportal_entires');
	}


}


/**
 * The main function responsible for returning the one true knowledgePortal Instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $kp = knowledgePortal(); ?>
 *
 * @since 2.0.0 knowledgePortal (r2464)
 *
 * @return knowledgePortal The one true knowledgePortal Instance
 */
function knowledgeportal() {
	return knowledgePortal::instance();
}

knowledgeportal();

endif;