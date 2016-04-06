<?php get_header(); ?>
<div class="twocolumns">
	<div id="content">
		<?php if ( have_posts() ) : ?>
		<div class="results-box">
			<div class="head">
				<?php the_archive_title( '<h1>', '</h1>' ); ?>
			</div>
			<div class="editor-posts">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="article">
					<div class="img-holder">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('t_314x228'); ?></a>
					</div>
					<div class="text-holder">
						<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<?php theme_the_excerpt(); ?>
						<div class="meta">
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
							<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
			</div>
			<?php get_template_part( 'blocks/pager' ); ?>
		</div>
		<?php else : ?>
			<?php get_template_part( 'blocks/not_found' ); ?>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>