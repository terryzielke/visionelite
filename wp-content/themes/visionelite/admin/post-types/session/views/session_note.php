<?php	
    // Get post meta data
    $session_note	= get_post_meta( $post->ID, 'session_note', true );
?>

<div class="frame">
    <textarea id="session_note" name="session_note"><?=$session_note?></textarea>
</div>