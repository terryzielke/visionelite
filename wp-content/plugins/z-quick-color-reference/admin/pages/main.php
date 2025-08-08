<div class="zqcr-settings-wrapper zielke_wp_admin">
<h1>Quick Color Reference Settings</h1>
<p>Here you can set the colors you want available in the admin top bar</p>

<form method="post" action="options.php">
<?php
settings_errors();

// select settings group
settings_fields( 'zqcr_settings' );
do_settings_sections( 'zqcr_settings' );

// get current settings
$zqcr_color_name_one = esc_attr( get_option('zqcr_color_name_one'));
$zqcr_color_code_one = esc_attr( get_option('zqcr_color_code_one'));
$zqcr_color_name_two = esc_attr( get_option('zqcr_color_name_two'));
$zqcr_color_code_two = esc_attr( get_option('zqcr_color_code_two'));
$zqcr_color_name_three = esc_attr( get_option('zqcr_color_name_three'));
$zqcr_color_code_three = esc_attr( get_option('zqcr_color_code_three'));
$zqcr_color_name_four = esc_attr( get_option('zqcr_color_name_four'));
$zqcr_color_code_four = esc_attr( get_option('zqcr_color_code_four'));
$zqcr_color_name_five = esc_attr( get_option('zqcr_color_name_five'));
$zqcr_color_code_five = esc_attr( get_option('zqcr_color_code_five'));
?>
	
<div class="break clear"></div>

<div class="color color1" style="background-color: <?php echo ($zqcr_color_code_one ? $zqcr_color_code_one : '#FFFFFF'); ?>;">
	<input type="text" name="zqcr_color_name_one" id="zqcr_color_name_one" class="color_name" value="<?php echo ($zqcr_color_name_one ? $zqcr_color_name_one :''); ?>" placeholder="Color Name">
	<input type="text" class="colorpicker" name="zqcr_color_code_one" id="zqcr_color_code_one" value="<?php echo ($zqcr_color_code_one ? $zqcr_color_code_one : '#FFFFFF'); ?>">
</div>

<div class="color color2" style="background-color: <?php echo ($zqcr_color_code_two ? $zqcr_color_code_two : '#00FF99'); ?>;">
	<input type="text" name="zqcr_color_name_two" id="zqcr_color_name_two" class="color_name" value="<?php echo ($zqcr_color_name_two ? $zqcr_color_name_two :''); ?>" placeholder="Color Name">
	<input type="text" class="colorpicker" name="zqcr_color_code_two" id="zqcr_color_code_two" value="<?php echo ($zqcr_color_code_two ? $zqcr_color_code_two : '#00FF99'); ?>">
</div>

<div class="color color3" style="background-color: <?php echo ($zqcr_color_code_three ? $zqcr_color_code_three : '#0099FF'); ?>;">
	<input type="text" name="zqcr_color_name_three" id="zqcr_color_name_three" class="color_name" value="<?php echo ($zqcr_color_name_three ? $zqcr_color_name_three :''); ?>" placeholder="Color Name">
	<input type="text" class="colorpicker" name="zqcr_color_code_three" id="zqcr_color_code_three" value="<?php echo ($zqcr_color_code_three ? $zqcr_color_code_three : '#0099FF'); ?>">
</div>

<div class="color color4" style="background-color: <?php echo ($zqcr_color_code_four ? $zqcr_color_code_four : '#FF3399'); ?>;">
	<input type="text" name="zqcr_color_name_four" id="zqcr_color_name_four" class="color_name" value="<?php echo ($zqcr_color_name_four ? $zqcr_color_name_four :''); ?>" placeholder="Color Name">
	<input type="text" class="colorpicker" name="zqcr_color_code_four" id="zqcr_color_code_four" value="<?php echo ($zqcr_color_code_four ? $zqcr_color_code_four : '#FF3399'); ?>">
</div>

<div class="color color5" style="background-color: <?php echo ($zqcr_color_code_five ? $zqcr_color_code_five : '#000000'); ?>;">
	<input type="text" name="zqcr_color_name_five" id="zqcr_color_name_five" class="color_name" value="<?php echo ($zqcr_color_name_five ? $zqcr_color_name_five :''); ?>" placeholder="Color Name">
	<input type="text" class="colorpicker" name="zqcr_color_code_five" id="zqcr_color_code_five" value="<?php echo ($zqcr_color_code_five ? $zqcr_color_code_five : '#000000'); ?>">
</div>
	
<div class="break clear" style="margin-bottom: 30px;"></div>

<?php submit_button('Save Colors','primary','zqcr_save_button'); ?>

</form>
</div>