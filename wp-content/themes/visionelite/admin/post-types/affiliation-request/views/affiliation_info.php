<?php	
	// Set post nonce
	wp_nonce_field('vision_elite_affiliation_nonce', 'vision_elite_affiliation_nonce');
	// Get post meta data
	$affiliation_firstname = get_post_meta( $post->ID, 'affiliation_firstname', true );
	$affiliation_lastname = get_post_meta( $post->ID, 'affiliation_lastname', true );
	$affiliation_position = get_post_meta( $post->ID, 'affiliation_position', true );
	$affiliation_bio = wpautop(get_post_meta( $post->ID, 'affiliation_bio', true ));
	$affiliation_phone = get_post_meta( $post->ID, 'affiliation_phone', true );
	$affiliation_email = get_post_meta( $post->ID, 'affiliation_email', true );
	$prefered_contact_method = get_post_meta( $post->ID, 'prefered_contact_method', true );
	$prefered_contact_time = get_post_meta( $post->ID, 'prefered_contact_time', true );
	$affiliation_province = get_post_meta( $post->ID, 'affiliation_province', true );
	$affiliation_city = get_post_meta( $post->ID, 'affiliation_city', true ); 
	$affiliation_sport = get_post_meta( $post->ID, 'affiliation_sport', true );
?>

<div class="frame">

	<table>
		<tr>
			<td>
				<label for="affiliation_firstname">First Name</label>
				<input type="text" name="affiliation_firstname" id="affiliation_firstname" value="<?= $affiliation_firstname ?>" />
			</td>
			<td>
				<label for="affiliation_lastname">Last Name</label>
				<input type="text" name="affiliation_lastname" id="affiliation_lastname" value="<?= $affiliation_lastname ?>" />
			</td>
		</tr>
	</table>

	<label for="affiliation_position">Position</label>
	<input type="text" name="affiliation_position" id="affiliation_position" value="<?= $affiliation_position ?>" />

	<label for="affiliation_bio">affiliation Bio</label>
	<?php
		wp_editor( $affiliation_bio, 'affiliation_bio', array(
			'textarea_name' => 'affiliation_bio',
			'media_buttons' => false,
			'textarea_rows' => 5,
			'teeny' => true,
			'quicktags' => false,
		) );
	?>

	<table>
		<tr>
			<td>
				<label for="affiliation_phone">Phone</label>
				<input type="text" name="affiliation_phone" id="affiliation_phone" value="<?= $affiliation_phone ?>" />
			</td>
			<td>
				<label for="affiliation_email">Email</label>
				<input type="email" name="affiliation_email" id="affiliation_email" value="<?= $affiliation_email ?>" />
			</td>
		</tr>
	</table>

	<label for="prefered_contact_method">Prefered Contact Method</label>
	<select name="prefered_contact_method" id="prefered_contact_method">
		<option value="email" <?= $prefered_contact_method == 'email' ? 'selected' : '' ?>>Email</option>
		<option value="phone" <?= $prefered_contact_method == 'phone' ? 'selected' : '' ?>>Phone</option>
		<option value="text" <?= $prefered_contact_method == 'text' ? 'selected' : '' ?>>Text</option>
	</select>

	<label for="prefered_contact_time">Prefered Contact Time</label>
	<input type="text" name="prefered_contact_time" id="prefered_contact_time" value="<?= $prefered_contact_time ?>" />

	<div class="break"></div>

	<table>
		<tr>
			<td>
				<label for="affiliation_province">Province</label>
				<input type="text" name="affiliation_province" id="affiliation_province" value="<?= $affiliation_province ?>" />
			</td>
			<td>
				<label for="affiliation_city">City</label>
				<input type="text" name="affiliation_city" id="affiliation_city" value="<?= $affiliation_city ?>" />
			</td>
		</tr>
	</table>

	<div class="break"></div>

	<label for="affiliation_sport">Sport</label>
	<input type="text" name="affiliation_sport" id="affiliation_sport" value="<?= $affiliation_sport ?>" />

</div>