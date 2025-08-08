<?php
/*
Template Name: Login
*/
?>
<?php get_header(); the_post(); ?>

<section id="contact-information" class="template-section">
    <div class="split">
        <div class="col">
            <div class="content">
                <h1>Vision Elite Login</h1>
            </div>
        </div>
        <div class="col">
            <div class="content form">
                <div class="custom-login-form">
                    <?php
                    if ( is_user_logged_in() ) {
                        echo '<p>You are already logged in. <a href="' . wp_logout_url( home_url() ) . '">Log out</a></p>';
                    } else {
                        $args = array(
                            'redirect'       => home_url(), // Redirect after login
                            'form_id'        => 'custom_loginform',
                            'label_username' => __( 'Username' ),
                            'label_password' => __( 'Password' ),
                            'label_remember' => __( 'Remember Me' ),
                            'label_log_in'   => __( 'Log In' ),
                            'remember'       => true
                        );
                        wp_login_form( $args );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>