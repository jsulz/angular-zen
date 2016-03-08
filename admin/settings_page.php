<?php
//boilerplate for single site settings page
//@todo - get logic for multisite!

function plugin_name_register_settings_page() {
	return new PLUGIN_SETTINGS_PAGE();
}

add_action('init', 'plugin_name_register_settings_page' );


class PLUGIN_SETTINGS_PAGE {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'plugin_settings_init') );
		add_action( 'network_admin_menu', array( $this, 'plugin_settings_menu') );
	}

	public function plugin_settings_menu() {

		add_options_page( 
			'Plugin Settings Page Title', 
			__( 'Plugin Menu Title', 'plugin-text-domain' ), 
			'edit_posts', 
			'plugin-boilerplate', 
			array( $this, 'plugin_options_page_callback')
			);

	}

	public function plugin_settings_init() {

		//register the settings group and the settings themselves
		register_setting( 'plugin-boilerplate', 'plugin_settings' );
		//create a settings section - there can be multiple settings sections, just make sure you attribute
		//the settings fields to the sections you want
		add_settings_section( 
			'settings-section-id', 
			__( 'Plugin Settings Section Title', 'plugin-text-domain'  ), 
			array( $this, 'settings_section_callback' ), 
			'plugin-boilerplate' );
		//create the settings fields, associate them with the required settings sections
		add_settings_field( 
			'settings-fields-id', 
			__('Settings Fields Title', 'plugin-text-domain' ), 
			array( $this, 'settings_field_callback' ), 
			'plugin-boilerplate', 
			'settings-section-id' );
		
	}

	public function settings_section_callback() {

			echo __('<p>If we want some explanatory text for this section, this is where we would put it</p>', 'plugin-text-domain');


	}

	public function settings_field_callback() {

		//just to make sure
		if ( !current_user_can( 'edit_posts' ) ) {
			$message = __( 'Sorry, you do not have sufficient permissions to edit this page', 'plugin-text-domain' );
			wp_die( $message );
		}

		$settings = (array) get_option('plugin_settings');

		if ( isset( $settings[ 'checkbox'] ) ) {
			$checkbox = $settings[ 'checkbox'];
		} else {
			$checkbox ='';
		}

		if ( isset( $settings[ 'radio_button'] ) ) {
			$radio_button = $settings['radio_button'];
		} else {
			$radio_button ='';
		}

		if ( isset( $settings[ 'textarea'] ) ) {
			$textarea = esc_textarea( $settings['textarea'] );
		} else {
			$textarea ='';
		}

		if ( isset( $settings[ 'input_field'] ) ) {
			$input_field = esc_attr( $settings['input_field'] );
		} else {
			$input_field ='';
		}

		if ( isset( $settings[ 'color'] ) ) {
			$color = esc_attr( $settings['color'] );
		} else {
			$color ='';
		}


		?>

		<p>
			<input type="checkbox" name="plugin_settings[checkbox]" value="1" <?php checked( $checkbox, 1 ); ?> />
		</p>
		<p>
			<fieldset>
				<input type="radio" id="value1" name="plugin_settings[radio_button]" value="Value 1" <?php checked( $radio_button, "Value 1" ); ?> />
				<label for="value1">Value 1</label>

				<input type="radio" id="value1" name="plugin_settings[radio_button]" value="Value 2" <?php checked( $radio_button, "Value 2" ); ?> />
				<label for="value2">Value 2</label>

				<input type="radio" id="value1" name="plugin_settings[radio_button]" value="Value 3" <?php checked( $radio_button, "Value 3" ); ?> />
				<label for="value2">Value 3</label>
			</fieldset>

		</p>
		<p>
			<input type="text" name="plugin_settings[input_field]" value="<?php echo $input_field; ?>" />
		</p>
		<p>
			<textarea name="plugin_settings[textarea]"><?php echo $textarea; ?></textarea>
		</p>
		<p>
			<input type="text" name='plugin_settings[color]' value="<?php echo $color; ?>" class="my-color-field" />
		</p>

		<?php

	}

	public function plugin_options_page_callback() {
		?>
		<div class='wrap'>

			<h2>Plugin Boilerplate Settings Page</h2>
			<form action='options.php' method='POST'>
				<?php 

					//output the settings fields using the settings group registered in register_settings
					settings_fields( 'plugin-boilerplate' );

				?>
				<?php 

					//output the settings sections using the options page slug to grab everything
					//can optionally include individual sections here if needed
					do_settings_sections( 'plugin-boilerplate' );

				?>
				<?php 

					//output the submit button for the <form> element
					submit_button( );

				?>
			</form>

		</div>
		<?php
	}

}

?>