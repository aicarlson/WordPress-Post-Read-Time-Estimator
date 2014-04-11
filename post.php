<?php
// Enqueue scripts once pluggable.php is ready.
add_action( 'wp_loaded', "itv_read_time_resources" );
// Enqueue scripts function
function itv_read_time_resources() {
  // Load our scripts, but only on the posts page!
  add_action('admin_enqueue_scripts', "itv_read_time_scripts");
  function itv_read_time_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
      wp_enqueue_script( "itv-read-time", plugins_url('/js/itv-read-time.js', __FILE__), array('jquery') );
    };
  };
};

// Register the post meta box.
add_action('add_meta_boxes', "itv_read_time_meta_box");
function itv_read_time_meta_box() {
	add_meta_box("itv_read_time_meta_box", "Estimated Read Time", "itv_read_time_meta_box_callback", 'post', 'side');
};

// Meta box callback function.
function itv_read_time_meta_box_callback($post) {
	wp_nonce_field("itv_read_time_nonce_action", "itv_read_time_meta_nonce");
  $default_value = get_post_meta($post->ID, "itv_read_time_value", true);
  if (!$default_value) {
    $default_value = 0;
  }
  echo "<p>Estimated read time: <span class=\"est_read_time\">{$default_value}</span> minutes</p>";
	echo "<input id=\"itv_read_time_value\" type=\"hidden\" name=\"itv_read_time_value\" value=\"{$default_value}\" />";
};

// Save the data... 
function itv_read_time_save_meta( $post_id ) {
  // Check for the nonce
  if ( ! isset( $_POST["itv_read_time_meta_nonce"] ) )
    return $post_id;
  $nonce = $_POST["itv_read_time_meta_nonce"];
  // Verify the nonce...
  if ( ! wp_verify_nonce( $nonce, "itv_read_time_nonce_action" ) )
      return $post_id;
  // Don't do anything on autosave
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
  // Check that the admin has permissions
  if ( 'page' == $_POST['post_type'] || 'post' == $_POST['post_type']) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  }
  // Sanitize user input. We only want integers and decimals
  $itv_read_time_to_save = $_POST["itv_read_time_value"];

  // Update the meta field in the database.
  update_post_meta( $post_id, "itv_read_time_value", $itv_read_time_to_save );
}
add_action( 'save_post', 'itv_read_time_save_meta' );
?>