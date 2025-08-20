<?php

function get_program_list($sessions) {
    // ob_start();
    
    echo '<ul id="sessions">';

    foreach ($sessions as $session_data) {
        $post = $session_data['post'];
        $blog_id = $session_data['blog_id'];

        if (is_multisite()) {
            switch_to_blog($blog_id);
        }

        setup_postdata($post);

        $post_id = $post->ID;

        $gender = get_the_terms($post_id, 'gender');
        $gender_list = $gender ? implode(', ', wp_list_pluck($gender, 'name')) : '';
        if (str_contains(strtolower($gender_list), 'boys') && str_contains(strtolower($gender_list), 'girls')) {
            $gender_list = 'CO-ED';
        }

        $age = get_the_terms($post_id, 'age');
        $ages_list = $age ? implode(',', wp_list_pluck($age, 'name')) : '';
        $age_values = array_map(fn($a) => (int) $a->name, $age ?: []);
        $lowest_age = $age_values ? min($age_values) : 18;
        $highest_age = $age_values ? max($age_values) : 0;
        $age_range = "$lowest_age - $highest_age";

        $grade = get_the_terms($post_id, 'grade');
        $grade_list = $grade ? implode(',', array_map('strval', wp_list_pluck($grade, 'name'))) : '';

        $program_type = get_post_meta($post_id, 'session_program', true);
        $session_sport = get_post_meta($post_id, 'session_sport', true);
        $session_venue = get_post_meta($post_id, 'session_venue', true);
        $session_season = get_post_meta($post_id, 'session_season', true);
        $session_price = get_post_meta($post_id, 'session_price', true);
        $session_registration = get_post_meta($post_id, 'session_registration', true);
        $session_remaining_spots = get_post_meta($post_id, 'session_remaining_spots', true);
        $session_start_date = get_post_meta($post_id, 'session_start_date', true);
        $session_end_date = get_post_meta($post_id, 'session_end_date', true);
        $session_start_time = get_post_meta($post_id, 'session_start_time', true);
        // start time with AM PM
        if ($session_start_time) {
            $session_start_time = date("g:i A", strtotime($session_start_time));
        }
        $session_end_time = get_post_meta($post_id, 'session_end_time', true);
        // end time with AM PM
        if ($session_end_time) {
            $session_end_time = date("g:i A", strtotime($session_end_time));
        }
        $session_days = get_post_meta($post_id, 'session_days', true);
        $days = is_array($session_days) ? implode(', ', $session_days) : '';
        $session_cancelations = get_post_meta($post_id, 'session_cancelations', true);
        $session_notes = get_post_meta($post_id, 'session_notes', true);

        // Now get the venue and program titles from main site
        if (is_multisite()) {
            switch_to_blog(1);
        }
        $program_title = get_the_title($program_type);
        $venue_title = get_the_title($session_venue);
        $venue_address = get_post_meta($session_venue, 'venue_address', true);
        $venue_city = get_post_meta($session_venue, 'venue_city', true);
        $venue_province = get_post_meta($session_venue, 'venue_province', true);
        $venue_postal_code = get_post_meta($session_venue, 'venue_postal_code', true);

        if (is_multisite()) {
            restore_current_blog(); // back from main site
        }

        ?>
        <li class="session" data-program="<?=$program_title?>" data-sport="<?=strtolower(get_the_title($session_sport))?>" data-season="<?=$session_season?>" data-province="<?=$venue_province?>" data-city="<?=strtolower($venue_city)?>" data-ages="<?=$ages_list?>" data-grade="<?=($grade_list ? $grade_list : '0')?>" data-gender="<?=$gender_list?>">

            <div class="session-header">
                <div class="row">
                    <div class="col col-12 col-md-10">
                        <h3>
                            <img src="<?=$session_sport ? get_the_post_thumbnail_url($session_sport) : get_template_directory_uri().'/assets/img/UI/location-orange.svg'?>" alt="sport" class="sport">
                            <?=$program_title?><br><?=$venue_title?>
                        </h3>
                    </div>
                    <div class="col col-12 col-md-2">
                        <?php if($session_registration): ?>
                            <a href="<?=$session_registration?>" target="_blank" class="btn white">Register<?=($session_remaining_spots ? '<span>('.$session_remaining_spots.' spots left)</span>' : '')?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="session-details">
                <div class="row">
                    <div class="col col-12 col-md-2">
                        <div>
                            <h4>Season</h4>
                            <p>
                                <strong><?=ucwords($session_season)?></strong><br>
                                <strong><?=ucwords(get_the_title($session_sport))?></strong>
                            </p>
                        </div>
                    </div>
                    <div class="col col-12 col-md-3">
                        <h4>Address</h4>
                        <p><strong><?=$venue_title?>:</strong></p>
                        <a href="https://www.google.com/maps/search/<?= urlencode("$venue_address $venue_city, $venue_province $venue_postal_code") ?>" target="_blank">
                            <p><strong><?=$venue_address?><br><?=$venue_city?>, <?=$venue_province?>. <?=$venue_postal_code?></strong></p>
                        </a>
                    </div>
                    <div class="col col-12 col-md-3">
                        <h4>Schedule</h4>
                        <?php if($session_start_date): ?><p><strong>Start Date: </strong><?=$session_start_date?></p><?php endif; ?>
                        <?php if($session_end_date): ?><p><strong>End Date: </strong><?=$session_end_date?></p><?php endif; ?>
                        <?php if($session_days): ?><p><strong>Days: </strong><span><?=$days?></span></p><?php endif; ?>
                        <?php if($session_start_time): ?><p><strong>Time: </strong><span><?=$session_start_time.($session_end_time ? ' - '.$session_end_time : '')?></span></p><?php endif; ?>
                        <?php if($session_cancelations): ?><p><strong>Cancelation Dates: </strong><span><?=$session_cancelations?></span></p><?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-3">
                        <h4>Details</h4>
                        <?php if($session_price): ?><p><strong>Price: </strong><?=$session_price?></p><?php endif; ?>
                        <?php if($gender_list): ?><p><strong>Gender: </strong><?=$gender_list?></p><?php endif; ?>
                        <?php if($ages_list): ?><p><strong>Ages: </strong><?=$age_range?></p><?php endif; ?>
                        <?php if($grade_list): ?><p><strong>Grade: </strong><?=$grade_list?></p><?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-1">
                    </div>
                </div>
            </div>
        </li>
        <?php

        wp_reset_postdata();

        if (is_multisite()) {
            restore_current_blog(); // back from the session's blog
        }
    }
    wp_reset_query();
    echo '</ul>';
    
    // return ob_get_clean();
}

?>