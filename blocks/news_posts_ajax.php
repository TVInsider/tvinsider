<?php if(isset($_GET['ajax']) && ($_GET['ajax'] == 1) && ((isset($_GET['popular']) && ($_GET['popular'] == 1)) || (isset($_GET['tid']) && ($_GET['tid'] > 0)) || (isset($_GET['uid']) && ($_GET['uid'] > 0)) || (isset($_GET['vpaged']) && ($_GET['vpaged'] > 0)))):
	$_ID = get_option('page_for_posts');
	$_posts_category = get_field('_posts_category', $_ID);
	$_post_type = array( 'post', 'gallery');
	
	$_paged = get_query_var('vpaged');
	if(!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
	if(!$_paged) $_paged = 1;
	
	$_tid = get_query_var('tid');
	if(!$_tid && isset($_GET['tid'])) $_tid = $_GET['tid'];
	
	$_uid = get_query_var('uid');
	if(!$_uid && isset($_GET['uid'])) $_uid = $_GET['uid'];
	
	$_args = array(
		'post_type' => $_post_type,
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $_paged,
	);
	if($_posts_category && $_tid) {
		$_args['tax_query']['relation'] = 'AND';
	}
	if($_posts_category) {
		$_args['tax_query'][] = array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $_posts_category,
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
	if($_posts->have_posts()): ?>
	<div>
		<div class="news-holder">
			<div class="ajax-holder">
				<?php
					$_next_utl = null;
					if($_posts->max_num_pages >= ($_paged + 1)){
						$_query = array('vpaged' => $_paged + 1, 'ajax' => 1);
						if($_tid) $_query['tid'] = $_tid;
						if($_uid) $_query['uid'] = $_uid;
						if(!empty($_posts_ids)) $_query['popular'] = 1;
						$_next_utl = add_query_arg($_query, get_permalink($_ID));
					}
				?>
				<ul class="news-list"<?php if(!empty($_next_utl)) echo ' data-more="'. $_next_utl .'"'; ?>>
					<?php while($_posts->have_posts()) : $_posts->the_post(); ?>
						<?php get_template_part( 'blocks/content', get_post_type() ); ?>
					<?php endwhile; ?>
				</ul>
			</div>
			<?php if($_posts->max_num_pages >= ($_paged + 1)): ?>
			<div class="loader-box">
				<img class="loader" src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" height="24" width="24" alt="image description">
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php else : ?>
	<div>
		<div class="news-holder">
			<div class="ajax-holder">
				<h2><?php _e('Not Found', 'tvinsider'); ?></h2>
				<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'tvinsider'); ?></p>
			</div>
		</div>
	</div>
	<?php endif;
	wp_reset_postdata();
endif; ?>