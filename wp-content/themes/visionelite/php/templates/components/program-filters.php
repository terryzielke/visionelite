<?php

function get_program_filters($filters = ['province', 'city', 'program', 'sport', 'season', 'age', 'grade', 'gender']) {


    $user_province = get_user_province();
    if (empty($user_province)) {
        $user_province = 'all';
    }
    $user_city = get_user_city();
    if (empty($user_city)) {
        $user_city = 'all';
    }

    echo '<div id="filters">';

    if (in_array('program', $filters)) {
        $url_programs = str_replace('-', ' ', isset($_GET['programs']) ? $_GET['programs'] : '');
        if (is_multisite()) {
            switch_to_blog(1);
        }
        $programs = get_posts([
            'post_type' => 'program',
            'status' => 'publish',
            'posts_per_page' => -1,
        ]);
        if (is_multisite()) {
            restore_current_blog();
        }

        if (!empty($programs)) {
            echo '<div class="filter program">
                    <label>Program</label>
                    <select id="filter-programs" name="programs">
                        <option value="all">All</option>';
                        foreach ($programs as $program) {
                            $selected = (strtolower($url_programs) == strtolower($program->post_title)) ? 'selected' : '';
                            echo '<option value="' . $program->post_title . '" ' . $selected . '>' . $program->post_title . '</option>';
                        }
            echo '</select>
                </div>';
        }
    }

    if (in_array('sport', $filters)) {
        $url_sport = str_replace('-', ' ', isset($_GET['sport']) ? $_GET['sport'] : '');
        $sports = get_posts([
            'post_type' => 'activity',
            'status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
        ]);

        if (!empty($sports)) {
            echo '<div class="filter sport">
                    <label>Sport</label>
                    <select id="filter-sport" name="sport">
                        <option value="all">All</option>';
                        foreach ($sports as $sport) {
                            $selected = (strtolower($url_sport) == strtolower($sport->post_title)) ? 'selected' : '';
                            echo '<option value="' . strtolower($sport->post_title) . '" ' . $selected . '>' . $sport->post_title . '</option>';
                        }
            echo '</select>
                </div>';
        }
    }

    if (in_array('season', $filters)) {
        $url_season = str_replace('-', ' ', isset($_GET['season']) ? $_GET['season'] : '');
        $seasons = ['Spring', 'Summer', 'Fall', 'Winter'];

        if (!empty($seasons)) {
            echo '<div class="filter season">
                    <label>Season</label>
                    <select id="filter-season" name="season">
                        <option value="all">All</option>
                        <option value="spring">Spring</option>
                        <option value="summer">Summer</option>
                        <option value="fall">Fall</option>
                        <option value="winter">Winter</option>
                    </select>
                </div>';
        }
    }

    if (in_array('province', $filters)) {

        echo '<div class="filter province">
                <label>Province</label>
                <select id="filter-province" name="province">
                    <option value="all">All</option>';

                    $provinces = array(
                        'AB' => 'Alberta',
                        'BC' => 'British Columbia',
                        'MB' => 'Manitoba',
                        'NB' => 'New Brunswick',
                        'NL' => 'Newfoundland and Labrador',
                        'NS' => 'Nova Scotia',
                        'ON' => 'Ontario',
                        'PE' => 'Prince Edward Island',
                        'QC' => 'Quebec',
                        'SK' => 'Saskatchewan'
                    );
                    foreach ($provinces as $code => $name) {
                        echo '<option value="'.$code.'" '.(strtolower($user_province) == strtolower($name) ? ' selected="selected"' : '' ).'>'.$name.'</option>';
                    }
        echo '</select>
            </div>';
    }

    if (in_array('city', $filters)) {

        echo '<div class="filter city">
                <label>City</label>
                <select id="filter-city" name="city">
                    <option value="all">All</option>';
                    $cities = get_all_cities();
                    foreach ($cities as $city) {
                        echo '<option value="' . strtolower($city) . '" '.(strtolower($user_city) == strtolower($city) ? ' selected="selected"' : '' ).'>' . ucwords($city) . '</option>';
                    }
        echo '</select>
            </div>';
    }

    if (in_array('age', $filters) || in_array('grade', $filters) || in_array('gender', $filters)) {
        $demographic_taxonomy_filters = ['age', 'grade', 'gender'];
        foreach ($demographic_taxonomy_filters as $taxonomy) {
            if(!in_array($taxonomy, $filters)){
                continue;
            }

            $url_term = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
            ]);

            if (!empty($terms)) {
                usort($terms, function ($a, $b) {
                    return strnatcmp($a->name, $b->name);
                });
                echo '<div class="filter '.strtolower($taxonomy).'">
                        <label>' . ucfirst($taxonomy) . '</label>
                        <select id="filter-' . $taxonomy . '" name="' . $taxonomy . '">
                            <option value="all">All</option>';
                foreach ($terms as $term) {
                    $selected = (strtolower($url_term) == strtolower($term->name)) ? 'selected' : '';
                    echo '<option value="' . $term->name . '" ' . $selected . '>' . $term->name . '</option>';
                }
                echo '</select>
                    </div>';
            }
        }
    }

    echo '</div>';
}
?>