<?php	
	// Set post nonce
	wp_nonce_field('volleyball_network_coach_nonce', 'volleyball_network_coach_nonce');
	// Get post meta data
	$coach_image = get_post_meta( $post->ID, 'coach_image', true );
	$coach_firstname = get_post_meta( $post->ID, 'coach_firstname', true );
	$coach_lastname = get_post_meta( $post->ID, 'coach_lastname', true );
	$coach_position = get_post_meta( $post->ID, 'coach_position', true );
	$caoch_bio = wpautop(get_post_meta( $post->ID, 'coach_bio', true ));
	$coach_phone = get_post_meta( $post->ID, 'coach_phone', true );
	$coach_email = get_post_meta( $post->ID, 'coach_email', true );
?>

<div class="frame">

	<label for="coach_image">Coach Image</label>
    <figure class="figure">
        <img src="<?= $coach_image ?>" />
        <input type="hidden" id="coach_image" name="coach_image" value="<?=$coach_image?>" />
    </figure>
    <?=($coach_image ? '<a id="remove_image">Remove Image</a>' : '')?>

	<table>
		<tr>
			<td>
				<label for="coach_firstname">First Name</label>
				<input type="text" name="coach_firstname" id="coach_firstname" value="<?= $coach_firstname ?>" />
			</td>
			<td>
				<label for="coach_lastname">Last Name</label>
				<input type="text" name="coach_lastname" id="coach_lastname" value="<?= $coach_lastname ?>" />
			</td>
		</tr>
	</table>

	<label for="coach_position">Position</label>
	<input type="text" name="coach_position" id="coach_position" value="<?= $coach_position ?>" />

	<label for="coach_bio">Coach Bio</label>
	<?php
		wp_editor( $caoch_bio, 'coach_bio', array(
			'textarea_name' => 'coach_bio',
			'media_buttons' => false,
			'textarea_rows' => 5,
			'teeny' => true,
			'quicktags' => false,
		) );
	?>

	<label for="coach_phone">Phone</label>
	<input type="text" name="coach_phone" id="coach_phone" value="<?= $coach_phone ?>" />

	<label for="coach_email">Email</label>
	<input type="email" name="coach_email" id="coach_email" value="<?= $coach_email ?>" />
	
</div>