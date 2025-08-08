<?php	
	// Set post nonce
	wp_nonce_field('vision_elite_testimonial_nonce', 'vision_elite_testimonial_nonce');
	// Get post meta data
	$testimonial_name = get_post_meta( $post->ID, 'testimonial_name', true );
	$testimonial_league = get_post_meta( $post->ID, 'testimonial_league', true );
	$testimonial_testimony = get_post_meta( $post->ID, 'testimonial_testimony', true );
	$testimonial_rating = get_post_meta( $post->ID, 'testimonial_rating', true );
	$testimonial_image = get_post_meta( $post->ID, 'testimonial_image', true );
?>

<div class="frame">
	<label for="testimonial_image">Image</label>
	<figure class="figure">
		<img src="<?= $testimonial_image ?>" />
		<input type="hidden" id="testimonial_image" name="testimonial_image" value="<?= esc_attr($testimonial_image) ?>" />
		<?=($testimonial_image ? '<a class="remove_image">Remove Image</a>' : '')?>
	</figure>

	<label for="testimonial_name">Name</label>
	<input type="text" id="testimonial_name" name="testimonial_name" value="<?= esc_attr($testimonial_name) ?>" />

	<label for="testimonial_league">League</label>
	<input type="text" id="testimonial_league" name="testimonial_league" value="<?= esc_attr($testimonial_league) ?>" />

	<label for="testimonial_rating">Rating</label>
	<input type="number" id="testimonial_rating" name="testimonial_rating" value="<?= esc_attr($testimonial_rating) ?>" min="0" max="5" step="1" />

	<label for="testimonial_testimony">Testimony</label>
	<?php
	 wp_editor($testimonial_testimony, 'testimonial_testimony', array(
		'textarea_name' => 'testimonial_testimony',
		'media_buttons' => false,
		'teeny' => true,
		'textarea_rows' => 5,
		'quicktags' => false,
	));
	?>

</div>