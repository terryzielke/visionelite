<?php
/*
Template Name: Front Page
*/

// ON SUBMIT OF find_my_programs FORM
if (isset($_POST['find_my_programs'])) {
	$city = strtolower( str_replace(' ', '-', sanitize_text_field($_POST['my_city'])));
	$sport = strtolower( str_replace(' ', '-', sanitize_text_field($_POST['my_sport'])));
	// if is multisite
	if (is_multisite()) {
		// loop htrough all sites
		$sites = get_sites();
		$redirect_url = '';
		foreach ($sites as $site) {
			switch_to_blog($site->blog_id);
			$site_city = strtolower( str_replace(' ', '-', get_option('site_city')));
			$site_sport = strtolower( str_replace(' ', '-', get_option('site_sport')));
			if ($site_city === $city && $site_sport === $sport && !is_main_site()) {
				// Redirect to the front page of the site that matches the city and sport
				$redirect_url = home_url('/');
				restore_current_blog();
				break; // Exit the loop once we find a match
			}
			else {
				// Redirect to become an affiliate page if no match is found
				$redirect_url = '/affiliate/?city=' . urlencode($city) . '&sport=' . urlencode($sport);
			}
			restore_current_blog();
		}
	} else {
		// For single site, redirect to the program search page
		$redirect_url = home_url('/program-search/');
	}

	wp_safe_redirect($redirect_url);
	exit;
}

get_header();

// Template meta fields
$banner_image = get_post_meta( $post->ID, 'banner_image', true );
$banner_white_h1 = get_post_meta( $post->ID, 'banner_white_h1', true );
$banner_orange_h1 = get_post_meta( $post->ID, 'banner_orange_h1', true );
$banner_description = wpautop(get_post_meta( $post->ID, 'banner_description', true ));
$banner_btn_text = get_post_meta( $post->ID, 'banner_btn_text', true );
$banner_btn_link = get_post_meta( $post->ID, 'banner_btn_link', true );
$banner_caption_text = wpautop(get_post_meta( $post->ID, 'banner_caption_text', true ));

$cta_h2 = get_post_meta( $post->ID, 'cta_h2', true );
$cta_h3 = get_post_meta( $post->ID, 'cta_h3', true );
$cta_buttons_csv = get_post_meta( $post->ID, 'cta_buttons_csv', true );

$registration_banner_image = get_post_meta( $post->ID, 'registration_banner_image', true );
$registration_banner_h2 = get_post_meta( $post->ID, 'registration_banner_h2', true );
$registration_banner_h3 = get_post_meta( $post->ID, 'registration_banner_h3', true );
$registration_banner_btn_text = get_post_meta( $post->ID, 'registration_banner_btn_text', true );
$registration_banner_btn_link = get_post_meta( $post->ID, 'registration_banner_btn_link', true );
$registration_cta_csv = get_post_meta( $post->ID, 'registration_cta_csv', true );
?>
<section id="front-page-top-section" class="template-section">
	<?php /*
	<div class="video-background">
		<video autoplay loop muted playsinline>
			<source src="<?=get_template_directory_uri()?>/assets/video/IMG_5707.mp4" type="video/mp4">
		</video>
	</div>
	*/ ?>
	<figure class="image-background" style="background-image: url(<?=$banner_image?>);">
	</figure>
	<div class="overlay">
		<div class="display-text">
			<div class="container">
				<h1>
					<span class="white"><?=$banner_white_h1?></span>
					<span class="orange"><?=$banner_orange_h1?></span>
				</h1>
				<div class="description"><?=$banner_description?></div>
				<?=($banner_btn_link ? '<a href="'.$banner_btn_link.'" class="btn orange darkblue-txt">'.$banner_btn_text.'</a>' : '')?>
			</div>
		</div>
		<div class="caption-text">
			<div class="container">
				<?php
					if (get_bloginfo('name') == 'Vision Elite International') {
						echo '<div class="caption">'.$banner_caption_text.'</div>';
					}
					else{
						$user_province = get_user_province();
						if (empty($user_province)) {
							$user_province = 'all';
						}
						$user_city = get_user_city();
						if (empty($user_city)) {
							$user_city = 'all';
						}
						/*
						$sports = array(
							'volleyball'       => 'Volleyball',
							'pickleball'       => 'Pickleball',
							'basketball'       => 'Basketball',
							'soccer'           => 'Soccer',
							'football'         => 'Football',
							'hockey'           => 'Hockey',
							'baseball'         => 'Baseball',
							'softball'         => 'Softball',
							'rugby'            => 'Rugby',
							'lacrosse'         => 'Lacrosse',
							'tennis'           => 'Tennis',
							'golf'             => 'Golf',
							'swimming'         => 'Swimming',
							'track-and-field'  => 'Track and Field',
						);
						*/
						// get sports from sport post type
						$sports = get_posts( array(
							'post_type'      => 'activity',
							'posts_per_page' => -1,
				            'orderby' => 'menu_order',
				            'order' => 'ASC',
							'fields'         => 'ids', // Only get IDs to reduce memory usage
						) );
						if ( ! empty( $sports ) && is_array( $sports ) ) {
							$sports = array_combine( $sports, array_map( function( $id ) {
								return get_the_title( $id );
							}, $sports ) );
						} else {
							// Fallback to predefined sports if no posts found
							$sports = array(
								'volleyball' => 'Volleyball',
							);
						}
						?>
						<form action="" method="post">
							<input type="text" name="my_city" id="my_city" placeholder="Enter Your City" value="<?= ucwords($user_city) ?>" />
							<select name="my_sport" id="my_sport">
								<!--<option value="">Select Sport</option>-->
								<?php
								foreach ($sports as $sport_key => $sport_name) {
									echo '<option value="' . strtolower($sport_name) . '" >' . $sport_name . '</option>';
								}
								?>
							</select>
							<input type="submit" name="find_my_programs" id="find_my_programs" class="btn white" value="Find Programs" />
						</form>
						<?php
					}
				?>
			</div>
		</div>
	</div>
</section>

<section id="cta-buttons-section" class="template-section">
	<div class="container">
		<div class="content">
			<h2><?=$cta_h2?></h2>
			<h3><?=$cta_h3?></h3>
				<?php
				if ($cta_buttons_csv) {
					$cta_buttons = explode(',', $cta_buttons_csv);
					// count the number of buttons
	 				$button_count = count($cta_buttons);
					$col_class = ' col-md-12';
					$col_space = ' ';
					if ($button_count > 1) {
						$col_class = ' col-md-6';
						$col_space = ' gx-5';
					}
					if ($button_count >= 3) {
						$col_class = ' col-md-4';
						$col_space = ' gx-4';
					}
					echo '<div class="row'.$col_space.'">';
					foreach ($cta_buttons as $button) {
						$button_data = explode('|', $button);
						$button_header = isset($button_data[0]) ? $button_data[0] : '';
						$button_text = isset($button_data[1]) ? $button_data[1] : '';
						$button_link = isset($button_data[2]) ? $button_data[2] : '';
						?>
						<div class="col col-12 <?=$col_class?>">
						<a href="<?=esc_url($button_link)?>" class="cta-btn">
						<h4><?=esc_html($button_header)?></h4>
						<p><?=esc_html($button_text)?></p>
						</a>
						</div>
						<?php
					}
					echo '</div>';
				}
				?>
		</div>
	</div>
</section>

<section id="registration-options-section" class="template-section">
	<div class="container">
		<?php if($registration_banner_h2 || $registration_banner_h3 || $registration_banner_btn_link): ?>
		<div class="registration-banner">
			<figure class="image-background" style="background-image: url(<?=$registration_banner_image?>);">
			</figure>
			<div class="overlay">
				<?=($registration_banner_h2 ? '<h2>'.$registration_banner_h2.'</h2>' : '')?>
				<?=($registration_banner_h3 ? '<h3>'.$registration_banner_h3.'</h3>' : '')?>
				<?=($registration_banner_btn_link ? '<a href="'.$registration_banner_btn_link.'" class="btn white darkblue-txt">'.$registration_banner_btn_text.'</a>' : '')?>
			</div>
		</div>
		<?php endif; ?>
		<div class="content registration-options">
			<?php
			if ($registration_cta_csv) {
				$registration_options = explode('~', $registration_cta_csv);
				$odd = true;
				foreach ($registration_options as $option) {
					$option_data = explode('|', $option);
					$option_image = isset($option_data[0]) ? $option_data[0] : '';
					$option_header = isset($option_data[1]) ? $option_data[1] : '';
					$option_text = isset($option_data[2]) ? wpautop($option_data[2]) : '';
					$option_button_text = isset($option_data[3]) ? $option_data[3] : '';
					$option_button_link = isset($option_data[4]) ? $option_data[4] : '';
					?>
					<div class="row gx-5 <?=($odd ? '' : ' reverse')?> registration-option">
						<div class="col col-12 col-md-6">
							<figure>
								<?php if ($option_image): ?>
									<img src="<?=esc_url($option_image)?>" alt="<?=esc_attr($option_header)?>">
								<?php endif; ?>
							</figure>
						</div>
						<div class="col col-12 col-md-6">
							<div class="option-content">
								<?=$option_header ? '<h2>'.esc_html($option_header).'</h2>' : ''?>
								<div class="desc"><?=html_entity_decode($option_text)?></div>
								<?=($option_button_link && $option_button_text) ? '<a href="'.esc_url($option_button_link).'" class="sml-btn">'.esc_html($option_button_text).'</a>' : ''?>
							</div>
						</div>
					</div>
					<?php
					if($odd){
						$odd = false;
					}else{
						$odd = true;
					}
				}
			}
			?>
		</div>
	</div>
</div>

<?php
// get all testimonials
$testimonial_args = array(
	'post_type' => 'testimonial',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC',
);
$testimonials = get_posts($testimonial_args);
if ($testimonials):
?>
<section id="testimonials-section" class="template-section">
	<div class="container">
		<h3>WHAT ATHLETES HAVE TO SAY</h3>
		<div id="testimonials-slider">
			<?php foreach ($testimonials as $testimonial): ?>
				<?php
				$testimonial_name = get_post_meta($testimonial->ID, 'testimonial_name', true);
				$testimonial_league = get_post_meta($testimonial->ID, 'testimonial_league', true);
				$testimonial_testimony = get_post_meta($testimonial->ID, 'testimonial_testimony', true);
				$testimonial_rating = get_post_meta($testimonial->ID, 'testimonial_rating', true);
				$testimonial_image = get_post_meta($testimonial->ID, 'testimonial_image', true);
				?>
				<div class="testimonial-item">
					<div class="bubble">
						<figure>
							<?php if ($testimonial_image): ?>
								<img src="<?=esc_url($testimonial_image)?>" alt="<?=esc_attr($testimonial_name)?>">
							<?php endif; ?>
						</figure>
						<div class="content">
							<p class="name"><strong><?=esc_html($testimonial_name)?></strong></p>
							<p class="league"><?=esc_html($testimonial_league)?></p>
							<p class="rating"><?=str_repeat('<span>★</span>', intval($testimonial_rating))?></p>
							<div class="testimony"><?=wp_kses_post($testimonial_testimony)?></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
endif; // End testimonials check
?>

<?php
//get the latest blog posts
$blog_args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 6,
	'orderby' => 'date',
	'order' => 'DESC',
);
$blog_posts = get_posts($blog_args);
if ($blog_posts):
?>
<section id="latest-news-section" class="template-section">
	<div class="container">
		<div class="content">
			<center>
				<h3>The Latest from Our Blog</h3>
				<p>Follow our blog for the latest news, coaching tips, and updates on our programs. Stay informed and inspired as we grow the volleyball community together!</p>
			</center>
		</div>
		<div id="blog-slider">
			<?php foreach ($blog_posts as $blog): ?>
				<?php
				setup_postdata($blog);
				$featured_image = get_the_post_thumbnail_url($blog->ID, 'full');
				$blog_title = get_the_title($blog->ID);
				$blog_date = get_the_date('F j, Y', $blog->ID);
				$blog_link = get_permalink($blog->ID);
				$blog_excerpt = get_cleaned_divi_content($blog->ID);
				?>
				<div class="blog-item">
					<a href="<?=esc_url($blog_link)?>" class="blog-link">
						<figure>
							<?php if ($featured_image): ?>
								<img src="<?=esc_url($featured_image)?>" alt="<?=esc_attr($blog_title)?>">
							<?php endif; ?>
						</figure>
						<div class="content">
							<h4><?=esc_html($blog_title);?></h4>
							<p class="date"><?=esc_html($blog_date)?></p>
							<div class="excerpt"><?=wp_kses_post($blog_excerpt)?></div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
endif; // End blog check
?>


<?php get_footer(); ?>