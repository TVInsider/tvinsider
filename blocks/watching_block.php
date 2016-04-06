<?php
	$_ID = get_the_ID();
	$_watching_category = get_field('_watching_category');
	$_post_type = 'post';
	
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
	if($_watching_category && $_tid) {
		$_args['tax_query']['relation'] = 'AND';
	}
	if($_watching_category) {
		$_args['tax_query'][] = array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $_watching_category,
		);
	}
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
?>
<section class="watching-area">
	<div class="holder filter-area">
		<div class="headline">
			<h2<?php if($_heading = get_field('_watching_heading')) echo ' style="background-image: url('. $_heading['url'] .')"'; ?>><a href="<?php echo get_permalink($_ID); ?>"><?php echo get_cat_name($_watching_category); ?></a></h2>
			<?php if($_posts->have_posts()): ?>
			<div class="filter-box">
				<div class="filter-panel">
					<span class="txt-filter"><?php _e('filter by', 'tvinsider'); ?>:</span>
					<ul class="filter-list">
						<?php $_query = array('vpaged' => 1, 'ajax' => 1); ?>
						<li class="active"><a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>"><?php _e('all', 'tvinsider'); ?></a></li>
						<?php
							$_query = array();
							$_genres = get_terms('genre', array(
								'orderby' => 'name',
								'order' => 'asc',
								'hide_empty' => false,
							));
							if(!empty($_genres)): ?>
							<li>
								<span class="open"><?php _e('genre', 'tvinsider'); ?></span>
								<div class="drop-filter">
									<div class="frame">
										<ul>
											<?php $i = 0; foreach($_genres as $_genre): ?>
												<?php $_query = array('tid' => $_genre->term_id, 'ajax' => 1); ?>
												<li><a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>"><?php echo $_genre->name; ?></a></li>
												<?php if(!(++$i % ceil(count($_genres) / 6)) && ($i != count($_genres))): ?>
													</ul>
													<ul>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</li>
							<?php endif;
							$_users = array();
							$_query = array();
							$_administrator_users = get_users(array(
								'role' => 'administrator',
							));
							$_author_users = get_users(array(
								'role' => 'author',
							));
							$_merge_users = array_merge($_administrator_users, $_author_users);
							if(!empty($_merge_users)){
								foreach($_merge_users as $_user){
									$show = get_field('_show_in_filters', $_user);
									if ($show) {
										$_users[$_user->data->ID] = $_user->data->display_name;
									}
								}
								asort($_users);
							}
							if(!empty($_users)): ?>
							<li>
								<span class="open"><?php _e('writer', 'tvinsider'); ?></span>
								<div class="drop-filter">
									<div class="frame">
										<ul>
											<?php foreach($_users as $_user_id => $_user_name): ?>
												<?php $_query = array('uid' => $_user_id, 'ajax' => 1); ?>
												<li><a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>"><?php echo $_user_name; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</li>
							<?php endif;
						?>
						<li>
							<?php $_query = array('popular' => 1, 'ajax' => 1); ?>
							<a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>"><?php _e('most popular', 'tvinsider'); ?></a>
						</li>
					</ul>
				</div>
			</div>
			<?php else : ?>
			<div class="filter-box">
				<div class="filter-panel">
					<h2><?php _e('Not Found', 'tvinsider'); ?></h2>
					<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'tvinsider'); ?></p>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php if($_posts->have_posts()): ?>
			<div class="frame ajax-holder">
				<div class="row">
					<ul class="show-list">
						<?php $i = 0; while($_posts->have_posts()) : $_posts->the_post(); ?>
						<li>
							<article class="show">
								<?php if(has_post_thumbnail()): ?>
								<div class="img-holder">
									<a href="<?php echo the_permalink(); ?>">
										<?php 
											if (MultiPostThumbnails::has_post_thumbnail(get_post_type($_posts->ID),'promo-small', $_posts->ID)) { 
												MultiPostThumbnails::the_post_thumbnail(get_post_type($_posts->ID),'promo-small', $_posts->ID, 't_314x228');
											} else { 
												echo get_the_post_thumbnail($_posts->ID, 't_314x228');
											}; 
										?>
									</a>
								</div>
								<?php endif; ?>
								<div class="text">
									<h3><a href="<?php the_permalink(); ?>"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_post->ID);}?></a></h3>
									<?php the_excerpt(); ?>
								</div>
								<div class="editor">
									<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="name"><?php echo get_author_name(get_the_author_ID()); ?></a>
									<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
									<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="photo"><?php echo get_avatar(get_the_author_ID(), 150); ?></a>
								</div>
							</article>
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
				<a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>" class="btn-more"><?php _e('load more', 'tvinsider'); ?></a>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>