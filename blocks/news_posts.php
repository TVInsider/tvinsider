<?php
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
?>
<div class="filter-area news-area">
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
							$_users[$_user->data->ID] = $_user->data->display_name;
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
	<?php if($_posts->have_posts()): ?>
		<div class="news-holder">
			<div class="ajax-holder">
				<?php
					global $_count;
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
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>