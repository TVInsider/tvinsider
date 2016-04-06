<?php if(isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ((isset($_GET['author']) && ($_GET['author'] > 0)) || (isset($_GET['vpaged']) && ($_GET['vpaged'] > 0)))):
	$_paged = get_query_var('vpaged');
	if (!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
	if (!$_paged) $_paged = 1;
	
	$_author = get_query_var('author');
	if(!$_author && isset($_GET['author'])) $_author = $_GET['author'];
	if($_author):
		$_author = get_userdata($_author);
		$_args = array(
			'post_type' => array('post', 'playlist', 'binge-guide', 'gallery'),
			'author' => $_author->ID,
			'paged' => $_paged,
			'category__not_in' => 10262,
		);
		$_posts = new WP_Query($_args);
		if($_posts->have_posts()): ?>
		<div>
			<?php $_query = array('vpaged' => $_paged + 1, 'ajax' => 1); ?>
			<div class="editor-posts"<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>  data-more="<?php echo esc_url(add_query_arg($_query, get_author_posts_url($_author->ID))); ?>"<?php endif; ?>>
				<?php while ( $_posts->have_posts() ) : $_posts->the_post(); ?>
				<article class="article">
					<?php if(has_post_thumbnail()): ?>
					<div class="img-holder">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('t_314x228'); ?></a>
					</div>
					<?php endif; ?>
					<div class="text-holder">
						<?php
							$_post_type = get_post_type();
							if(get_field('_post_type_names', 'option')) {
								while(has_sub_field('_post_type_names', 'option')) {
									if(get_sub_field('_post_type', 'option') == $_post_type) {
										$_post_type = get_sub_field('_name', 'option');
									}
								}
							}
						?>
						<strong class="category"><?php echo $_post_type; ?></strong>
						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<?php theme_the_excerpt(); ?>
						<div class="meta">
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
							<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
				<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>
				<div class="loader-box">
					<img class="loader" src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" height="24" width="24" alt="loader">
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif;
		wp_reset_postdata();
	endif;
else: ?>
<?php get_header(); ?>
<div class="twocolumns">
	<div id="content">
		<?php
			$_paged = get_query_var('vpaged');
			if (!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
			if (!$_paged) $_paged = 1;
			
			$_author = get_query_var('author');
			if(!$_author && isset($_GET['author'])) $_author = $_GET['author'];
			if($_author):
				$_author = get_userdata($_author); ?>
				<article class="editor-info">
					<div class="img-holder">
						<?php echo get_avatar($_author->ID, 150); ?>
						<?php if($_follow_link = get_field('_follow_link', 'user_'.$_author->ID)): ?>
						<a target="_blank" href="<?php echo $_follow_link; ?>" class="btn-follow"><span class="icon-twitter"><?php _e('follow me', 'tvinsider'); ?></span></a>
						<?php endif; ?>
					</div>
					<div class="text">
						<h1><?php echo $_author->display_name; ?></h1>
						<?php if($_desc = get_user_meta($_author->ID, 'description', true)) echo apply_filters('the_content', $_desc); ?>
					</div>
				</article>
				<?php $_args = array(
					'post_type' => array('post', 'playlist', 'binge-guide', 'gallery'),
					'author' => $_author->ID,
					'paged' => $_paged,
					'category__not_in' => 10262,
				);
				$_posts = new WP_Query($_args);
				if($_posts->have_posts()): ?>
					<?php $_query = array('vpaged' => $_paged + 1, 'ajax' => 1); ?>
					<div class="editor-posts"<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>  data-more="<?php echo esc_url(add_query_arg($_query, get_author_posts_url($_author->ID))); ?>"<?php endif; ?>>
						<?php while ( $_posts->have_posts() ) : $_posts->the_post(); ?>
						<article class="article">
							<?php if(has_post_thumbnail()): ?>
							<div class="img-holder">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('t_314x228'); ?></a>
							</div>
							<?php endif; ?>
							<div class="text-holder">
								<?php
									$_post_type = get_post_type();
									if($_post_type == 'post') {
										$_cats = get_the_category();
										$_category = '';
										foreach($_cats as $_cat){
											$_category .= ', ' . $_cat->name;
										}
										$_post_type = substr($_category, 2);
									} elseif(get_field('_post_type_names', 'option')) {
										while(has_sub_field('_post_type_names', 'option')) {
											if(get_sub_field('_post_type', 'option') == $_post_type) {
												$_post_type = get_sub_field('_name', 'option');
											}
										}
									}
								?>
								<strong class="category"><?php echo $_post_type; ?></strong>
								<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<?php theme_the_excerpt(); ?>
								<?php if(get_post_type() != 'playlist'): ?>
								<div class="meta">
									<?php if(get_post_type() == 'binge-guide'):
										$_add_info = null;
										if($_episodes = get_field('_episodes')){
											$_add_info = $_episodes.' '. __('Episodes', 'tvinsider');
										}
										if($_seasons = get_field('_seasons')){
											if(!empty($_add_info)) {
												$_add_info .= ' / ';
											}
											$_add_info .= $_seasons.' '. __('Seasons', 'tvinsider');
										}
										if(!empty($_add_info)): ?>
										<a href="<?php the_permalink(); ?>" class="author"><?php echo $_add_info; ?></a>
										<?php endif; ?>
									<?php else: ?>
										<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
										<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
									<?php endif; ?>
								</div>
								<?php endif; ?>
							</div>
						</article>
						<?php endwhile; ?>
						<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>
						<div class="loader-box">
							<img class="loader" src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" height="24" width="24" alt="loader">
						</div>
						<?php endif; ?>
					</div>
				<?php else:
					get_template_part( 'blocks/not_found' );
				endif;
				wp_reset_postdata();
			endif;
		?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
<?php endif; ?>