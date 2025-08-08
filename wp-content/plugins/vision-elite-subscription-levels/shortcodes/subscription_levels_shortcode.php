<?php
function subscription_levels_chart_shortcode() {

    // Get all subscription levels
    $subscription_levels = get_posts([
        'post_type' => 'subscription_levels',
        'numberposts' => -1,
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'post_status' => 'publish',
    ]);

    $HTML = '<div id="subscription-levels-chart">
                <ul class="column-headers">
                    <li class="column-header">Features</li>
                    <li>Online recruit profile</li>
                    <li>Highlight film</li>
                    <li>Group Practice Sessions per week</li>
                    <li>Recorded sessions per month</li>
                    <li>S&C programming</li>
                    <li>Monthly group meetings with recruiting coach</li>
                    <li>Monthly Team session with sport psychologist</li>
                    <li>Monthly S&C session with trainer</li>
                    <li>Bi-Weekly position small group private lessons</li>
                    <li>Monthly position group film sessions</li>
                    <li>1 on 1 sport psychologist meeting</li>
                    <li>Professional 1 hour video film sessions</li>
                    <li>1 hour consultation with recruiting coach</li>
                </ul>';

                foreach ($subscription_levels as $level) {
                    $online_recruit_profile = get_post_meta($level->ID, 'online_recruit_profile', true);
                    $highlight_film = get_post_meta($level->ID, 'highlight_film', true);
                    $group_practice_sessions_per_week = get_post_meta($level->ID, 'group_practice_sessions_per_week', true);
                    $recoreded_sessions_per_month = get_post_meta($level->ID, 'recoreded_sessions_per_month', true);
                    $s_and_c_programming = get_post_meta($level->ID, 's_and_c_programming', true);
                    $monthly_group_meetings = get_post_meta($level->ID, 'monthly_group_meetings', true);
                    $monthly_team_sessions = get_post_meta($level->ID, 'monthly_team_sessions', true);
                    $monthly_s_and_c_sessions = get_post_meta($level->ID, 'monthly_s_and_c_sessions', true);
                    $bi_weekly_position_small_group_film_sessions = get_post_meta($level->ID, 'bi_weekly_position_small_group_film_sessions', true);
                    $monthly_position_group_film_sessions = get_post_meta($level->ID, 'monthly_position_group_film_sessions', true);
                    $one_and_one_sport_psychologist_meeting = get_post_meta($level->ID, 'one_and_one_sport_psychologist_meeting', true);
                    $professional_one_hour_video_film_sessions = get_post_meta($level->ID, 'professional_one_hour_video_film_sessions', true);
                    $one_hour_consultation_with_recruiting_coach = get_post_meta($level->ID, 'one_hour_consultation_with_recruiting_coach', true);

                    $HTML .= '<ul class="subscription-level">
                                <li class="column-header">' . esc_html($level->post_title) . '</li>
                                <li>
                                    ' . ($online_recruit_profile ? ' <span class="mobile-only">Online recruit profile</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' .($highlight_film ? esc_html($highlight_film).'<span class="mobile-only"> Highlight film</span>' : '') . '</li>
                                <li>
                                    ' . ($group_practice_sessions_per_week > 0 ? esc_html($group_practice_sessions_per_week).'<span class="mobile-only"> Group practice per week</span>' : '') . '
                                </li>
                                <li>
                                    ' . ($recoreded_sessions_per_month > 0 ? esc_html($recoreded_sessions_per_month).'<span class="mobile-only"> Recorded sessions per month</span>' : '') . '
                                </li>
                                <li>
                                    ' . ($s_and_c_programming ? '<span class="mobile-only">S&C programming</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($monthly_group_meetings ? '<span class="mobile-only">Monthly group meetings with recruiting coach</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($monthly_team_sessions ? '<span class="mobile-only">Monthly Team session with sport psychologist</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($monthly_s_and_c_sessions ? '<span class="mobile-only">Monthly S&C session with trainer</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($bi_weekly_position_small_group_film_sessions ? '<span class="mobile-only">Bi-Weekly position small group private lessons</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($monthly_position_group_film_sessions ? '<span class="mobile-only">Monthly position group film sessions</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($one_and_one_sport_psychologist_meeting ? '<span class="mobile-only">1 on 1 sport psychologist meeting</span><i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>') . '
                                </li>
                                <li>
                                    ' . ($professional_one_hour_video_film_sessions ? '<span class="mobile-only">Professional 1 hour video film sessions</span><span class="desktop-only">Add-on</span>' : 'No') . '
                                </li>
                                <li>
                                    ' . ($one_hour_consultation_with_recruiting_coach ? '<span class="mobile-only">1 hour consultation with recruiting coach</span><span class="desktop-only">Add-on</span>' : 'No') . '
                                </li>
                            </ul>';
                }

    $HTML .= '</div>';

	/* RETURN HTML OUTPUT */
	return $HTML;
}
add_shortcode( 'subscription_levels_chart', 'subscription_levels_chart_shortcode' );
?>