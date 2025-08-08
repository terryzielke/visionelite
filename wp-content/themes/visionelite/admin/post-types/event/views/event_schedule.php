<?php	
    // Get post meta data
    $event_start_date	= get_post_meta( $post->ID, 'event_start_date', true );
    $event_end_date	    = get_post_meta( $post->ID, 'event_end_date', true );
    $event_days		    = get_post_meta( $post->ID, 'event_days', true );
    $event_start_time	= get_post_meta( $post->ID, 'event_start_time', true );
    $event_end_time	    = get_post_meta( $post->ID, 'event_end_time', true );
?>

<div class="frame">
    <label for="event_days">Days</label>
    <div id="event_days">
        <label><input type="checkbox" name="event_days[]" value="Sunday" <?=($event_days ? (in_array('Sunday', $event_days) ? 'checked' : '') : '') ?> /> Sunday</label>
        <label><input type="checkbox" name="event_days[]" value="Monday" <?=($event_days ? (in_array('Monday', $event_days) ? 'checked' : '') : '') ?> /> Monday</label>
        <label><input type="checkbox" name="event_days[]" value="Tuesday" <?=($event_days ? (in_array('Tuesday', $event_days) ? 'checked' : '') : '') ?> /> Tuesday</label>
        <label><input type="checkbox" name="event_days[]" value="Wednesday" <?=($event_days ? (in_array('Wednesday', $event_days) ? 'checked' : '') : '') ?> /> Wednesday</label>
        <label><input type="checkbox" name="event_days[]" value="Thursday" <?=($event_days ? (in_array('Thursday', $event_days) ? 'checked' : '') : '') ?> /> Thursday</label>
        <label><input type="checkbox" name="event_days[]" value="Friday" <?=($event_days ? (in_array('Friday', $event_days) ? 'checked' : '') : '') ?> /> Friday</label>
        <label><input type="checkbox" name="event_days[]" value="Saturday" <?=($event_days ? (in_array('Saturday', $event_days) ? 'checked' : '') : '') ?> /> Saturday</label>
    </div>

    <table>
        <tr>
            <td>
                <label for="event_start_time">Start Time</label>
                <input type="time" id="event_start_time" name="event_start_time" value="<?=$event_start_time?>" />
            </td>
            <td>
                <label for="event_end_time">End Time</label>
                <input type="time" id="event_end_time" name="event_end_time" value="<?=$event_end_time?>" />
            </td>
        </tr>
    </table>
    <table style="margin-bottom: 100px !important;">
        <tr>
            <td>
                <label for="event_start_date">Start Date</label>
                <input type="date" id="event_start_date" name="event_start_date" value="<?=$event_start_date?>" />
            </td>
            <td>
                <label for="event_end_date">End Date</label>
                <input type="date" id="event_end_date" name="event_end_date" value="<?=$event_end_date?>" />
            </td>
        </tr>
    </table>
</div>