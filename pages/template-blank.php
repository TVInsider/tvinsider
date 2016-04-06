<?php
/*
Template Name: Blank Template
*/
get_header(); ?>

<div class="twocolumns">
	<div id="content">
		<?php get_template_part('blocks/carousel'); ?>
		<?php get_template_part('blocks/category_block'); ?>
	</div>
	<aside id="sidebar">
		<?php dynamic_sidebar('blank-sidebar'); ?>
	</aside>
</div>
<?php get_footer(); ?>