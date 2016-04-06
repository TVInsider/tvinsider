<?php get_header(); ?>
<?php if(have_posts()) : the_post(); ?>
<div class="twocolumns">
	<div class="playlist-area">
		<article class="single-playlists-article">
			<?php if(has_post_thumbnail()): ?>
			<div class="img-holder">
				<?php the_post_thumbnail('t_1122x424'); ?>
			</div>
			<?php endif; ?>
			<div class="description">
				<h1><?php the_title(); ?></h1>
				<div class="meta">
					<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID(get_the_ID())); ?></a>
					<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
				</div>
				<div class="soc-box right">
					<ul class="social-networks">
						<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
						<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
						<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
						<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
					</ul>
				</div>
				<?php the_content(); ?>
			</div>
		</article>
		<?php if(get_field('articles')): ?>
		<div class="playlist-article-list">
			<?php $i = 0; while(has_sub_field('articles')): ?>
			<article class="playlists-article">
				<?php if($vid = get_sub_field('_video')): ?>
				<div class="img-holder">
					<?php echo apply_filters('the_content', $vid); ?>
				</div>
				<?php elseif($_image = get_sub_field('_image')): ?>
				<div class="img-holder">
					<img src="<?php echo $_image['sizes']['t_1122x631']; ?>" height="631" width="1122" alt="<?php if(!empty($_image['alt'])) echo $_image['alt']; else echo $_image['title']; ?>">
				</div>
				<?php endif; ?>
				<span class="photo-credits"><?php echo $_image['description']; ?></span>
				<div class="description">
					<?php if($_title = get_sub_field('_title')): ?>
					<div class="headline">
						<span class="num"><?php echo ++$i; ?></span>
						<h2><?php echo $_title; ?></h2>
					</div>
					<?php endif; ?>
					<?php if(($_content = get_sub_field('_content')) && ($_advertisments = get_sub_field('_advertisment'))): ?><div class="text"><?php endif; ?>
						<?php echo apply_filters('the_content', $_content); ?>
					<?php if($_content && $_advertisments): ?></div><?php endif; ?>
					<?php if($_advertisments): ?>
						<?php foreach($_advertisments as $_advertisment): ?>
							<?php if($_advertisment['_ad_image']): ?>
							<div class="banner">
								<?php if($_advertisment['_ad_url']): ?><a target="_blank" href="<?php echo $_advertisment['_ad_url']; ?>"><?php endif; ?>
									<img src="<?php echo $_advertisment['_ad_image']['url'] ?>" height="250" width="300" alt="<?php echo $_advertisment['_ad_image']['title'] ?>">
								<?php if($_advertisment['_ad_url']): ?></a><?php endif; ?>
								<span class="txt-advertisment"><?php _e('advertisment', 'tvinsider'); ?></span>
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</article>
			<?php endwhile; ?>
			<div class="soc-box">
				<ul class="social-networks">
					<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
					<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
					<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
					<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		<?php if($_advertisments = get_field('_advertisment')): ?>
			<?php foreach($_advertisments as $_advertisment): ?>
				<?php if($_advertisment['_ad_image']): ?>
				<div class="bottom-banner">
					<div class="holder">
						<?php if($_advertisment['_ad_url']): ?><a target="_blank" href="<?php echo $_advertisment['_ad_url']; ?>"><?php endif; ?>
							<img src="<?php echo $_advertisment['_ad_image']['url'] ?>" height="90" width="970" alt="<?php echo $_advertisment['_ad_image']['title'] ?>">
						<?php if($_advertisment['_ad_url']): ?></a><?php endif; ?>
						<span class="txt-advertisment"><?php _e('advertisment', 'tvinsider'); ?></span>
					</div>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if($_related_playlists = get_field('_related_playlists')): ?>
		<div class="full-playlist">
			<h2 class="related-playlist-txt"><?php _e('Related Playlists', 'tvinsider'); ?></h2>
			<div class="row-playlist">
				<ul class="playlist-list">
					<?php foreach($_related_playlists as $_post): ?>
					<li>
						<article class="item">
							<?php if(has_post_thumbnail($_post->ID)): ?>
							<div class="img-holder">
								<a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_post_thumbnail($_post->ID, 't_195x195'); ?></a>
							</div>
							<?php endif; ?>
							<div class="text">
								<h3><a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_title($_post->ID); ?></a></h3>
								<span class="author"><a href="<?php echo get_author_posts_url(get_the_author_ID($_post->ID)); ?>"><?php echo get_author_name(get_the_author_ID($_post->ID)); ?></a></span>
								<?php
									if($_post->post_excerpt) echo apply_filters('the_excerpt', $_post->post_excerpt);
									elseif($_post->post_content) echo string_limit_words(apply_filters('the_excerpt', $_post->post_content), 18);
								?>
							</div>
						</article>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		<?php if(function_exists('related_posts')): ?>
		<div class="related-stories">
			<?php related_posts(); ?>
		</div>
		<?php endif; ?>
		<section class="bottom-section">
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			<?php // comments_template(); ?>
			<?php if(is_active_sidebar('bottom1-sidebar') || is_active_sidebar('bottom2-sidebar') || is_active_sidebar('bottom3-sidebar')): ?>
			<div class="frame">
				<div class="three-columns">
					<?php if(is_active_sidebar('bottom1-sidebar')) : ?>
					<div class="col">
						<?php dynamic_sidebar('bottom1-sidebar'); ?>
					</div>
					<?php endif; ?>
					<?php if(is_active_sidebar('bottom2-sidebar')) : ?>
					<div class="col">
						<?php dynamic_sidebar('bottom2-sidebar'); ?>
					</div>
					<?php endif; ?>
					<?php if(is_active_sidebar('bottom3-sidebar')) : ?>
					<div class="col">
						<?php dynamic_sidebar('bottom3-sidebar'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
		</section>
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