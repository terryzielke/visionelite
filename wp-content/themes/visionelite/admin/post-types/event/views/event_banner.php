<?php	
	// Set post nonce
	wp_nonce_field('vision_elite_event_post_type_nonce', 'vision_elite_event_post_type_nonce');
	// Get post meta data
	$banner_image = get_post_meta( $post->ID, 'banner_image', true );
    $banner_description = get_post_meta( $post->ID, 'banner_description', true );
    $banner_btn_text = get_post_meta( $post->ID, 'banner_btn_text', true );
    $banner_btn_link = get_post_meta( $post->ID, 'banner_btn_link', true );
?>

<div class="frame">

	<label for="banner_image">Background Image</label>
    <figure class="figure">
        <img src="<?= $banner_image ?>" />
        <input type="hidden" id="banner_image" name="banner_image" value="<?=$banner_image?>" />
    </figure>
    <?=($banner_image ? '<a id="remove_image">Remove Image</a>' : '')?>

    <label for="banner_description">Excerpt</label>
    <textarea id="banner_description" name="banner_description" rows="5"><?= $banner_description ?></textarea>

    <table>
        <tr>
            <td>
                <label for="banner_btn_text">Button Text</label>
                <input type="text" id="banner_btn_text" name="banner_btn_text" value="<?= $banner_btn_text ?>" />
            </td>
            <td>
                <label for="banner_btn_link">Button Link</label>
                <input type="text" id="banner_btn_link" name="banner_btn_link" value="<?= $banner_btn_link ?>" />
            </td>
        </tr>
    </table>

</div> 