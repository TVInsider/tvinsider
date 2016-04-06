<?php
	$cur_package = null;
	if($_packages = get_field('_highlights_packages_2')) {
		//for some reason (maybe computer clock?), the time is off by four hours, so adjust for that
		$cur_date = date('m/d/y g:i a', strtotime(date('m/d/y g:i a')) - 60 * 60 * 4);
		foreach($_packages as $_package) {
			if(floor(strtotime($cur_date) - strtotime($_package['_highlights_published'])) > 0) {
				$cur_package = $_package;
				break;
			}
		}
	}
	if(!empty($cur_package) && !empty($cur_package['_highlights_stories'])): ?>
	<section class="highlights-area">
		<?php if($_heading = get_field('_highlights_heading_2')): ?>
		<h2><?php echo $_heading; ?></h2>
		<?php endif; ?>
		<div class="holder">
			<div class="column">
				<?php $i = 0; foreach($cur_package['_highlights_stories'] as $item): ?>
				<?php if($i<3): ?>
					<?php if(get_post_status($item->ID) == 'publish'): ?>
						<div class="item">
							<?php
								$_thumbnail = 't_330x240';
								if($i==0) $_thumbnail = 't_666x486';
							?>
							<a href="<?php echo get_permalink($item->ID); ?>">
								<?php 
									if (MultiPostThumbnails::has_post_thumbnail(get_post_type($item->ID),'promo-large', $item->ID)) { 
										MultiPostThumbnails::the_post_thumbnail(get_post_type($item->ID),'promo-large', $item->ID, $_thumbnail);
									} else { 
										echo get_the_post_thumbnail($item->ID, $_thumbnail);
									}; 
								?>
								<div class="text">
									<?php
										$_sticker_field = get_field_object('_sticker', $item->ID);
										$_sticker_value = get_field('_sticker', $item->ID);
										$_sticker_label = $_sticker_field['choices'][$_sticker_value];
										if($_sticker_label): ?>
										<span class="label <?php echo $_sticker_value; ?>"><span><?php echo $_sticker_label; ?></span></span>
										<?php endif;
									?>
									<h3><?php $subhead = get_field('short_headline', $item->ID); if($subhead) {echo $subhead;} else {echo get_the_title($item->ID);}?></h3>
								</div>
							</a>
						</div>
						<?php if(!$i++): ?>
							</div>
							<div class="aside">
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif;
?>