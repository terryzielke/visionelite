<?php
/*
Template Name: SUb-Site Front Page
*/
get_header();

// get the subsite root URL
$subsite_root_url = get_bloginfo('url');
// get the subsite metafields site_province, site_city, and site_sport
$site_province = get_blog_option(get_current_blog_id(), 'site_province', '');
$site_city = get_blog_option(get_current_blog_id(), 'site_city', '');
$site_sport = get_blog_option(get_current_blog_id(), 'site_sport', '');
?>

<section id="subsite-top-section" class="template-section province-<?= strtolower($site_province) ?> sport-<?= strtolower($site_sport) ?>">
	<figure class="sport-image">
		<img src="<?=get_template_directory_uri()?>/assets/img/sports/banner-volleyball.png" alt="<?=$site_sport?>" />
	</figure>
	<div class="overlay">
		<div class="container">
			<div class="content">
				<h1><?=get_bloginfo('name')?></h1>
			</div>
		</div>
	</div>
</section>

<section id="subsite-programs-section" class="template-section">
	<div class="container">
		<div class="content">
			<h3><?=$site_sport.' Programs In '.$site_city?></h3>
			<p>Explore our sports programs and find the right fit to grow as an athlete.</p>
		</div>
		<div class="programs row gx-5 equal-height-items">
		<?php
		$available_programs = array();
		// get all sessions for the current blog
		$session_args = array(
			'post_type' => 'session',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$sessions = get_posts($session_args);
		if ($sessions) {
			foreach ($sessions as $session) {
				// get the session's league
				$session_program = get_post_meta($session->ID, 'session_program', true);
				// if the session_program is not empty, add it to the available_programs array
				if (!empty($session_program)) {
					// check if the program is already in the array
					if (!in_array($session_program, $available_programs)) {
						// add the program to the array
						$available_programs[] = $session_program;
					}
					else {
						// if the program is already in the array, continue to the next session
						continue;
					}
				}
			}
		}
		if (!empty($available_programs)) {
			foreach ($available_programs as $program_id) {
				if(is_multisite()){
					switch_to_blog(1);
				}
				$program = get_post($program_id);
				if ($program) {
					$program_image = get_the_post_thumbnail_url($program->ID, 'full');
					// get program_excerpt meta field
					$program_excerpt = get_post_meta($program->ID, 'program_excerpt', true);
					$program_slug = $program->post_name;
					echo '<div class="col col-12 col-md-6 col-lg-4">
							<a href="'. $subsite_root_url . '/program/' . $program_slug . '/?name='.$program_slug.'" class="program-item item">
								<figure class="image-background">
									<img src="' . esc_url($program_image) . '" alt="' . esc_attr($program->post_title) . '" />
								</figure>
								<div class="program-info">
									<h4>' . esc_html($program->post_title) . '</h4>
									'.($program_excerpt ? wpautop($program_excerpt) : '').'
								</div>
							</a>
						</div>';
				}
				if(is_multisite()){
					restore_current_blog();
				}
			}
		} else {
			echo '<p>No programs available at this time.</p>';
		}
		?>
		</div>
	</div>
</section>

<section id="subsite-events-section" class="template-section">
	<div class="container">
			<?php
			// Get the event post for the current blog where the event_start_date is today or in the future
			$event_args = array(
				'post_type' => 'event',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'meta_value',
				'order' => 'ASC'
			);
			$events = get_posts($event_args);
			if ($events) {
				echo '<div class="events row gx-5"><div class="col col-12"><div id="event-slider">';
				foreach ($events as $event) {
					$banner_image = get_post_meta( $post->ID, 'banner_image', true );
					$event_title = get_the_title($event->ID);
					$event_link = get_permalink($event->ID);
					$event_start_date = get_post_meta($event->ID, 'event_start_date', true);
					$event_end_date = get_post_meta($event->ID, 'event_end_date', true);
					$event_start_time = get_post_meta($event->ID, 'event_start_time', true);
					$event_end_time = get_post_meta($event->ID, 'event_end_time', true);
					// time includes AM/PM, so we can use it directly
					$start_time = date('g:i A', strtotime($event_start_time));
					$end_time = date('g:i A', strtotime($event_end_time));
					$event_slug = $event->post_name;
					$banner_image = get_post_meta( $event->ID, 'banner_image', true );
					$banner_description = get_post_meta( $event->ID, 'banner_description', true );
					$banner_btn_text = get_post_meta( $event->ID, 'banner_btn_text', true );
					$banner_btn_link = get_post_meta( $event->ID, 'banner_btn_link', true );
					$event_description = wpautop(get_post_meta($event->ID, 'event_description', true));

					// if date check is in the past, skip this event
					$event_date_check = $event_end_date ? strtotime($event_end_date) : strtotime($event_start_date);
					if ($event_date_check < time()) {
						continue;
					}

					// get the event venue
					$event_venue = get_post_meta($event->ID, 'event_venue', true);
					// get venue province, city, and postal code
					if (is_multisite()) {
						switch_to_blog(1);
					}
					$event_venue_address = get_post_meta($event_venue, 'venue_address', true);
					$event_venue_province = get_post_meta($event_venue, 'venue_province', true);
					$event_venue_city = get_post_meta($event_venue, 'venue_city', true);
					$event_venue_postal_code = get_post_meta($event_venue, 'venue_postal_code', true);
					if (is_multisite()) {
						restore_current_blog();
					}
					echo '<div class="event-item">
							<div class="event-banner">
								<figure class="image-background" style=" background-image: url('.$banner_image.');"></figure>
								<div class="content">
									<div class="display-text">
										<h2>'.$event_title.'</h2>
										'.($banner_description ? '<p>'.$banner_description.'</p>' : '').'
										'.($banner_btn_link ? '<p><a href="'.$banner_btn_link.'" target="_blank" class="btn button orange darkblue-txt">'.$banner_btn_text.'</a></p>' : '').'
									</div>
									<div class="caption-text">
										<div class="address">
											'.($event_venue ? '<p>'.$event_venue_address.'<br>'.$event_venue_city.' '.$event_venue_province.', '.$event_venue_postal_code.'</p>' : '').'
										</div>
										<div class="date-time">
											<p class="event-date">'.($event_start_date ? date('F j, Y', strtotime($event_start_date)).'<br>' : '').
											($event_start_time ? '<span class="event-start-time">'.$start_time.'</span>' : '').
											($event_end_time ? ' - <span class="event-end-time">'.$end_time.'</span>' : '').'</p>
										</div>
									</div>
								</div>
							</div>
							<div class="event-description">
								<div class="content">
									<div class="description">
										'.$event_description.'
										<p style="margin: 40px 0 0;"><a href="'.$event_link.'" class="btn button blue">More Details</a></p>
									</div>
								</div>
							</div>
						</div>';
				}
				echo '</div></div></div>';
			} else {
				echo '<h3>No Upcoming Events</h3>';
				echo '<p>There are no upcoming events at this time.</p>';
			}
			?>
	</div>
</section>

<section id="subsite-coaches-section" class="template-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12">
					<center>
						<h3>Meet Our Coaches</h3>
						<p>Meet our experienced coaches—dedicated to helping every athlete reach their full potential.</p>
					</center>
				</div>
			</div>
			<div class="coachs row gx-5">
				<?php
				// Get all coaches for the current blog
				$coach_args = array(
					'post_type' => 'coach',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'ASC',
				);
				$coaches = get_posts($coach_args);
				if ($coaches) {
					foreach ($coaches as $coach) {
						$coach_image = get_post_meta($coach->ID, 'coach_image', true);
						$coach_name = get_the_title($coach->ID);
						$coach_position = get_post_meta($coach->ID, 'coach_position', true);
						$coach_slug = $coach->post_name;
						echo '<div class="col">
								<a href="' . $subsite_root_url . '/coach/' . $coach_slug . '" class="coach-item item">
									<figure class="coach-image">
										<img src="' . esc_url($coach_image) . '" alt="' . esc_attr($coach_name) . '" />
									</figure>
									<div class="coach-info">
										<h4 class="dark">' . esc_html($coach_name) . '</h4>
										<h4 class="orange">' . esc_html($coach_position) . '</h4>
									</div>
								</a>
							</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>