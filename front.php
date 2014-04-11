<?php
function itv_read_time() {
	echo "<span class=\"read_time\">";
	global $post;
	$read_time_value = esc_attr(get_post_meta($post->ID, "itv_read_time_value", true));
	if ($read_time_value > 0) {
		$read_time = "<img class=\"clock_image\" src=\"" . plugins_url('/res/clock.svg', __FILE__) . "\" /> {$read_time_value} minute estimated read";
		echo $read_time;
	};
	echo "</span>";
};
?>