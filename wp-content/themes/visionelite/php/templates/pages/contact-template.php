<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); the_post(); ?>

<section id="contact-information" class="template-section">
    <div class="split">
        <div class="col">
            <div class="content">
                <h1><?php the_title(); ?></h1>
                <div class="offices">
                    <div class="office">
                        <h3>Winnipeg</h3>
                        <p>
                            <i class="fa-solid fa-location-pin"></i>
                            3 Myles Robinson Way<br>
                            Winnipeg, Manitoba R3X 1M6
                        </p>
                        <p><i class="fa-solid fa-phone"></i> 204-471-1111</p>
                    </div>
                    <div class="office">
                        <h3>Calgary</h3>
                        <p>
                            <i class="fa-solid fa-location-pin"></i>
                            One Executive Place<br>
                            1816 Crowchild Trail NW #700<br>
                            Calgary, Alberta   T2M 3Y7
                        </p>
                        <p><i class="fa-solid fa-phone"></i> 403-510-1784</p>
                    </div>
                    <div class="office">
                        <p><i class="fa-solid fa-clock"></i> 9:00am - 4:00pm daily.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="content form">
                <?php echo do_shortcode('[forminator_form id="34040"]'); ?>
            </div>
        </div>
    </div>
</section>

<section id="our-team-section" class="template-section">
    <div class="container">
        <div class="content">
            <div class="row gx-5">
                <div class="col col-12">
                    <h2>The Vision Elite Team</h2>
                    <p>We are a team of dedicated professionals committed to providing the best sports program experience. Our team is passionate about the sport and works tirelessly to ensure that every player, coach, and fan has an unforgettable experience.</p>
                </div>
            </div>
	    </div>
        <div class="row gx-5">
            <div class="col col-12">
                <div class="team-members">
                    <?php
                    // get all coach posts
                    $args = array(
                        'post_type' => 'coach',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                    );
                    $coaches = get_posts($args);
                    if ($coaches) {
                        foreach ($coaches as $coach) {
                            $post = $coach; // Set the global post variable
                            setup_postdata($post);
                            // Get post meta data
                            $coach_image = get_post_meta( $post->ID, 'coach_image', true );
                            $coach_firstname = get_post_meta( $post->ID, 'coach_firstname', true );
                            $coach_lastname = get_post_meta( $post->ID, 'coach_lastname', true );
                            $coach_position = get_post_meta( $post->ID, 'coach_position', true );
                            $caoch_bio = wpautop(get_post_meta( $post->ID, 'coach_bio', true ));
                            $coach_phone = get_post_meta( $post->ID, 'coach_phone', true );
                            $coach_email = get_post_meta( $post->ID, 'coach_email', true );
                            ?>
                            <div class="team-member">
                                <h3><?= esc_html($coach_firstname . ' ' . $coach_lastname) ?></h3>
                                <h4> <?= esc_html($coach_position) ?></h4>
                                <p><?= wp_kses_post($caoch_bio) ?></p>
                                <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?= esc_html($coach_email) ?>"><?= esc_html($coach_email) ?></a></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No coaches found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>