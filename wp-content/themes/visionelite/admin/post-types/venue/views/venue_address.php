<?php	
	// Set post nonce
	wp_nonce_field('volleyball_network_venue_nonce', 'volleyball_network_venue_nonce');
	// Get post meta data
	$venue_address  	= get_post_meta( $post->ID, 'venue_address', true );
	$venue_city		  	= get_post_meta( $post->ID, 'venue_city', true );
	$venue_province  	= get_post_meta( $post->ID, 'venue_province', true );
	$venue_postal_code	= get_post_meta( $post->ID, 'venue_postal_code', true );
?>

<div class="frame">
	<label for="venue_address">Street Address</label>
	<input type="text" id="venue_address" name="venue_address" value="<?=$venue_address?>" />

	<label for="venue_city">City</label>
 	<input type="text" id="venue_city" name="venue_city" value="<?=$venue_city?>" />

	<label for="venue_province">Province</label>
	<select id="venue_province" name="venue_province">
		<option value="">Select Province</option>
		<?php
			$provinces = array(
				'AB' => 'Alberta',
				'BC' => 'British Columbia',
				'MB' => 'Manitoba',
				'NB' => 'New Brunswick',
				'NL' => 'Newfoundland and Labrador',
				'NS' => 'Nova Scotia',
				'ON' => 'Ontario',
				'PE' => 'Prince Edward Island',
				'QC' => 'Quebec',
				'SK' => 'Saskatchewan'
			);
			foreach ($provinces as $code => $name) {
				$selected = ($venue_province == $code) ? 'selected' : '';
				echo "<option value='$code' $selected>$name</option>";
			}
		?>
	</select>
	
	<label for="venue_postal_code">Postal Code</label>
	<input type="text" id="venue_postal_code" name="venue_postal_code" value="<?=$venue_postal_code?>" />
</div>