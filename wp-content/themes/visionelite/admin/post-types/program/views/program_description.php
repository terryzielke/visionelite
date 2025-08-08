<?php
	// Get post meta data
	$program_description = get_post_meta( $post->ID, 'program_description', true );
?>
<div class="frame">
    <?php wp_editor( $program_description, 'program_description', array('textarea_name' => 'program_description') ); ?>
</div>