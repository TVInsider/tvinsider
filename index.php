<?php
if(isset($_GET['ajax']) && ($_GET['ajax'] == 1)):
	get_template_part('blocks/news_posts_ajax');
else:
	get_header(); ?>
	<div class="twocolumns">
		<div id="content">
			<?php if ( have_posts() ) : ?>
				<?php get_template_part('blocks/carousel'); ?>
				<?php get_template_part('blocks/news_posts'); ?>
			<?php else : ?>
				<?php get_template_part( 'blocks/not_found' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
	<?php get_footer(); ?>
<?php endif; ?>