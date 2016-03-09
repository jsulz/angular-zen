<?php 
/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */

function az_register_dashboard_widget() {

	return new ANGULAR_ZEN_DASHBOARD_WIDGET();

}

add_action( 'init', 'az_register_dashboard_widget' );

class ANGULAR_ZEN_DASHBOARD_WIDGET {

	function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'az_add_dashboard_widgets') );
	}

	function az_add_dashboard_widgets() {

		wp_add_dashboard_widget(
	                 'az_dashboard_widget',         // Widget slug.
	                 'Angular Dashboard Widget',         // Title.
	                 array( $this, 'az_dashboard_widget_function' ) // Display function.
	        );	
	}

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function az_dashboard_widget_function() {

		// Display whatever it is you want to show.
		?>
			<div ng-app="azApp">
				<div ng-controller="azHelpCenter">
					<input id="input" type="text">
					<ul ng-repeat="answer in answers">	
						<li>{{ answer.title }}</li>
					</ul>
				</div>
			</div>


		<?php
	}

}

?>