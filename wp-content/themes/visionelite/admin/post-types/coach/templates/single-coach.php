<?php 
	get_header(); the_post(); 
	$coach_image = get_post_meta( $post->ID, 'coach_image', true );
	$coach_firstname = get_post_meta( $post->ID, 'coach_firstname', true );
	$coach_lastname = get_post_meta( $post->ID, 'coach_lastname', true );
	$coach_position = get_post_meta( $post->ID, 'coach_position', true );
	$caoch_bio = wpautop(get_post_meta( $post->ID, 'coach_bio', true ));
	$coach_phone = get_post_meta( $post->ID, 'coach_phone', true );
	$coach_email = get_post_meta( $post->ID, 'coach_email', true );
?>

<section id="coach-information-section" class="template-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12 col-md-8">
					<h1><?= $coach_firstname . ' ' . $coach_lastname ?></h1>
					<h3><?= $coach_position ?></h3>
					<?= $caoch_bio ?>
				</div>
				<div class="col col-12 col-md-4">
					<?php if ($coach_image): ?>
						<figure class="coach-image">
							<img src="<?= esc_url($coach_image) ?>" alt="<?= esc_attr($coach_firstname . ' ' . $coach_lastname) ?>" />
						</figure>
					<?php endif; ?>
					<?php if ($coach_phone || $coach_email): ?>
						<h4>Contact Info</h4>
						<?php
							echo ($coach_phone ? '<p><strong>Phone:</strong> <a href="tel:' . esc_attr($coach_phone) . '">' . esc_html($coach_phone) . '</a></p>' : '');
							echo ($coach_email ? '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($coach_email) . '">' . esc_html($coach_email) . '</a></p>' : '');
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>