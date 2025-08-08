<?php
global $wp_query;
$wp_query->is_404 = false;
status_header(200);
get_header();

if(is_multisite()){
	switch_to_blog(1);
}
// get the post slug from the URL
$program_slug = get_query_var('name');
// get the post object by slug
$program_post = get_page_by_path($program_slug, OBJECT, 'program');
// get the post ID
$program_id = $program_post->ID;

$program_description = get_post_meta( $program_id, 'program_description', true );
$program_program_info = get_post_meta( $program_id, 'program_program_info', true );
$program_format_info = get_post_meta( $program_id, 'program_format_info', true );
$program_expectation_info = get_post_meta( $program_id, 'program_expectation_info', true );
?>
<section class="header template-section">
	<div class="container">
		<div class="content" style="margin-bottom: 0;">
		    <h1 style="margin-top:0;"><?= get_the_title($program_id) ?></h1>
		</div>
	</div>
</section>

<?php if($program_program_info || $program_format_info || $program_expectation_info): ?>
<section id="program-details-section" class="template-section">
    <div class="container">
        <div class="content">
            <div class="row">
                <?php if($program_program_info): ?>
                <div class="col-md-4">
                    <h3>Program</h3>
                    <p><?= $program_program_info ?></p>
                </div>
                <?php endif; ?>
                <?php if($program_format_info): ?>
                <div class="col-md-4">
                    <h3>Format</h3>
                    <p><?= $program_format_info ?></p>
                </div>
                <?php endif; ?>
                <?php if($program_expectation_info): ?>
                <div class="col-md-4">
                    <h3>Expectation</h3>
                    <p><?= $program_expectation_info ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- end program -->
</section>
<?php endif; ?>
<?php
if(is_multisite()){
	restore_current_blog();
}
?>
<section id="program-list-section" class="page template-section">
	<div class="container">
        <div class="content">
            <div id="program-list-header">
                <h3>Program List</h3>
				<a id="toggle-filters"><i class="fa-solid fa-filter"></i>Filters</a>
                <?php
                    get_program_filters();
                ?>
            </div>
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
                            // where metafield 'session_program' is equal to current program ID
                            'meta_query' => [
                                [
                                    'key' => 'session_program',
                                    'value' => get_the_ID(),
                                    'compare' => '=',
                                ],
                            ],
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
				} 
                elseif (is_multisite()) {
                    // If on a subsite, just get sessions from current blog
                    restore_current_blog();
                    $query = new WP_Query([
                        'post_type' => 'session',
                        'post_status' => 'publish',
                        'orderby' => 'title',
                        'order' => 'ASC',
                        // where metafield 'session_program' is equal to current program ID
                        'meta_query' => [
                            [
                                'key' => 'session_program',
                                'value' => $program_id,
                                'compare' => '=',
                            ],
                        ],
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
                }
                else {
					// Just get sessions from current site
					$query = new WP_Query([
						'post_type' => 'session',
						'post_status' => 'publish',
						'orderby' => 'title',
						'order' => 'ASC',
                        // where metafield 'session_program' is equal to current program ID
                        'meta_query' => [
                            [
                                'key' => 'session_program',
                                'value' => get_the_ID(),
                                'compare' => '=',
                            ],
                        ],
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
        </div>
	</div>
</section>

<?php /*
<section id="program-description-section" class="page template-section">
	<div class="container">
        <div class="content">
            <?= $program_description ?>
        </div>
	</div>
</section>
*/ ?>

<script>
jQuery(document).ready(function($){

    const $programFilter = $('select#filter-programs');
    // set the program filter select field to 'all'
    $programFilter.val('all');
    // trigger change event on program filter
    $programFilter.trigger('change');

});
</script>

<?php get_footer(); ?>