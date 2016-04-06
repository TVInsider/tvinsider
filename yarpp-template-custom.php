<?php
/*
YARPP Template: Custom
*/
?>
<div class="related-box">
	<h2><?php _e('Related Stories', 'tvinsider'); ?></h2>
	<?php if (have_posts()):?>
	<div class="holder">
		<ul>
			<?php while (have_posts()) : the_post(); ?>
			<li>
				<article class="article">
					<?php if ( MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'promo-small') ) { ?>
						<div class="img-holder"><a href="<?php the_permalink() ?>"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type(),'promo-small', get_the_ID(), 't_314x228');?></div>
			    	<?php } elseif(has_post_thumbnail()) { ?>
						<div class="img-holder"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('t_314x228'); ?></a></div>
			    	<?php }; ?>
					<div class="text-holder">
						<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<div class="meta">
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
							<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"> <?php the_time('F j, Y g:i a') ?></time>
						</div>
					</div>
				</article>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php else: ?>
	<?php endif; ?>
</div>