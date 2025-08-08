<?php	
	// Set post nonce
	wp_nonce_field('vision_elite_front_page_nonce', 'vision_elite_front_page_nonce');
	// Get post meta data
	$banner_image = get_post_meta( $post->ID, 'banner_image', true );
    $banner_white_h1 = get_post_meta( $post->ID, 'banner_white_h1', true );
    $banner_orange_h1 = get_post_meta( $post->ID, 'banner_orange_h1', true );
    $banner_description = wpautop(get_post_meta( $post->ID, 'banner_description', true ));
    $banner_btn_text = get_post_meta( $post->ID, 'banner_btn_text', true );
    $banner_btn_link = get_post_meta( $post->ID, 'banner_btn_link', true );
    $banner_caption_text = wpautop(get_post_meta( $post->ID, 'banner_caption_text', true ));
?>
<style>
.banner_button{
   display: flex;
   gap: 20px; 
}
.banner_button .col{
   flex: 1;
}
</style>
<div class="frame">

	<label for="figure">Background Image</label>
    <figure class="figure">
        <img src="<?= $banner_image ?>" />
        <input type="hidden" id="banner_image" name="banner_image" value="<?=$banner_image?>" />
    </figure>
    <?=($banner_image ? '<a id="remove_image">Remove Image</a>' : '')?>


    <label for="banner_white_h1">White H1 Text</label>
    <input type="text" id="banner_white_h1" name="banner_white_h1" value="<?= $banner_white_h1 ?>" />

    <label for="banner_orange_h1">Orange H1 Text</label>
    <input type="text" id="banner_orange_h1" name="banner_orange_h1" value="<?= $banner_orange_h1 ?>" />

    <label for="banner_description">Description</label>
    <?php
        wp_editor($banner_description, 'banner_description', array(
            'textarea_name' => 'banner_description',
            'media_buttons' => false,
            'teeny' => true,
            'textarea_rows' => 5,
            'quicktags' => false,
            'wpautop' => true,
        ));
    ?>

    <div class="banner_button row">
        <div class="col">
            <label for="banner_btn_text">Button Text</label>
            <input type="text" id="banner_btn_text" name="banner_btn_text" value="<?= $banner_btn_text ?>" />
        </div>
        <div class="col">
            <label for="banner_btn_link">Button Link</label>
            <input type="text" id="banner_btn_link" name="banner_btn_link" value="<?= $banner_btn_link ?>" />
        </div>
    </div>

    <label for="banner_caption_text">Caption Text</label>
    <?php
        wp_editor($banner_caption_text, 'banner_caption_text', array(
            'textarea_name' => 'banner_caption_text',
            'media_buttons' => false,
            'teeny' => true,
            'textarea_rows' => 5,
            'quicktags' => false,
            'wpautop' => true,
        ));
    ?>

</div>