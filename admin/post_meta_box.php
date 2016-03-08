<?php

function plugin_name_register_post_meta_box() {

	return new PLUGIN_POST_META_BOX();

}

add_action( 'admin_init', 'plugin_name_register_post_meta_box' );


class PLUGIN_POST_META_BOX {

	public function __construct() {

		add_action( 'add_meta_boxes', array( $this, 'register_post_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post_meta_box_values' ) );

	}

	public function register_post_meta_box() {

		add_meta_box( 'post-meta-box-id', 'Post Meta Box Callback', array( $this, 'post_meta_box_callback' ), 'post', 'normal' );

	}

	public function post_meta_box_callback() {

		global $post;

		$textval = get_post_meta( $post->ID, 'my_meta_box_text', true );

		//sure, ternary operators are great, but I *like* this structure
		if ( isset( $textval ) ) {
			$text = $textval;
		} else {
			$text = '';
		}

		//set the nonce field
		wp_nonce_field( 'post_meta_box_nonce', 'post_meta_box' );

		?>
			<p>This is the content that will appear in the post meta box.</p>
			<input type="text" class="widefat" name="my_meta_box_text" placeholder="Here are some settings" value="<?php echo $text ?>"/>

		<?php

	}

	public function save_post_meta_box_values( $post_id ) {

		// Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return false; }
	     
	    // if our nonce isn't there, or we can't verify it, bail
	    if( !isset( $_POST['post_meta_box'] ) || !wp_verify_nonce( $_POST['post_meta_box'], 'post_meta_box_nonce' ) ) { return false; }
	    
	    // Make sure your data is set before trying to save it
	    if( isset( $_POST['post_meta_box'] ) )
	        update_post_meta( $post_id, 'my_meta_box_text', wp_kses( $_POST['my_meta_box_text'] ) );

	}
}

?>