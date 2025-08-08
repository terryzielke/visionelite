<?php
/*
Template Name: Program Search
*/
get_header();
?>

<section id="filters-section" class="template-section">
	<div class="container">
		<div class="row">
			<div class="col col-10">
				<h1>Find a Program</h1>
			</div>
			<div class="col col-2">
				<a id="toggle-filters"><i class="fa-solid fa-filter"></i>Filters</a>
			</div>
		</div>
		<div class="row filters-row">
			<div class="col col-12">
				<?php
					get_program_filters();
				?>
			</div>
		</div>
   </div>
</section>


<section class="programs-section template-section">
    <div class="container">
		<div id="program-container">
			<?php
				// Get all sessions across multisite or just current site
				$sessions = [];
				if (is_multisite() && get_current_blog_id() === 1) {
					// Get sessions from all blogs if on main site
					$sites = get_sites(['public' => 1]);

					foreach ($sites as $site) {
						switch_to_blog($site->blog_id);

						$query = new WP_Query([
							'post_type' => 'session',
							'post_status' => 'publish',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
						]);

						while ($query->have_posts()) {
							$query->the_post();
							// Store post object and blog_id
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
					$query = new WP_Query([
						'post_type' => 'session',
						'post_status' => 'publish',
						'orderby' => 'title',
						'order' => 'ASC',
						'posts_per_page' => -1,
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
			?>
		</ul>
    </div>
</section>

<?php get_footer(); ?>