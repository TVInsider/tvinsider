<?php get_header(); ?>
<div class="twocolumns">
	<div id="content">
		<article class="single-post">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="headline">
					<h1><?php the_title(); ?></h1>
				</div>
				<?php if(has_post_thumbnail()): ?>
					<div class="img-holder">
						<?php the_post_thumbnail('t_812x522'); ?>
						<?php
							$_sticker_field = get_field_object('_sticker');
							$_sticker_value = get_field('_sticker');
							$_sticker_label = $_sticker_field['choices'][$_sticker_value];
							if($_sticker_label): ?>
							<span class="single-label <?php echo $_sticker_value; ?>"><span><?php echo $_sticker_label; ?></span></span>
							<?php endif;
						?>
					</div>
					<?php if($_alt = trim(strip_tags(get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true)))): ?>
					<em class="photo-credits"><?php echo $_alt; ?></em>
					<?php endif; ?>
				<?php endif; ?>
				<div class="soc-box">
					<ul class="social-networks">
						<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
						<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
						<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
						<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
					</ul>
				</div>
				<div class="description">
					<?php the_content(); ?>
					<div class="soc-box">
						<ul class="social-networks">
							<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
							<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
							<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
							<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
						</ul>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_link_pages(); ?>
		</article>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>