<?php
	if(is_home()) $_ID = get_option('page_for_posts');
	elseif(is_page() || is_single()) $_ID = get_the_ID();
	$cur_package = null;
	if($_packages = get_field('_packages', $_ID)) {
		$cur_date = date('m/d/y g:i a', strtotime(date('m/d/y g:i a')) - 60 * 60 * 4);
		foreach($_packages as $_package) {
			if(floor(strtotime($cur_date) - strtotime($_package['_published'])) > 0) {
				$cur_package = $_package;
				break;
			}
		}
	}
	if(!empty($cur_package) && !empty($cur_package['_stories'])): ?>
	<div class="main-carousel">
		<div class="mask">
			<div class="slideset">
				<?php foreach($cur_package['_stories'] as $item): ?>
				<?php if (get_post_status($item->ID) == 'publish'): ?>
				<div class="slide">
					<div class="slide-frame">
						<?php if (get_post_type($item->ID) == 'attachment'): ?>
							<div class="img-holder">
								<?php echo wp_get_attachment_image( $item->ID ); ?>
							</div>
						<?php else: ?>
							<a href="<?php echo get_permalink($item->ID); ?>">
								<div class="img-holder">
									<?php 
										if (MultiPostThumbnails::has_post_thumbnail(get_post_type($item->ID),'carousel', $item->ID)) { 
											MultiPostThumbnails::the_post_thumbnail(get_post_type($item->ID),'carousel', $item->ID, 't_812x522');
										} else { 
											echo get_the_post_thumbnail($item->ID, 't_812x522');
										}; 
									?>
									<?php
										$_sticker_field = get_field_object('_sticker', $item->ID);
										$_sticker_value = get_field('_sticker', $item->ID);
										$_sticker_label = $_sticker_field['choices'][$_sticker_value];
										if($_sticker_label): ?>
										<span class="single-label <?php echo $_sticker_value; ?>"><span><?php echo $_sticker_label; ?></span></span>
										<?php endif;
									?>
								</div>
								<div class="text">
									<h1><?php $subhead = get_field('short_headline', $item->ID); if($subhead) {echo $subhead;} else {echo get_the_title($item->ID);}?></h1>
									<?php if(isset($cur_package['_meta_info']) && $cur_package['_meta_info']): ?>
									<div class="meta">
										<span class="author"><?php echo get_author_name($item->post_author); ?></span>
										<time class="date" datetime="<?php echo get_the_time('Y-m-d', $item->ID) ?>T<?php echo get_the_time('g:i', $item->ID) ?>"> <?php echo get_the_time('F j, Y g:i a', $item->ID) ?></time>
										<?php $sponsor = get_field('sponsor_name', $item->ID); ?><?php if($sponsor): ?> <span class="sponsor"> | presented by <a href="<?php echo get_field('sponsor_link', $item->ID); ?>"><?php echo $sponsor; ?></a></span><?php endif; ?>
									</div>
									<?php endif; ?>
									<?php if($item->post_excerpt) echo apply_filters('the_excerpt', $item->post_excerpt); ?>
								</div>
							</a>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if(count($cur_package['_stories']) > 1): ?>
		<a class="btn-prev" href="#">&lt;</a>
		<a class="btn-next" href="#">&gt;</a>
		<div class="pagination">
			<!-- pagination generated here -->
		</div>
		<?php endif; ?>
	</div>
	<?php endif;
?>