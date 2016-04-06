<?php get_header(); ?>
<div class="twocolumns">
	<div id="content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'blocks/content-single', get_post_type() ); ?>
			<!-- /173750744/ROS_Mobile_300x250 -->
			<div id='div-gpt-ad-ros_mobile_300x250'>
			<script type='text/javascript'>googletag.cmd.push(function() { googletag.display('div-gpt-ad-ros_mobile_300x250'); });</script>
			</div>
		<?php endwhile; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>