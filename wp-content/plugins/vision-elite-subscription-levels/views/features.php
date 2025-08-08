<?php
    // Set nonce
    wp_nonce_field('ve_subscription_levels_meta_nonce', 've_subscription_levels_meta_nonce');
    // Get data
    $online_recruit_profile = get_post_meta( $post->ID, 'online_recruit_profile', true );
    $highlight_film = get_post_meta( $post->ID, 'highlight_film', true );
    $group_practice_sessions_per_week = get_post_meta( $post->ID, 'group_practice_sessions_per_week', true );
    $recoreded_sessions_per_month = get_post_meta( $post->ID, 'recoreded_sessions_per_month', true );
    $s_and_c_programming = get_post_meta( $post->ID, 's_and_c_programming', true );
    $monthly_group_meetings = get_post_meta( $post->ID, 'monthly_group_meetings', true );
    $monthly_team_sessions = get_post_meta( $post->ID, 'monthly_team_sessions', true );
    $monthly_s_and_c_sessions = get_post_meta( $post->ID, 'monthly_s_and_c_sessions', true );
    $bi_weekly_position_small_group_film_sessions = get_post_meta( $post->ID, 'bi_weekly_position_small_group_film_sessions', true );
    $monthly_position_group_film_sessions = get_post_meta( $post->ID, 'monthly_position_group_film_sessions', true );
    $one_and_one_sport_psychologist_meeting = get_post_meta( $post->ID, 'one_and_one_sport_psychologist_meeting', true );
    $professional_one_hour_video_film_sessions = get_post_meta( $post->ID, 'professional_one_hour_video_film_sessions', true );
    $one_hour_consultation_with_recruiting_coach = get_post_meta( $post->ID, 'one_hour_consultation_with_recruiting_coach', true );
?>
<style>
    table.feature-table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }
    table.feature-table tbody,
    table.feature-table tr{
        width: 100%;
    }
    table.feature-table tr:nth-child(odd){
        background-color: #f9f9f9;
    }
    table.feature-table tr th,
    table.feature-table tr td{
        width: 50%;
        text-align: left;
        padding: 10px;
    }
</style>
<table class="feature-table">
    <tr>
        <th>Online recruit profile</th>
        <td><input type="checkbox" name="online_recruit_profile" value="1" <?php checked( $online_recruit_profile, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Highlight film</th>
        <td><input type="text" name="highlight_film" value="<?=$highlight_film?>" /></td>
    </tr>
    <tr>
        <th>Group Practice Sessions per week</th>
        <td><input type="number" name="group_practice_sessions_per_week" value="<?=$group_practice_sessions_per_week?>" /></td>
    </tr>
    <tr>
        <th>Recorded sessions per month</th>
        <td><input type="number" name="recoreded_sessions_per_month" value="<?=$recoreded_sessions_per_month?>" /></td>
    </tr>
    <tr>
        <th>S&C Programming</th>
        <td><input type="checkbox" name="s_and_c_programming" value="1" <?php checked( $s_and_c_programming, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Monthly group meetings with recruiting coach</th>
        <td><input type="checkbox" name="monthly_group_meetings" value="1" <?php checked( $monthly_group_meetings, '1' ); ?> /></td >
    </tr>
    <tr>
        <th>Monthly Team session with sport psychologist</th>
        <td><input type="checkbox" name="monthly_team_sessions" value="1" <?php checked( $monthly_team_sessions, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Monthly S&C session with trainer</th>
        <td><input type="checkbox" name="monthly_s_and_c_sessions" value="1" <?php checked( $monthly_s_and_c_sessions, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Bi-Weekly position small group private lessons</th>
        <td><input type="checkbox" name="bi_weekly_position_small_group_film_sessions" value="1" <?php checked( $bi_weekly_position_small_group_film_sessions, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Monthly position group film sessions</th>
        <td><input type="checkbox" name="monthly_position_group_film_sessions" value="1" <?php checked( $monthly_position_group_film_sessions, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>1 on 1 sport psychologist meeting</th>
        <td><input type="checkbox" name="one_and_one_sport_psychologist_meeting" value="1" <?php checked( $one_and_one_sport_psychologist_meeting, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>Professional 1 hour video film session</th>
        <td><input type="checkbox" name="professional_one_hour_video_film_sessions" value="1" <?php checked( $professional_one_hour_video_film_sessions, '1' ); ?> /></td>
    </tr>
    <tr>
        <th>1 hour consultation with recruiting coach</th>
        <td><input type="checkbox" name="one_hour_consultation_with_recruiting_coach" value="1" <?php checked( $one_hour_consultation_with_recruiting_coach, '1' ); ?> /></td>
    </tr>
</table>