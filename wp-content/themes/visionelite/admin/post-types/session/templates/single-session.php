<?php 
	get_header(); the_post(); 

	$session_address  		= get_post_meta( $post->ID, 'session_address', true );
	$session_phone			= get_post_meta( $post->ID, 'session_phone', true );
	$session_email			= get_post_meta( $post->ID, 'session_email', true );
	$session_coming_soon	= get_post_meta( $post->ID, 'session_coming_soon', true );
?>

<section class="header">
	<div class="container">
		<div class="text-container">
			<h1><?= the_title() ?></h1>
		</div>
	</div>
</section>

<?php if( $session_coming_soon ): ?>
	<section class="coming-soon">
		<div class="container">
			<div class="text-container">
				<h4 class="orange">There are no sessions in this session yet.</h4>
			</div>
		</div>
<?php endif; ?>

<section class="page">
	<div class="container">
		<div class="text-container">
			<div class="content">
				<?= the_content() ?>
			</div>
		</div>
	</div>
</section>

<section class="contact">
	<div class="container">
		<div class="text-container">
			<h2>Contact Info</h2>
			<?=
				($session_address ? '<p><strong>Address:</strong> ' . $session_address . '</p>' : '').
				($session_phone ? '<p><strong>Phone:</strong> ' . $session_phone . '</p>' : '').
				($session_email ? '<p><strong>Email:</strong> ' . $session_email . '</p>' : '');
			?>

		</div>
	</div>
</section>

<?php get_footer(); ?>