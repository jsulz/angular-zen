<?php 

	function az_load_admin_scripts() {

    	wp_enqueue_script( 'angular-core', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js',  array( 'jquery' ), '1.5', false );
		wp_enqueue_script( 'angular-resource', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-resource.js', array('angular-core'), '1.0', false );
		wp_enqueue_script( 'angular-app', AZ_JS . 'app.js', array('angular-core', 'angular-resource'), '0.1', false );
		wp_localize_script( 'angular-app', 'azOpt', array(

				'zdDomain'	 => get_option('az_hc'),
				'apiKey'	=> get_option('az_api')

			) );
		

	}

	add_action( 'admin_enqueue_scripts', 'az_load_admin_scripts' );

?>