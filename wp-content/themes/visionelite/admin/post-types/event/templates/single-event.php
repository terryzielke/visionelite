<?php 
	get_header(); the_post(); 

	$banner_image = get_post_meta( $post->ID, 'banner_image', true );
    $banner_tagline = get_post_meta( $post->ID, 'banner_tagline', true );
    $banner_description = wpautop(get_post_meta( $post->ID, 'banner_description', true ));
    $banner_btn_text = get_post_meta( $post->ID, 'banner_btn_text', true );
    $banner_btn_link = get_post_meta( $post->ID, 'banner_btn_link', true );

	$event_venue = get_post_meta( $post->ID, 'event_venue', true );
	$event_price = get_post_meta( $post->ID, 'event_price', true );
	$event_description = wpautop(get_post_meta( $post->ID, 'event_description', true ));

    $event_start_date	= get_post_meta( $post->ID, 'event_start_date', true );
    $event_end_date	    = get_post_meta( $post->ID, 'event_end_date', true );
    $event_days		    = get_post_meta( $post->ID, 'event_days', true );
    $event_start_time	= get_post_meta( $post->ID, 'event_start_time', true );
    $event_end_time	    = get_post_meta( $post->ID, 'event_end_time', true );
	// time includes AM/PM, so we can use it directly
	$start_time = date('g:i A', strtotime($event_start_time));
	$end_time = date('g:i A', strtotime($event_end_time));
	// get start date month and day and no year
	$short_start_date = date('F j', strtotime($event_start_date));

	// Now get the venue and program titles from main site
	if (is_multisite()) {
		switch_to_blog(1);
	}
	$venue_title = get_the_title($event_venue);
	$venue_address = get_post_meta($event_venue, 'venue_address', true);
	$venue_city = get_post_meta($event_venue, 'venue_city', true);
	$venue_province = get_post_meta($event_venue, 'venue_province', true);
	$venue_postal_code = get_post_meta($event_venue, 'venue_postal_code', true);
	if (is_multisite()) {
		restore_current_blog();
	}
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<section id="event-banner-section" class="template-section">
	<figure class="image-background" style="background-image: url(<?=$banner_image?>);"></figure>
	<div class="overlay">
		<div class="display-text">
			<div class="container">
				<h1>
					<span class="white"><?=$venue_city.': '.$short_start_date?></span>
					<span class="orange"><?=get_the_title()?></span>
				</h1>
				<?=($banner_description ? '<div class="description">'.$banner_description.'</div>' : '')?>
				<?=($banner_btn_link ? '<a href="'.$banner_btn_link.'" class="btn orange darkblue-txt">'.$banner_btn_text.'</a>' : '')?>
			</div>
		</div>
		<div class="caption-text">
			<div class="container">
				<div class="row">
					<div class="col col-12 col-md-6">
						<p>
							<?=$venue_address?><br><?=$venue_city?>, <?=$venue_province?>. <?=$venue_postal_code?>
						</p>
					</div>
					<div class="col col-12 col-md-6">
						<p>
							<?=$event_start_date?><br><?=$start_time?><?=($end_time ? ' - '.$end_time : '')?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="event-description-section" class="page template-section">
	<div class="container">
		<div class="content">
				<div class="row">
				<div class="col col-12">
					<h3>About The Event</h3>
					<?= $event_description ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="event-details-section" class="template-section">
	<div class="container">
		<div class="content">
			<div class="row">
				<div class="col col-12 col-md-6">
					<h3>Event Details</h3>
					<?php if($venue_title): ?>
						<h5>Location</h5>
						<p>
							<strong><?=$venue_title?></strong>
							<br>
							<a href="https://www.google.com/maps/search/<?= urlencode("$venue_address $venue_city, $venue_province $venue_postal_code") ?>" target="_blank">
								<?=$venue_address?><br><?=$venue_city?>, <?=$venue_province?>. <?=$venue_postal_code?>
							</a>
						</p>
					<?php endif; ?>
					<?php
						if($event_days || $event_start_date || $event_start_time){
						echo '<h5>Schedule</h5>';
						echo ($event_days ? '<p><strong>Days:</strong> '. implode(', ', (array)$event_days) .'</p>' : '');
						echo ($event_start_date ? '<p><strong>Date:</strong> '. $event_start_date . ($event_end_date ? ' - '.$event_end_date : '') .'</p>' : '');
						echo ($event_start_time ? '<p><strong>Time:</strong> '. $event_start_time . ($event_end_time ? ' - '.$event_end_time : '') .'</p>' : '');
						}
					?>
					<?php if($event_price): ?>
						<h5>Detail</h5>
						<p><strong>Price:</strong> $<?= $event_price ?></p>
					<?php endif; ?>
				</div>
				<div class="col col-12 col-md-6">
					<?php if($venue_title): ?>
						<div class="map">
							<div id="leaflet-map"></div>
							<?php
								$city_name = strtok($venue_city, " ");
								$full_address = $venue_address . ', ' . $city_name . ', ' . $venue_postal_code;
								$geocodeUrl = "https://nominatim.openstreetmap.org/search?q=" . urlencode($full_address) . "&format=json&limit=1&email=your@email.com";

								$response = wp_remote_get($geocodeUrl);
								$data = json_decode(wp_remote_retrieve_body($response), true);

								if (!empty($data)) {
									$lat = $data[0]['lat'];
									$lon = $data[0]['lon'];

									echo "<script>
										document.addEventListener('DOMContentLoaded', function () {
											var map = L.map('leaflet-map').setView([$lat, $lon], 15);
											L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
												attribution: '&copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors'
											}).addTo(map);
											L.marker([$lat, $lon]).addTo(map)
												.bindPopup('{$venue_address}<br>{$city_name}, {$venue_postal_code}')
												.openPopup();
										});
									</script>";
								} else {
									echo '<p id="maperror">Map leaflet not available.</p>';
								}
								// Create a Google Maps link
								$encoded_address = urlencode($full_address);
								echo '<p><span><a href="https://www.google.com/maps/search/?api=1&query=' . $encoded_address . '" target="_blank" rel="noopener noreferrer">View on Google Maps</a></span></p>';
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>