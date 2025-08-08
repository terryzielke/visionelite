<?php	
	// Get post meta data
    $registration_banner_image = get_post_meta( $post->ID, 'registration_banner_image', true );
	$registration_banner_h2 = get_post_meta( $post->ID, 'registration_banner_h2', true );
    $registration_banner_h3 = get_post_meta( $post->ID, 'registration_banner_h3', true );
    $registration_banner_btn_text = get_post_meta( $post->ID, 'registration_banner_btn_text', true );
    $registration_banner_btn_link = get_post_meta( $post->ID, 'registration_banner_btn_link', true );
    $registration_cta_csv = get_post_meta( $post->ID, 'registration_cta_csv', true );
?>
<style>
    .repeatable-registration-options .option{
        position: relative;
        margin: 10px 0 20px;
        padding: 0px 20px 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
    .repeatable-registration-options .option .remove-option{
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>
<div class="frame">

    <label for="registration_banner_image">Image</label>
    <figure class="figure">
        <img src="<?= esc_url($registration_banner_image) ?>" />
        <input type="hidden" id="registration_banner_image" name="registration_banner_image" value="<?= esc_url($registration_banner_image) ?>" />
        <?=($registration_banner_image ? '<a class="remove_image">Remove Image</a>' : '')?>
    </figure>

    <label for="registration_banner_h2">H2</label>
    <input type="text" id="registration_banner_h2" name="registration_banner_h2" value="<?= $registration_banner_h2 ?>" />

    <label for="registration_banner_h3">H3</label>
    <input type="text" id="registration_banner_h3" name="registration_banner_h3" value="<?= $registration_banner_h3 ?>" />

    <table>
        <tr>
            <td>
                <label for="registration_banner_btn_text">Button Text</label>
                <input type="text" id="registration_banner_btn_text" name="registration_banner_btn_text" value="<?= esc_attr($registration_banner_btn_text) ?>" />
            </td>
            <td>
                <label for="registration_banner_btn_link">Button Link</label>
                <input type="text" id="registration_banner_btn_link" name="registration_banner_btn_link" value="<?= esc_url($registration_banner_btn_link) ?>" />
            </td>
        </tr>
    </table>

    <label for="registration_cta_csv">Registration Options</label>
    <input type="hidden" id="registration_cta_csv" name="registration_cta_csv" value="<?= $registration_cta_csv ?>" />
    <div class="repeatable-registration-options">
        <?php
        // button fields: option_header, option_text, option_button_link, option_image
        if ($registration_cta_csv){
            $registration_options = explode('~', $registration_cta_csv);
            foreach ($registration_options as $index => $option) {
                $option_data = explode('|', $option);
                $option_image = isset($option_data[0]) ? $option_data[0] : '';
                $option_header = isset($option_data[1]) ? $option_data[1] : '';
                $option_text = isset($option_data[2]) ? wpautop($option_data[2]) : '';
                $option_button_text = isset($option_data[3]) ? $option_data[3] : '';
                $option_button_link = isset($option_data[4]) ? $option_data[4] : '';

                ?>
                <div class="option">
                    <label for="option_image_<?= $index ?>">Image</label>
                    <figure class="figure">
                        <img src="<?= esc_url($option_image) ?>" />
                        <input type="hidden" id="option_image_<?= $index ?>" name="option_image[]" value="<?= esc_url($option_image) ?>" />
                        <a class="remove_image">Remove Image</a>
                    </figure>
                    <label for="option_header_<?= $index ?>">Header</label>
                    <input type="text" id="option_header_<?= $index ?>" name="option_header[]" value="<?= esc_attr($option_header) ?>" />

                    <label for="option_text_<?= $index ?>">Description</label>
                    <?php
                    $option_text = isset($option_text) ? html_entity_decode($option_text) : '';
                    wp_editor($option_text, 'option_text_' . $index, array(
                        'textarea_name' => 'option_text[]',
                        'textarea_rows' => 5,
                        'media_buttons' => false,
                        'teeny' => true,
                        'quicktags' => false,
                        'wpautop' => true,
                    ));
                    ?>
                    <table>
                        <tr>
                            <td>
                                <label for="option_button_text_<?= $index ?>">Button Text</label>
                                <input type="text" id="option_button_text_<?= $index ?>" name="option_button_text[]" value="<?= esc_attr($option_button_text) ?>" />
                            </td>
                            <td>
                                <label for="option_button_link_<?= $index ?>">Button Link</label>
                                <input type="text" id="option_button_link_<?= $index ?>" name="option_button_link[]" value="<?= esc_url($option_button_link) ?>" />
                            </td>
                        </tr>
                    </table>
                    

                    <button type="button" class="remove-option btn button">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="button" class="add-option btn button">Add Retistration Option</button>
    

</div>

<script>
    jQuery(document).ready(function($) {

        // Function to add a new registration option
        function addRegistrationOption() {
            const index = $('.repeatable-registration-options .option').length;
            const newOption = `
                <div class="option">
                    <label for="option_image_${index}">Image</label>
                    <figure class="figure">
                        <img src="" />
                        <input type="hidden" id="option_image_${index}" name="option_image[]" value="" />
                        <a class="remove_image">Remove Image</a>
                    </figure>
                    <label for="option_header_${index}">Header</label>
                    <input type="text" id="option_header_${index}" name="option_header[]" value="" />

                    <label for="option_text_${index}">Description</label>
                    <textarea id="option_text_${index}" name="option_text[]" rows="5"></textarea>

                    <table>
                        <tr>
                            <td>
                                <label for="option_button_text_${index}">Button Text</label>
                                <input type="text" id="option_button_text_${index}" name="option_button_text[]" value="" />
                            </td>
                            <td>
                                <label for="option_button_link_${index}">Button Link</label>
                                <input type="text" id="option_button_link_${index}" name="option_button_link[]" value="" />
                            </td>
                        </tr>
                    </table>

                    <button type="button" class="remove-option btn button">Remove</button>
                </div>
            `;
            $('.repeatable-registration-options').append(newOption);

            initializeWPEditors();
        }

        // Add new registration option on button click
        $('.add-option').on('click', function() {
            addRegistrationOption();
        });

        // Remove registration option
        $(document).on('click', '.remove-option', function() {
            $(this).closest('.option').remove();
        });

        // Initialize the textareas with wp_editor
        function initializeWPEditors(){
            $('.repeatable-registration-options textarea').each(function() {
                const id = $(this).attr('id');
                const name = $(this).attr('name');
                wp.editor.initialize(id, {
                    tinymce: { wpautop: true, plugins: 'lists,paste' },
                    quicktags: true,
                    mediaButtons: false,
                    teeny: true,
                    textarea_rows: 5,
                    quicktags: false,
                    wpautop: true,
                });
            });
        }

        // Update hidden input field with serialized data
        function updateRegistrationOptions() {
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave(); // Ensure all wp_editor content is pushed to their <textarea>s
            }

            let options = [];
            $('.repeatable-registration-options .option').each(function() {
                const image = $(this).find('input[name="option_image[]"]').val();
                const header = $(this).find('input[name="option_header[]"]').val();
                const text = $(this).find('textarea[name="option_text[]"]').val();
                const buttonText = $(this).find('input[name="option_button_text[]"]').val();
                const buttonLink = $(this).find('input[name="option_button_link[]"]').val();
                options.push(`${image}|${header}|${text}|${buttonText}|${buttonLink}`);
            });

            $('#registration_cta_csv').val(options.join('~'));
        }

        // Bind change event
        $(document).on('change', '.repeatable-registration-options input, .repeatable-registration-options textarea', updateRegistrationOptions);

        // Also bind on form submit, to be extra sure
        $('form').on('submit', updateRegistrationOptions);

    });
</script>