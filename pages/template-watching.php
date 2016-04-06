<?php
/*
Template Name: Watching Template
*/
if(isset($_GET['ajax']) && ($_GET['ajax'] == 1)):
	get_template_part('blocks/watching_block_ajax');
	get_template_part('blocks/binge_guide_block_ajax');
else:
	get_header();
	if(have_posts()) : the_post(); ?>
	<div class="watching-page">
		<?php get_template_part('blocks/todays_picks'); ?>
		<?php get_template_part('blocks/watching_block'); ?>
		<?php get_template_part('blocks/binge_guide_block'); ?>
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