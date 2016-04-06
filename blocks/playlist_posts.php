<?php
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
?>
<div class="frame playlist-ajax-area">
	<div class="banner-holder">
		<div class="bottom-banner">
			<div class="holder">
				<!-- /173750744/Desktop_Playlist_Middle_728x90_970x90 -->
				<div id='div-gpt-ad-Desktop_Playlist_Middle_728x90_970x90'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-Desktop_Playlist_Middle_728x90_970x90'); });
				</script>
				</div>
				<!-- /173750744/Mobile_Playlist_Middle_300x50_300x100_320x50_320x100 -->
				<div id='div-gpt-ad-Mobile_Playlist_Middle_300x50_300x100_320x50_320x100'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-Mobile_Playlist_Middle_300x50_300x100_320x50_320x100'); });
				</script>
				</div>
			</div>
		</div>
	</div>
	<div class="headline">
		<h2 class="playlist-txt"><span><?php _e('PLAYLISTS', 'tvinsider'); ?></span></h2>
		<?php if($_suggestions = get_field('_suggestions')): ?>
		<a href="mailto:<?php echo antispambot($_suggestions); ?>" class="suggestion"><?php _e('send us your suggestions', 'tvinsider'); ?></a>
		<?php endif; ?>
	</div>
	<div class="filter-area">
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
										<h3><a href="<?php the_permalink(); ?>"><?php $subhead = get_field('short_headline', $_posts->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_posts->ID);}?></a></h3>
										<span class="author"><a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>"><?php echo get_author_name(get_the_author_ID()); ?></a></span>
										<?php the_excerpt(); ?>
									</div>
								</article>
							</li>
							<?php if(($_advertisments = get_field('_advertisments', $_ID)) && !(++$i % 8) && ($i != $_posts->post_count)): ?>
								<?php $_advertisment = $_advertisments[rand(0, count($_advertisments)-1)]; ?>
									</ul>
								</div>
								<div class="banner-holder">
									<div class="large-banner">
										<div class="holder">
											<!-- /173750744/Desktop_Playlist_Middle_728x90_970x90 -->
											<div id='div-gpt-ad-Desktop_Playlist_Middle_728x90_970x90'>
											<script type='text/javascript'>
											googletag.cmd.push(function() { googletag.display('div-gpt-ad-Desktop_Playlist_Middle_728x90_970x90'); });
											</script>
											</div>
											<!-- /173750744/Mobile_Playlist_Middle_300x50_300x100_320x50_320x100 -->
											<div id='div-gpt-ad-Mobile_Playlist_Middle_300x50_300x100_320x50_320x100'>
											<script type='text/javascript'>
											googletag.cmd.push(function() { googletag.display('div-gpt-ad-Mobile_Playlist_Middle_300x50_300x100_320x50_320x100'); });
											</script>
											</div>
										</div>
									</div>
								</div>
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
				<a href="<?php echo esc_url(add_query_arg($_query, get_permalink($_ID))); ?>" class="btn-more"><?php _e('load more', 'tvinsider'); ?></a>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>