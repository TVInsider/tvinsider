<?php
/*
Template Name: Playlists Template
*/
if(isset($_GET['ajax']) && ($_GET['ajax'] == 1)):
	get_template_part('blocks/playlist_posts_ajax');
else:
	get_header();
	if(have_posts()) : the_post(); ?>
		<?php get_template_part('blocks/carousel-playlist'); ?>
		<div class="playlist-section">
			<?php get_template_part('blocks/playlist_posts'); ?>
			<?php get_template_part('blocks/bottom_section'); ?>
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
<?php endif; ?>