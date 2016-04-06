<?php get_header(); ?>
<?php if(have_posts()) : the_post(); ?>
<div class="twocolumns">
	<aside id="sidebar">
		<div class="info-box">
			<h1><?php the_title(); ?></h1>
			<h2 class="binge-guide-txt"><strong><span><?php echo _e('Binge Guide', 'tvinsider'); ?></span></strong></h2>
			<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo _e('By', 'tvinsider'); ?> <?php echo get_author_name(get_the_author_ID(get_the_ID())); ?></a>
			<?php if(get_field('_seasons') || get_field('_episodes') || get_field('_hours')): ?>
			<ul class="info">
				<?php if($_seasons = get_field('_seasons')): ?>
				<li>
					<div class="box">
						<span class="number"><?php echo $_seasons; ?></span>
						<span class="text"><?php _e('seasons', 'tvinsider'); ?></span>
					</div>
				</li>
				<?php endif; ?>
				<?php if($_episodes = get_field('_episodes')): ?>
				<li>
					<div class="box">
						<span class="number"><?php echo $_episodes; ?></span>
						<span class="text"><?php _e('episodes', 'tvinsider'); ?></span>
					</div>
				</li>
				<?php endif; ?>
				<?php if($_hours = get_field('_hours')): ?>
				<li>
					<div class="box">
						<span class="number"><?php echo $_hours; ?></span>
						<span class="text"><?php _e('hours', 'tvinsider'); ?></span>
					</div>
				</li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
			<?php if(get_field('_cast')): ?>
			<div class="cast-box">
				<strong class="title"><?php _e('Cast', 'tvinsider'); ?></strong>
				<ul>
					<?php while(has_sub_field('_cast')): ?>
					<li>
						<span>
							<?php if($_name = get_sub_field('_name')): ?>
							<strong><?php echo $_name; ?> </strong>
							<?php endif; ?>
							<?php if($_cast_name = get_sub_field('_cast_name')) echo '('.$_cast_name.')'; ?>
						</span>
					</li>
					<?php endwhile; ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
				<div class="aside-banner">
					<div class="frame">
					<!-- /173750744/ROS_Desktop_Middle_300x250_300x600_300x1050 -->
						<div id='div-gpt-ad-1430489157041-4'>
						<script type='text/javascript'>
						googletag.cmd.push(function() { googletag.display('div-gpt-ad-1430489157041-4'); });
						</script>
						</div>
					</div>
				</div>
		<?php $the_shows = get_the_terms(get_the_id(), 'show'); if ($the_shows) { ?>
			<div class="chanel-info">
			<h2><?php _e('Where to Watch', 'tvinsider'); ?></h2>
			<?php foreach( $the_shows as $term ) { ?>
				<strong><?php echo $term->name; ?></strong>
				<?php 
					$rows = get_field('where_to_watch', 'show_'.$term->term_id);
					if($rows) {
						foreach($rows as $row) {
							echo '<a target="_blank" href="'.$row['link'].'" class="btn">'.$row['network'].'</a>';
						}
					};
				?>
			<?php }; ?> 
			</div>
		<?php }; ?> 
				<div class="aside-banner">
					<div class="frame">
						<!-- /173750744/ROS_Desktop_Middle_300x250 -->
						<div id='div-gpt-ad-1430489157041-3' style='height:250px; width:300px;'>
						<script type='text/javascript'>
						googletag.cmd.push(function() { googletag.display('div-gpt-ad-1430489157041-3'); });
						</script>
						</div>
					</div>
				</div>
		<?php if($_related_playlists = get_field('_related_playlists')): ?>
		<div class="related-playlists">
			<h2 class="related-playlist-txt"><?php _e('Related Playlists', 'tvinsider'); ?></h2>
			<div class="aside-carousel">
				<div class="mask">
					<div class="slideset">
						<?php $i = 0; foreach($_related_playlists as $_post): ?>
						<div class="slide">
							<?php if(has_post_thumbnail($_post->ID)): ?>
							<div class="img-holder">
								<a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_post_thumbnail($_post->ID, 't_195x195'); ?></a>
							</div>
							<?php endif; ?>
							<div class="text">
								<h3><a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_title($_post->ID); ?></a></h3>
								<a href="<?php echo get_author_posts_url(get_the_author_ID($_post->ID)); ?>" class="author"><?php echo get_author_name(get_the_author_ID($_post->ID)); ?></a>
								<?php
									if($_post->post_excerpt) echo apply_filters('the_excerpt', $_post->post_excerpt);
									elseif($_post->post_content) echo string_limit_words(apply_filters('the_excerpt', $_post->post_content), 18);
								?>
							</div>
						</div>
						<?php $i++; endforeach; ?>
					</div>
				</div>
				<?php if($i > 1): ?>
				<a class="btn-prev icon-arrow-left" href="#"></a>
				<a class="btn-next icon-arrow-right" href="#"></a>
				<div class="pagination">
					<!-- pagination generated here -->
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</aside>
	<div id="content">
		<div class="description-area">
			<?php if($_videos = get_field('_videos')): ?>
			<div class="video-area">
				<div class="video-box">
					<?php if (strpos($_videos,'/feeds/') !== false) : ?>
						<!-- if it's a jwplayer playlist via an rss feed -->
						<!-- example: //content.jwplatform.com/feeds/oro97D0U.rss -->
						<div id="myElement">Loading the player...</div>
						<script type="text/javascript">
						jwplayer("myElement").setup({
							playlist: "<?php echo $_videos; ?>",
							width: 725,
							height: 610,
							advertising: {
								client: 'vast',
								tag: 'http://search.spotxchange.com/vast/2.00/108886?VPAID=1&content_page_url=__page-url__&cb=__random-number__&player_width=__player-width__&player_height=__player-height__'
							},
							listbar: {
						        position: "bottom",
						        size: 180
						    }
						});
						</script>
					<?php elseif (strpos($_videos,'/players/') !== false) : ?>
						<!-- if it's a single jwplayer video -->
						<!-- example: <script type="text/javascript" src="//content.jwplatform.com/players/Q8jAr5W7-CV6Syw6i.js"></script> -->
						<?php 
							echo $_videos;
						?>
					<?php elseif (strpos($_videos,'v=') !== false) : ?>
						<!-- if it's a youtube video -->
						<!-- example: //youtube.com/watch?v=An2a1_Do_fc -->
						<?php 
							echo apply_filters('the_content', $_videos);
						?>
					<?php elseif (strpos($_videos,'playlist') !== false) : ?>
						<!-- if it's a youtube playlist -->
						<!-- example: //youtube.com/playlist?list=PL5TqrD7I6G6gQjWoLBtl17mcqw7wmfStP -->
						<?php 
							parse_str( parse_url( $_videos, PHP_URL_QUERY ), $array_of_vars );
							echo '<iframe src="https://www.youtube.com/embed/videoseries?list='.$array_of_vars['list'].'" frameborder="0" allowfullscreen></iframe>';
						?>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="text-box">
				<div class="soc-box right">
					<ul class="social-networks">
						<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
						<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
						<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
						<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
					</ul>
				</div>
				<div class="frame">
					<?php the_content(); ?>
				</div>
			</div>
			<?php if(function_exists('related_posts')): ?>
			<div class="related-stories">
				<?php related_posts(); ?>
			</div>
			<?php endif; ?>
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			<?php // comments_template(); ?>
		</div>
	</div>
</div>
<?php else : ?>
<div class="twocolumns">
	<div id="content">
		<?php get_template_part( 'blocks/not_found' ); ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php endif; ?>
<?php get_footer(); ?>