<?php get_header(); ?>
<div class="twocolumns">
	<div id="content">
		<?php if(have_posts()): ?>
			<div class="results-box">
				<div class="head">
					<h1><?php echo get_search_query(); ?></h1>
					<span class="amount"><?php echo $wp_query->found_posts; ?> <?php _e('results', 'tvinsider'); ?></span>
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
			</div>
			<div style="text-align: center; margin-top: 20px;">
			<?php
				global $wp_query;
				$big = 999999999;
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				) );
				?>
			</div>
		<?php else : ?>
			<div class="results-box">
				<div class="head">
					<h1><?php echo get_search_query(); ?></h1>
					<span class="amount">No results found.</span>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
