<?php if($_playlists_posts = get_field('_playlists_posts')): ?>
<div class="playlist-column">
	<?php if($_heading = get_field('_playlists_heading')): ?>
	<h2 class="playlist-txt"><span><?php echo $_heading; ?></span></h2>
	<?php endif; ?>
	<ul class="playlist-list">
		<?php foreach($_playlists_posts as $_post): ?>
		<li>
			<article class="item">
				<div class="img-holder">
					<a href="<?php echo get_permalink($_post->ID) ?>"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type($_post->ID), 'promo-circular', $_post->ID,  't_195x195'); ?></a>
				</div>
				<div class="text">
					<h3><a href="<?php echo get_permalink($_post->ID); ?>"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_post->ID);}?></a></h3>
					<span class="author"><a href="<?php echo get_author_posts_url($_post->post_author); ?>"><?php echo get_author_name($_post->post_author); ?></a></span>
					<?php
						if($_post->post_excerpt) echo apply_filters('the_excerpt', $_post->post_excerpt);
						elseif($_post->post_content) echo string_limit_words(apply_filters('the_excerpt', $_post->post_content), 18);
					?>
				</div>
			</article>
		</li>
		<?php endforeach; ?>
	</ul>
	<div class="btn-holder"><a href="<?php if($_playlists_page = get_field('_playlists_page', 'option')) echo get_permalink($_playlists_page); else echo get_post_type_archive_link('playlist'); ?>" class="btn-more"><?php _e('see more', 'tvinsider'); ?></a></div>
</div>
<?php endif; ?>