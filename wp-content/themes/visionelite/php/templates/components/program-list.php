<?php

function get_program_list($sessions) {
    // ob_start();
    
    $items = [];

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
        if ((str_contains(strtolower($gender_list), 'boys') && str_contains(strtolower($gender_list), 'girls')) || (str_contains(strtolower($gender_list), 'co-ed'))) {
            $gender_list = 'Boys & Girls';
        }

        $age = get_the_terms($post_id, 'age');
        $ages_list = $age ? implode(',', wp_list_pluck($age, 'name')) : '';
        $age_values = array_map(fn($a) => (int) $a->name, $age ?: []);
        $lowest_age = $age_values ? min($age_values) : 18;
        $highest_age = $age_values ? max($age_values) : 0;
        $age_range = "$lowest_age - $highest_age";

        $grade = get_the_terms($post_id, 'grade');
        // get comma separated grades
        $grades = $grade ? implode(',', array_map('strval', wp_list_pluck($grade, 'name'))) : '';
        // comma separated grades in order from smallest to largest. ensuring that 10 will come after 9
        $grade_list = array_map('intval', explode(',', $grades));
        sort($grade_list);
        $grade_list = implode(',', $grade_list);
        // order grades
        $grade_values = array_map(fn($g) => (int) $g->name, $grade ?: []);
        $lowest_grade = $grade_values ? min($grade_values) : 0;
        $highest_grade = $grade_values ? max($grade_values) : 12;
        $grade_range = "$lowest_grade - $highest_grade";

        // Get skill_level terms ordered by custom "order" meta
		$skill_levels = get_the_terms($post_id, 'skill_level');
		$skill_csv = $skill_levels ? implode(',', wp_list_pluck($skill_levels, 'name')) : '';
		if ($skill_levels && !is_wp_error($skill_levels)) {
		    // Sort terms by "order" meta
		    usort($skill_levels, function($a, $b) {
		        $order_a = (int) get_term_meta($a->term_id, 'order', true);
		        $order_b = (int) get_term_meta($b->term_id, 'order', true);
		        return $order_a - $order_b;
		    });
		
		    // Get first and last term names
		    $first_skill = reset($skill_levels)->name;
		    $last_skill  = end($skill_levels)->name;
		
		    // If only one skill level, first = last
		    $skill_range = ($first_skill === $last_skill) 
		        ? $first_skill 
		        : "$first_skill - $last_skill";
		} else {
		    $skill_range = '';
		}
		
		$season = get_the_terms($post_id, 'season');
        // Get season name
        $season_name = $season ? implode(', ', wp_list_pluck($season, 'name')) : '';

        // get Province taxonomy terms
        $province = get_the_terms($post_id, 'province');
        $province_list = $province ? implode(', ', wp_list_pluck($province, 'name')) : '';

        // get City taxonomy terms
        $city = get_the_terms($post_id, 'city');
        $city_list = $city ? implode(', ', wp_list_pluck($city, 'name')) : '';

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

        ob_start();
        ?>
        <li class="session" data-program="<?=$program_title?>" data-sport="<?=strtolower(get_the_title($session_sport))?>" data-season="<?=($season_name ? strtolower($season_name) : $session_season)?>" data-province="<?=$venue_province?>" data-city="<?=strtolower($venue_city)?>" data-ages="<?=$ages_list?>" data-grade="<?=($grade_list ? $grade_list : '0')?>" data-gender="<?=$gender_list?>" data-skill="<?=($skill_csv ? $skill_csv : '')?>">

            <div class="session-header">
                <div class="row">
                    <div class="col col-12 col-md-10">
                        <h4>
                            <img src="<?=$session_sport ? get_the_post_thumbnail_url($session_sport) : get_template_directory_uri().'/assets/img/UI/location-orange.svg'?>" alt="sport" class="sport">
                            <?=($grades ? (strpos(strtolower($grades), 'grade') !== false ? $grades : 'Grade '.$grades) : ($ages_list ? 'Ages '.$age_range : ''))?>
                            <?=($gender_list ? ' '.$gender_list.':' : '')?>
                            <?=($skill_range ? ' '.$skill_range : '')?>
                            <br>
                            <?=($session_days ? ' '.$days : '')?>
                            <?=($venue_title ? ' at '.$venue_title : '')?>
                        </h4>
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
                        <?php /* if($session_days): ?><p><strong>Days: </strong><span><?=$days?></span></p><?php endif; */ ?>
                        <?php if($session_start_time): ?><p><strong>Time: </strong><span><?=$session_start_time.($session_end_time ? ' - '.$session_end_time : '')?></span></p><?php endif; ?>
                        <?php if($session_cancelations): ?><p><strong>Cancelation Dates: </strong><span><?=$session_cancelations?></span></p><?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-3">
                        <?php
                        // if $session_price includes "$"
                        if($session_price): ?><h4>Price: <?=($session_price ? (strpos($session_price, '$') !== false ? $session_price : '$'.$session_price) : '')?></h4><?php endif; ?>
                        <?php if($session_registration): ?>
                            <strong><a href="<?=$session_registration?>" target="_blank">Register Now <?=($session_remaining_spots ? '<span>('.$session_remaining_spots.' spots left)</span>' : '')?></a></strong>
                        <?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-1">
                    </div>
                </div>
            </div>
        </li>
        <?php
        $li_html = ob_get_clean();

        wp_reset_postdata();

        if (is_multisite()) {
            restore_current_blog(); // back from the session's blog
        }

        $venue_key = strtolower($venue_title ?: '');
        $group_key = $grade_values ? $lowest_grade : ($age_values ? $lowest_age : 999);
        $start_key = $session_start_date ? strtotime($session_start_date) : PHP_INT_MAX;

        $items[] = [
            'venue' => $venue_key,
            'group' => (int)$group_key,
            'start' => (int)$start_key,
            'html'  => $li_html,
        ];
    }

    usort($items, function($a, $b) {
        if ($a['venue'] !== $b['venue']) {
            return $a['venue'] <=> $b['venue'];
        }
        if ($a['group'] !== $b['group']) {
            return $a['group'] <=> $b['group'];
        }
        return $a['start'] <=> $b['start'];
    });

    echo '<ul id="sessions">';
    foreach ($items as $item) {
        echo $item['html'];
    }
    wp_reset_query();
    echo '</ul>';
    
    // return ob_get_clean();
}

?>