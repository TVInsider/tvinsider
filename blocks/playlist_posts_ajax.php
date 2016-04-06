<?php if(isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ((isset($_GET['popular']) && ($_GET['popular'] == 1)) || (isset($_GET['tid']) && ($_GET['tid'] > 0)) || (isset($_GET['uid']) && ($_GET['uid'] > 0)) || (isset($_GET['vpaged']) && ($_GET['vpaged'] > 0)))):
	$_ID = get_the_ID();
	$_post_type = 'playlist';
	
	$_paged = get_query_var('vpaged');
	if(!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
	if(!$_paged) $_paged = 1;
	
	$_tid = get_query_var('tid');
	if(!$_tid && isset($_GET['tid'])) $_tid = $_GET['tid'];
	
	$_uid = get_query_var('uid');
	if(!$_uid && isset($_GET['uid'])) $_uid = $_GET['uid'];
	
	$_args = array(
		'post_type' => $_post_type,
		'posts_per_page' => 12,
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
		<div class="ajax-holder">
			<div class="row-playlist">
				<ul class="playlist-list">
					<?php $_advertisment = null; ?>
					<?php $i = 0; while($_posts->have_posts()) : $_posts->the_post(); ?>
						<li>
							<article class="item">
								<div class="img-holder">
										<a href="<?php the_permalink() ?>"><?php MultiPostThumbnails::the_post_thumbnail('playlist','promo-circular', get_the_ID(), 't_195x195');?>
								</div>
								<div class="text">
									<h3><a href="<?php the_permalink(); ?>"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_post->ID);}?></a></h3>
									<span class="author"><a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>"><?php echo get_author_name(get_the_author_ID()); ?></a></span>
									<?php the_excerpt(); ?>
								</div>
							</article>
						</li>
						<?php if(($_advertisments = get_field('_advertisments', $_ID)) && !(++$i % 8) && ($i != $_posts->post_count)): ?>
							<?php $_advertisment = $_advertisments[rand(0, count($_advertisments)-1)]; ?>
								</ul>
							</div>
							<?php if(!empty($_advertisment)): ?>
							<div class="banner-holder">
								<div class="large-banner">
									<div class="holder">
										<?php if(isset($_advertisment['_ad_url'])): ?><a target="_blank" href="<?php echo $_advertisment['_ad_url']; ?>"><?php endif; ?>
										<img src="<?php echo $_advertisment['_ad_image']['url']; ?>" height="90" width="970" alt="<?php echo $_advertisment['_ad_image']['title']; ?>">
										<?php if(isset($_advertisment['_ad_url'])): ?></a><?php endif; ?>
										<span class="txt-advertisment"><?php _e('advertisment', 'tvinsider'); ?></span>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<?php $_advertisment = null; ?>
							<div class="row-playlist">
								<ul class="playlist-list">
						<?php endif; ?>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>
		<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>
		<div class="loader-box">
			<img class="loader" src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" height="24" width="24" alt="loader">
		</div>
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
		<div class="ajax-holder">
			<div class="row-playlist">
				<h2><?php _e('Not Found', 'tvinsider'); ?></h2>
				<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'tvinsider'); ?></p>
			</div>
		</div>
	</div>
	<?php endif;
	wp_reset_postdata();
endif; ?>