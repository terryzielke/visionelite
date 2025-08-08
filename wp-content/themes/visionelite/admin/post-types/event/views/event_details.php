<?php	
	// Set post nonce
	wp_nonce_field('volleyball_network_event_nonce', 'volleyball_network_event_nonce');
	// Get post meta data
	$event_venue = get_post_meta( $post->ID, 'event_venue', true );
	$event_price = get_post_meta( $post->ID, 'event_price', true );
	$event_description = wpautop(get_post_meta( $post->ID, 'event_description', true ));
	// get curernt site option site_city
	$site_city = get_option('site_city');
?>
<style>
	.frame #toggle_add_venue{
		cursor: pointer;
		font-weight: bold;
	}
	.frame #add_venue_wrapper{
		margin: 20px;
		padding: 20px;
		border: 1px solid #ccc;
		border-radius: 10px;
		background-color: #f9f9f9;
	}
	.frame #add_venue_wrapper:not(.show-form){
		display: none !important;
	}
	.frame #add_venue_form label:first-child{
		margin-top: 0;
	}
	.frame #add_venue_form a#add_venue_button{
		margin-top: 20px;
	}
</style>

<div class="frame">

	<input type="hidden" name="event_venue" id="event_venue" value="<?= $event_venue ?>">
	<table>
		<tr>
			<td>
				<label for="event_local_venue"><?=$site_city?> Venues</label>
				<select id="event_local_venue">
					<option value="">--</option>
					<?php
						$venues;
						// get all venues where the venue_city field matches the site_city option
						$venue_args = array(
							'post_type' => 'venue',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => 'venue_city',
									'value' => $site_city,
									'compare' => '='
								)
							)
						);
						// if is multisite
						if (is_multisite()) {
							// get the current site ID
							$current_site_id = get_current_blog_id();
							// get the site ID of the first site
							$first_site_id = 1; // Assuming site 1 is the first site
							// switch to the first site
							switch_to_blog($first_site_id);
							// get the venues from site 1
							$venues = get_posts($venue_args);
							// switch back to the current site
							restore_current_blog();
						} else {
							// if not multisite, get the venues from the current site
							$venues = get_posts($venue_args);
						}
						foreach ($venues as $venue) {
							$selected = $event_venue == $venue->ID ? 'selected' : '';
							echo '<option value="' . $venue->ID . '" ' . $selected . '>' . $venue->post_title . '</option>';
						}
					?>
				</select>
			</td>
			<td>
				<label for="event_outside_venue">Venues Outside <?=$site_city?></label>
				<select id="event_outside_venue">
					<option value="">--</option>
					<?php
						// get all venues where the venue_city field does not match the site_city option
						$venue_args = array(
							'post_type' => 'venue',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => 'venue_city',
									'value' => $site_city,
									'compare' => '!='
								)
							)
						);
						// if is multisite
						if (is_multisite()) {
							// get the current site ID
							$current_site_id = get_current_blog_id();
							// get the site ID of the first site
							$first_site_id = 1; // Assuming site 1 is the first site
							// switch to the first site
							switch_to_blog($first_site_id);
							// get the venues from site 1
							$venues = get_posts($venue_args);
							// switch back to the current site
							restore_current_blog();
						} else {
							// if not multisite, get the venues from the current site
							$venues = get_posts($venue_args);
						}
						foreach ($venues as $venue) {
							$selected = $event_venue == $venue->ID ? 'selected' : '';
							echo '<option value="' . $venue->ID . '" ' . $selected . '>' . $venue->post_title . '</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<sub>Can't find your venue? <a id="toggle_add_venue">Add a new venue</a></sub>
	<div id="add_venue_wrapper">
		<div id="add_venue_form">
			<label for="new_venue_name">New Venue Name</label>
			<input type="text" id="new_venue_name" name="new_venue_name">

			<label for="new_venue_address">Street Address</label>
			<input type="text" id="new_venue_address"  name="new_venue_address">

			<label for="new_venue_city">City</label>
			<input type="text" id="new_venue_city" name="new_venue_city">

			<label for="new_venue_province">Province</label>
			<select id="new_venue_province" name="new_venue_province">
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
						echo "<option value='$code'>$name</option>";
					}
				?>
			</select>

			<label for="new_venue_postal_code">Postal Code</label>
			<input type="text" id="new_venue_postal_code" name="new_venue_postal_code">

			<a class="button button-primary" id="add_venue_button" data-site-city="<?=$site_city?>">Add Venue</a>
		</div>
	</div>
	<label for="event_price">Price</label>
	<input type="text" name="event_price" id="event_price" value="<?= $event_price ?>" placeholder="$0.00">

    <label for="event_description">Description</label>
    <?php
        wp_editor($event_description, 'event_description', array(
            'textarea_name' => 'event_description',
            'media_buttons' => false,
            'teeny' => true,
            'textarea_rows' => 5,
            'quicktags' => false,
            'wpautop' => true,
        ));
    ?>
</div>