<?php
	$_tattle_posts = get_field('tv_tattle_featured');
	$_watching_posts = get_field('whats_worth_watching_featured');
	$_matt_posts = get_field('ask_matt_featured');

	$t = new WP_Query( array(
		'post_type' 		  => 'post',
		'posts_per_page'      => 1,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'category__in'        => 10009,
		)
	);
	$w = new WP_Query( array(
		'post_type' 		  => 'post',
		'posts_per_page'      => 1,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'category__in'        => 6,
		)
	);
	$m = new WP_Query( array(
		'post_type' 		  => 'post',
		'posts_per_page'      => 1,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'category__in'        => 10008,
		)
	);
?>
<section class="watching-area">
	<div class="holder">
		<div class="frame">
			<ul class="show-list">
				<li>
					<article class="show">
						<div class="featured-header"><a href="http://www.tvinsider.com/author/norman-weiss/"><img src="http://www.tvinsider.com/wp-content/themes/tvinsider/images/tv_tattle_header.png" width="201" height="107" /></a></div>
							<?php if($_tattle_posts) { $x = $_tattle_posts; } else { $x = $t; }; ?>
								<?php foreach($x as $post): ?>
									<?php setup_postdata($post); ?>
										<?php if(has_post_thumbnail($post->ID)): ?>
										<div class="img-holder">
										<a href="<?php echo get_permalink($post->ID); ?>">
										<?php 
											if (MultiPostThumbnails::has_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID)) { 
												MultiPostThumbnails::the_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID, 't_330x240');
											} else { 
												echo get_the_post_thumbnail($post->ID, 't_330x240');
											}; 
										?>
										</a>
										</div>
										<div class="text">
											<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php $subhead = get_field('short_headline', $post->ID); if($subhead) {echo strip_tags(apply_filters('the_content', $subhead),"<i>");} else {echo get_the_title($post->ID);}?></a></h3>
											<?php
												if($post->post_excerpt) echo apply_filters('the_excerpt', $post->post_excerpt);
												elseif($post->post_content) echo string_limit_words(apply_filters('the_excerpt', $post->post_content), 18);
											?>
										</div>
										<?php endif; ?>
								<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</article>
				</li>
				<li>
					<article class="show">
						<div class="featured-header"><a href="http://www.tvinsider.com/whats-worth-watching/"><img src="http://www.tvinsider.com/wp-content/themes/tvinsider/images/whats_worth_watching_header.png" width="285" height="107" /></a></div>
							<?php if($_watching_posts) { $x = $_watching_posts; } else { $x = $w; }; ?>
								<?php foreach($x as $post): ?>
									<?php setup_postdata($post); ?>
										<?php if(has_post_thumbnail($post->ID)): ?>
										<div class="img-holder">
										<a href="<?php echo get_permalink($post->ID); ?>">
										<?php 
											if (MultiPostThumbnails::has_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID)) { 
												MultiPostThumbnails::the_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID, 't_330x240');
											} else { 
												echo get_the_post_thumbnail($post->ID, 't_330x240');
											}; 
										?>
										</a>
										</div>
										<div class="text">
											<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php $subhead = get_field('short_headline', $post->ID); if($subhead) {echo strip_tags(apply_filters('the_content', $subhead),"<i>");} else {echo get_the_title($post->ID);}?></a></h3>
											<?php
												if($post->post_excerpt) echo apply_filters('the_excerpt', $post->post_excerpt);
												elseif($post->post_content) echo string_limit_words(apply_filters('the_excerpt', $post->post_content), 18);
											?>
										</div>
										<?php endif; ?>
								<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</article>
				</li>
				<li>
					<article class="show">
						<div class="featured-header"><a href="http://www.tvinsider.com/category/ask-matt/"><img src="http://www.tvinsider.com/wp-content/themes/tvinsider/images/ask_matt_header.png" width="212" height="107" /></a></div>
							<?php if($_matt_posts) { $x = $_matt_posts; } else { $x = $m; }; ?>
								<?php foreach($x as $post): ?>
									<?php setup_postdata($post); ?>
										<?php if(has_post_thumbnail($post->ID)): ?>
										<div class="img-holder">
										<a href="<?php echo get_permalink($post->ID); ?>">
										<?php 
											if (MultiPostThumbnails::has_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID)) { 
												MultiPostThumbnails::the_post_thumbnail(get_post_type($post->ID),'promo-small', $post->ID, 't_330x240');
											} else { 
												echo get_the_post_thumbnail($post->ID, 't_330x240');
											}; 
										?>
										</a>
										</div>
										<div class="text">
											<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php $subhead = get_field('short_headline', $post->ID); if($subhead) {echo strip_tags(apply_filters('the_content', $subhead),"<i>");} else {echo get_the_title($post->ID);}?></a></h3>
											<?php
												if($post->post_excerpt) echo apply_filters('the_excerpt', $post->post_excerpt);
												elseif($post->post_content) echo string_limit_words(apply_filters('the_excerpt', $post->post_content), 18);
											?>
										</div>
										<?php endif; ?>
								<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</article>
				</li>
			</ul>
		</div>
	</div>
</section>
