<?php
	$_watching_posts = null;
	$_watching_category = get_field('_watching_category');
	if($_watching_page = get_field('_watching_page', 'option')) {
		$_watching_page = get_permalink($_watching_page);
	} elseif($_watching_category) {
		$_watching_page = get_category_link($_watching_category);
	}
	if($_posts = get_field('_watching_posts')) {
		$_watching_posts = $_posts;
	} elseif($_watching_category) {
		$_args = array(
			'post_type' => 'post',
			'posts_per_page' => 4,
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $_watching_category
				)
			)
		);
		$_posts = new WP_Query($_args);
		if($_posts->have_posts()) {
			$_watching_posts = $_posts->posts;
		}
		wp_reset_postdata();
	}
	if(!empty($_watching_posts)): ?>
	<section class="watching-area">
		<div class="holder">
			<div class="headline">
				<h2<?php if($_heading = get_field('_watching_heading')) echo ' style="background-image: url('. $_heading['url'] .')"'; ?>><a href="<?php echo $_watching_page; ?>"><?php echo get_cat_name($_watching_category); ?></a></h2>
				<a href="<?php echo $_watching_page; ?>" class="where"><?php _e('today', 'tvinsider'); ?></a>
			</div>
			<div class="frame">
				<ul class="show-list">
					<?php $v = 0; foreach($_watching_posts as $_post): ?>
						<?php if(($v < 4) && (get_post_status($_post->ID) == 'publish')): ?>
							<li>
								<article class="show">
									<?php if(has_post_thumbnail($_post->ID)): ?>
									<div class="img-holder">
									<a href="<?php echo get_permalink($_post->ID); ?>">
									<?php 
										if (MultiPostThumbnails::has_post_thumbnail(get_post_type($_post->ID),'promo-small', $_post->ID)) { 
											MultiPostThumbnails::the_post_thumbnail(get_post_type($_post->ID),'promo-small', $_post->ID, 't_234x170');
										} else { 
											echo get_the_post_thumbnail($_post->ID, 't_234x170');
										}; 
									?>
									</a>
									</div>
									<?php endif; ?>
									<div class="text">
										<h3><a href="<?php echo get_permalink($_post->ID); ?>"><?php $subhead = get_field('short_headline', $_post->ID); if($subhead) {echo apply_filters('the_content', $subhead);} else {echo get_the_title($_post->ID);}?></a></h3>
										<?php
											if($_post->post_excerpt) echo apply_filters('the_excerpt', $_post->post_excerpt);
											elseif($_post->post_content) echo string_limit_words(apply_filters('the_excerpt', $_post->post_content), 18);
										?>
									</div>
								</article>
							</li>
						<?php $v++; endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php if($_watching_page): ?>
			<div class="btn-holder">
				<a href="<?php echo $_watching_page; ?>" class="btn-seemore"><?php _e('see more', 'tvinsider'); ?></a>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif;
?>