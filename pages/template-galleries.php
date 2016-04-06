<?php
/*
Template Name: Galleries Template
*/
get_header(); ?>

<div class="twocolumns">
	<div id="content">
		<?php get_template_part('blocks/carousel'); ?>
		<?php
			$_ID = get_the_ID();
			$_posts_category = get_field('_posts_category', $_ID);
			$_featured_posts = get_field('_featured_posts', $_ID); 
			$_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$_post_type = array( 'post', 'gallery');
			$_args_posts = array(
				'post_type' => 'gallery',
				'paged' => $_paged
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
		<?php
			$_thumbnail = 't_314x228';
			$_posts_category = get_field('_playlist_category', $_ID);
			$_post_type = array( 'post', 'gallery');
			$_args_posts_list = array(
				'post_type' => $_post_type,
				'cat' => $_posts_category,
				'paged' => $_paged,
				'posts_per_page' => 30
			);
			$query = get_posts( $_args_posts_list );
		?>
		<ul class="news-list">
			<?php foreach($query as $_post): setup_postdata( $_post ) ?>
				<li>
					<?php $field = get_field_object('_sticker', $_post->ID); $value = get_field('_sticker', $_post->ID); $sticker = $field['choices'][ $value ]; ?>
					<article <?php post_class('article'); ?> id="post-<?php echo $_post->ID; ?>">
						<?php if ( MultiPostThumbnails::has_post_thumbnail(get_post_type($_post->ID), 'promo-small', $_post->ID) ) { ?>
							<div class="img-holder"><a href="<?php echo get_permalink($_post->ID); ?>"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type($_post->ID),'promo-small', $_post->ID, $_thumbnail);?></div>
				    	<?php } elseif(has_post_thumbnail($_post->ID)) { ?>
							<div class="img-holder"><a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_post_thumbnail($_post->ID, $_thumbnail); ?></a></div>
				    	<?php }; ?>
						<strong class="title"><?php if($sticker): ?><div class="label <?php echo $value; ?>"><?php echo $sticker; ?></div><?php endif; ?></strong>
						<div class="text-holder">
							<h2><a href="<?php echo get_permalink($_post->ID); ?>" rel="bookmark"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo $subhead;} else {echo get_the_title($_post->ID);}?></a></h2>
							<div class="meta">
								<a href="<?php echo get_author_posts_url(get_the_author_ID($_post->ID)); ?>" class="author"><?php echo get_author_name(get_the_author_ID($_post->ID)); ?></a>
								<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"> <?php the_time('F j, Y g:i a') ?></time>
							</div>
						</div>
					</article>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
			// next_posts_link() usage with max_num_pages
			next_posts_link( '<div class="paginate-older">Older Entries</div>', $_posts->max_num_pages );
			previous_posts_link( '<div class="paginate-newer">Newer Entries</div>' );
		?>
	<?php wp_reset_postdata(); ?>
	</div>
	<aside id="sidebar">
		<?php dynamic_sidebar('blank-sidebar'); ?>
	</aside>
</div>
<?php get_footer(); ?>