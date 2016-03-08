<?php
/*
	Plugin Name: Angular Zen
	Plugin URI: https://profiles.wordpress.org/jsulz
	Description: A plugin that combines the functionality of searching Zendesk's Help Center and submitting tickets via an API request while utilizing Angular for most of the heavy lifting.
	Author: Jared Sulzdorf
	Version: 1.0
	Author URI: https://profiles.wordpress.org/jsulz
 */
	
// Peace out if you're trying to access this up front
if( ! defined( 'ABSPATH' ) ) exit;

//If this class don't exist, make it so
if( ! class_exists( 'ANGULAR_ZEN' ) ) {

	class ANGULAR_ZEN {

		private static $instance;

			//the magic
	        public static function instance() {

	            if( ! self::$instance ) {

	                self::$instance = new ANGULAR_ZEN( );
	                self::$instance->plugin_constants( );
	                self::$instance->plugin_requires( );

	            }

	            return self::$instance;

	        }

	    //the constants (folders and such)
		public function plugin_constants() {

			define( 'AZ_FOLDER', plugin_dir_path( __FILE__ ) );
			define( 'AZ_LOCAL_ASSETS', plugin_dir_url( __FILE__ ) );
			define( 'AZ_INC', trailingslashit( AZ_FOLDER . 'inc' ) );
			define( 'AZ_CSS', trailingslashit( AZ_LOCAL_ASSETS . 'css' ) );
			define( 'AZ_JS', trailingslashit( AZ_LOCAL_ASSETS . 'js' ) );
			define( 'AZ_ADMIN', trailingslashit( AZ_FOLDER . 'admin' ) );
			define( 'AZ_SETTINGS_PAGE', AZ_ADMIN . 'settings_page.php' );
			define( 'AZ_POST_META_BOX', AZ_ADMIN . 'post_meta_box.php' );
			define( 'AZ_API_CLIENT', AZ_INC . 'client.php' );
			define( 'AZ_SCRIPTS', AZ_INC . 'scripts.php' );
			define( 'AZ_DASHBOARD', AZ_INC . 'dashboard_widget.php');

		}

		//the files
		public function plugin_requires() {

			require( AZ_SCRIPTS ) ;
			require( AZ_API_CLIENT );
			require( AZ_SETTINGS_PAGE );
			require( AZ_POST_META_BOX );
			require( AZ_DASHBOARD );
			//require( AZ_CUSTOM_FIELDS );

		}
		//in case someone wants to translate stuff 
		//Need to refactor as I might need to load this differently similar to load_all_scripts()
		public function az_load_plugin_textdomain() {

	    	load_plugin_textdomain( 'az-domain', FALSE, dirname( AZ_basename( __FILE__ ) ) . '/languages/' );

		}
		
	}

}

//get this show on the road
function angular_zen() {

    return ANGULAR_ZEN::instance( );
    
}

//Check to see if this can be done differently 
add_action( 'plugins_loaded', 'angular_zen' );

?>