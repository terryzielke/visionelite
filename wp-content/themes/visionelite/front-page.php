<?php 
get_header();

if ( is_multisite() && get_current_blog_id() !== 1 ) {
    
    include '/php/templates/pages/subsite-template.php';
}

get_footer();
?>