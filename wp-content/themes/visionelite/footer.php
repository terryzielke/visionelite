	</main><!--#main-->

	<footer id="footer">
		<div class="footer-crosslink row">
			<div class="col col-12 col-md-6">
				<?=(get_bloginfo('name') != 'Vision Elite International' ? '<a href="https://visioneliteinternational.com" rel="noopener noreferrer">' : '<span>')?>
					<!--<h3>Vision Elite International</h3>-->
					<img src="<?=get_template_directory_uri()?>/assets/img/VE-I-logo-white.svg" alt="Vision Elite International">
					<p>High-performance athlete training programs</p>
				<?=(get_bloginfo('name') != 'Vision Elite International' ? '</a>' : '</span>')?>
			</div>
			<div class="col col-12 col-md-6">
				<?=(get_bloginfo('name') == 'Vision Elite International' ? '<a href="https://visioneliteacademy.com" rel="noopener noreferrer">' : '<span>')?>
					<img src="<?=get_template_directory_uri()?>/assets/img/VE-A-logo-white.svg" alt="Vision Elite Acedemy">
					<p>Grass-roots sports camps for developing players</p>
				<?=(get_bloginfo('name') == 'Vision Elite International' ? '</a>' : '</span>')?>
			</div>
		</div>
		<div class="footer-content">
			<div class="container">
				<div class="row">
					<div class="footer-menu col col-12">
						<?php
							if(is_multisite()){
								// switch to the main site
								switch_to_blog(1);
							}
							wp_nav_menu(array(
								'theme_location' => 'footer',
								'menu_id'        => 'footer-menu',
								'depth'		     => '3'
							));
							if(is_multisite()){
								// return to the current site
								restore_current_blog();
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="legal">
			<div class="row">
				<div id="copywrite" class="col col-12 col-md-6">
					&copy; Copyright <?php echo date('Y').' '.get_bloginfo('name'); ?><b>|</b><a href="/privacy-policy">Privacy Policy</a><b>|</b><a href="/terms-of-service">Terms of Service</a>
				</div>
				<div id="webdeveloper" class="col col-12 col-md-6">
					<a href="https://zielke.design" target="_blank" title="website designed and developed by Zielke Design" id="zielkedesign">
						<svg version="1.1" id="zielkedesign_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60.57267 61.6248016">
						<g class="left">
						<path class="light" d="M30.286335,52.9373932l-7.3750076-7.3750076l-7.3750086-7.3749771l-7.3749762-7.3750076l-7.004961,7.0049629
						c-0.2043714,0.2043686-0.204371,0.5357208,0.0000007,0.7400932l7.0049601,7.0049286l7.3749762,7.3750076l7.0692129,7.0692139
						c0.195797,0.195797,0.4613552,0.3057938,0.7382545,0.3057938h13.0541401c0.4662323,0,0.6997223-0.563694,0.3700447-0.8933716
						L30.286335,52.9373932z"></path>
						<path class="dark" d="M15.2305231,23.7431908l-7.0691805,7.0692101l7.3749762,7.3750076l7.3750086-7.3750076l6.481636-6.481636
						c0.3296757-0.3296757,0.0961857-0.8933716-0.3700466-0.8933716H15.9687796
						C15.6918793,23.4373932,15.426321,23.5473919,15.2305231,23.7431908z"></path>
						</g>
						<g class="right">	
						<path class="light" d="M52.4113274,16.0623856l-7.3749771-7.3749762l-7.0692139-7.0692129
						c-0.195797-0.1957974-0.4613533-0.3057952-0.7382545-0.3057952H24.1747437c-0.4662323,0-0.6997223,0.5636951-0.3700466,0.8933713
						l6.481638,6.481637l7.3750076,7.3749762l7.3750076,7.3750076l7.3749771,7.3750076l7.0049591-7.004961
						c0.2043724-0.2043705,0.2043724-0.5357227,0-0.7400932L52.4113274,16.0623856z"></path>
						<path class="dark" d="M45.0363503,23.4373932l-7.3750076,7.3750076l-6.481636,6.481636
						c-0.3296776,0.3296776-0.0961876,0.8933716,0.3700466,0.8933716h13.0541363c0.2769012,0,0.5424576-0.1099968,0.7382584-0.3057976
						l7.0691795-7.0692101L45.0363503,23.4373932z"></path>
						</g>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</footer>

</div><!--#page-->

<?php wp_footer(); ?>