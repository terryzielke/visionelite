<!DOCTYPE html>
<html lang="en">
<head>
	<meta charSet="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="color-scheme" content="light only">
	<link rel="shortcut icon" href="<?=get_template_directory_uri()?>/assets/img/VE-favicon.png">
	<script src="https://kit.fontawesome.com/dd2ef627ee.js" crossorigin="anonymous"></script>
	<!-- Google tag (gtag.js) -->
	<?php if(get_bloginfo('name') != 'Vision Elite International'): ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZX5F7W47K"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-8ZX5F7W47K');
		</script>
	<?php else: ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-LYHHM2SHPP"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-LYHHM2SHPP');
		</script>
	<?php endif; ?>

	<?php wp_head(); ?>
	<?php
		$postBody = '';
		if(is_home()){
			$postBody = 'blog-body';
		}
		elseif(is_404()){ 
			$postBody = 'oops-body';
		}
		elseif(is_author()){
			$postBody = 'author-body';
		}
		elseif(is_search()){
			$postBody = 'search-body';
		}
		else{
			global $post;
			if($post){
				$pageSlug = $post->post_name;
				$postBody = $pageSlug.'-body';
			}
		}
		// get user's primary blog path if multisite and not on main site
		$site_path = '';
		if (is_multisite() && !is_main_site()) {
			$site_path = get_site_url();
		}
	?>
</head>
<body <?php body_class(); ?> id="<?=$postBody?>">

<!-- content -->
<div id="page">
	<!-- header -->
	<header id="header">
		<div class="header-row row">
			<div class="col col-6 col-md-2 left">
				<a id="header-logo" href="<?=get_site_url(1)?>">
					<img src="<?=get_template_directory_uri().(get_bloginfo('name') != 'Vision Elite International' ? '/assets/img/VE-A-logo.svg' : '/assets/img/VE-I-logo.svg')?>" alt="<?=get_bloginfo('name')?>">
				</a>
			</div>
			<div class="col col-8 center">
				<div id="mobile-nav-ui">
					<a id="nav-back"></a>
					<div id="nav-current-level"></div>
				</div>
				<?php
					if(is_multisite()){
						// switch to the main site
						switch_to_blog(1);
					}
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'depth'		     => '0'
					));
					if(is_multisite()){
						// return to the current site
						restore_current_blog();
					}
				?>
				<a id="mobilelogin" href="<?=(is_user_logged_in() ? $site_path.'/wp-admin/edit.php?post_type=session' : $site_path.'/wp-admin/edit.php?post_type=session')?>">
					<span>
						<?php
							if (is_user_logged_in()) {
								echo 'Dashboard';
							} else {
								echo 'Coachs';
							}
						?>
					</span>
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
					<path d="M8.65967,4.65028l4.31836,4.31763c.25195.25269.39697.60059.39697.95947s-.14502.70679-.39697.95947l-4.31836,4.31763c-.22412.22485-.52734.3479-.84375.3479-.65625,0-1.19092-.53467-1.19092-1.19165v-2.18335H2.125c-.62256,0-1.125-.50244-1.125-1.125v-2.25c0-.62256.50244-1.125,1.125-1.125h4.5v-2.18335c0-.65698.53467-1.19165,1.19092-1.19165.31641,0,.61963.12671.84375.3479ZM13.375,15.55238h2.25c.62256,0,1.125-.50244,1.125-1.125V5.42738c0-.62256-.50244-1.125-1.125-1.125h-2.25c-.62256,0-1.125-.50244-1.125-1.125s.50244-1.125,1.125-1.125h2.25c1.86328,0,3.375,1.51172,3.375,3.375v9c0,1.86328-1.51172,3.375-3.375,3.375h-2.25c-.62256,0-1.125-.50244-1.125-1.125s.50244-1.125,1.125-1.125Z"/>
					</svg>
				</a>
			</div>
			<div class="col col-6 col-md-2 right">
				<a id="login" href="<?=(is_user_logged_in() ? $site_path.'/wp-admin/edit.php?post_type=session' : $site_path.'/wp-admin/edit.php?post_type=session')?>">
					<span>
						<?php
							if (is_user_logged_in()) {
								echo 'Dashboard';
							} else {
								echo 'Coachs';
							}
						?>
					</span>
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
					<path d="M8.65967,4.65028l4.31836,4.31763c.25195.25269.39697.60059.39697.95947s-.14502.70679-.39697.95947l-4.31836,4.31763c-.22412.22485-.52734.3479-.84375.3479-.65625,0-1.19092-.53467-1.19092-1.19165v-2.18335H2.125c-.62256,0-1.125-.50244-1.125-1.125v-2.25c0-.62256.50244-1.125,1.125-1.125h4.5v-2.18335c0-.65698.53467-1.19165,1.19092-1.19165.31641,0,.61963.12671.84375.3479ZM13.375,15.55238h2.25c.62256,0,1.125-.50244,1.125-1.125V5.42738c0-.62256-.50244-1.125-1.125-1.125h-2.25c-.62256,0-1.125-.50244-1.125-1.125s.50244-1.125,1.125-1.125h2.25c1.86328,0,3.375,1.51172,3.375,3.375v9c0,1.86328-1.51172,3.375-3.375,3.375h-2.25c-.62256,0-1.125-.50244-1.125-1.125s.50244-1.125,1.125-1.125Z"/>
					</svg>
				</a>
				<button id="menu-button">
					<b class="bar bar1"></b>
					<b class="bar bar2"></b>
					<b class="bar bar3"></b>
				</button>
			</div>
		</div>
		<div class="subheader-row row">
			<div class="col col-12">
				<?php
				
					// if is a wordpress mutilsite subsite, show the site name
					if (is_multisite() && !is_main_site()) {
						$site_name = get_bloginfo('name');
						echo '<nav class="subsite-nav">
								<a href="'.$site_path.'">' . esc_html($site_name) . '</a>
								<i class="fa-solid fa-circle"></i>
								<a href="'.$site_path.'/#subsite-programs-section">Programs</a>
								<i class="fa-solid fa-circle"></i>
								<a href="'.$site_path.'/#subsite-events-section">Events</a>
								<i class="fa-solid fa-circle"></i>
								<a href="'.$site_path.'/#subsite-coaches-section">Coaches</a>
							</nav>';
					}
					else {
						echo '<div class="find-a-program"><a href="/program-search"><i class="fa fa-search"></i>Find A Program</a></div>';
					}

				?>
			</div>
		</div>
	</header>
	<!-- back to top -->
	<a id="back-to-top" href="#header">
		<i class="fas fa-caret-up"></i>
	</a>
	<!-- main -->
	<main id="main">