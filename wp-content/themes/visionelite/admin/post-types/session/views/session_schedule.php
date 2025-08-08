<?php	
    // Get post meta data
    $session_start_date	    = get_post_meta( $post->ID, 'session_start_date', true );
    $session_end_date	    = get_post_meta( $post->ID, 'session_end_date', true );
    $session_days		    = get_post_meta( $post->ID, 'session_days', true );
    $session_start_time	    = get_post_meta( $post->ID, 'session_start_time', true );
    $session_end_time	    = get_post_meta( $post->ID, 'session_end_time', true );
    $session_cancelations	= get_post_meta( $post->ID, 'session_cancelations', true );
?>

<div class="frame">
    <label for="session_days">Days</label>
    <div id="session_days">
        <label><input type="checkbox" name="session_days[]" value="Sunday" <?=($session_days ? (in_array('Sunday', $session_days) ? 'checked' : '') : '') ?> /> Sunday</label>
        <label><input type="checkbox" name="session_days[]" value="Monday" <?=($session_days ? (in_array('Monday', $session_days) ? 'checked' : '') : '') ?> /> Monday</label>
        <label><input type="checkbox" name="session_days[]" value="Tuesday" <?=($session_days ? (in_array('Tuesday', $session_days) ? 'checked' : '') : '') ?> /> Tuesday</label>
        <label><input type="checkbox" name="session_days[]" value="Wednesday" <?=($session_days ? (in_array('Wednesday', $session_days) ? 'checked' : '') : '') ?> /> Wednesday</label>
        <label><input type="checkbox" name="session_days[]" value="Thursday" <?=($session_days ? (in_array('Thursday', $session_days) ? 'checked' : '') : '') ?> /> Thursday</label>
        <label><input type="checkbox" name="session_days[]" value="Friday" <?=($session_days ? (in_array('Friday', $session_days) ? 'checked' : '') : '') ?> /> Friday</label>
        <label><input type="checkbox" name="session_days[]" value="Saturday" <?=($session_days ? (in_array('Saturday', $session_days) ? 'checked' : '') : '') ?> /> Saturday</label>
    </div>
    
    <label for="session_start_time">Start Time</label>
    <input type="time" id="session_start_time" name="session_start_time" value="<?=$session_start_time?>" />
    <label for="session_end_time">End Time</label>
    <input type="time" id="session_end_time" name="session_end_time" value="<?=$session_end_time?>" />

    <label for="session_start_date">Start Date</label>
    <input type="date" id="session_start_date" name="session_start_date" value="<?=$session_start_date?>" />
    <label for="session_end_date">End Date</label>
    <input type="date" id="session_end_date" name="session_end_date" value="<?=$session_end_date?>" />
    
    <label for="session_cancelations">Cancelations</label>
    <input type="text" id="session_cancelations" name="session_cancelations" value="<?=$session_cancelations?>" />
</div>