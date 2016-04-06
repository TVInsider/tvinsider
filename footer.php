					<?php get_template_part('blocks/ad_bottom'); ?>
				</div>
			</div>
		</main>
		<footer id="footer">
			<div class="top-holder">
				<div class="container">
					<a href="<?php bloginfo('rss2_url'); ?>" class="rss"><?php echo _e( 'rss', 'tvinsider' ); ?>:</a>
					<div class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-small.png" alt="<?php bloginfo( 'name' ); ?>" width="183" height="34"></a></div>
					<div class="search-popup">
						<a href="#" class="open-search icon-search"></a>
						<?php get_search_form(); ?>
						<?php if(get_field('_social_networks', 'option')): ?>
						<ul class="social-networks">
							<?php while(has_sub_field('_social_networks', 'option')): ?>
							<li><a target="_blank" href="<?php the_sub_field('_url', 'option'); ?>" class="icon-<?php the_sub_field('_social_network', 'option'); ?>"></a></li>
							<?php endwhile; ?>
						</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
				if(has_nav_menu('footer_nav'))
					wp_nav_menu(array(
						'theme_location' => 'footer_topnav',
						'container' => 'nav',
						'container_class' => 'nav',
					));
			?>
			<div class="bottom-holder">
				<?php
					if(has_nav_menu('footer_nav'))
						wp_nav_menu(array(
							'theme_location' => 'footer_nav',
							'container' => 'nav',
							'container_class' => 'add-nav',
						));
				?>
				<p class="copy">© <?php echo _e( 'Copyright', 'tvinsider' ); ?> <?php echo date( 'Y' ); ?> <?php echo _e( 'TV Insider LLC. All rights reserved.', 'tvinsider' ); ?></p>
			</div>
		</footer>
	</div>
    <?php wp_footer(); ?>

<?php get_template_part('blocks/footer_tracking'); ?>
<script src="http://jwpsrv.com/library/s4aGxmtyEeSb8BLddj37mA.js"></script>
<script id="dsq-count-scr" src="//tvinsider.disqus.com/count.js" async></script>

</body>
</html>
