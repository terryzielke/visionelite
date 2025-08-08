<?php
	// Get post meta data
	$program_sub_header = get_post_meta( $post->ID, 'program_sub_header', true );
	$program_excerpt = get_post_meta( $post->ID, 'program_excerpt', true );
?>

<div class="frame">

    <label for="program_sub_header">Sub Header</label>
    <input type="text" name="program_sub_header" value="<?= $program_sub_header ?>" />

    <label for="program_excerpt">Excerpt</label>
    <?php wp_editor( $program_excerpt, 'program_excerpt', array('textarea_name' => 'program_excerpt') ); ?>
</div>