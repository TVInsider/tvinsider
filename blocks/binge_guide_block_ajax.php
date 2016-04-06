<?php if(isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ((isset($_GET['popular']) && ($_GET['popular'] == 1)) || (isset($_GET['tid']) && ($_GET['tid'] > 0)) || (isset($_GET['uid']) && ($_GET['uid'] > 0)) || (isset($_GET['vpaged']) && ($_GET['vpaged'] > 0)))):
	$_ID = get_the_ID();
	$_post_type = 'binge-guide';
	
	$_paged = get_query_var('vpaged');
	if(!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
	if(!$_paged) $_paged = 1;
	
	$_tid = get_query_var('tid');
	if(!$_tid && isset($_GET['tid'])) $_tid = $_GET['tid'];
	
	$_uid = get_query_var('uid');
	if(!$_uid && isset($_GET['uid'])) $_uid = $_GET['uid'];
	
	$_args = array(
		'post_type' => $_post_type,
		'posts_per_page' => 8,
		'paged' => $_paged,
	);
	if($_tid) {
		$_args['tax_query'][] = array(
			'taxonomy' => 'genre',
			'field' => 'id',
			'terms' => $_tid,
		);
	}
	if($_uid) {
		$_args['author'] = $_uid;
	}
	
	if(function_exists('wpp_get_mostpopular') && function_exists('get_popular_post_ids') && isset($_GET['popular']) && ($_GET['popular'] == 1)) {
		$_posts_ids = get_popular_post_ids(array(
			'post_type' => $_post_type,
		));
		if(!empty($_posts_ids)) {
			$_args['post__in'] = $_posts_ids;
			$_args['orderby'] = 'post__in';
		}
	}
	$_posts = new WP_Query($_args);
	if($_posts->have_posts()): ?>
	<div>
		<div class="holder">
			<div class="row">
				<ul>
					<?php $i = 0; while($_posts->have_posts()) : $_posts->the_post(); ?>
					<li>
						<?php if(has_post_thumbnail()): ?>
						<div class="img-holder">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('t_812x522'); ?></a>
						</div>
						<?php endif; ?>
						<div class="text-holder">
							<h3><a href="<?php the_permalink(); ?>"><?php $subhead = get_field('short_headline', $_posts->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_posts->ID);}?></a></h3>
							<?php the_excerpt(); ?>
							<?php
								$_add_info = null;
								if($_seasons = get_field('_seasons')){
									$_add_info = $_seasons.' '. __('Seasons', 'tvinsider');
								}
								if($_episodes = get_field('_episodes')){
									if(!empty($_add_info)) {
										$_add_info .= ' / ';
									}
									$_add_info .= $_episodes.' '. __('Episodes', 'tvinsider');
								}
							?>
							<?php if(!empty($_add_info)): ?>
							<a href="<?php the_permalink(); ?>" class="seasons"><?php echo $_add_info; ?></a>
							<?php endif; ?>
						</div>
					</li>
					<?php if(!(++$i % 4) && ($i != $_posts->post_count)): ?>
						</ul>
					</div>
					<div class="row">
						<ul class="show-list">
					<?php endif; ?>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>
		<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>
		<div class="btn-holder">
			<?php
				$_query = array('vpaged' => $_paged + 1, 'ajax' => 1);
				if($_tid) $_query['tid'] = $_tid;
				if($_uid) $_query['uid'] = $_uid;
				if(!empty($_posts_ids)) $_query['popular'] = 1;
			?>
			<a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>" class="btn-more"><?php _e('load more ', 'tvinsider'); ?></a>
		</div>
		<?php endif; ?>
	</div>
	<?php else : ?>
	<div>
		<div class="holder">
			<div class="row">
				<h2><?php _e('Not Found', 'tvinsider'); ?></h2>
				<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'tvinsider'); ?></p>
			</div>
		</div>
	</div>
	<?php endif;
	wp_reset_postdata();
endif; ?>