<?php
/*
Template Name: Program Search
*/
get_header();

$season_cookie = isset($_COOKIE['filter-season']) ? strtolower($_COOKIE['filter-season']) : 'all';
$season_map = [
    'fall'   => 'Fall',
    'winter' => 'Winter',
    'spring' => 'Spring',
    'summer' => 'Summer',
    'all'    => 'All'
];
$current_season = isset($season_map[$season_cookie]) ? $season_map[$season_cookie] : 'All';
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
					get_program_filters(['sport', 'city', 'program', 'season']);
				?>
			</div>
		</div>
</section>
 
<section id="programs-section" class="template-section">
	<?php
		echo '<div class="container active" id="all-programs-container">';
		echo '<div class="program-container">';

		$sessions = [];

		if (is_multisite() && get_current_blog_id() === 1) {
			$sites = get_sites(['public' => 1]);
			foreach ($sites as $site) {
				switch_to_blog($site->blog_id);
				$query = new WP_Query([
					'post_type' => 'session',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'meta_value_num',
					'meta_key' => 'session_start_date',
					'order' => 'ASC',
				]);
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
			$query = new WP_Query([
				'post_type' => 'session',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'meta_value_num',
				'meta_key' => 'session_start_date',
				'order' => 'ASC',
			]);
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
	?>
</section>

<?php get_footer(); ?>
