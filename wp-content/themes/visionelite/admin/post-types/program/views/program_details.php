<?php	
	// Set post nonce
	wp_nonce_field('volleyball_network_admin_program_nonce', 'volleyball_network_admin_program_nonce');
	// Get post meta data
	$program_program_info = get_post_meta( $post->ID, 'program_program_info', true );
	$program_format_info = get_post_meta( $post->ID, 'program_format_info', true );
	$program_expectation_info = get_post_meta( $post->ID, 'program_expectation_info', true );
?>
<style>
    .frame .row{
        display: flex;
        flex-wrap: wrap;
    }
    .frame .col-md-4{
        flex: 1;
        width: 100%;
        min-width: 400px;
    }
    .frame .col-md-4:nth-child(1){
        padding-right: 6px;
    }
    .frame .col-md-4:nth-child(2){
        padding-left: 6px;
        padding-right: 6px;
    }
    .frame .col-md-4:nth-child(3){
        padding-left: 6px;
    }
</style>

<div class="frame">
    <div class="row">
        <div class="col-md-4">
            <!-- WYSIWYG editor for program info -->
            <div class="form-group">
                <label for="program_program_info">Program Info</label>
                <?php wp_editor( $program_program_info, 'program_program_info', array('textarea_name' => 'program_program_info') ); ?>
            </div>
        </div>
        <div class="col-md-4">
            <!-- WYSIWYG editor for format info -->
            <div class="form-group">
                <label for="program_format_info">Format Info</label>
                <?php wp_editor( $program_format_info, 'program_format_info', array('textarea_name' => 'program_format_info') ); ?>
            </div>
        </div>
        <div class="col-md-4">
            <!-- WYSIWYG editor for expectation info -->
            <div class="form-group">
                <label for="program_expectation_info">Expectation Info</label>
                <?php wp_editor( $program_expectation_info, 'program_expectation_info', array('textarea_name' => 'program_expectation_info') ); ?>
            </div>
        </div>
    </div>
</div>