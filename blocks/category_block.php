<?php
	$_ID = get_the_ID();
	$_posts_category = get_field('_posts_category', $_ID);
	$_featured_posts = get_field('_featured_posts', $_ID); 
	$_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$_post_type = array( 'post', 'gallery');
	$_args_posts = array(
		'post_type' => $_post_type,
		'paged' => $_paged,
		'tax_query' => array(
			array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => $_posts_category,
			),
		),
	);
	$_posts = new WP_Query($_args_posts);
?>
	<?php if($_posts->have_posts()): ?>
	<h3 style="margin-top:20px;"><?php echo get_field('_featured_label', $_ID); ?></h3>
	<ul class="news-list">
		<?php foreach($_featured_posts as $_post): ?>
			<li>
				<article class="show">
					<?php if(has_post_thumbnail($_post->ID)): ?>
					<div class="img-holder">
					<a href="<?php echo get_permalink($_post->ID); ?>">
					<?php 
						if (MultiPostThumbnails::has_post_thumbnail(get_post_type($_post->ID),'promo-small', $_post->ID)) { 
							MultiPostThumbnails::the_post_thumbnail(get_post_type($_post->ID),'promo-small', $_post->ID, 't_314x228');
						} else { 
							echo get_the_post_thumbnail($_post->ID, 't_314x228');
						}; 
					?>
					</a>
					</div>
					<?php endif; ?>
					<div class="text">
						<h3><a href="<?php echo get_permalink($_post->ID); ?>"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_post->ID);}?></a></h3>
					</div>
				</article>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<h3><?php echo get_field('_posts_label', $_ID); ?></h3>
	<ul class="news-list">
		<?php while($_posts->have_posts()) : $_posts->the_post(); ?>
			<?php get_template_part('blocks/content', get_post_type() ); ?>
		<?php endwhile; ?>
	</ul>
	<?php
		// next_posts_link() usage with max_num_pages
		next_posts_link( '<div class="paginate-older">Older Entries</div>', $_posts->max_num_pages );
		previous_posts_link( '<div class="paginate-newer">Newer Entries</div>' );
	?>

	<?php wp_reset_postdata(); ?>
