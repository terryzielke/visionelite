<?php
/*
Template Name: Program Search
*/
get_header();

// get current month number
$current_season = '';
$current_month = date('n');
// if current month is between 3 and 5, it's spring
if ($current_month >= 3 && $current_month <= 5) {
    $current_season = 'Spring';
}
// if current month is between 6 and 8, it's summer
elseif ($current_month >= 6 && $current_month <= 8) {
    $current_season = 'Summer';
}
// if current month is between 9 and 11, it's fall
elseif ($current_month >= 9 && $current_month <= 11) {
    $current_season = 'Fall';
}
// if current month is 12 or 1 or 2, it's winter
else {
    $current_season = 'Winter';
}
// create season array
$season_array = ['Spring', 'Summer', 'Fall', 'Winter', 'Special Event'];
?>

<section id="filters-section" class="template-section">
	<div class="container">
		<div class="row">
			<div class="col col-10">
				<h1><span id="season-name"><?=$current_season?></span> Programs</h1>
			</div>
			<div class="col col-2">
				<a id="toggle-filters"><i class="fa-solid fa-filter"></i>Filters</a>
			</div>
		</div>
		<div class="row filters-row">
			<div class="col col-12">
				<?php
					get_program_filters(['city', 'sport']);
				?>
			</div>
		</div>
</section>
<section id="season-section" class="template-section">
	<div class="container">
		<div class="row season-row">
			<div class="col col-12">
				<?php
					foreach ($season_array as $season) {
						echo '<a class="season-tab ' . (($current_season === $season) ? 'active' : '') . '" data-season="' . esc_attr($season) . '">' . esc_html($season) . '</a>';
					}
				?>
			</div>
		</div>
	</div>
</section>


<section id="programs-section" class="template-section">
			<?php
			foreach($season_array as $season) {
				echo '<div class="container '.($current_season === $season ? 'active' : '').'" id="' . str_replace(' ', '-', strtolower($season)) . '-container">';
				echo '<div class="program-container">';

				$sessions = [];
				$month_range = [];
				if (is_multisite() && get_current_blog_id() === 1) {
					// Get sessions from all blogs if on main site
					$sites = get_sites(['public' => 1]);
					foreach ($sites as $site) {
						switch_to_blog($site->blog_id);




						// get all sessions where the "season" taxonomy matches $season. order by session_start_date
						// if $season is "Special", include all sessions that are not "Spring", "Summer", "Fall", or "Winter"
						// if the post has no season, include it in the $current_season $season
						if ($season === 'Special Event') {
							$query = new WP_Query([
								'post_type' => 'session',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'tax_query' => [
									'relation' => 'OR',
									[
										'taxonomy' => 'season',
										'field' => 'slug',
										'terms' => ['spring', 'summer', 'fall', 'winter'],
										'operator' => 'NOT IN',
									],
								],
							]);
						} elseif($season === $current_season) {
							$query = new WP_Query([
								'post_type' => 'session',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'tax_query' => [
									'relation' => 'OR',
									[
										'taxonomy' => 'season',
										'field' => 'slug',
										'terms' => [$season],
									],
									[
										'taxonomy' => 'season',
										'operator' => 'NOT EXISTS',
									],
								],
								'orderby' => 'meta_value_num',
								'meta_key' => 'session_start_date',
								'order' => 'ASC',
							]);
						} else {
							$query = new WP_Query([
								'post_type' => 'session',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'tax_query' => [
								[
									'taxonomy' => 'season',
									'field' => 'slug',
									'terms' => $season,
								],
							],
							'orderby' => 'meta_value_num',
							'meta_key' => 'session_start_date',
							'order' => 'ASC',
						]);
						}
						while ($query->have_posts()) {
							$query->the_post();
							$sessions[] = [
								'post' => get_post(),
								'blog_id' => get_current_blog_id(),
							];
						}

						wp_reset_postdata();
						restore_current_blog();
					}

				} else {
					
					// Just get sessions from current site
					if ($season === 'Special Event') {
						$query = new WP_Query([
							'post_type' => 'session',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'tax_query' => [
								'relation' => 'OR',
								[
									'taxonomy' => 'season',
									'field' => 'slug',
									'terms' => ['spring', 'summer', 'fall', 'winter'],
									'operator' => 'NOT IN',
								],
							],
						]);
					} elseif($season === $current_season) {
							$query = new WP_Query([
								'post_type' => 'session',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'tax_query' => [
									'relation' => 'OR',
									[
										'taxonomy' => 'season',
										'field' => 'slug',
										'terms' => [$season],
									],
									[
										'taxonomy' => 'season',
										'operator' => 'NOT EXISTS',
									],
								],
								'orderby' => 'meta_value_num',
								'meta_key' => 'session_start_date',
								'order' => 'ASC',
							]);
						} else {
						$query = new WP_Query([
							'post_type' => 'session',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'tax_query' => [
							[
								'taxonomy' => 'season',
								'field' => 'slug',
								'terms' => $season,
							],
						],
						'orderby' => 'meta_value_num',
						'meta_key' => 'session_start_date',
						'order' => 'ASC',
					]);
					}
					while ($query->have_posts()) {
						$query->the_post();
						$sessions[] = [
							'post' => get_post(),
							'blog_id' => get_current_blog_id(),
						];
					}

					wp_reset_postdata();
				}

				get_program_list($sessions);

				echo '</div></div>';
			}
			?>
</section>

<?php get_footer(); ?>
