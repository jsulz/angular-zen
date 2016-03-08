<?php
//boilerplate for single site settings page
//@todo - get logic for multisite!

function plugin_name_register_settings_page() {
	return new PLUGIN_SETTINGS_PAGE();
}

add_action('init', 'plugin_name_register_settings_page' );


class PLUGIN_SETTINGS_PAGE {

	public function __construct() {
		add_action( 'network_admin_menu', array( $this, 'plugin_settings_menu') );
	}

	public function plugin_settings_menu() {

		add_submenu_page(
			'settings.php',
			__('Angular Zen', 'az-domain'),
			__('Angular Zen', 'az-domain'),
			'manage_network',
			'angular-zen',
			array( $this, 'az_page_output')
		);

	}


	function az_page_output() {
	
	if ( ! is_network_admin() ) { return FALSE; }
	if ( ! is_super_admin() ) { return FALSE; }
	if( ! current_user_can( 'manage_network' ) ) { return FALSE; }

	$this->az_settings_updated();
	
		?>

			<div class="wrap">
		
				<?php

					if( isset( $_GET[ 'action' ] ) ) {

						if( $_GET[ 'action' ] == 'process' ) {

							$this->az_settings_update();

							$this->az_settings_redirect();

						}

					}

				?>
					
				<h2><?php _e('Angular Zen', 'az') ?></h2>
				
				<?php $this->az_settings_form(); ?>

			</div>

		<?php

	}

	function az_settings_update() {

		$az_hc = $_POST['az_hc'];

		if ( isset( $az_hc ) ) {
			update_option( 'az_hc', $az_hc );
		}

		$az_api = $_POST['az_api'];

		if ( isset( $az_api ) ) {
			update_option( 'az_api', $az_api );
		}

	}

	function az_settings_redirect() {

		$url = "settings.php?page=angular-zen&updated=true";

		$out = "
			<script>
				window.location='$url';
				console.log('$url');
			</script>
		";

		echo $out;

	}

	function az_settings_updated() {

		if ( ! isset( $_GET['updated'] ) ) { return FALSE; }
		
		$out = "<div id='message' class='updated fade'><p>Settings saved.</p></div>";
		
		echo $out;

	}

	function az_settings_form() {

		$az_hc = get_option( 'az_hc' );

		// The old version of this plugin used this string as a keyword to represent an empty value.
		
		$az_api = get_option( 'az_api' );

		$out = "
			<form method='post' action='settings.php?page=angular-zen&action=process'>
				
				<table class='form-table'>
					<tr>
						<th scope='row'>Zendesk Subdomain</th>
						<td><p> Hi </p>
							<input value='$az_hc' name='az_hc' type='text' class='widefat' placeholder='Enter the \"subdomain\" in subdomain.zendesk.com'>
						</td>
					</tr>
					<tr>
						<th scope='row'>Zendesk API Key</th>
						<td>
							<input value='$az_api' name='az_api' type='text' class='widefat' placeholder='Enter your API key'>
						</td>
					</tr>
				</table>
				
				<p class='submit'>
					<input type='submit' class='button button-primary' name='Submit' value='Save Changes'>
				</p>
				
			</form>

		";

		echo $out;

	}


}

?>