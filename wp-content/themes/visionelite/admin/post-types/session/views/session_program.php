<?php	
	// Set post nonce
	wp_nonce_field('volleyball_network_session_nonce', 'volleyball_network_session_nonce');
	// Get post meta data
	$session_program = get_post_meta( $post->ID, 'session_program', true );
	$session_sport = get_post_meta( $post->ID, 'session_sport', true );
	$session_season = get_post_meta( $post->ID, 'session_season', true );
	$session_venue = get_post_meta( $post->ID, 'session_venue', true );
	$session_registration = get_post_meta( $post->ID, 'session_registration', true );
	$session_remaining_spots = get_post_meta( $post->ID, 'session_remaining_spots', true );
	$session_price = get_post_meta( $post->ID, 'session_price', true );
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

	<table>
		<tr>
			<td>
				<label for="session_program">Program Type:</label>
				<select name="session_program" id="session_program">
					<option value="">--</option>
					<?php
						// if is multisite
						if (is_multisite()) {
							// get the current site ID
							$current_site_id = get_current_blog_id();
							// get the site ID of the first site
							$first_site_id = 1; // Assuming site 1 is the first site
							// switch to the first site
							switch_to_blog($first_site_id);
							// get the programs from site 1
							$program_args = array(
								'post_type' => 'program',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);
							$programs = get_posts($program_args);
							// switch back to the current site
							restore_current_blog();
							foreach ($programs as $program) {
								$selected = $session_program == $program->ID ? 'selected' : '';
								echo '<option value="' . $program->ID . '" ' . $selected . '>' . $program->post_title . '</option>';
							}
						} else {
							// if not multisite, get the programs from the current site
							$program_args = array(
								'post_type' => 'program',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);
							$programs = get_posts($program_args);
							foreach ($programs as $program) {
								$selected = $session_program == $program->ID ? 'selected' : '';
								echo '<option value="' . $program->ID . '" ' . $selected . '>' . $program->post_title . '</option>';
							}
						}
					?>
				</select>
			</td>
			<td>
				<label for="session_sport">Sport:</label>
				<?php

					// Get all sports
					$sports = get_posts([
						'post_type' => 'activity',
						'status' => 'publish',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'posts_per_page' => -1,
					]);
					$sports_options = '';
					foreach ($sports as $sport) {
						$selected = $session_sport == $sport->ID ? 'selected' : '';
						$sports_options .= '<option value="' . $sport->ID . '" ' . $selected . '>' . $sport->post_title . '</option>';
					}
				?>
				<select name="session_sport" id="session_sport">
					<option value="">--</option>
					<?= $sports_options ?>
				</select>
			</td>
		</tr>
	</table>

	<label for="session_season">Season</label>
	<select name="session_season" id="session_season" season="<?= $session_season ?>">
		<option value="winter" <?=($session_season == 'winter' ? ' selected="selected"' : '')?> >Winter</option>
		<option value="spring" <?=($session_season == 'spring' ? ' selected="selected"' : '')?> >Spring</option>
		<option value="summer" <?=($session_season == 'summer' ? ' selected="selected"' : '')?> >Summer</option>
		<option value="fall" <?=($session_season == 'fall' ? ' selected="selected"' : '')?> >Fall</option>
	</select>

	<input type="hidden" name="session_venue" id="session_venue" value="<?= $session_venue ?>">
	<table>
		<tr>
			<td>
				<label for="session_local_venue"><?=$site_city?> Venues</label>
				<select id="session_local_venue">
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
							$selected = $session_venue == $venue->ID ? 'selected' : '';
							echo '<option value="' . $venue->ID . '" ' . $selected . '>' . $venue->post_title . '</option>';
						}
					?>
				</select>
			</td>
			<td>
				<label for="session_outside_venue">Venues Outside <?=$site_city?></label>
				<select id="session_outside_venue">
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
							$selected = $session_venue == $venue->ID ? 'selected' : '';
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
	
	<label for="session_registration">Registration URL</label>
	<input type="text" name="session_registration" id="session_registration" value="<?= $session_registration ?>" placeholder="https://">

	<label for="session_remaining_spots">Remaining Spots</label>
	<input type="number" name="session_remaining_spots" id="session_remaining_spots" value="<?= get_post_meta( $post->ID, 'session_remaining_spots', true ) ?>" placeholder="0" min="0">

	<label for="session_price">Price</label>
	<input type="text" name="session_price" id="session_price" value="<?= $session_price ?>" placeholder="$0.00">
</div>