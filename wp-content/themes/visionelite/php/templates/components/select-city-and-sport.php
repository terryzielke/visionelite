<?php
    $user_province = get_user_province();
    if (empty($user_province)) {
        $user_province = 'all';
    }
    $user_city = get_user_city();
    if (empty($user_city)) {
        $user_city = 'all';
    }
    $sports = array(
        'volleyball'       => 'Volleyball',
        'pickleball'       => 'Pickleball',
        'basketball'       => 'Basketball',
        'soccer'           => 'Soccer',
        'football'         => 'Football',
        'hockey'           => 'Hockey',
        'baseball'         => 'Baseball',
        'softball'         => 'Softball',
        'rugby'            => 'Rugby',
        'lacrosse'         => 'Lacrosse',
        'tennis'           => 'Tennis',
        'golf'             => 'Golf',
        'swimming'         => 'Swimming',
        'track-and-field'  => 'Track and Field',
    );
?>
<form action="" method="post">
    <input type="text" name="my_city" id="my_city" placeholder="Enter Your City" value="<?= $user_city ?>" />
    <select name="my_sport" id="my_sport">
        <option value="">Select Sport</option>
        <?php
        foreach ($sports as $sport_key => $sport_name) {
            $selected = ($sport_key == $user_province) ? 'selected' : '';
            echo '<option value="' . $sport_key . '" ' . $selected . '>' . $sport_name . '</option>';
        }
        ?>
    </select>
    <input type="submit" name="find_my_programs" id="find_my_programs" class="btn white" value="Find Programs" />
</form>