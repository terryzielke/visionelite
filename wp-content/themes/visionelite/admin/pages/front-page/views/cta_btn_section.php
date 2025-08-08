<?php	
	// Get post meta data
	$cta_h2 = get_post_meta( $post->ID, 'cta_h2', true );
    $cta_h3 = get_post_meta( $post->ID, 'cta_h3', true );
    $cta_buttons_csv = get_post_meta( $post->ID, 'cta_buttons_csv', true );
?>
<style>
.frame .repeatable-cta-buttons .cta-button{
    position: relative;
    margin: 10px 0 20px;
    padding: 0px 20px 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
}
.frame .repeatable-cta-buttons .cta-button input{
    width: 80%;
}
.frame .repeatable-cta-buttons .cta-button table{
    width: 80%;
}
.frame .repeatable-cta-buttons .cta-button table input{
    width: 100%;
}
.frame .repeatable-cta-buttons .cta-button button{
    position: absolute;
    top: 20px;
    right: 20px;
}
</style>
<div class="frame">

    <label for="cta_h2">H2</label>
    <input type="text" id="cta_h2" name="cta_h2" value="<?= $cta_h2 ?>" />

    <label for="cta_h3">H3</label>
    <input type="text" id="cta_h3" name="cta_h3" value="<?= $cta_h3 ?>" />

    <label for="banner_description">CTA Buttons</label>
    <input type="hidden" id="cta_buttons_csv" name="cta_buttons_csv" value="<?= $cta_buttons_csv ?>" />
    <div class="repeatable-cta-buttons">
        <?php
        // button fields: button_header, button_text, button_link
        if ($cta_buttons_csv){
            $cta_buttons = explode(',', $cta_buttons_csv);
            foreach ($cta_buttons as $index => $button) {
                $button_data = explode('|', $button);
                $button_header = isset($button_data[0]) ? $button_data[0] : '';
                $button_text = isset($button_data[1]) ? $button_data[1] : '';
                $button_link = isset($button_data[2]) ? $button_data[2] : '';
                ?>
                <div class="cta-button">
                    <label for="button_header_<?= $index ?>">Button Header</label>
                    <input type="text" id="button_header_<?= $index ?>" name="button_header[]" value="<?= esc_attr($button_header) ?>" />
                    <table>
                        <tr>
                            <td>
                                <label for="button_text_<?= $index ?>">Button Text</label>
                                <input type="text" id="button_text_<?= $index ?>" name="button_text[]" value="<?= esc_attr($button_text) ?>" />
                            </td>
                            <td>
                                <label for="button_link_<?= $index ?>">Button Link</label>
                                <input type="text" id="button_link_<?= $index ?>" name="button_link[]" value="<?= esc_url($button_link) ?>" />
                            </td>
                        </tr>
                    </table>

                    <button type="button" class="remove-cta-button btn button">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="button" class="add-cta-button btn button">Add CTA Button</button>
    

</div>

<script>
    jQuery(document).ready(function($) {
        // add new CTA button
        $(document).on('click', '.add-cta-button', function() {
            var index = $('.repeatable-cta-buttons .cta-button').length;
            var newButton = `
            <div class="cta-button">
                <label for="button_header_${index}">Button Header</label>
                <input type="text" id="button_header_${index}" name="button_header[]" value="" />

                <label for="button_text_${index}">Button Text</label>
                <input type="text" id="button_text_${index}" name="button_text[]" value="" />

                <label for="button_link_${index}">Button Link</label>
                <input type="text" id="button_link_${index}" name="button_link[]" value="" />

                <button type="button" class="remove-cta-button">Remove</button>
            </div>`;
            $('.repeatable-cta-buttons').append(newButton);
            updateCTAButtonsCSV();
        });

        // update CTA buttons CSV on input change
        $(document).on('input', '.repeatable-cta-buttons input', function() {
            updateCTAButtonsCSV();
        });

        // remove CTA button
        $(document).on('click', '.remove-cta-button', function() {
            $(this).closest('.cta-button').remove();
            updateCTAButtonsCSV();
        });

        // updateCTA buttons CSV
        function updateCTAButtonsCSV() {
            var ctaButtons = [];
            $('.repeatable-cta-buttons .cta-button').each(function() {
                var header = $(this).find('input[name="button_header[]"]').val();
                var text = $(this).find('input[name="button_text[]"]').val();
                var link = $(this).find('input[name="button_link[]"]').val();
                if (header && text && link) {
                    ctaButtons.push(header + '|' + text + '|' + link);
                }
            });
            $('#cta_buttons_csv').val(ctaButtons.join(','));
        }
    });
</script>