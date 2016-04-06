<?php
/*
Template Name: Home Template
*/
get_header();
if(have_posts()) : the_post(); ?>
	<?php if(get_field('_packages') || is_active_sidebar('homepage-sidebar')): ?>
	<div class="column-holder">
		<?php if(get_field('_packages')): ?>
		<div class="column">
			<?php get_template_part('blocks/carousel'); ?>
		</div>
		<?php endif; ?>
		<?php if(is_active_sidebar('homepage-sidebar')): ?>
		<div class="aside">
			<?php dynamic_sidebar('homepage-sidebar'); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php get_template_part('blocks/featured_block'); ?>
	<?php //get_template_part('blocks/watching_posts'); ?>
	<?php get_template_part('blocks/highlights'); ?>
	<?php get_template_part('blocks/highlights2'); ?>
	<?php if(get_field('_playlists_posts') || is_active_sidebar('homepage-bottom-sidebar')): ?>
	<section class="playlist-box">
		<div class="holder">
			<?php get_template_part('blocks/playlists_block'); ?>
			<?php if(is_active_sidebar('homepage-bottom-sidebar')): ?>
			<div class="aside same-height-ignore">
				<?php dynamic_sidebar('homepage-bottom-sidebar'); ?>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>
<?php else : ?>
<div class="twocolumns">
	<div id="content">
		<?php get_template_part( 'blocks/not_found' ); ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php endif; ?>
<?php get_footer(); ?>